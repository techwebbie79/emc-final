<?php
/**
 * Created by PhpStorm.
 * User: pranab
 * Date: 11/17/17
 * Time: 5:59 PM
 */
namespace App\Repositories;


use App\Models\Appeal;
use App\Models\LawBroken;
use App\Models\RaiOrder;
use App\Services\AdminAppServices;
use App\Services\DataConversionService;
use App\Services\ProjapotiServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\EmAppeal;
use App\Models\EmCitizen;
use App\Models\User;
use Illuminate\Support\Str;


class AppealRepository
{
    public static function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }
    public static function getDigitalCaseNumber($userName,$appealId)
    {
        /*
         * total 17 digit
         *  District Code 2 digit
         *  upozila Code 2 digit
         * 	court code	2 digit
         *  service id	5 digit
         *  Sequential number  4 Digit
         *  last two digit of year 2 digit
         */
        /*
         * total 20 digit
         *  District Code 2 digit
         * 	Office Code	3 digit
         *  service id	5 digit
         *  Sequential number  6 Digit
         *  Year  4 digit
         */
        /*
         * total 18 digit
         * magistrate id  4
         * iffice id  4 digit
         * Sequential number 6
         * year 4
         */

        $magistrate_serviceId = "";
        $magistrate_serviceId_Bng = "";
        $magistrate_serviceId_Eng = "";

        $dmInfo=array();
        if(Session::get('flagForSSOLogin')==1){
            $dmInfo=ProjapotiServices::getPermisionWiseUser($userName);
        }else{
            $dmInfo=ProjapotiServices::getPermisionWiseUserLocalDb($userName);
        }

        $divid_mag = $dmInfo[0]->divisionBbsCode;
        $zillaId_mag = $dmInfo[0]->districtId;
        if($dmInfo[0]->upazilaId){
            $upozilaid_mag = $dmInfo[0]->upazilaId;
        }else{
            $upozilaid_mag = 0;
        }

        if (isset($dmInfo[0]->identity_no) && $dmInfo[0]->identity_no!="0") {

            $serviceId = $dmInfo[0]->identity_no;
            $width = 5;

            $new_service_strEng = DataConversionService::banToEngNumberConversion($serviceId);
            $new_service_strBng = DataConversionService::engToBanglaNumberConversion($serviceId);

            if ($new_service_strEng != '') {
                $magistrate_serviceId_Eng = str_pad((string)$new_service_strEng, $width, "0", STR_PAD_LEFT);
            } else {
                $magistrate_serviceId_Eng = $serviceId;
            }

            if ($new_service_strBng != '') {
                $magistrate_serviceId_Bng = str_pad((string)$new_service_strBng, $width, "0", STR_PAD_LEFT);
            } else {
                $magistrate_serviceId_Bng = $serviceId;

            }

        } else {
            $magistrate_serviceId_Bng = "00000";
            $magistrate_serviceId_Eng = "00000";
        }

        $part1 = "";
        $upozilacode = "00";

        if (isset($upozilaid_mag) ) {
            $upozilacode = $upozilaid_mag;
        } else {
            $upozilacode = "00";
        }

        $part1 = str_pad((string)$zillaId_mag, 2, "0", STR_PAD_LEFT) . str_pad((string)$upozilacode, 2, "0", STR_PAD_LEFT);
        $part2 = "03"; // mobile court 01//appeal court 02 //certificate court 03
        $part_Eng = $magistrate_serviceId_Eng;
        $part_Bng = $magistrate_serviceId_Bng;
        $part4 = ".____."; // sequential number
        $part5 = date('y');

        $appeals=DB::connection('appeal')
            ->select(DB::raw(
                "SELECT appeals.case_no  AS case_no
                 FROM appeals
                 WHERE appeals.id !=$appealId AND appeals.gco_user_id='$userName' AND case_no!='অসম্পূর্ণ মামলা' "
            ));


        $max_value = count($appeals);
        $lastFourChar = $max_value;  // 4th slot is fixed for case number
        $lastFourNumber = (int)$lastFourChar + 1;

        $part4 = str_pad($lastFourNumber, 4, '0', STR_PAD_LEFT);
        $serviceId = substr($userName, -5);
        $code = str_pad($part1, 4, '0', STR_PAD_LEFT) .
            '.' . str_pad($part2, 2, '0', STR_PAD_LEFT) .
            '.' . str_pad($serviceId, 5, '0', STR_PAD_LEFT) .
            '.' . $part4 .
            '.' . $part5;

        return $code;
    }

    public static function checkAppealExist($appealId){
        if(isset($appealId)){
            $appeal=EmAppeal::find($appealId);
        }else{
            $appeal=new EmAppeal();
        }
        // dd($appeal);
        return $appeal;
    }

    public static function getAppealByCaseNo($caseNo){
        $appeal=DB::connection('appeal')
            ->select(DB::raw(
                "SELECT appeals.case_no  AS case_no
                    FROM appeals
                    WHERE appeals.case_no='$caseNo' "
            ));
        return $appeal ? $appeal :'$caseNo';
    }

    public static function generateCaseNo($appealId){
        $appeal=EmAppeal::find($appealId);
        // dd($appeal);

        if($appeal->appeal_status=='SEND_TO_EM'){
            // $appeal->case_no=self::getDigitalCaseNumber($appeal->gco_user_id,$appealId);
            $appeal->case_no= '2022_02' .globalUserInfo()->id . $appealId;
            $appeal->save();
        }

        if($appeal->appeal_status=='SEND_TO_DM'){
            // $appeal->case_no=self::getDigitalCaseNumber($appeal->gco_user_id,$appealId);
            $appeal->case_no= '2022_02' .globalUserInfo()->id . $appealId;
            $appeal->save();
        }

        return;
    }

    public static function storeAppeal($appealInfo){
        

        if ($appealInfo->status == 'SEND_TO_ASST_EM') {
            $em_court_id=DB::table('case_mapping')->select('court_id')->where('district_id',$appealInfo->district)->where('upazilla_id',$appealInfo->upazila)->where('status',1)->first();
            // dd($em_court_id->court_id);
        }elseif ($appealInfo->status == 'SEND_TO_ASST_DM') {
            $em_court_id=DB::table('court')->select('id')->where('district_id',$appealInfo->district)->where('status',1)->where('level',1)->first();
            // dd($em_court_id->id);
        }
        // dd($em_court_id);
        // if(empty($em_court_id) || $em_court_id == null)
        // {
        //     return redirect('/citizen/appeal/create')
        //         ->with('error', 'দুঃখিত! নির্বাচিত জেলায়/উপজেলায় আদালত ম্যাপিং করা হয় নি');
        // }
        // dd(1);
        $caseDate = bn2en($appealInfo->caseDate);
        $appeal = self::checkAppealExist($appealInfo->appealId);
        $user = globalUserInfo();
        
        try {
        // dd($appealInfo->caseDate);
            
            $appeal->case_no="অসম্পূর্ণ মামলা";
            $appeal->appeal_status= $appealInfo->status;
            $appeal->case_date =date('Y-m-d',strtotime(str_replace('/', '-', $caseDate)));
            // $appeal->case_date =date('Y-m-d',strtotime(str_replace('/', '-', $appealInfo->caseDate)));
            $appeal->case_entry_type=$appealInfo->caseEntryType;
            
            $appeal->law_section=$appealInfo->lawSection;
            // $appeal->case_decision_id=$appealInfo->caseDecision;
            
            $appeal->applicant_type=$appealInfo->applicant['type'];
            
            $appeal->updated_by=$user->id;
            $appeal->initial_note=$appealInfo->note;
            $appeal->flag_on_trial=0;
            $appeal->office_id=$user->office_id;
            $appeal->division_id=$appealInfo->division;
            $appeal->district_id=$appealInfo->district;
            $appeal->upazila_id=$appealInfo->upazila;
            $appeal->case_details=$appealInfo->case_details;
            $appeal->is_own_case=$appealInfo->is_own_case;
            
            //dd($appealInfo->appealEntryType);

            if ($appealInfo->status == 'SEND_TO_ASST_EM') 
            {
                $appeal->court_id =$em_court_id->court_id;
            }
            elseif ($appealInfo->status == 'SEND_TO_ASST_DM') 
            {
                $appeal->court_id =$em_court_id->id;
            }
            if ($appealInfo->appealEntryType == 'edit') 
            {
                $appeal->peshkar_comment =$appealInfo->peshkar_comment;
            }
            $appeal->office_unit_id=$user->role_id;
            $appeal->office_unit_name=$user->role->role_name;
            $appeal->created_at=date('Y-m-d H:i:s');
            $appeal->updated_at=date('Y-m-d H:i:s');

            if($appealInfo->appealEntryType == 'create'){
                $appeal->created_by=$user->id;
            }else{
                $appeal->updated_by=$user->id;
            }
            
            $appeal->save();
            
            $appealId=$appeal->id;
           
        } catch (\Exception $e) {
            // dd($e);
            $appealId=null;
        }
        return $appealId;
    }
    public static function storeAppealForOnTrial($appealInfo){
        // dd($appealInfo->shortOrder[0]);
        $appeal=self::checkAppealExist($appealInfo->appealId);
        
        self::generateCaseNo($appeal->id);

        $trialDate = $appealInfo->trialDate;;
        $date_format = str_replace('/', '-', $trialDate);

        $finalOrderPublishDate = $appealInfo->finalOrderPublishDate;;
        $orderPublishDate_format = str_replace('/', '-', $finalOrderPublishDate);
        try {
            $appeal->flag_on_trial=1;
            $appeal->appeal_status=$appealInfo->status;
            $appeal->payment_status=$appealInfo->paymentStatus;
            $appeal->case_decision_id=$appealInfo->appealDecision;
            $appeal->next_date=date('Y-m-d',strtotime($date_format));
            $appeal->next_date_trial_time=$appealInfo->trialTime;
            if($appealInfo->shortOrder[0] == 2 || $appealInfo->shortOrder[0] == 5 || $appealInfo->shortOrder[0] == 21){
                $random_code = Str::random(6);
                // dd($random_code);
                $appeal->investigator_type_id=$appealInfo->investigatorType;
                $appeal->investigation_tracking_code=$random_code;
                $appeal->investigator_assigned=1;
            }
            if($appealInfo->status == 'CLOSED'){
                $appeal->final_order_publish_status=$appealInfo->orderPublishDecision;
                $appeal->final_order_publish_date=date('Y-m-d',strtotime($orderPublishDate_format));
                $appeal->is_applied_for_review=0;
            }
            $appeal->updated_at=date('Y-m-d H:i:s');
            $appeal->updated_by= globalUserInfo()->id;
            $appeal->save();
            $appealId=$appeal->id;

        }catch (\Exception $e) {
            $appealId=null;
        }
        return $appealId;
    }

    public static function storeAppealForAdcAssign($appealInfo){
        // dd($appealInfo->shortOrder[0]);
        $appeal=self::checkAppealExist($appealInfo->appeal_id);
        // self::generateCaseNo($appeal->id);
        try {
            $appeal->flag_on_trial=1;
            $appeal->is_assigned=1;
            $appeal->assigned_adc_id=$appealInfo->nothiID;
            $appeal->updated_at=date('Y-m-d H:i:s');
            $appeal->updated_by= globalUserInfo()->id;

            $appeal->save();
            $appealId=$appeal->id;

        }catch (\Exception $e) {
            $appealId=null;
        }
        return $appealId;
    }


    public static function destroyAppeal($appealId){

        $appeal=EmAppeal::where('id',$appealId);
        $appeal->delete();
        return;
    }

    public static function appealRollback($appealId){
        self::destroyAppeal($appealId);

        CauseListRepository::destroyCauseList($appealId);

        NoteRepository::destroyNote($appealId);

        $citizenIds=AppealCitizenRepository::destroyAppealCitizen($appealId);
        CitizenRepository::destroyCitizen($citizenIds);

    }

    public static function getAllAppealInfo($appealId){
        //variable declare
        $applicantCitizen=[];
        $victimCitizen=[];
        $defaulterCitizen=[];
        $guarantorCitizen=[];
        $lawerCitizen=[];
        $witnessCitizen=[];
        $policeCitizen=[];
        $issuerCitizen=[];
        $citizenAttendance=[];
        $notApprovedNoteList=[];
        $notApprovedAttachmentList=[];
        $notApprovedShortOrderList=[];


        // $userInfo=Session::get('userInfo');
        $userInfo= globalUserInfo();
        //find appeal
        // $thanas=AdminAppServices::getThana($userInfo->office->district_id);
        $appeal = EmAppeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens=$appeal->appealCitizens;
        // dd($citizens);
        $LegalInfo=LegalInfoRepository::getLegalInfoByAppealId($appealId);
        $noteCauseList=NoteRepository::getNoteCauseListByAppealId($appealId);
        $attachmentList = AttachmentRepository::getAttachmentListByAppealId($appealId);
        $approvedNoteList=NoteRepository::getApprovedNoteList($appealId);

        $notApprovedNoteList=NoteRepository::getNotApprovedNote($appealId);
        // dd($notApprovedNoteList);
        if(count($notApprovedNoteList)>0){
            $notApprovedAttachmentList=AttachmentRepository::getAttachmentListByAppealIdAndCauseListId($appealId,$notApprovedNoteList[0]->cause_list_id);
            $notApprovedShortOrderList=CauseListShortDecisionRepository::getShortOrderListByAppealIdAndCauseListId($appealId,$notApprovedNoteList[0]->cause_list_id);
        }

        //get DM role office info
        // $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('GCO_');
        $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode($userInfo->role_id);
        //get Dm list

        $gcoList=array();
        //get Gco list
        // if(Session::get('flagForSSOLogin')==1) {
        //     $gcoList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo,Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        // }else{
            // $gcoList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo,$userInfo->office->district_id, $userInfo->office_id);
        // }



            // $min  = [];
        // foreach ($citizens as $citizen){
        //     // $min []= $citizen->citizenType;
        //     $citizenTypes = $citizen->citizenType;
        //     //dd($citizenTypes);


        //     foreach ($citizenTypes as $citizenType){
        //         // $min .= "," .$citizenType->id;
        //         if($citizenType->id==1){
        //             // $citizenAttendance[]=CitizenAttendanceRepository::getCitizenAttendanceByParameter($appealId,$citizen->id,$appeal->appealCauseList[count($appeal->appealCauseList)-1]->conduct_date);
        //             $applicantCitizen[]=$citizen;
        //         }
        //         if($citizenType->id==2){
        //             // $citizenAttendance[]=CitizenAttendanceRepository::getCitizenAttendanceByParameter($appealId,$citizen->id,$appeal->appealCauseList[count($appeal->appealCauseList)-1]->conduct_date);
        //             $defaulterCitizen[]=$citizen;
        //             // dd($citizen);
        //         }
        //         if($citizenType->id==3){
        //             $guarantorCitizen=$citizen;
        //         }
        //         if($citizenType->id==4){
        //             $lawerCitizen[]=$citizen;
        //            // dd($lawerCitizen);
        //         }
        //         if($citizenType->id==5){
        //             $witnessCitizen[]=$citizen;
        //         }
        //         if($citizenType->id==6){
        //             $policeCitizen=$citizen;
        //         }
        //         if($citizenType->id==7){
        //             $issuerCitizen=$citizen;
        //         }
        //         if($citizenType->id==8){
        //             $victimCitizen[]=$citizen;
        //         }
        //     }
        // }
         //dd($lawerCitizen);
        // dd('minar');
        
        $lawerCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',4)
        ->select('em_citizens.id')
        ->first();
   
        //
        //dd($lawerCitizenDB);

       $lawerCitizen=EmCitizen::find($lawerCitizenDB->id);
        
       
      


        $applicantCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',1)
        ->select('em_citizens.id')
        ->get();
        
        $applicatIDs=[];
        foreach($applicantCitizenDB as $applicantCitizenSingle)
         {
            array_push($applicantCitizen,EmCitizen::find($applicantCitizenSingle->id)); 
         }

        
        
        $victimCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',8)
        ->select('em_citizens.id')
        ->get();

        $victimIDs=[];
        foreach($victimCitizenDB as $victimCitizenSingle)
         {
            array_push($victimCitizen,EmCitizen::find($victimCitizenSingle->id)); 
         }

        $witnessCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',5)
        ->select('em_citizens.id')
        ->get();

        $witnessIDs=[];
       foreach($witnessCitizenDB as $witnessCitizenSingle)
        {
            array_push($witnessCitizen,EmCitizen::find($witnessCitizenSingle->id)); 
        }


        $defaulterCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',2)
        ->select('em_citizens.id')
        ->get();
        
        $defaulterIDs=[];
       foreach($defaulterCitizenDB as $defaulterCitizenSingle)
        {
            array_push($defaulterCitizen,EmCitizen::find($defaulterCitizenSingle->id)); 
        }


        //prepare response
        $data = array(
            // 'thanas'  => $thanas,
            'appeal'  => $appeal,
            'legalInfo'  => $LegalInfo,
            'applicantCitizen'=>$applicantCitizen,
            'defaulterCitizen'=>$defaulterCitizen,
            'guarantorCitizen'=>$guarantorCitizen,
            'victimCitizen'=>$victimCitizen,
            'lawerCitizen'=>$lawerCitizen,
            'witnessCitizen'=>$witnessCitizen,
            'policeCitizen'=>$policeCitizen,
            'issuerCitizen'=>$issuerCitizen,
            'appealCauseList'=>$appeal->appealCauseList, //appeal causelist model relation
            'appealNote'=>$appeal->appealNotes ,         //appeal note model relation
            'gcoList'=>$gcoList  ,
            'citizenAttendance'=>$citizenAttendance,
            'noteCauseList'=>$noteCauseList,
            'attachmentList' => $attachmentList,
            'approvedNoteCauseList' => $approvedNoteList,
            'notApprovedNoteCauseList' => $notApprovedNoteList,
            'notApprovedAttachmentCauseList' => $notApprovedAttachmentList,
            'notApprovedShortOrderCauseList' => $notApprovedShortOrderList,
            'loginUserInfo'=> Auth::user()
        );
        // dd($data);

        return $data;
    }

    public static function getAllAppealCitizenListForAPI($appealId){
        //variable declare
        $applicantCitizen=[];
        $defaulterCitizen=[];
       
        $userInfo= globalUserInfo();
        $appeal = EmAppeal::find($appealId);
       
        $citizens=$appeal->appealCitizens;
        foreach ($citizens as $citizen){
            $citizenTypes = $citizen->citizenType;
            foreach ($citizenTypes as $citizenType){
                if($citizenType->id==1){
                    $applicantCitizen[]=$citizen->citizen_name;
        // dd($citizen);
                }
                if($citizenType->id==2){
                    $defaulterCitizen[]=$citizen->citizen_name;
                }
               
            }
        }
    
        $data = array(
            'applicantCitizen'=>$applicantCitizen,
            'defaulterCitizen'=>$defaulterCitizen,
            
        );
        // dd($data);

        return $data;
    }


    public static function getCauseListAllAppealInfo($appealId){
        //variable declare
        $applicantCitizen=[];
        $victimCitizen=[];
        $defaulterCitizen=[];
        $guarantorCitizen=[];
        $lawerCitizen=[];
        $witnessCitizen=[];
        $policeCitizen=[];
        $issuerCitizen=[];
        $citizenAttendance=[];
        $notApprovedNoteList=[];
        $notApprovedAttachmentList=[];
        $notApprovedShortOrderList=[];


        // $userInfo=Session::get('userInfo');
        $userInfo= globalUserInfo();
        //find appeal
        // $thanas=AdminAppServices::getThana($userInfo->office->district_id);
        $appeal = EmAppeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens=$appeal->appealCitizens;
        // dd($citizens);
        $LegalInfo=LegalInfoRepository::getLegalInfoByAppealId($appealId);
        $noteCauseList=NoteRepository::getNoteCauseListByAppealId($appealId);
        $attachmentList = AttachmentRepository::getAttachmentListByAppealId($appealId);
        $approvedNoteList=NoteRepository::getApprovedNoteList($appealId);

        $notApprovedNoteList=NoteRepository::getNotApprovedNote($appealId);
        // dd($notApprovedNoteList);
        if(count($notApprovedNoteList)>0){
            $notApprovedAttachmentList=AttachmentRepository::getAttachmentListByAppealIdAndCauseListId($appealId,$notApprovedNoteList[0]->cause_list_id);
            $notApprovedShortOrderList=CauseListShortDecisionRepository::getShortOrderListByAppealIdAndCauseListId($appealId,$notApprovedNoteList[0]->cause_list_id);
        }

        //get DM role office info
        // $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('GCO_');
        // $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode($userInfo->role_id);
        //get Dm list

        $gcoList=array();
        //get Gco list
        // if(Session::get('flagForSSOLogin')==1) {
        //     $gcoList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo,Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        // }else{
            // $gcoList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo,$userInfo->office->district_id, $userInfo->office_id);
        // }



            // $min  = [];
        // foreach ($citizens as $citizen){
        //     // $min []= $citizen->citizenType;
        //     $citizenTypes = $citizen->citizenType;
        //     // dd($citizen);


        //     foreach ($citizenTypes as $citizenType){
        //         // $min .= "," .$citizenType->id;
        //         if($citizenType->id==1){
        //             // $citizenAttendance[]=CitizenAttendanceRepository::getCitizenAttendanceByParameter($appealId,$citizen->id,$appeal->appealCauseList[count($appeal->appealCauseList)-1]->conduct_date);
        //             $applicantCitizen[]=$citizen;
        //         }
        //         if($citizenType->id==2){
        //             // $citizenAttendance[]=CitizenAttendanceRepository::getCitizenAttendanceByParameter($appealId,$citizen->id,$appeal->appealCauseList[count($appeal->appealCauseList)-1]->conduct_date);
        //             $defaulterCitizen[]=$citizen;
        //             // dd($citizen);
        //         }
        //         if($citizenType->id==3){
        //             $guarantorCitizen=$citizen;
        //         }
        //         if($citizenType->id==4){
        //             $lawerCitizen=$citizen;
        //         }
        //         if($citizenType->id==5){
        //             $witnessCitizen[]=$citizen;
        //         }
        //         if($citizenType->id==6){
        //             $policeCitizen=$citizen;
        //         }
        //         if($citizenType->id==7){
        //             $issuerCitizen=$citizen;
        //         }
        //         if($citizenType->id==8){
        //             $victimCitizen[]=$citizen;
        //         }
        //     }
        // }
        // dd($min);
        // dd('minar');

        $lawerCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',4)
        ->select('em_citizens.id')
        ->first();
   
        //
        //dd($lawerCitizenDB);

       $lawerCitizen=EmCitizen::find($lawerCitizenDB->id);
        
       
      


        $applicantCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',1)
        ->select('em_citizens.id')
        ->get();
        
        $applicatIDs=[];
        foreach($applicantCitizenDB as $applicantCitizenSingle)
         {
            array_push($applicantCitizen,EmCitizen::find($applicantCitizenSingle->id)); 
         }

        
        
        $victimCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',8)
        ->select('em_citizens.id')
        ->get();

        $victimIDs=[];
        foreach($victimCitizenDB as $victimCitizenSingle)
         {
            array_push($victimCitizen,EmCitizen::find($victimCitizenSingle->id)); 
         }

        $witnessCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',5)
        ->select('em_citizens.id')
        ->get();

        $witnessIDs=[];
       foreach($witnessCitizenDB as $witnessCitizenSingle)
        {
            array_push($witnessCitizen,EmCitizen::find($witnessCitizenSingle->id)); 
        }


        $defaulterCitizenDB= DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',2)
        ->select('em_citizens.id')
        ->get();
        
        $defaulterIDs=[];
       foreach($defaulterCitizenDB as $defaulterCitizenSingle)
        {
            array_push($defaulterCitizen,EmCitizen::find($defaulterCitizenSingle->id)); 
        }
        //prepare response
        $data = array(
            // 'thanas'  => $thanas,
            'appeal'  => $appeal,
            'legalInfo'  => $LegalInfo,
            'applicantCitizen'=>$applicantCitizen,
            'defaulterCitizen'=>$defaulterCitizen,
            'guarantorCitizen'=>$guarantorCitizen,
            'victimCitizen'=>$victimCitizen,
            'lawerCitizen'=>$lawerCitizen,
            'witnessCitizen'=>$witnessCitizen,
            'policeCitizen'=>$policeCitizen,
            'issuerCitizen'=>$issuerCitizen,
            'appealCauseList'=>$appeal->appealCauseList, //appeal causelist model relation
            'appealNote'=>$appeal->appealNotes ,         //appeal note model relation
            'gcoList'=>$gcoList  ,
            'citizenAttendance'=>$citizenAttendance,
            'noteCauseList'=>$noteCauseList,
            'attachmentList' => $attachmentList,
            'approvedNoteCauseList' => $approvedNoteList,
            'notApprovedNoteCauseList' => $notApprovedNoteList,
            'notApprovedAttachmentCauseList' => $notApprovedAttachmentList,
            'notApprovedShortOrderCauseList' => $notApprovedShortOrderList,
            // 'loginUserInfo'=> Auth::user()
        );
        // dd($data);

        return $data;
    }
    public static function getPermissionBasedConditions($usersPermissions){
        $permissionBasedConditions='';
        $userRole=Session::get('userRole');
        $userOffice=Session::get('userInfo')->office_id;
        $loginUserId = Session::get('userInfo')->username;
        if($userRole=='GCO'){
            $permissionBasedConditions="a.appeal_status NOT IN ('DRAFT','ON_DC_TRIAL') AND ";
        }else if($userRole=='DC'||$userRole=='DM'||$userRole=='ADC'||$userRole=='ADM'||$userRole=='Admin'){
            $permissionBasedConditions="a.appeal_status ='ON_DC_TRIAL' AND ";
        }else{
            // Case Transfer Section [ Every one can access from same office ]
//            $permissionBasedConditions="a.appeal_status!='ON_DC_TRIAL' AND a.peshkar_user_id=$loginUserId AND ";
            $permissionBasedConditions="a.appeal_status!='ON_DC_TRIAL' AND ";
        }
        $permissionBasedConditions.="a.office_id=$userOffice ";

        /*$loginOfficeId=Session::get('userInfo')->office_id;
        $permissionBasedConditions="";

        $permissionBasedConditions="a.office_id=$loginOfficeId ";
        $loginUserId = Session::get('userInfo')->username;
        foreach ($usersPermissions as $Permission) {

            if ($Permission->role_name == 'GCO'){
                $permissionBasedConditions="a.appeal_status!='DRAFT' AND a.gco_user_id=$loginUserId ";
            }
            elseif($Permission->role_name == 'Peshkar'){
                $permissionBasedConditions="a.peshkar_user_id=$loginUserId ";
            }

        }*/
        return $permissionBasedConditions;
    }

    public static function getAppealListBySearchParam($request){

        $usersPermissions = Session::get('userPermissions');
        $userInfo = Session::get('userInfo');
        $searchConditions=$caseNoCondition="";

        //default list populate Condition/user permission based
        $permissionBasedConditions=self::getPermissionBasedConditions($usersPermissions);

        //search parameter
        $searchParameters=$request->searchParameter;

        //search by others field
        if(isset($searchParameters)){
            if(isset($searchParameters['startDate'])){
                if(isset($searchParameters['endDate'])){
                    $endDate = date('Y-m-d',strtotime($searchParameters['endDate']));
                }else{
                    $endDate = date('d-m-Y', time());
                }
                $startDate = date('Y-m-d',strtotime($searchParameters['startDate']));

                $searchConditions.="AND cl.trial_date BETWEEN '$startDate' AND '$endDate' ";
            }
            if(isset($searchParameters['appealStatus'])){
                $appealStatus=$searchParameters['appealStatus'];
                $searchConditions.="AND a.appeal_status='$appealStatus' ";
            }
            if(isset($searchParameters['caseStatus'])){
                $caseStatus=$searchParameters['caseStatus'];
                $searchConditions.="AND a.case_decision_id=$caseStatus ";
            }
            if(isset($searchParameters['gcoList'])){
                $gco=$searchParameters['gcoList'];
                $searchConditions.="AND a.gco_user_id=$gco ";
            }
//            else{  // For Peshkar
//                $userId=Session::get('userInfo')->username;
//                $searchConditions.="AND a.peshkar_user_id=$userId ";
//            }
            if(isset($searchParameters['caseNo'])){
                $caseNo=$searchParameters['caseNo'];
                $searchConditions.="AND a.case_no='$caseNo' ";
            }
        }

        $appeals=DB::connection('appeal')
            ->select(DB::raw(
                "SELECT
                                a.id,
                                a.payment_status,
                                a.appeal_status,
                                a.gco_name,
                                a.case_no,
                                a.prev_case_no,
                                c.citizen_name,
                                CASE
                                   WHEN a.appeal_status = 'CLOSED' THEN \" \"
                                   ELSE  DATE_FORMAT(cl.trial_date,'%d-%m-%Y')
                                END AS trial_date,
                                xl.case_decision,
                                a.flag_on_trial
                            FROM appeals a
                            LEFT JOIN (
                                  SELECT xl.id, xl.appeal_id, xl.trial_date
                                  FROM cause_lists xl
                                  WHERE xl.id = (SELECT MAX(id) FROM cause_lists WHERE appeal_id = xl.appeal_id)
                            ) cl ON cl.appeal_id = a.id
                            LEFT JOIN (
                                SELECT cl2.appeal_id AS AppealID, cl2.id AS CauseListID, GROUP_CONCAT(csd.case_short_decision) AS case_decision
                                FROM cause_lists cl2
                                JOIN (
                                    SELECT MAX(cl1.id)   AS CauseListID, cl1.appeal_id AS AppealID
                                    FROM cause_lists cl1
                                    JOIN ( SELECT MAX(cl0.id) AS CauseListID, cl0.appeal_id AS AppealID FROM cause_lists cl0 GROUP BY cl0.appeal_id ) x0 ON x0.AppealID = cl1.appeal_id AND x0.CauseListID > cl1.id
                                    GROUP BY cl1.appeal_id
                                ) x1 ON x1.AppealID = cl2.appeal_id AND x1.CauseListID = cl2.id
                                LEFT JOIN causelist_caseshortdecisions clcsd ON clcsd.cause_list_id = cl2.id
                                LEFT JOIN case_shortdecisions csd ON csd.id = clcsd.case_shortdecision_id
                                GROUP BY cl2.appeal_id
                            ) xl ON xl.AppealID = a.id
                            JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                            JOIN appeal_citizens ac ON ac.appeal_id=a.id AND ac.citizen_type_id=1
                            JOIN citizens c ON c.id=ac.citizen_id
                          WHERE $permissionBasedConditions  $searchConditions $caseNoCondition AND a.office_id = $userInfo->office_id
                          ORDER BY cl.trial_date ASC,cl.id ASC  "
            ));

        return $appeals;
    }


    public static function getNothiListBySearchParam($request){

        $userInfo = Session::get('userInfo');
        $userRole=Session::get('userRole');
        $loginUserId = Session::get('userInfo')->username;
        $searchConditions ="a.appeal_status <> 'DRAFT'";

        if($userRole == "Peshkar" || $userRole == "GCO" || $userRole == "Recordroom Officer"){
            // Case Transfer Section [ Every one can access from same office ]
//            if($userRole=='Peshkar'){
//                $searchConditions.="AND a.peshkar_user_id='$loginUserId' ";
//            }
            $searchConditions.="AND a.office_id = '$userInfo->office_id'";
        }

        //search parameter
        $searchParameters = $request->searchParameter;

        if(isset($searchParameters)){
            if(isset($searchParameters['startDate'])){
                if(isset($searchParameters['endDate'])){
                    $endDate=date('Y-m-d',strtotime(trim($searchParameters['endDate'])));
                }else{
                    $endDate= date('Y-m-d', time());
                }
                $startDate=date('Y-m-d',strtotime(trim($searchParameters['startDate'])));

                $searchConditions .= "AND cl.trial_date BETWEEN '$startDate' AND '$endDate' ";
            }

            if(isset($searchParameters['appealCaseNo'])){
                $appealCaseNo=trim($searchParameters['appealCaseNo']);
                $searchConditions .= "AND a.case_no='$appealCaseNo' ";
            }

            if(isset($searchParameters['appealStatus'])){
                $appealStatus=trim($searchParameters['appealStatus']);
                $searchConditions.="AND a.appeal_status ='$appealStatus' ";
            }
            if(isset($searchParameters['upazillaId'])){
                $upazillaId=trim($searchParameters['upazillaId']);
                $searchConditions.="AND a.upazila_bbs_code ='$upazillaId' ";
            }

            if(isset($searchParameters['caseStatus'])){
                $caseStatus=trim($searchParameters['caseStatus']);
                $searchConditions.="AND a.case_decision_id = '$caseStatus' ";
            }
            if(isset($searchParameters['gcoList'])){
                $gco=$searchParameters['gcoList'];
                $searchConditions.="AND a.gco_user_id='$gco' ";
            }
        }

        $nothi=DB::connection('appeal')
            ->select(DB::raw(
                "SELECT a.id,a.appeal_status,a.gco_name,
                       a.case_no,a.prev_case_no,cd.case_decision,
                        CASE
                           WHEN a.appeal_status = 'CLOSED' THEN \" \"
                           ELSE DATE_FORMAT(cl.trial_date, '%d-%m-%Y')
                        END AS trial_date
                       FROM cause_lists cl
                       JOIN (
                                   SELECT xl.appeal_id, MAX(xl.trial_date) AS trial_date
                                   FROM cause_lists xl
                                   GROUP BY xl.appeal_id
                            ) xl ON xl.appeal_id = cl.appeal_id AND xl.trial_date = cl.trial_date
                       JOIN appeals a ON a.id = cl.appeal_id
                       JOIN case_decisions AS cd ON a.case_decision_id=cd.id
                       WHERE  $searchConditions
                       GROUP BY a.id"
            ));

        return $nothi;

    }





    public static function getAppealCaseAndCriminalId($id){
        // $caseInfo = DB::connection('appeal')
        //     ->select(DB::raw(
        //         "SELECT a.id, a.case_no
        //                FROM appeals a
        //                WHERE a.id = $request->id"
        //     ));
        $caseInfo = DB::connection('mysql')
            ->select(DB::raw(
                "SELECT a.id, a.case_no
                       FROM em_appeals a
                       WHERE a.id = $id"
            ));
            // dd($caseInfo);
        return $caseInfo;
    }


    public static function getNothiListFromAppeal($id){

        $getALLNothi = DB::connection('mysql')
            ->select(DB::raw(
                "SELECT a.id,a.appeal_id,a.cause_list_id,c.trial_date,c.conduct_date,
                       a.file_type,a.file_category,a.file_name,a.file_path
                       FROM em_attachments a JOIN em_cause_lists c
                       ON a.cause_list_id = c.id
                       WHERE a.appeal_id = $id
                       -- GROUP BY a.file_submission_date
                       ORDER BY a.file_submission_date asc"

             ));

        $index = 1;
        $nothiList =  array ();

        foreach ($getALLNothi as $getNothi)
        {
            $nothi['index'] = DataConversionService::toBangla($index);
            $nothi['id'] = $getNothi->id;
            $nothi['appeal_id'] = $getNothi->appeal_id;
            $nothi['cause_list_id'] = $getNothi->cause_list_id;
            $nothi['conduct_date'] = DataConversionService::toBangla(date('d-m-Y',strtotime($getNothi->conduct_date)));
            $nothi['file_type'] = $getNothi->file_type;
            $nothi['file_category'] = $getNothi->file_category;
            $nothi['file_name'] = $getNothi->file_name;
            $nothi['file_path'] = $getNothi->file_path;
            $index++;
            array_push($nothiList, $nothi);
        }
        // dd($nothiList);
        return $nothiList;

    }



    public static function saveRaiOrder($request){
        $transactionStatus = true;


        if(isset($request->sendOrderData)) {

            $id =  $request->sendOrderData['raiID'];
            $RaiOrder=RaiOrder::find($id);
            if($RaiOrder){
                $RaiOrder->updated_at = date('Y-m-d H:i:s');
                $RaiOrder->updated_by = Session::get('userInfo')->username;
            }else{
                //new role create
                $RaiOrder = new RaiOrder();
                $RaiOrder->appeal_id = $request->sendOrderData['appealID'];
                $RaiOrder->appeal_case_no = $request->sendOrderData['appealCaseno'];
            }

            $RaiOrder->rai_header = $request->sendOrderData['raiOrderHeader'];
            $RaiOrder->rai_details = $request->sendOrderData['raiOrderBody'];
            $RaiOrder->rai_order_text = $request->sendOrderData['raiOrderTextDetails'];
            $RaiOrder->created_at = date('Y-m-d H:i:s');
            $RaiOrder->created_by = Session::get('userInfo')->username;

            if ($RaiOrder->save()) {
                $transactionStatus = true;
            }else{
                $transactionStatus = false;
            }

        }

        return $transactionStatus;

    }

    public static function getAppealandCriminalInfo($request){

        $sqlRes =DB::connection('appeal')
            ->select(DB::raw(
                "SELECT cl.trial_date,cl.conduct_date,a.case_no,
                     a.created_at, c.citizen_name,a.law_section,
                    nt.order_text,nt.cause_list_id, nt.created_date, nt.created_by_id,nt.created_by_name
                    FROM appeals a
                    JOIN appeal_citizens ac ON a.id = ac.appeal_id AND ac.citizen_type_id=1
                    JOIN citizens c ON ac.citizen_id = c.id
                    JOIN citizen_types ct ON ac.citizen_type_id = ct.id
                    JOIN notes nt ON a.id =nt.appeal_id
                    JOIN cause_lists cl ON cl.id=nt.cause_list_id
                    WHERE a.id = $request AND ct.id =1"
            ));

        return $sqlRes;

    }
    // public  function fullAppealInfo($appeal){
    //     $appealId = $appeal->id;
    //     $citizens=$appeal->appealCitizens;
    //     $applicantCitizen=[];
    //     $defaulterCitizen=[];
    //     $guarantorCitizen=[];
    //     $lawerCitizen=[];
    //     $nomineeCitizen=[];
    //     $policeCitizen=[];
    //     $citizenAttendance=[];
    //     $notApprovedNoteList=[];
    //     $notApprovedAttachmentList=[];
    //     $notApprovedShortOrderList=[];

    //     foreach ($citizens as $citizen){
    //         $citizenTypes = $citizen->citizenType;

    //         foreach ($citizenTypes as $citizenType){

    //             if($citizenType->id==1){
    //                 $applicantCitizen=$citizen;
    //             }
    //             if($citizenType->id==2){
    //                 $defaulterCitizen=$citizen;
    //             }
    //             if($citizenType->id==3){
    //                 $guarantorCitizen=$citizen;
    //             }
    //             if($citizenType->id==4){
    //                 $lawerCitizen=$citizen;
    //             }
    //             if($citizenType->id==5){
    //                 $nomineeCitizen[]=$citizen;
    //             }
    //             if($citizenType->id==6){
    //                 $policeCitizen=$citizen;
    //             }
    //         }
    //     }
    //         $data['applicantCitizen']= $applicantCitizen;
    //         $data['defaulterCitizen']= $defaulterCitizen;
    //         $data['guarantorCitizen']= $guarantorCitizen;
    //         $data['lawerCitizen']= $lawerCitizen;
    //         $data['nomineeCitizen']= $nomineeCitizen;
    //         $data['policeCitizen']= $policeCitizen;
    //         $data['appealCauseList']= $appeal->appealCauseList; //appeal causelist model relation
    //         $data['appealNote']= $appeal->appealNotes ;         //appeal note model relation
    //         $data['citizenAttendance'] = $citizenAttendance;
    //         $data['noteCauseList']=NoteRepository::getNoteCauseListByAppealId($appealId);
    //         $data['attachmentList'] = AttachmentRepository::getAttachmentListByAppealId($appealId);
    // }






}
