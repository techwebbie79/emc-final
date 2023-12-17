<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\CrpcSection;
use App\Models\EmAppeal;
use App\Models\EmCitizen;
use App\Models\User;
use App\Repositories\AppealCitizenRepository;
use App\Repositories\AppealRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\CitizenEditRepository;
use App\Repositories\LogManagementRepository;
use App\Repositories\PeshkarNoteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AppealInitiateController extends Controller
{
    public $permissionCode = 'certificateInitiate';
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    // public function __construct()
    // {
    //   //  $this->middleware('auth');
    //     AppealBaseController::__construct();

    // }

    /**
     * Show the form for creating a new Appeal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return EmAppeal::all();
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $gcoList = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();

        $appealId = null;
        $data = [
            'districtId' => $officeInfo->district_id,
            'divisionId' => $officeInfo->division_id,
            'office_id' => $office_id,
            'appealId' => $appealId,
            'gcoList' => $gcoList,
        ];

        // if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
        //     $query->where('case_register.district_id','=', $officeInfo->district_id);
        // }elseif($roleID == 9 || $roleID == 10 || $roleID == 11){
        //     $query->where('case_register.upazila_id','=', $officeInfo->upazila_id);
        // }elseif($roleID == 12){
        //     $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
        //     // dd($moujaIDs);
        //     // print_r($moujaIDs); exit;
        //     $query->whereIn('case_register.mouja_id', [$moujaIDs]);

        // $data=["districtId"=>Session::get('userInfo')->districtId,
        //         "divisionId"=>Session::get('userInfo')->divisionBbsCode,
        //         "appealId"=>$appealId];
        $page_title = 'সার্টিফিকেট মামলা তৈরি';
        return view('appealInitiate.appealCreateNew')->with(['data' => $data, 'page_title' => $page_title]);
    }

    // public function store(Request $request) {
    //     return $request;
    // }

    public function store(Request $request)
    {
       // dd($request);
        //var_dump($_FILES);
        //exit;

        //dd($request);
        $return_validated = $this->validate_request_data($request);

        if (!empty($return_validated)) {
            return $return_validated;
        }
        // CitizenEditRepository::storeatEditCitizen($request, 136);
        // CitizenEditRepository::storeatEditCitizen($request, 138);
        //LogManagementRepository::peskar_appeal_store($request, 138, null);
        // dd('ss');
       // dd($request);

        $appealInfo = [
            'appealId' => $request->appealId,
            'case_no' => $request->caseNo,
            'appeal_status' => $request->status,
            'court_fee_amount' => isset($request->court_fee_amount) ? $request->court_fee_amount : null,
            'manual_case_no' => isset($request->manual_case_no) ? $request->manual_case_no : null,
        ];

        //dd($appealInfo);
        DB::beginTransaction();
        try {
            $appealId = AppealRepository::storeAppealPeshkar($appealInfo);

            CitizenEditRepository::storeatEditCitizen($request, $appealId);

            $peshkar_note_id = PeshkarNoteRepository::store_peshkar_note($request, $appealId);

            if ($request->file_type && $_FILES['file_name']['name']) {
                $log_file_data = AttachmentRepository::storeAttachment('APPEAL', $appealId, $causeListId = date('Y-m-d'), $request->file_type);
                // AttachmentRepository::storeAttachment('APPEAL', $appealId, $causeListId, $request->file_type);
            } else {
                $log_file_data = null;
            }

            if (!empty($_FILES['court_fee_file'])) {
                //dd('1');
                $captions_main_court_Fee_report = 'কোর্ট ফি আদায় রশিদ এর স্ক্যান' . $appealId . date('Y-m-d');
                $court_fee_file_main = AttachmentRepository::storeInvestirationCourtFree('COURT_Fee', $request->appealId, $captions_main_court_Fee_report);
            } else {
                $court_fee_file_main = null;
            }

            $flag = 'true';
            DB::table('peskar_notes_modified')
                ->where('id', $peshkar_note_id)
                ->update([
                    'peshkar_attachmets' => $log_file_data,
                ]);

            if (!empty($court_fee_file_main)) {
                DB::table('em_appeals')
                    ->where('id', $appealId)
                    ->update([
                        'court_fee_file' => $court_fee_file_main,
                    ]);
            }

            LogManagementRepository::peskar_appeal_store($request, $appealId, $log_file_data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            $flag = 'false';
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'Internal Server Error',
                'status' => 'error',
            ]);
        }

        return response()->json([
            'success' => 'আদেশ সফলভাবে সংরক্ষণ করা হয়েছে',
            'status' => 'success',
            'message' => 'আদেশ সফলভাবে সংরক্ষণ করা হয়েছে',
        ]);

        // return redirect('appeal/pending/list')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
        // return redirect(route('appeal.index'))->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    }

    // public function edit(Request $request)
    // {
    //     $appealId=$request->id;
    //     $data=["districtId"=>'',
    //             "divisionId"=>'',
    //             "appealId"=>$appealId];

    //     return view('appealInitiate.appealCreate')->with('data',$data);
    // }
    public function edit($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        //$office_id = $user->office_id;
        $roleID = $user->role_id;
        //$officeInfo = user_office_info();

        $appeal = EmAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal'] = $appeal;
        //$data["notes"] = $appeal->appealNotes;
        //$data["districtId"]= $officeInfo->district_id;
        //$data["divisionId"]=$officeInfo->division_id;
        //$data["office_id"] = $office_id;
        //$data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();
        $data['laws'] = DB::table('crpc_sections')
            ->select('crpc_sections.*')
            ->get();
        $data['divisionId'] = DB::table('division')
            ->select('division.*')
            ->get();
        $data['districtId'] = DB::table('district')
            ->select('district.*')
            ->where('division_id', $appeal->division_id)
            ->get();
        $data['districtId'] = DB::table('district')
            ->select('district.*')
            ->get();
        $data['upazilaId'] = DB::table('upazila')
            ->select('upazila.*')
            ->where('district_id', $appeal->district_id)
            ->get();
        $data['upazilaId'] = DB::table('upazila')
            ->select('upazila.*')
            ->get();
        //dd($appeal->appealNotes);
        $law_id = $appeal->law_section;
        $crpc_id = CrpcSection::select('crpc_id')
            ->where('id', $law_id)
            ->first()->crpc_id;
        $data['shortOrderList'] = DB::table('peshkar_case_shortdecisions')
            ->orderBy('peshkar_case_shortdecisions.id', 'ASC')
            ->where('peshkar_case_shortdecisions.law_sec_id', 'like', '%' . $crpc_id . '%')
            ->join('peshkar_case_shortdecisions_details', 'peshkar_case_shortdecisions.id', '=', 'peshkar_case_shortdecisions_details.case_short_decision_id')
            ->where('peshkar_case_shortdecisions_details.law_sec_id', $crpc_id)
            ->select('peshkar_case_shortdecisions.*', 'peshkar_case_shortdecisions_details.delails', 'peshkar_case_shortdecisions_details.sms_templet')
            ->get();
            
        $em_investigation_report_before_accepted = DB::table('em_investigation_report')
            ->where('appeal_id', '=', $id)
            ->where('is_investigation_report_accepted', '=', 0)
            ->get();

        $em_investigation_report_after_accepted = DB::table('em_investigation_report')->where('appeal_id', '=', $id)
            ->where('is_investigation_report_accepted', '=', 1)
            ->get();

        $data['em_investigation_report_before_accepted'] = $em_investigation_report_before_accepted;
        $data['em_investigation_report_after_accepted'] = $em_investigation_report_after_accepted;

        $data['page_title'] = 'অভিযোগ দায়েরের তথ্য সংশোধন';
        // return $data;
        $shortoder_array = PeshkarNoteRepository::order_list($id);

        $data['shortoder_array'] = isset($shortoder_array) ? $shortoder_array : [];

        $data['em_last_order'] = PeshkarNoteRepository::em_last_order($id);

        //dd($data['shortoder_array']);

        return view('appealInitiate.appealEdit')->with($data);
    }

    public function fileDelete(Request $request, $id)
    {
        $fileID = $id;
        AttachmentRepository::deleteFileByFileID($fileID);
        return response()->json([
            'msg' => 'success',
        ]);
    }
    public function appealCitizenDelete($citizen_id)
    {
        $appealCitizen = AppealCitizenRepository::checkAppealCitizenExist($citizen_id);
        // return $citizen_id;
        if ($appealCitizen->delete()) {
            return response()->json([
                'msg' => 'success',
            ]);
        }
        return response()->json([
            'msg' => 'error',
        ]);
    }

    public function delete($id = null)
    {
        $id = decrypt($id);
        $appeal = EmAppeal::findOrFail($id);

        $cases = EmAppeal::where('id', $id)->get();
        foreach ($cases as $case) {
            DB::table('em_case_shortdecision_templates')
                ->where('appeal_id', $case->id)
                ->delete();
            DB::table('em_appeal_order_sheets')
                ->where('appeal_id', $case->id)
                ->delete();
            DB::table('em_attachments')
                ->where('appeal_id', $case->id)
                ->delete();
            DB::table('em_cause_lists')
                ->where('appeal_id', $case->id)
                ->delete();
            DB::table('em_appeal_citizens')
                ->where('appeal_id', $case->id)
                ->delete();
            DB::table('em_notes')
                ->where('appeal_id', $case->id)
                ->delete();
        }

        $appeal->delete();
        return redirect()
            ->back()
            ->with('success', 'তথ্য সফলভাবে মুছে ফেলা হয়েছে');
    }
    public function appealFullDelete($citizen_id)
    {
        $appealCitizen = AppealCitizenRepository::checkAppealCitizenExist($citizen_id);
        // return $citizen_id;
        if ($appealCitizen->delete()) {
            return response()->json([
                'msg' => 'success',
            ]);
        }
        return response()->json([
            'msg' => 'error',
        ]);
    }

    public function deleteAppealFile($fileID, $appealID)
    {
        AttachmentRepository::deleteAppealFile($fileID, $appealID);
        return response()->json([
            'msg' => 'success',
        ]);
    }

    public function number_field_check(Request $request)
    {
        if (is_numeric(bn2en($request->court_fee_amount))) {
            return response()->json([
                'is_numeric' => true,
            ]);
        } else {
            return response()->json([
                'is_numeric' => false,
            ]);
        }
    }
    public function validate_request_data($requestInfo)
    {
        //dd($requestInfo);
         //check the data already modified or not
         $appeal=DB::table('em_appeals')->where('id',$requestInfo->appealId)->first();
         $user=DB::table('users')->where('id',$appeal->updated_by)->first();
         if(!empty($user))
         {
            if($appeal->action_required == "EM_DM")
            {
               return response()->json([
                   'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                   'message' => 'মামলাটিতে ইতিমধ্যে '.$user->name.' তথ্য সংশোধন করেছেন ',
                   'div_id' => 'receiver_land_details',
                   'status' => 'error',
               ]);
            }
         }
         
        
         if (!empty($requestInfo->defaulter_change)){
             
           $mes=$this->checkdateDefulterDataInputPerfectly($requestInfo);
           
           if(!empty($mes))
           {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => $mes,
                'div_id' => 'receiver_land_details',
                'status' => 'error',
            ]);
           }
           
         }
         if (!empty($requestInfo->defaulter_withness_change)){
             
            $mes=$this->checkdateDefulterWithnessDataInputPerfectly($requestInfo);
            if(!empty($mes))
            {
             return response()->json([
                 'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                 'message' => $mes,
                 'div_id' => 'receiver_land_details',
                 'status' => 'error',
             ]);
            }
          }
          if (!empty($requestInfo->defaulter_lawyer_change)){
             
            $mes=$this->checkdateDefulterLawyerDataInputPerfectly($requestInfo);
            if(!empty($mes))
            {
             return response()->json([
                 'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                 'message' => $mes,
                 'div_id' => 'receiver_land_details',
                 'status' => 'error',
             ]);
            } 
          }

        if (!empty($requestInfo->defaulter_withness_change) || !empty($requestInfo->defaulter_lawyer_change) || !empty($requestInfo->defaulter_change)) {

            $all_request_nids = [];

            if (!empty($requestInfo->victim['nid'])) {
                array_push($all_request_nids, $requestInfo->victim['nid']);
            }

            foreach ($requestInfo->defaulter['nid'] as $value_nid_single) {
                if (!empty($value_nid_single)) {
                    array_push($all_request_nids, $value_nid_single);
                }
            }

            foreach ($requestInfo->defaulerWithness['nid'] as $value_nid_single) {
                if (!empty($value_nid_single)) {
                    array_push($all_request_nids, $value_nid_single);
                }
            }
            foreach ($requestInfo->defaulerLawyer['nid'] as $value_nid_single) {
                if (!empty($value_nid_single)) {
                    array_push($all_request_nids, $value_nid_single);
                }
            }

            foreach ($requestInfo->witness['nid'] as $value_nid_single) {
                array_push($all_request_nids, $value_nid_single);
            }

            array_push($all_request_nids, $requestInfo->lawyer['nid']);
            array_push($all_request_nids, $requestInfo->applicant['nid']);

            if (count(array_unique($all_request_nids)) != count($all_request_nids)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'আপনি একই নাগরিককে একাধিকবার আবেদনকারী , ভিক্টিম , বিবাদী , সাক্ষী ,অথবা আইনজীবী হিসেবে যোগ করেছেন !',
                    'div_id' => 'appeal_date_time_status',
                    'status' => 'error',
                ]);
            }
        }

        //validatePhoneNumberOnTrial

        foreach ($requestInfo->defaulter['phn'] as $key => $value_phn_single) {
            if (EmCitizen::find($requestInfo->defaulter['id'][$key])->citizen_phone_no != $value_phn_single && empty($requestInfo->defaulter['nid'][$key])) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'বিবাদীর NID সঠিক ভাবে পূরণ করলে moblie edit করতে পারবেন !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                ]);
            }
            if (!empty($requestInfo->defaulter['nid'][$key])) {
                $mobile_error = $this->validatePhoneNumberOnTrial($value_phn_single);

                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'বিবাদীর মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'বিবাদীর মোবাইল নম্বর format সঠিক নয় !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                    ]);
                }
            }
        }

        foreach ($requestInfo->defaulter['email'] as $value_email_single) {
            if (EmCitizen::find($requestInfo->defaulter['id'][$key])->email != $value_email_single && empty($requestInfo->defaulter['nid'][$key])) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'বিবাদীর NID সঠিক ভাবে পূরণ করলে email edit করতে পারবেন !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                ]);
            }
            if (!empty($requestInfo->defaulter['nid'][$key])) {
                if (!empty($value_email_single)) {
                    $email_check = $this->validateEmail($value_email_single);
                    if ($email_check == 'format_error') {
                        return response()->json([
                            'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                            'message' => 'বিবাদীর ইমেইল format সঠিক নয় !',
                            'div_id' => 'receiver_land_details',
                            'status' => 'error',
                        ]);
                    }
                }
            }

        }

        foreach ($requestInfo->defaulerWithness['phn'] as $key => $value_phn_single) {
            if (empty($requestInfo->defaulerWithness['nid'][$key]) && !(empty($value_phn_single))) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'বিবাদী পক্ষের সাক্ষীর NID না দিলে মোবাইল নম্বর দেয়ার সুযোগ নেই  !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                ]);
            }
            if (!empty($requestInfo->defaulerWithness['nid'][$key])) {
                $mobile_error = $this->validatePhoneNumberOnTrial($value_phn_single);

                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'বিবাদী পক্ষের সাক্ষীর মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'বিবাদী পক্ষের সাক্ষীর মোবাইল নম্বর format সঠিক নয় !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                    ]);
                }
            }

        }

        if (empty($requestInfo->defaulerLawyer['nid'][0]) && !empty($requestInfo->defaulerLawyer['phn'][0])) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'বিবাদী পক্ষের আইনজীবী NID না দিলে মোবাইল নম্বর দেয়ার সুযোগ নেই  !',
                'div_id' => 'receiver_land_details',
                'status' => 'error',
            ]);
        }
        if (!empty($requestInfo->defaulerLawyer['nid'][0])) {
            $defaulerLawyer_mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->defaulerLawyer['phn'][0]);

            if ($defaulerLawyer_mobile_error == 'size_error') {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'বিবাদী পক্ষের আইনজীবীর মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                ]);
            } elseif ($defaulerLawyer_mobile_error == 'format_error') {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'বিবাদী পক্ষের আইনজীবীর মোবাইল নম্বর format সঠিক নয় !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                ]);
            }
        }

        if (empty($requestInfo->defaulerLawyer['nid'][0]) && !empty($requestInfo->defaulerLawyer['email'][0])) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'বিবাদী পক্ষের আইনজীবী NID না দিলে ইমেইল দেয়ার সুযোগ নেই  !',
                'div_id' => 'receiver_land_details',
                'status' => 'error',
            ]);
        }

        if (!empty($requestInfo->defaulerLawyer['nid'][0]) && !empty($requestInfo->defaulerLawyer['email'][0])) {
            $email_check = $this->validateEmail($requestInfo->defaulerLawyer['email'][0]);
            if ($email_check == 'format_error') {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'বিবাদী পক্ষের আইনজীবীর ইমেইল format সঠিক নয় !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                ]);
            }
        }

        // if (empty($requestInfo->trialDate)) {
        //     return response()->json([
        //         'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
        //         'message' => 'পরবর্তী তারিখ দিতে হবে !',
        //         'div_id' => 'appeal_date_time_status',
        //         'status' => 'error',
        //     ]);
        // }
    }

    public function validatePhoneNumberOnTrial($phone_number)
    {
        $phone_number=trim($phone_number);
        if (strlen($phone_number) != 11) {
            return 'size_error';
        } else {
            $pattern = '/(01)[0-9]{9}/';
            $preg_answer = preg_match($pattern, $phone_number);
            if (!$preg_answer) {
                return 'format_error';
            }
        }
    }

    public function validateEmail($email)
    {
        $email=trim($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //Valid email!
            return 'format_ok';
        } else {
            return 'format_error';
        }
    }

    public function checkdateDefulterDataInputPerfectly($requestInfo)
    {
        $message='';

        $field=[
            'name'=>'২য় পক্ষের নাম দিতে হবে',
            'father'=>'২য় পক্ষের পিতার নাম দিতে হবে',
            'mother'=>'২য় পক্ষের মাতার নাম দিতে হবে',
            'nid'=>'২য় পক্ষের পিতার নাম দিতে হবে',
            'phn'=>'২য় পক্ষের মোবাইল দিতে হবে',
            'presentAddress'=>'২য় পক্ষের ঠিকানা দিতে হবে'
        ];
 
        foreach($requestInfo->defaulter as $key=>$value)
        {
            if(!in_array($key,['name','father','mother','nid','phn','presentAddress']))
            {
                continue ;
            }
               foreach($requestInfo->defaulter[$key] as $child_key=>$child_value)
               {
                  
                    if(empty($requestInfo->defaulter[$key][$child_key]))
                    {
                         $message .=$field[$key].', ';
                    } 
                  
                  
               }
        }
         
        return $message;
    }
    public function checkdateDefulterWithnessDataInputPerfectly($requestInfo)
    {
        $message='';

        $field=[
            'name'=>'২য় পক্ষের সাক্ষীর নাম দিতে হবে',
            'father'=>'২য় পক্ষের সাক্ষীর পিতার নাম দিতে হবে',
            'mother'=>'২য় পক্ষের সাক্ষীর মাতার নাম দিতে হবে',
            'phn'=>'২য় পক্ষের সাক্ষীর মোবাইল দিতে হবে',
            'presentAddress'=>'২য় পক্ষের সাক্ষীর ঠিকানা দিতে হবে'
        ];
        foreach($requestInfo->defaulerWithness as $key=>$value)
        {
            if(!in_array($key,['name','father','mother','phn','presentAddress']))
            {
                continue ;
            }
               foreach($requestInfo->defaulerWithness[$key] as $child_key=>$child_value)
               {
                  
                    if(empty($requestInfo->defaulerWithness[$key][$child_key]))
                    {
                         $message .=$field[$key].', ';
                    } 
                  
                  
               }
        }
         
        return $message;
    }
    public function checkdateDefulterLawyerDataInputPerfectly($requestInfo)
    {
        $message='';

        $field=[
            'name'=>'২য় পক্ষের আইনজীবী নাম দিতে হবে',
            'father'=>'২য় পক্ষের আইনজীবী পিতার নাম দিতে হবে',
            'mother'=>'২য় পক্ষের আইনজীবী মাতার নাম দিতে হবে',
            'nid'=>'২য় পক্ষের আইনজীবী পিতার নাম দিতে হবে',
            'phn'=>'২য় পক্ষের আইনজীবী মোবাইল দিতে হবে',
            'presentAddress'=>'২য় পক্ষের আইনজীবী ঠিকানা দিতে হবে'
        ];
        foreach($requestInfo->defaulerLawyer as $key=>$value)
        {
            if(!in_array($key,['name','father','mother','nid','phn','presentAddress']))
            {
                continue ;
            }

               foreach($requestInfo->defaulerLawyer[$key] as $child_key=>$child_value)
               {
                  if(empty($key[$child_key]))
                  {
                       $message .=$field[$key].', ';
                  } 
               }
        }
        return $message;
    }
}
