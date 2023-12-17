<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmAppeal;
use Mcms\Auth\Exception;
use App\Models\EmCitizen;
use App\Models\Attachment;
use App\Models\CrpcSection;
use App\Models\EmCauseList;
use App\Models\EmLegalInfo;
use Illuminate\Http\Request;
use App\Models\EmPaymentList;
use App\Models\EmAppealCitizen;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Http;
use App\Repositories\AppealRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\CauseListRepository;
use App\Services\AppealOrderSheetService;
use App\Repositories\AttachmentRepository;
use App\Repositories\ShortOrderRepository;
use App\Repositories\PeshkarNoteRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\InvestigatorRepository;
use App\Repositories\LogManagementRepository;
use App\Repositories\OnlineHearingRepository;
use App\Repositories\WarrantExecutorRepository;
use App\Repositories\CitizenAttendanceRepository;
use App\Repositories\EmailNotificationRepository;
use App\Services\ShortOrderTemplateServiceUpdated;
use App\Repositories\CauseListShortDecisionRepository;

class AppealTrialController extends Controller
{
    public $permissionCode = 'certificateTrial';

    public function showTrialPage(Request $request, $id)
    {
        
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        // $shortOrderList=ShortOrderRepository::getShortOrderList();

        $appeal = EmAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal'] = $appeal;
        $law_id = $appeal->law_section;
        $crpc_id = CrpcSection::select('crpc_id')
            ->where('id', $law_id)
            ->first()->crpc_id;

        $data['districtId'] = $officeInfo->district_id;
        $data['divisionId'] = $officeInfo->division_id;
        $data['office_id'] = $office_id;
        $data['gcoList'] = User::where('office_id', $user->office_id)
            ->where('id', '!=', $user->id)
            ->get();
        // Check short decision by district
        // If not found this result
        $data['shortOrderList'] = DB::table('em_case_shortdecisions')
            ->orderBy('em_case_shortdecisions.id', 'ASC')
            ->where('em_case_shortdecisions.law_sec_id', 'like', '%' . $crpc_id . '%')
            ->join('em_case_shortdecisions_details', 'em_case_shortdecisions.id', '=', 'em_case_shortdecisions_details.case_short_decision_id')
            ->where('em_case_shortdecisions_details.law_sec_id', $crpc_id)
            ->select('em_case_shortdecisions.*', 'em_case_shortdecisions_details.delails', 'em_case_shortdecisions_details.sms_templet')
            ->get();
        if ($user->role_id == 27 || $user->role_id == 28) {
            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট পরিচালনা';
        } else {
            $data['page_title'] = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালত পরিচালনা';
        }

        $data['crpcID'] = $crpc_id;

        $em_investigation_report_before_accepted = DB::table('em_investigation_report')
            ->where('appeal_id', '=', $id)
            ->where('is_investigation_report_accepted', '=', 0)
            ->get();

        $em_investigation_report_after_accepted = DB::table('em_investigation_report')
            ->where('appeal_id', '=', $id)
            ->where('is_investigation_report_accepted', '=', 1)
            ->get();

        $data['em_investigation_report_before_accepted'] = $em_investigation_report_before_accepted;
        $data['em_investigation_report_after_accepted'] = $em_investigation_report_after_accepted;

        $data['peshkar_initial_comments'] = PeshkarNoteRepository::peshkar_initial_comments($id);

        $shortoder_array = PeshkarNoteRepository::order_list($id);

        $data['shortoder_array'] = isset($shortoder_array) ? $shortoder_array : [];

        // dd($data);
        return view('appealTrial.appealTrial')->with($data);
    }

    public function investigationReportPage(Request $request, $id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        // $shortOrderList=ShortOrderRepository::getShortOrderList();

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
        // Check short decision by district

        // If not found this result
        $data['shortOrderList'] = ShortOrderRepository::getShortOrderList();

        $data['page_title'] = 'তদন্তের রিপোর্ট প্রদানের ফরম';
        // return $data;
        return view('appealTrial.appealInvestigationReport')->with($data);
    }
    // public function showTrialPage(Request $request){
    //     $appealId=$request->id;
    //     $appealDetails = Appeal::where('id',$appealId)->first();
    //     $userRole = Session::get('userRole');

    //     // return view('appealTrial.appealTrial',compact('appealId',$appealId,'appealDetails',$appealDetails,'userRole',$userRole));
    //     return view('appealTrial.appealTrial',compact('appealId', 'appealDetails', 'userRole'));

    // }

    public function lastOrderDelete(Request $request)
    {
        if ($request->ajax()) {
            try {
                $causeListId = $request->causeListId;
                $appealId = $request->appealId;
                $appealDetails = Appeal::where('id', $appealId)->first();

                // Delete Last CauseList
                $lastCauseList = CauseListRepository::getPreviousCauseListId($appealId);
                CauseListRepository::destroyCauseListByCauseListId($lastCauseList->id);

                // Delete citizen Attendance
                $previouseCauseList = CauseListRepository::getPreviousCauseListId($appealId);
                CitizenAttendanceRepository::deletCitizenAttendanceByPreviousCaseDate($previouseCauseList->conduct_date, $appealId);

                // Delete appeal_order_sheets
                $previousOrderSheetList = AppealOrderSheetService::getLastOrderSheetByAppealId($appealId);
                AppealOrderSheetService::destroyOrderSheetByOrderSheetId($previousOrderSheetList->id);

                // Delete Note
                NoteRepository::destroyNoteByCauseListId($appealId, $causeListId);

                // File Delete
                $attachments = Attachment::where('appeal_id', $appealId)
                    ->where('cause_list_id', $causeListId)
                    ->get();
                foreach ($attachments as $attachment) {
                    AttachmentRepository::deleteFileByFileID($attachment->id);
                }

                // Delete Case Short decision
                CauseListShortDecisionRepository::deleteShortOrderListByCauseListId($causeListId);

                // Delete Case Short order template
                ShortOrderTemplateService::deleteShortOrderTemplate($causeListId);

                $flag = 'true';
            } catch (\Exception $e) {
                $flag = 'false';
            }
        }
        return response()->json([
            'flag' => $flag,
        ]);
    }

    public function storeOnTrialInfo(Request $request)
    {
            
        if ($request->status == 'REJECTED') {
            try {
                $appeal = EmAppeal::findOrFail($request->appealId);
                $appeal->appeal_status = $request->status;
                $appeal->updated_at = date('Y-m-d H:i:s');
                $appeal->updated_by = globalUserInfo()->id;
                $appeal->save();
                $applicantpeople = $this->get_applicant_info($request->appealId);
                $msisdn = [];
                array_push($msisdn, $applicantpeople['appplicant_citizen_phone_no']);
                
                //dd($msisdn);
                $message = 'আপনার অভিযোগটি বাতিল করা হল কারণ ' . $request->note;
                $this->send_sms($msisdn, $message);
                LogManagementRepository::RejectAppeal($request);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
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
        }
        $return_validated = $this->validate_request_data($request);

        if (!empty($return_validated)) {
            return $return_validated;
        }
       
        
        $caseNo = EmAppeal::select('case_no')
            ->where('id', $request->appealId)
            ->first()->case_no;
        $disName = EmAppeal::findOrFail($request->appealId);
        $districtName = $disName->district->district_name_bn;
        $shortOrderID = $request->shortOrder;
        foreach ($shortOrderID as $kew => $value) {
            if ($value == 8) {
                $typeID = 5;
            } elseif ($value == 11) {
                $typeID = 1;
            } else {
                $typeID = 2;
            }
            $sms_details = DB::table('em_case_shortdecisions_details')
                ->where('law_sec_id', $request->law_sec_id)
                ->where('case_short_decision_id', $value)
                ->select('sms_templet')
                ->first()->sms_templet;
        }
     
        $trialDate = str_replace('/', '-', $request->trialDate);
        DB::beginTransaction();
        try {
            $caseNo = null;

            $time = $request->trialTime;
            $chngdtime = date('H:i', strtotime($time));
            $appealId = AppealRepository::storeAppealForOnTrial($request);

            $caseNo = EmAppeal::select('case_no')
                ->where('id', $request->appealId)
                ->first()->case_no;

            if ($request->case_no != 'অসম্পূর্ণ মামলা') {
                CitizenAttendanceRepository::saveCitizenAttendance($request->citizenAttendance);
            }

            //dd($caseNo);

            $em_note_id = NoteRepository::store_em_dm_note($request, $appealId);

            if ($request->file_type && $_FILES['file_name']['name']) {
                $log_file_data = AttachmentRepository::storeAttachment('APPEAL', $appealId, date('Y-m-d'), $request->file_type);
            } else {
                $log_file_data = null;
            }

            $generateShortOrderTemplateID =ShortOrderTemplateServiceUpdated::generateShortOrderTemplate($request->shortOrder, $appealId, null, $request);
            
            if (!empty($generateShortOrderTemplateID)) {
                $shortorderTemplateUrl = [];
                $shortorderTemplateName = [];
                foreach ($generateShortOrderTemplateID as $value) {
                    array_push($shortorderTemplateUrl, url('/') . '/appeal/get/shortOrderSheets/' . $value);
                    array_push($shortorderTemplateName, get_short_order_name_by_id($value));
                }
                
            } else {
                $shortorderTemplateUrl = null;
                $shortorderTemplateName=null;
            }


            DB::table('em_notes_modified')
                ->where('id', $em_note_id)
                ->update([
                    'em_attachmets' => $log_file_data,
                ]);

            //return $log_file_data.'54545';

            $flag = 'true';

            if ($request->status != 'CLOSED') {
                OnlineHearingRepository::storeHearingKey($appealId, $request->shortOrder[0], $request->trialDate, $request->trialTime);
            }

            $this->get_sms_data($request, $appealId, $caseNo, $sms_details, $disName, $shortorderTemplateUrl);
            EmailNotificationRepository::send_email_notification($request, $appealId, $caseNo, $sms_details, $disName,$shortorderTemplateUrl,$shortorderTemplateName);

            LogManagementRepository::storeOnTrialInfo($request, $appealId, $log_file_data);

            //return $message_flag;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
             dd($e);
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

        //return redirect()->route('dashboard')->with('success', 'আদেশ সফলভাবে সংরক্ষণ করা হয়েছে');
    }
    public function caseAssignedADC($id)
    {
        // return $id;
        $appealId = decrypt($id);
        $data['appeal_id'] = $appealId;
        $data['page_title'] = 'এডিসিকে মামলার দায়িত্ব দেওয়ার ফর্ম ';
        // return $data;
        return view('appealTrial.caseAssignADC')->with($data);

        // return view('paymentList.paymentList')->with('appealId',$appealId);
    }
    public function caseAssignedADCstore(Request $request)
    {
        // return $request;
        try {
            $appealId = AppealRepository::storeAppealForAdcAssign($request);

            $flag = 'true';

            $message = 'মামলা নম্বর: ' . $request->appeal_id . '|';

            $mobile = $request->adcMobile;
            // $this->send_sms($mobile, $message);
        } catch (\Exception $e) {
            dd($e);
            $flag = 'false';
        }
        // return $data;
        return redirect('appeal/list')->with('success', 'এডিসি কে মামলা সফল ভাবে হস্তান্তর করা হয়েছে');
        return view('appealTrial.caseAssignADC')->with($data);
    }
    public function collectPaymentAmount(Request $request, $id)
    {
        // return $id;
        $appealId = decrypt($id);
        $appeal = EmAppeal::find($appealId);

        $paymentInfo = [];
        $totalLoanAmount = '';
        $caseNumber = '';
        $caseID = '';
        $totalDueAmount = '';
        if (isset($appealId)) {
            $totalLoanAmount = $appeal->loan_amount;
            $caseNumber = $appeal->case_no;
            $caseID = $appeal->id;
            $paymentStatus = $appeal->payment_status;
            $paymentInfo = PaymentService::getPaidListByAppealId($appealId);
            $totalDueAmount = PaymentService::getTotalDueAmount($appealId, $totalLoanAmount);
            $totalAuctionSale = PaymentService::getAuctionTotalAmount($appealId);
            // dd('minar');
        }

        $data = [
            'caseNumber' => $caseNumber,
            'caseID' => $caseID,
            'paymentStatus' => $paymentStatus,
            'totalAuctionSale' => $totalAuctionSale,
            'paymentList' => $paymentInfo,
            'totalLoanAmount' => $totalLoanAmount,
            'totalDueAmount' => $totalDueAmount,
            'appealId' => $appealId,
            'page_title' => 'অর্থ আদায়',
        ];
        // return $data;
        return view('paymentList.paymentList')->with($data);

        // return view('paymentList.paymentList')->with('appealId',$appealId);
    }

    public function printCollectPaymentAmount(Request $request, $id)
    {
        // return $id;
        $appealId = decrypt($id);
        $appeal = EmAppeal::find($appealId);

        $paymentInfo = [];
        $totalLoanAmount = '';
        $caseNumber = '';
        $totalDueAmount = '';
        if (isset($appealId)) {
            $totalLoanAmount = $appeal->loan_amount;
            $caseNumber = $appeal->case_no;
            $paymentStatus = $appeal->payment_status;
            $paymentInfo = PaymentService::getPaidListByAppealId($appealId);
            $totalDueAmount = PaymentService::getTotalDueAmount($appealId, $totalLoanAmount);
            $totalAuctionSale = PaymentService::getAuctionTotalAmount($appealId);
            // dd('minar');
        }

        $data = [
            'caseNumber' => $caseNumber,
            'paymentStatus' => $paymentStatus,
            'totalAuctionSale' => $totalAuctionSale,
            'paymentList' => $paymentInfo,
            'totalLoanAmount' => $totalLoanAmount,
            'totalDueAmount' => $totalDueAmount,
            'appealId' => $appealId,
            'page_title' => 'অর্থ আদায়',
        ];
        // return $data;
        return view('paymentList.printPaymentList')->with($data);

        // return view('paymentList.paymentList')->with('appealId',$appealId);
    }

    public function collectPaymentList(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')
            ->whereHas('causelistCaseshortdecision', function ($query) {
                $query->where('case_shortdecision_id', 19);
            })
            ->paginate(20);
        // if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
        //     // dd(1);
        //     $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
        //     $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
        //     $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'POSTPONED')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        // }
        // if(!empty($_GET['case_no'])) {
        //     $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'POSTPONED')->where('case_no','=',$_GET['case_no'])->paginate(5);
        // }
        $date = date($request->date);
        $caseStatus = 1;
        $userRole = globalUserInfo()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = globalUserInfo()->username;
        }
        $page_title = 'অর্থ আদায় মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function storeAppealPaymentInfo(Request $request)
    {
        // return $request->att_file;
        $appealId = $request->appealId;
        $lastPayment = PaymentRepository::storePaymentInfo($appealId, $request);
        $paymentId = $lastPayment->id;

        if ($request->att_file_caption && $request->att_file) {
            // AttachmentRepository::storeAttachmentOnPayment('APPEAL', $appealId, $paymentId, $request->captions);
            // $tmp_name = $_FILES["files"]["tmp_name"][0]['someName'];
            // // $fileName = $_FILES["files"]["name"][0]['someName'];
            // $fileCategory = $request->captions[0]['someCaption'];

            $appealYear = 'APPEAL - ' . date('Y');
            $appealID = 'AppealID - ' . $appealId;
            $filePath = 'APPEAL/' . $appealYear . '/' . $appealID . '/' . 'paymentInfo/';
            $fileName = $appealId . '_' . time() . '.' . request()->att_file->getClientOriginalExtension();
            $request->att_file->move(public_path($filePath), $fileName);
            $lastPayment->att_file = $filePath . $fileName;
            $lastPayment->att_file_caption = $request->att_file_caption;
            $lastPayment->save();
            // return $lastPayment;
        }
        return redirect()
            ->back()
            ->with('success', 'অর্থ আদায় সফলভাবে সংরক্ষণ করা হয়েছে!');
        return response()->json([
            'flag' => isset($paymentId) ? 'true' : 'false',
        ]);
    }

    public function deletePaymentInfoById($id)
    {
        $id = decrypt($id);
        $msg = 'মামলা সফলভাবে মুছে ফেলা হয়েছে!';
        $paymentInfo = EmPaymentList::find($id);
        if ($paymentInfo->att_file != null) {
            $path = public_path() . '/' . $paymentInfo->att_file;
            unlink($path);
        }
        $paymentInfo->delete();
        return redirect()
            ->back()
            ->with('success', $msg);
    }
    public function status_change(Request $request, $id)
    {
        $id = decrypt($id);
        $msg = 'মামলা সফলভাবে প্রেরণ করা হয়েছে!';
        $appeal = EmAppeal::findOrFail($id);
        $appeal->appeal_status = $request->status;
        $appeal->updated_at = date('Y-m-d H:i:s');
        $appeal->updated_by = globalUserInfo()->id;

        if ($request->status == 'REJECTED') {
            $appeal->case_decision_id = 5; //REJECTED
            $msg = 'মামলা সফলভাবে বর্জন করা হয়েছে';
        }
        if ($request->status == 'SEND_TO_DC') {
            $appeal->case_decision_id = 4; //কোর্ট বদলি
        }
        if ($request->status == 'SEND_TO_DIV_COM') {
            $appeal->case_decision_id = 4; //কোর্ট বদলি
        }
        if ($request->status == 'SEND_TO_NBR_CM') {
            $appeal->case_decision_id = 4; //কোর্ট বদলি
        }
        // return $appeal;
        if ($appeal->save()) {
            return redirect(route('appeal.index'))->with('success', $msg);
        }
        return redirect()
            ->back()
            ->with('error', 'দুঃখিত, কিছু ভুল হয়েছে!');
    }

    public function report_add(Request $request)
    {
        // return $request;
        $appealId = $request->hide_case_id;
        $legalInfos = EmLegalInfo::where('appeal_id', $appealId)->get();
        if (count($legalInfos) != 0) {
            foreach ($legalInfos as $item) {
                if (isset($item->report_file) && file_exists($item->report_file)) {
                    unlink($item->report_file);
                }
                $item->delete();
            }
        }

        $legalInfo = new EmLegalInfo();
        $legalInfo->appeal_id = $request->hide_case_id;
        $legalInfo->report_date = $request->report_date;
        $legalInfo->report_details = $request->report_details;
        $legalInfo->report_file = 'path';
        $legalInfo->created_by = globalUserInfo()->id;

        $legalInfo->appeal_id = $request->hide_case_id;
        if ($legalInfo->report_file != null) {
            $appealYear = 'APPEAL - ' . date('Y');
            $appealID = 'AppealID - ' . $appealId;
            $filePath = 'APPEAL/' . $appealYear . '/' . $appealID . '/' . 'legalInfo/';

            $fileName = $appealId . '_' . time() . '.' . request()->report_file->getClientOriginalExtension();
            $request->report_file->move(public_path($filePath), $fileName);
            $legalInfo->report_file = $filePath . $fileName;
            // return $fileName;
        }
        if ($legalInfo->save()) {
            $html = view('appealTrial.inc._legalReportSection')
                ->with(['legalInfo' => $legalInfo])
                ->render();
            return Response()->json(['success' => 'জারিকারকের রিপোর্ট সংরক্ষণ করা হয়েছে', 'data' => $html]);
        }
        return Response()->json(['error' => 'Something went wrong!', 'data' => []]);
    }
    public function attendance_print($id, Request $request)
    {
        $appeal = EmAppeal::find($id);
        $citizens = EmAppealCitizen::with('Citizen')
            ->where('appeal_id', $id)
            ->whereIn('citizen_type_id', [1, 2])
            ->get();
        $data['applicant'] = [
            'citizen_name' => $citizens[0]->citizen_type_id == 1 ? $citizens[0]->citizen->citizen_name : $citizens[1]->citizen->citizen_name,
            'designation' => $citizens[0]->citizen_type_id == 1 ? $citizens[0]->citizen->designation : $citizens[1]->citizen->designation,
        ];
        $data['defaulter'] = [
            'citizen_name' => $citizens[0]->citizen_type_id == 2 ? $citizens[0]->citizen->citizen_name : $citizens[1]->citizen->citizen_name,
            'designation' => $citizens[0]->citizen_type_id == 2 ? $citizens[0]->citizen->designation : $citizens[1]->citizen->designation,
        ];
        $data['trial_date'] = EmCauseList::orderby('id', 'DESC')
            ->select('*')
            ->where('appeal_id', $id)
            ->first();
        if ($data['trial_date'] == null) {
            $data['trial_date'] = $request->conductDate;
        }
        $data['case_no'] = $appeal->case_no;
        $data['district'] = $appeal->district->district_name_bn;
        $data['page_title'] = 'হাজিরা';
        // return $appeal;
        return view('report.hajira')->with($data);
    }

    public function send_sms_todonto($mobile_no, $message_details)
    {
        // print_r("+8801".$mobile_no.' , '.$message_details);exit('zuel');
        // $msisdn=$mobile_no;

        Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
            'auth' => [
                'username' => 'ecourt',
                'password' => 'A2ist2#0166',
                'acode' => 1005370,
            ],
            'smsInfo' => [
                'message' => $message_details,
                'is_unicode' => 1,
                'masking' => 8801552146224,
                'msisdn' => [
                    '0' => $mobile_no,
                ],
            ],
        ]);
    }

    public function send_sms($msisdn, $message)
    {
        // print_r($msisdn).'sms' .print_r($message);exit('alis');
        //   var_dump($msisdn);
        //   var_dump($message);
        //   exit('zuel');
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
                'msisdn' => $msisdn,
            ],
        ]);
    }

    public function get_applicant_info($appealId)
    {
        $ApplicantCitizenID = EmAppealCitizen::select('citizen_id')
            ->where('appeal_id', $appealId)
            ->where('citizen_type_id', 1)
            ->first()->citizen_id;

        $applicantpeople = EmCitizen::select('citizen_phone_no', 'citizen_name')
            ->where('id', $ApplicantCitizenID)
            ->first();

        $applicant_people_data = [
            'appplicant_citizen_name' => $applicantpeople->citizen_name,
            'appplicant_citizen_phone_no' => $applicantpeople->citizen_phone_no,
        ];

        return $applicant_people_data;
    }
    public function get_defaulter_people($appealId)
    {
        $DefaulterCitizenID = EmAppealCitizen::select('citizen_id')
            ->where('appeal_id', $appealId)
            ->where('citizen_type_id', 2)
            ->get();

        $defaulterpeople = [];

        foreach ($DefaulterCitizenID as $key => $value) {
            $defaulter = EmCitizen::select('citizen_name', 'citizen_phone_no')
                ->where('id', $value->citizen_id)
                ->first();

            $defaulterpeoplesingle = [
                'defaulter_citizen_name' => $defaulter->citizen_name,
                'defaulter_citizen_phone_no' => $defaulter->citizen_phone_no,
            ];

            array_push($defaulterpeople, $defaulterpeoplesingle);
        }

        return $defaulterpeople;
    }
    public function get_withness_people($appealId)
    {
        $WitnessCitizenID = EmAppealCitizen::select('citizen_id')
            ->where('appeal_id', $appealId)
            ->whereIn('citizen_type_id', [5, 6])
            ->get();

        $withnesspeople = [];

        foreach ($WitnessCitizenID as $key => $value) {
            $withness = EmCitizen::select('citizen_name', 'citizen_phone_no')
                ->where('id', $value->citizen_id)
                ->first();

            $withnesspeoplesingle = [
                'withness_citizen_name' => $withness->citizen_name,
                'withness_citizen_phone_no' => $withness->citizen_phone_no,
            ];

            array_push($withnesspeople, $withnesspeoplesingle);
        }

        return $withnesspeople;
    }

    public function get_vicitim_people($appealId)
    {
        $vicitimCitizenID = EmAppealCitizen::select('citizen_id')
            ->where('appeal_id', $appealId)
            ->where('citizen_type_id', 8)
            ->first()->citizen_id;

        $vicitimpeople = EmCitizen::select('citizen_phone_no', 'citizen_name')
            ->where('id', $vicitimCitizenID)
            ->first();

        $victim_people_data = [
            'victim_citizen_name' => $vicitimpeople->citizen_name,
            'victim_citizen_phone_no' => $vicitimpeople->citizen_phone_no,
        ];

        return $victim_people_data;
    }

    public function get_sms_data(Request $request, $appealId, $caseNo, $sms_details, $disName, $shortorderTemplateUrl)
    {
        $applicantName = null;
        $defaulterName = null;
        $victinName = null;
        $investigatorName = null;
        $warrantExecutorName = null;
        $witnessName = null;
        $nextDate = null;

        $applicantpeople = $this->get_applicant_info($appealId);
        //dd($applicantpeople);
        $defaulterpeople = $this->get_defaulter_people($appealId);
        $Witnesspeople = $this->get_withness_people($appealId);
        //dd($Witnesspeople);

        if ($request->law_sec_id == 100) {
            $vicitimpeople = $this->get_vicitim_people($appealId);
        }

        $nextDate = EmAppeal::select('next_date')
            ->where('id', $appealId)
            ->first()->next_date;
        $message_tracking = ' ';

        $message_flag = false;

        if ($request->shortOrder[0] == 2 || $request->shortOrder[0] == 5 || $request->shortOrder[0] == 21) {
            $investigatorId = InvestigatorRepository::storeInvestigator($appealId, $request);

            if ($request->shortOrder[0] == 21) {
                $citizenID = EmAppealCitizen::select('citizen_id')
                    ->where('appeal_id', $appealId)
                    ->where('citizen_type_id', 8)
                    ->first()->citizen_id;
                $tracking_code = EmAppeal::select('investigation_tracking_code')
                    ->where('id', $appealId)
                    ->first()->investigation_tracking_code;
                $victinName = EmCitizen::select('citizen_name')
                    ->where('id', $citizenID)
                    ->first()->citizen_name;
                $investigatorName = $request->investigatorName;

                $mobile_no = $request->investigatorMobile;
                $msisdn = [];

                array_push($msisdn, $mobile_no);

                $victinName = $vicitimpeople['victim_citizen_name'];

                $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);

                $court_details = $this->get_court_details($disName->court_id);

                $message_tracking = 'গোপন নম্বর  ' . $tracking_code . "\r\n" . $court_details->court_name . ', ' . $disName->district->district_name_bn;

                $message = $message . $message_tracking;
                
                $this->send_sms($msisdn, $message);
                $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
            } elseif ($request->shortOrder[0] == 2 || $request->shortOrder[0] == 5) {
                $tracking_code = EmAppeal::select('investigation_tracking_code')
                    ->where('id', $appealId)
                    ->first()->investigation_tracking_code;
                $investigatorName = $request->investigatorName;
              
                $mobile_no = $request->investigatorMobile;
                $msisdn = [];

                array_push($msisdn, $mobile_no);

                $applicantName=$applicantpeople['appplicant_citizen_name'];

                foreach ($defaulterpeople as $defaulterpeoplesingle) {
                    $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
                }
                
                $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);
                
                $court_details = $this->get_court_details($disName->court_id);

                $message_tracking = 'গোপন নম্বর  ' . $tracking_code . "\r\n" . $court_details->court_name . ', ' . $disName->district->district_name_bn;

                $message = $message . $message_tracking;
                // dd($message);
                $this->send_sms($msisdn, $message);
                $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
            }
        } elseif ($request->shortOrder[0] == 19) {
            $warrantExecutorId = WarrantExecutorRepository::storeWarrantExecutor($appealId, $request);

            $warrantExecutorName = $request->warrantExecutorName;

            $warrantExecutorMobile = $request->warrantExecutorMobile;

            $mobile_no = $warrantExecutorMobile;

            $msisdn = [];
            array_push($msisdn, $mobile_no);

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $applicantName=$applicantpeople['appplicant_citizen_name'];
            
            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
            }
            
            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            // dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 4 || $request->shortOrder[0] == 24) {
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $applicantName=$applicantpeople['appplicant_citizen_name'];

                foreach ($defaulterpeople as $defaulterpeoplesingle) {
                    $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
                }
            
            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            $msisdn = [];

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);
            }

            array_push($msisdn, $applicantpeople['appplicant_citizen_phone_no']);
            // dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 1) {
            $msisdn = [];

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);
            }

            $applicantName = $applicantpeople['appplicant_citizen_name'];
            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name'].', ';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            // dd($message);
            //dd($msisdn);

            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 9) {
            $msisdn = [];
            $defaulterName = ' ';

            $Payable = $request->bond_amount;
            $Payableyear = $request->bond_period;

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);

                $defaulterName .= $defaulterpeoplesingle['defaulter_citizen_name'] . ', ';
            }

            array_push($msisdn, $applicantpeople['appplicant_citizen_phone_no']);

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#Payable}', '{#year}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $Payable, $Payableyear, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            // dd($message);
            //dd($msisdn);

            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 13) {
            $msisdn = [];

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
            }

            $applicantName=$applicantpeople['appplicant_citizen_name'];

           

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            // dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 15) {
            $msisdn = [];

            array_push($msisdn, $applicantpeople['appplicant_citizen_phone_no']);
            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name'].', ';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            // dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 16) {
            $msisdn = [];
            $law_enforcement_forces_Mobile = $request->law_enforcement_forces_Mobile;
            $zillSuperMobile = $request->zillSuperMobile;

            array_push($msisdn, $law_enforcement_forces_Mobile, $zillSuperMobile);
            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name'].', ';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
    
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 7) {
            $msisdn = [];
            $law_enforcement_forces_Mobile = $request->law_enforcement_forces_Mobile;

            array_push($msisdn, $law_enforcement_forces_Mobile);
            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            // dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 26) {
            $msisdn = [];
            $law_enforcement_forces_Mobile = $request->law_enforcement_forces_Mobile;

            //dd($law_enforcement_forces_Mobile);

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);
                $defaulterName .= $defaulterpeoplesingle['defaulter_citizen_name']. ',';
            }

            $warrantExecutorName = $request->law_enforcement_forces_Name;

            array_push($msisdn, $law_enforcement_forces_Mobile);

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            //dd($msisdn);
            // dd($message);

            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 11 || $request->shortOrder[0] == 12) {
            $msisdn = [];
            $witnessName;
            foreach ($Witnesspeople as $withness) {
                array_push($msisdn, $withness['withness_citizen_phone_no']);
                $witnessName .=$withness['withness_citizen_name']. ',';
            }
            
            
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $timeOfhearing = explode(' ', date('g:i a', strtotime($request->trialTime)));

            if ($timeOfhearing[1] == 'pm') {
                $time_string = 'শুনানির সময় বিকাল ' . $timeOfhearing[0];
            } else {
                $time_string = 'শুনানির সময় সকাল ' . $timeOfhearing[0];
            }

            $message = str_replace($dummy, $original, $sms_details) . ' ' . $time_string;
            // dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 29) {
            $msisdn = [];
            $msisdn_receiver=[];
            $law_enforcement_forces_Mobile = $request->law_enforcement_forces_Mobile;
            array_push($msisdn, $law_enforcement_forces_Mobile);
            
            $receiver_Mobile = $request->receiver_Mobile;
            array_push($msisdn_receiver, $receiver_Mobile);

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, explode(';',$sms_details)[0]);

            $dummy_receiver = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}','{#ReceiverName}'];
            $original_reciver = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate,$request->receiver_Name];
            $message_receiver = str_replace($dummy_receiver, $original_reciver, explode(';',$sms_details)[1]);
            // dd($message);
            // dd($message_receiver);
            $this->send_sms($msisdn, $message);
            $this->send_sms($msisdn_receiver, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
            $this->send_template_url_in_sms($msisdn_receiver,$shortorderTemplateUrl);

        } elseif ($request->shortOrder[0] == 28) {
            $msisdn = [];
            $receiver_Mobile = $request->receiver_Mobile;
            array_push($msisdn, $receiver_Mobile);
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            //dd($message);
            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 23) {
            $msisdn = [];
            $law_enforcement_forces_Mobile = $request->law_enforcement_forces_Mobile;

            $victinName = $vicitimpeople['victim_citizen_name'];
            $applicantName=$applicantpeople['appplicant_citizen_name'];

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
            }
            array_push($msisdn, $law_enforcement_forces_Mobile);
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            // dd($message);
            //dd($msisdn);

            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        } elseif ($request->shortOrder[0] == 10) {
            $msisdn = [];
            $defaulterName = ' ';
            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);
                $defaulterName .= $defaulterpeoplesingle['defaulter_citizen_name'] . ',';
            }

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $applicantName = $applicantpeople['appplicant_citizen_name'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $timeOfhearing = explode(' ', date('g:i a', strtotime($request->trialTime)));
            if ($timeOfhearing[1] == 'pm') {
                $time_string = 'শুনানির সময় বিকাল ' . $timeOfhearing[0];
            } else {
                $time_string = 'শুনানির সময় সকাল ' . $timeOfhearing[0];
            }

            $message = str_replace($dummy, $original, $sms_details) . ' ' . $time_string;

            array_push($msisdn, $applicantpeople['appplicant_citizen_phone_no']);
            // dd($message);
            $this->send_sms($msisdn, $message);
        } elseif ($request->shortOrder[0] == 22) {
            $applicantName = $applicantpeople['appplicant_citizen_name'];

            $msisdn = [];

            foreach ($defaulterpeople as $defaulterpeoplesingle) {
                array_push($msisdn, $defaulterpeoplesingle['defaulter_citizen_phone_no']);
                $defaulterName .= $defaulterpeoplesingle['defaulter_citizen_name'] . ',';
            }

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            if ($request->law_sec_id == 100) {
                $victinName = $vicitimpeople['victim_citizen_name'];
            }

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            // dd($message);
            //dd($msisdn);

            $this->send_sms($msisdn, $message);
            $this->send_template_url_in_sms($msisdn,$shortorderTemplateUrl);
        }

        // if ($message_flag) {

        //     $dummy = ["{#caseNo}", "{#name1}", "{#name2}", "{#victim}", "{#investogator}", "{#warrantExecutor}", "{#witness}", "{#nextDate}"];

        //     $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

        //     $message = str_replace($dummy, $original, $sms_details);

        //     //dd($message);

        //     $message_details = $message . $message_tracking;
        //     //dd($message_details);
        //     $this->send_sms($msisdn, $message_details);
        // }
    }

    public function send_template_url_in_sms($msisdn,$shortorderTemplateUrl)
    {
        if (!empty($shortorderTemplateUrl)) {
            foreach ($shortorderTemplateUrl as $value) {
               
                $message2 = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট নোটিশ দেখতে প্রবেশ করুন ' . $value;
                $this->send_sms($msisdn, $message2);
            }
        }
    }

    public function get_court_details($court_id)
    {
        return DB::table('court')
            ->where('id', '=', $court_id)
            ->first();
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

    public function validate_request_data($requestInfo)
    {

        $note_hash_dynamic_field_error=[
          [
            'niddle'=>'({#investigator})',
            'message'=>'তদন্তকারীর নাম আদেশের মাঝে ঠিক মত আসে নাই অথবা তদন্তকারীর নাম দেওয়া হয় নাই'
          ],
          [
            'niddle'=>'{#Payable}',
            'message'=>'বন্ডের টাকার পরিমাণ আদেশের মাঝে ঠিক মত আসে নাই অথবা বন্ডের টাকার পরিমাণ দেওয়া হয় নাই'
          ],
          [
            'niddle'=>'{#year}',
            'message'=>'বন্ডের টাকার সময় আদেশের মাঝে ঠিক মত আসে নাই অথবা বন্ডের টাকার সময় দেওয়া হয় নাই'
          ],
          [
            'niddle'=>'{#complain}',
            'message'=>'অভিযোগের সংক্ষিপ্ত বিবরণ আদেশের মাঝে ঠিক মত আসে নাই অথবা অভিযোগের সংক্ষিপ্ত বিবরণ দেওয়া হয় নাই'
          ],
        ];
        foreach($note_hash_dynamic_field_error as $key=>$value)
        {
            if (str_contains($requestInfo->note, $note_hash_dynamic_field_error[$key]['niddle'])) { 
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => $note_hash_dynamic_field_error[$key]['message'],
                    'div_id' => 'note',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
        }
      
        
        




        $appeal=DB::table('em_appeals')->where('id',$requestInfo->appealId)->first();
         $user=DB::table('users')->where('id',$appeal->updated_by)->first()->name;
         if($appeal->action_required == "PESH")
         {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                'message' => 'মামলাটিতে ইতিমধ্যে '.$user.' কোর্ট পরিচালনা করেছেন ',
                'div_id' => 'receiver_land_details',
                'status' => 'error',
                'note'=>$requestInfo->note
            ]);
         }

        if ($requestInfo->status == 'CLOSED' && $requestInfo->orderPublishDecision == 1 && empty($requestInfo->finalOrderPublishDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'সম্পূর্ণ আদেশ প্রকাশের তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status',
                'status' => 'error',
                'note'=>$requestInfo->note
            ]);
        }

        if ($requestInfo->status == 'ON_TRIAL' && empty($requestInfo->trialDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'পরবর্তী তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status',
                'status' => 'error',
                'note'=>$requestInfo->note
            ]);
        }

        if ($requestInfo->status == 'ON_TRIAL_DM' && empty($requestInfo->trialDate)) {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'পরবর্তী তারিখ দিতে হবে !',
                'div_id' => 'appeal_date_time_status',
                'status' => 'error',
                'note'=>$requestInfo->note
            ]);
        }
        if(in_array($requestInfo->shortOrder[0],[18,15,4]) && $requestInfo->status == 'ON_TRIAL')
        {
            return response()->json([
                'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                'message' => 'আপনি মামলা নিষ্পত্তির আদেশ দিয়েছেন সে ক্ষেত্রে অবস্থা চলমান থেকে নিষ্পত্তি দিন',
                'div_id' => 'is_varified_org',
                'status' => 'error',
                'note'=>$requestInfo->note
            ]);
        }


        // $trialDate_fomatted=strrev(str_replace('/','-',$requestInfo->trialDate));
        // if($requestInfo->shortOrder[0] == 11 || $requestInfo->shortOrder[0] == 12)
        // {
        //     $is_hearing=true;
        // }
        // else
        // {
        //     $is_hearing=false;
        // }

        if (!empty($requestInfo->trialDate) && !empty($requestInfo->trialTime) && in_array($requestInfo->shortOrder[0], [10, 11, 12]) && $requestInfo->status !== 'CLOSED') {
            if ($requestInfo->trialDate == date('d/m/Y', strtotime(now()))) {
                date_default_timezone_set('Asia/Dhaka');
                $time_in_24hr = date('H:i');
                $requestInfoHour = explode(':', $requestInfo->trialTime)[0];
                $requestInfoMinitue = explode(':', $requestInfo->trialTime)[1];

                $currentHour = explode(':', $time_in_24hr)[0];
                $currentMinitue = explode(':', $time_in_24hr)[1];

                if ($currentHour > $requestInfoHour) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => 'আপনি শুনানির সময় বর্তমান সময়ের আগে দিয়েছেন !',
                        'div_id' => 'appeal_date_time_status',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($currentHour == $requestInfoHour) {
                    if ($currentMinitue > $requestInfoMinitue) {
                        return response()->json([
                            'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                            'message' => 'আপনি শুনানির সময় বর্তমান সময়ের আগে দিয়েছেন !',
                            'div_id' => 'appeal_date_time_status',
                            'status' => 'error',
                            'note'=>$requestInfo->note
                        ]);
                    }
                }
            }

            $format1 = explode('/', $requestInfo->trialDate);
            $format2 = $format1[2] . '-' . $format1[1] . '-' . $format1[0];

            $appealIds = [];
            array_push($appealIds, $requestInfo->appealId);
            $role_id = globalUserInfo()->role_id;

            $beforeTotalTime = strtotime($requestInfo->trialTime) - 300;
            $afterTotalTime = strtotime($requestInfo->trialTime) + 300;

            $beforeTimeSting = date('H:i:s', $beforeTotalTime);
            $afterTimeSting = date('H:i:s', $afterTotalTime);

            if ($role_id == 27 || $role_id == 38) {
                $exiting_trail_date = EmAppeal::select('case_no', 'next_date_trial_time')
                    ->where('next_date', $format2)
                    ->where('updated_by', globalUserInfo()->id)
                    ->where('court_id', globalUserInfo()->court_id)
                    ->whereBetween('next_date_trial_time', [$beforeTimeSting, $afterTimeSting])
                    ->whereNotIn('id', $appealIds)
                    ->get();
            } elseif ($role_id == 7) {
                $exiting_trail_date = EmAppeal::select('case_no', 'next_date_trial_time')
                    ->where('next_date', $format2)
                    ->where('updated_by', globalUserInfo()->id)
                    ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                    ->where('district_id', user_district())
                    ->whereNotIn('id', $appealIds)
                    ->whereBetween('next_date_trial_time', [$beforeTimeSting, $afterTimeSting])
                    ->get();
            }

            if (count($exiting_trail_date) > 0) {
                $message = 'ইতিমধ্যে  ';
                $message .= $requestInfo->trialDate . ' তারিখে ';
                foreach ($exiting_trail_date as $row) {
                    $bela = '';
                    if (!empty($row->next_date_trial_time)) {
                        if (date('a', strtotime($row->next_date_trial_time)) == 'am') {
                            $bela = 'সকাল';
                        } else {
                            $bela = 'বিকাল';
                        }
                    }

                    $message .= $bela . ' ' . date('h:i', strtotime($row->next_date_trial_time)) . ' মিনিটের সময়  ' . $row->case_no . ' নং আভিযোগের শুনানির সময় দেয়া আছে';
                    $message .= ', ';
                }

                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => $message,
                    'div_id' => 'appeal_date_time_status',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
        }

        if ($requestInfo->shortOrder[0] == 2 || $requestInfo->shortOrder[0] == 5 || $requestInfo->shortOrder[0] == 21) {
            if (empty($requestInfo->investigatorName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'তদন্তকারীর  নাম দিতে হবে ! ',
                    'div_id' => 'investigatorDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->investigatorInstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'তদন্তকারীর প্রতিষ্ঠানের নাম দিতে হবে ! ',
                    'div_id' => 'investigatorDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->investigatorMobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'তদন্তকারীর মোবাইল নম্বর দিতে হবে ! ',
                    'div_id' => 'investigatorDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->investigatorMobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => 'তদন্তকারীর মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে ! ',
                        'div_id' => 'investigatorDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => 'তদন্তকারীর মোবাইল নম্বর format সঠিক নয় ! ',
                        'div_id' => 'investigatorDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
            if (!empty($requestInfo->investigatorEmail)) {
                $email_check = $this->validateEmail($requestInfo->investigatorEmail);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                        'message' => 'তদন্তকারীর ইমেইল format সঠিক নয় ! ',
                        'div_id' => 'investigatorDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
        }
        if ($requestInfo->shortOrder[0] == 19) {
            if (empty($requestInfo->warrantExecutorName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর নাম দিতে হবে ! ',
                    'div_id' => 'warrantExecutorDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->warrantExecutorInstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর প্রতিষ্ঠানের নাম দিতে হবে ! ',
                    'div_id' => 'warrantExecutorDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->warrantExecutorMobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই !',
                    'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল নম্বর দিতে হবে ! ',
                    'div_id' => 'warrantExecutorDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->warrantExecutorMobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই !  ',
                        'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে! ',
                        'div_id' => 'warrantExecutorDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল নম্বর format সঠিক নয় ! ',
                        'div_id' => 'warrantExecutorDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
            if (!empty($requestInfo->warrantExecutorEmail)) {
                $email_check = $this->validateEmail($requestInfo->warrantExecutorEmail);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'ওয়ারেন্ট বাস্তবায়নকারীর ইমেইল format সঠিক নয় ! ',
                        'div_id' => 'warrantExecutorDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
        }
        if ($requestInfo->shortOrder[0] == 16) {
            if (empty($requestInfo->zillSuperName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                    'message' => 'জেল সুপার নাম দিতে হবে ! ',
                    'div_id' => 'warrantExecutorZellSuperDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->zillSuperInstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                    'message' => 'জেল সুপার প্রতিষ্ঠানের নাম দিতে হবে ! ',
                    'div_id' => 'warrantExecutorZellSuperDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->zillSuperMobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                    'message' => 'জেল সুপার মোবাইল নম্বর দিতে হবে ! ',
                    'div_id' => 'warrantExecutorZellSuperDetails',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->zillSuperMobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'জেল সুপার  মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে ! ',
                        'div_id' => 'warrantExecutorZellSuperDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                        'message' => 'জেল সুপার  মোবাইল নম্বর format সঠিক নয় ! ',
                        'div_id' => 'warrantExecutorZellSuperDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
            if (!empty($requestInfo->zillSuperEmail)) {
                $email_check = $this->validateEmail($requestInfo->zillSuperEmail);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'জেল সুপার বাহিনী ইমেইল format সঠিক নয় !',
                        'div_id' => 'warrantExecutorZellSuperDetails',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }

            if (empty($requestInfo->law_enforcement_forces_Name)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                    'message' => 'আইনশৃঙ্খলা বাহিনী নাম দিতে হবে !',
                    'div_id' => 'law_enforcement_forces_Details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->law_enforcement_forces_InstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই  !',
                    'message' => 'আইনশৃঙ্খলা বাহিনী প্রতিষ্ঠানের নাম দিতে হবে !',
                    'div_id' => 'law_enforcement_forces_Details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->law_enforcement_forces_Mobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'আইনশৃঙ্খলা বাহিনী মোবাইল নম্বর দিতে হবে !',
                    'div_id' => 'law_enforcement_forces_Details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->law_enforcement_forces_Mobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'আইনশৃঙ্খলা বাহিনী মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে ! ',
                        'div_id' => 'law_enforcement_forces_Details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'আইনশৃঙ্খলা বাহিনী মোবাইল নম্বর format সঠিক নয় !',
                        'div_id' => 'law_enforcement_forces_Details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
            if (!empty($requestInfo->law_enforcement_forces_Email)) {
                $email_check = $this->validateEmail($requestInfo->law_enforcement_forces_Email);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'আইনশৃঙ্খলা বাহিনী ইমেইল format সঠিক নয় !',
                        'div_id' => 'law_enforcement_forces_Details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
        }
        if ($requestInfo->shortOrder[0] == 7 || $requestInfo->shortOrder[0] == 26 || $requestInfo->shortOrder[0] == 29 || $requestInfo->shortOrder[0] == 23) {
            if (empty($requestInfo->law_enforcement_forces_Name)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'আইনশৃঙ্খলা বাহিনী নাম দিতে হবে !',
                    'div_id' => 'law_enforcement_forces_Details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->law_enforcement_forces_InstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'আইনশৃঙ্খলা বাহিনী প্রতিষ্ঠানের নাম দিতে হবে ! ',
                    'div_id' => 'law_enforcement_forces_Details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->law_enforcement_forces_Mobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'আইনশৃঙ্খলা বাহিনী মোবাইল নম্বর দিতে হবে !',
                    'div_id' => 'law_enforcement_forces_Details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->law_enforcement_forces_Mobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'আইনশৃঙ্খলা বাহিনী  মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে ! ',
                        'div_id' => 'law_enforcement_forces_Details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'আইনশৃঙ্খলা বাহিনী  মোবাইল নম্বর format সঠিক নয় !',
                        'div_id' => 'law_enforcement_forces_Details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
            if (!empty($requestInfo->law_enforcement_forces_Email)) {
                $email_check = $this->validateEmail($requestInfo->law_enforcement_forces_Email);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'আইনশৃঙ্খলা বাহিনী ইমেইল format সঠিক নয় !',
                        'div_id' => 'law_enforcement_forces_Details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
        }
        if ($requestInfo->shortOrder[0] == 28 || $requestInfo->shortOrder[0] == 29) {
            if (empty($requestInfo->receiver_Name)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'রিসিভার নাম দিতে হবে !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->receiver_InstituteName)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'রিসিভার প্রতিষ্ঠানের নাম দিতে হবে !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
            if (empty($requestInfo->receiver_Mobile)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'রিসিভার মোবাইল নম্বর দিতে হবে !',
                    'div_id' => 'receiver_land_details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            } else {
                $mobile_error = $this->validatePhoneNumberOnTrial($requestInfo->receiver_Mobile);
                if ($mobile_error == 'size_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'রিসিভার মোবাইল নম্বর ইংরেজিতে 11 digit দিতে হবে !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                } elseif ($mobile_error == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'রিসিভার মোবাইল নম্বর format সঠিক নয় !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
            if (!empty($requestInfo->receiver_Email)) {
                $email_check = $this->validateEmail($requestInfo->receiver_Email);
                if ($email_check == 'format_error') {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'রিসিভার ইমেইল format সঠিক নয় !',
                        'div_id' => 'receiver_land_details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
        }
        if($requestInfo->law_sec_id !=144 || $requestInfo->law_sec_id !=100 || $requestInfo->law_sec_id !=145 )
        {
            if ($requestInfo->shortOrder[0] == 9 || $requestInfo->shortOrder[0]  == 3 || $requestInfo->shortOrder[0]  == 33 || $requestInfo->shortOrder[0]  == 22) {
                if (empty($requestInfo->bond_amount) || $requestInfo->bond_amount < 0) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'বন্ড টাকা দিতে হবে! ',
                        'div_id' => 'bond_amount_bond_details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
                if (empty($requestInfo->bond_period) || $requestInfo->bond_period < 0) {
                    return response()->json([
                        'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                        'message' => 'সময় (বছর) দিতে হবে ! ',
                        'div_id' => 'bond_amount_bond_details',
                        'status' => 'error',
                        'note'=>$requestInfo->note
                    ]);
                }
            }
        }

        if ($requestInfo->shortOrder[0] == 10 || $requestInfo->shortOrder[0]  == 11 || $requestInfo->shortOrder[0]  == 5) {
            if (empty($requestInfo->complain_detail)) {
                return response()->json([
                    'error' => 'আদেশ সংরক্ষণ করা হয় নাই',
                    'message' => 'অভিযোগের সংক্ষিপ্ত বিবরণ দিতে হবে !',
                    'div_id' => 'complain_details',
                    'status' => 'error',
                    'note'=>$requestInfo->note
                ]);
            }
        }
        
    }

    public function get_dynamic_name_defulter_applicant(Request $request)
    {
      
        $applicant_name=$this->get_applicant_info($request->appeal_id);
        $defulter_name=$this->get_defaulter_people($request->appeal_id);
        $withness_name= $this->get_withness_people($request->appeal_id);

        if($request->law_sec_id == 100)
        {
           $victim_name=$this->get_vicitim_people($request->appeal_id);
        }
        $defaulterName=null;
        $applicantName=null;
        $victinName=null;
        $withnessName=null;
        if(!empty($applicant_name))
        {
            $applicantName=$applicant_name['appplicant_citizen_name'];
        }
        if(!empty($defulter_name))
        {
            foreach ($defulter_name as $defaulterpeoplesingle) {
                $defaulterName .=$defaulterpeoplesingle['defaulter_citizen_name']. ',';
            }
        }
        if(!empty($victim_name))
        {
            $victinName = $victim_name['victim_citizen_name'];
        }
        if(!empty($withness_name))
        {
            foreach ($withness_name as $withnesspeoplesingle) {
                $withnessName .=$withnesspeoplesingle['withness_citizen_name']. ',';
            }
        }
       // dd($withnessName);
        $dummy = ['{#name1}', '{#name2}', '{#victim}', '{#witness}'];

        $original = [$applicantName, substr($defaulterName, 0, -1), $victinName, substr($withnessName, 0, -1)];

        $message = str_replace($dummy, $original, $request->details);
       
        return response()->json([
            'success'=>'success',
            'message'=> $message 
        ]);
    }
}
