<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Appeal;
use App\Models\Citizen;
use App\Models\EmAppeal;
use App\Models\CauseList;
use App\Models\Attachment;
use App\Models\EmCauseList;
use App\Services\SmsService;
use Illuminate\Http\Request;
use App\Models\AppealCitizen;
use App\Models\EmAppealCitizen;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Services\ProjapotiServices;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Repositories\AppealRepository;
use App\Repositories\CitizenRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\AppealerRepository;
use Illuminate\Support\Facades\Redirect;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\CauseListRepository;
use App\Repositories\LawBrokenRepository;
use App\Repositories\UserAgentRepository;
use App\Repositories\AttachmentRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\AppealCitizenRepository;
use App\Repositories\LogManagementRepository;
use App\Repositories\CauseListShortDecisionRepository;

class CitizenAppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // exit('hi');
        $results = EmAppeal::orderby('id', 'desc')
            ->whereHas('appealWithAppealCitizens', function ($query) {
                $query->where('citizen_id', Auth::user()->role_id);
            })
            ->paginate(20);
        // return $results->appealCitizens;
        $date = date('Y-m-d');
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'মামলার তালিকা';
        //return view('appealList.appeallist')->with('date',$date);
        return view('citizen.caseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return EmAppeal::all();
        $user = globalUserInfo();

        if ($user->is_cdap_user == 1) {
            $citizen_info_cdap = DB::table('cdap_users')
                ->where('nid', '=', $user->citizen_nid)
                ->first();
        } else {
            $citizen_info = DB::table('em_citizens')
                ->where('id', '=', $user->citizen_id)
                ->first();
        }
        //dd($citizen_info);

        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $divisions = DB::table('division')
            ->select('division.*')
            ->get();
        $gcoList = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();

        $appealId = null;
        $laws = DB::table('crpc_sections')
            ->select('crpc_sections.*')
            ->where('status', 1)
            ->get();
        $law_details = DB::table('crpc_section_details')
            ->select('crpc_section_details.*')
            ->get();
        if (globalUserInfo()->is_cdap_user == 1) {
            $mobile_int_2_str = (string) globalUserInfo()->mobile_no;

            $mobile_number_reshaped = '0' . $mobile_int_2_str;
        } else {
            $mobile_number_reshaped = globalUserInfo()->mobile_no;
        }

        
        //dd($citizen_info);
        $data = [
            'divisionId' => $divisions,
            'office_id' => $office_id,
            'appealId' => $appealId,
            'gcoList' => $gcoList,
            'lawSections' => $laws,
            'law_details' => $law_details,
            'office_name' => $officeInfo->office_name_bn,
            'citizen_gender' => isset($citizen_info->citizen_gender) ? $citizen_info->citizen_gender : strtoupper($citizen_info_cdap->gender),
            'father' => isset($citizen_info->father) ? $citizen_info->father : $citizen_info_cdap->father_name,
            'mother' => isset($citizen_info->mother) ? $citizen_info->mother : $citizen_info_cdap->mother_name,
            'present_address' => isset($citizen_info->present_address) ? $citizen_info->present_address : $citizen_info_cdap->present_address,
            'mobile_number_reshaped' => globalUserInfo()->mobile_no,
        ];
       
        // dd( $data );

        $page_title = 'অভিযোগ দায়ের ফর্ম';
        return view('citizenAppealInitiate.appealCreateNew')->with(['data' => $data, 'page_title' => $page_title]);
    }

    public function create_old()
    {
        // return EmAppeal::all();
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();
        $divisions = DB::table('division')
            ->select('division.*')
            ->get();
        $gcoList = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();

        $appealId = null;
        $laws = DB::table('crpc_sections')
            ->select('crpc_sections.*')
            ->where('status', 1)
            ->get();
        $law_details = DB::table('crpc_section_details')
            ->select('crpc_section_details.*')
            ->get();
        $data = [
            'divisionId' => $divisions,
            'office_id' => $office_id,
            'appealId' => $appealId,
            'gcoList' => $gcoList,
            'lawSections' => $laws,
            'law_details' => $law_details,
            'office_name' => $officeInfo->office_name_bn,
        ];

        $page_title = 'অভিযোগ দায়ের ফর্ম';
        return view('citizenAppealInitiate.appealCreateNew_30_06_2022')->with(['data' => $data, 'page_title' => $page_title]);
    }

    public function appeal_nid_check(Request $request)
    {
        $all_nids = [];

        foreach ($request->nids as $nid_single) {
            if (!empty($nid_single)) {
                array_push($all_nids, $nid_single);
            }
        }
        if (count(array_unique($all_nids)) != count($all_nids)) {
            return response()->json([
                'error' => 'অভিযোগ সংরক্ষণ করা হয় নাই',
                'message' => 'আপনি একই নাগরিককে একাধিকবার আবেদনকারী, ভিক্টিম, বিবাদী, সাক্ষী অথবা আইনজীবী হিসেবে যোগ করেছেন ',
                'status' => 'error',
            ]);
        }

        if (empty($request->case_details)) {
            return response()->json([
                'error' => 'অভিযোগ সংরক্ষণ করা হয় নাই',
                'message' => 'অভিযোগের বিবরণ দিতে হবে ',
                'status' => 'error',
            ]);
        
        }

        $em_court_id = DB::table('case_mapping')
            ->select('court_id')
            ->where('district_id', $request->district)
            ->where('upazilla_id', $request->upazila)
            ->where('status', 1)
            ->whereIn('lavel', [0, 1])
            ->get();

        if (count($em_court_id) == 0) {
            return response()->json([
                'error' => 'অভিযোগ সংরক্ষণ করা হয় নাই',
                'message' => 'দুঃখিত! নির্বাচিত জেলায়/উপজেলায় আদালত ম্যাপিং করা হয় নি ',
                'status' => 'error',
            ]);
        }

        return response()->json([
            'status' => 'success',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //var_dump($_FILES);

        //dd($request);

        if (globalUserInfo()->role_id == 36) {
            $all_request_nids = [];

            array_push($all_request_nids, $request->applicant['nid']);

            if (!empty($request->victim['nid'])) {
                array_push($all_request_nids, $request->victim['nid']);
            }

            foreach ($request->defaulter['nid'] as $value_nid_single) {
                if(!empty($value_nid_single))
                {

                    array_push($all_request_nids, $value_nid_single);
                }
            }

            foreach ($request->witness['nid'] as $value_nid_single) {
                array_push($all_request_nids, $value_nid_single);
            }

            array_push($all_request_nids, $request->lawyer['nid']);

            if (count(array_unique($all_request_nids)) != count($all_request_nids)) {
                return Redirect::back()->with('Errormassage', 'আপনি একই নাগরিককে একাধিকবার আবেদনকারী , ভিক্টিম , বিবাদী , সাক্ষী ,অথবা আইনজীবী হিসেবে যোগ করেছেন');
            }
        } elseif (globalUserInfo()->role_id == 20 && $request->is_own_case == 0) {
            $all_request_nids = [];

            array_push($all_request_nids, $request->applicant['nid']);
            if (!empty($request->victim['nid'])) {
                array_push($all_request_nids, $request->victim['nid']);
            }
            foreach ($request->defaulter['nid'] as $value_nid_single) {
                array_push($all_request_nids, $value_nid_single);
            }
            foreach ($request->witness['nid'] as $value_nid_single) {
                array_push($all_request_nids, $value_nid_single);
            }

            if (count(array_unique($all_request_nids)) != count($all_request_nids)) {
                return Redirect::back()->with('Errormassage', 'আপনি একই নাগরিককে একাধিকবার আবেদনকারী , ভিক্টিম , বিবাদী ,অথবা সাক্ষী  হিসেবে যোগ করেছেন');
            }
        } elseif (globalUserInfo()->role_id == 20 && $request->is_own_case == 1) {
            $all_request_nids = [];

            array_push($all_request_nids, $request->applicant['nid']);
            if (!empty($request->victim['nid'])) {
                array_push($all_request_nids, $request->victim['nid']);
            }
            foreach ($request->defaulter['nid'] as $value_nid_single) {
                array_push($all_request_nids, $value_nid_single);
            }
            foreach ($request->witness['nid'] as $value_nid_single) {
                array_push($all_request_nids, $value_nid_single);
            }
            array_push($all_request_nids, $request->lawyer['nid']);

            if (count(array_unique($all_request_nids)) != count($all_request_nids)) {
                return Redirect::back()->with('Errormassage', 'আপনি একই নাগরিককে একাধিকবার আবেদনকারী , ভিক্টিম , বিবাদী ,সাক্ষী অথবা আইনজীবী হিসেবে যোগ করেছেন');
            }
        }

        if (empty($request->case_details)) {
            return Redirect::back()->with('Errormassage', 'অভিযোগের বিবরণ দিতে হবে');
        }

        $flag = 'false';

        if ($request->status == 'SEND_TO_ASST_EM') {
            $em_court_id = DB::table('case_mapping')
                ->select('court_id')
                ->where('district_id', $request->district)
                ->where('upazilla_id', $request->upazila)
                ->where('status', 1)
                ->where('lavel', 0)
                ->first();
        } elseif ($request->status == 'SEND_TO_ASST_DM') {
            $em_court_id = DB::table('case_mapping')
                ->select('court_id')
                ->where('district_id', $request->district)
                ->where('upazilla_id', $request->upazila)
                ->where('status', 1)
                ->where('lavel', 1)
                ->first();
        }

        if ($request->status == 'SEND_TO_ASST_DM' || $request->status == 'SEND_TO_ASST_EM') {
            if (empty($em_court_id)) {
                return Redirect::back()->with('Errormassage', 'দুঃখিত! নির্বাচিত জেলায়/উপজেলায় আদালত ম্যাপিং করা হয় নি');
            } else {
                $court_id = $em_court_id->court_id;
            }
        } else {
            $court_id = globalUserInfo()->court_id;
        }

        $caseDate = bn2en($request->caseDate);

        if ($request->appealEntryType == 'edit') {
            $peshkar_comment = $request->peshkar_comment;
            $is_own_case = null;
        } else {
            $is_own_case = $request->is_own_case;
            $peshkar_comment = null;
        }

        $appealInfo = [
            'appealId' => $request->appealId,
            'appeal_status' => $request->status,
            'case_date' => date('Y-m-d', strtotime(str_replace('/', '-', $caseDate))),
            'caseEntryType' => $request->caseEntryType,
            'law_section' => $request->lawSection,
            'applicant_type' => $request->applicant['type'],
            'initial_note' => $request->note,
            'division_id' => $request->division,
            'district_id' => $request->district,
            'upazila_id' => $request->upazila,
            'case_details' => $request->case_details,
            'is_own_case' => $is_own_case,
            'court_id' => $court_id,
            'peshkar_comment' => $peshkar_comment,
            'appealEntryType' => $request->appealEntryType,
        ];

        //dd($appealInfo);
        DB::beginTransaction();
        try {
            // $trialDate = date('Y-m-d', strtotime($request->caseDate));
            // $trialTime = date('H:i', strtotime(date('h:i:s A')));
            // $conductDate = date('Y-m-d', strtotime($request->caseDate));
            // $conductTime = date('H:i', strtotime(date('h:i:s A')));

            $appealId = AppealRepository::storeAppeal($appealInfo);

            CitizenRepository::storeCitizen($request, $appealId);

            if ($request->file_type && $_FILES['file_name']['name']) {
                $log_file_data = AttachmentRepository::storeAttachment('APPEAL', $appealId, $causeListId = date('Y-m-d'), $request->file_type);
                // AttachmentRepository::storeAttachment('APPEAL', $appealId, $causeListId, $request->file_type);
            } else {
                $log_file_data = null;
            }
            $flag = 'true';

            LogManagementRepository::citizen_appeal_store($request, $appealId, $log_file_data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            $flag = 'false';
            return redirect()
                ->back()
                ->with('error', 'দুঃখিত! তথ্য সংরক্ষণ করা হয়নি ');
        }
        return redirect('appeal/pending/list')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function show(Citizen $citizen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = EmAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal'] = $appeal;
        $data['notes'] = $appeal->appealNotes;
        $data['districtId'] = $officeInfo->district_id;
        $data['divisionId'] = $officeInfo->division_id;
        $data['office_id'] = $office_id;
        $data['gcoList'] = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();
        $data['laws'] = DB::table('crpc_sections')
            ->select('crpc_sections.*')
            ->get();
        $data['divisionId'] = DB::table('division')
            ->select('division.*')
            ->get();
        // $data["districtId"] = DB::table('district')->select('district.*')->where('division_id',$appeal->division_id)->get();
        $data['districtId'] = DB::table('district')
            ->select('district.*')
            ->get();
        // $data["upazilaId"] = DB::table('upazila')->select('upazila.*')->where('district_id',$appeal->district_id)->get();
        $data['upazilaId'] = DB::table('upazila')
            ->select('upazila.*')
            ->get();

        $data['page_title'] = 'অভিযোগ দায়ের ের তথ্য সংশোধন';
        // return $data;
        return view('citizenAppealInitiate.appealEdit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Citizen $citizen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Citizen  $citizen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Citizen $citizen)
    {
        //
    }

    public function getDependentDistrict($id)
    {
        $subcategories = DB::table('district')
            ->where('division_id', $id)
            ->pluck('district_name_bn', 'id');
        return json_encode($subcategories);
    }

    public function getDependentUpazila($id)
    {
        $subcategories = DB::table('upazila')
            ->where('district_id', $id)
            ->pluck('upazila_name_bn', 'id');
        return json_encode($subcategories);
    }

    public function getDependentCourt($id)
    {
        $subcategories = DB::table('court')
            ->where('district_id', $id)
            ->pluck('court_name', 'id');
        return json_encode($subcategories);
    }

    public function getDependentLawDetails($id)
    {
        $crpcDetails = DB::table('crpc_section_details')
            ->select('crpc_details')
            ->where('crpc_id', $id)
            ->first();
        // $crpcDetails = nl2br($crpcDetails);
        return json_encode($crpcDetails);
    }

    public function send_sms($mobile, $message)
    {
        // print_r($mobile.' , '.$message);exit('zuel');
        //$msisdn=$mobile;

        Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
            'auth' => [
                'username' => 'ecourt',
                'password' => 'A2ist2#0166',
                'acode' => 1005370,
            ],
            'smsInfo' => [
                'message' => $message,
                'is_unicode' => 1,
                'masking' => 8801552146224,
                'msisdn' => [
                    '0' => $mobile,
                ],
            ],
        ]);
    }
}
