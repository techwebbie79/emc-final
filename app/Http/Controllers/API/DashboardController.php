<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
// use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\EmAppeal;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Validator;

// use Validator;


class DashboardController extends BaseController
{
    public function test()
    {
        // $data = array();
        // Counter
        //$data['total_case'] = DB::table('case_register')->count();
        $data[] = "Test";
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $roleID = $request->role_id;
        $userID = $request->user_id;
        $court_id = $request->court_id;
        $district_id = $request->district_id;
        //   dd($roleID);

        $data = [];
        // $data['rm_case_status'] = [];


        if ($roleID == 1) {
            // Superadmi dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_EM', 'SEND_TO_DM'])->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();


        } elseif ($roleID == 2) {
            // Superadmin dashboard
            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_EM', 'SEND_TO_DM'])->count();
            $data['running_case'] = EmAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();

            return $this->sendResponse($data, 'Super Admin Data.');


        } elseif ($roleID == 6) {
            // Superadmin dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();


        } elseif ($roleID == 7) {
            // Superadmin dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED','ON_TRIAL_DM'])->where('district_id', user_district())->where('assigned_adc_id', $userID)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district())->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_DM'])->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();
            $data['trial_date_list'] = EmAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();


            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->where('assigned_adc_id', $userID)->where('district_id', user_district())->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->where('district_id', user_district())->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();


            return $this->sendResponse($data, 'ADC Data.');

        } elseif ($roleID == 14) {
            // Solicitor
            // Get case status by group
            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();


        } elseif ($roleID == 20) {
            $appeal_no = [];
         $totalCase_bibadi = 0;
         $totalRunningCase_bibadi = 0;
         $totalCompleteCase_bibadi = 0;
         $pending_case_assigned_lawer_count=0;

         $citizen_id = DB::table('em_citizens')
         ->where('citizen_NID', globalUserInfo()->citizen_nid)
         ->select('id')
         ->get();
         if(!empty($citizen_id)){               
         foreach ($citizen_id as $key => $value) {
            // return $value;
               $appeal_no = DB::table('em_appeal_citizens')
                           ->where('citizen_id', $value->id)
                           ->whereIN('citizen_type_id', [2,4])
                           ->select('appeal_id')
                           ->get();
            
         }
         }  
         else
         {
         $appeal_no=null;
         }
         // return $appeal_no;
         

         if(!empty($appeal_no)){
            foreach ($appeal_no as $key => $value){
               if (!empty($value)) {
               // return $value;
                 $all_case = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM','CLOSED'])->first();
                 if($all_case){
                     $totalCase_bibadi ++;  
                 }
                 $running_case = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM'])->first();
                 if($running_case){
                     $totalRunningCase_bibadi ++;   
                 }
                 $completed_case = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['CLOSED'])->first();
                 if($completed_case){
                     $totalCompleteCase_bibadi ++;   
                 }
                 $pending_case_assigned_lawer = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])->first();
                 if($pending_case_assigned_lawer){
                     $pending_case_assigned_lawer_count ++;   
                 }
               }
            }
         }
         
         $total_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['CLOSED','ON_TRIAL','ON_TRIAL_DM'])->count();
         $running_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM'])->count();
         $completed_case_badi = EmAppeal::where('created_by', $userID)->where('appeal_status', 'CLOSED')->count();
         $data['total_case'] = $totalCase_bibadi + $total_case_badi;
         $data['running_case'] = $totalRunningCase_bibadi + $running_case_badi;
         $data['completed_case'] = $totalCompleteCase_bibadi + $completed_case_badi;
         // Counter
         // $data['total_case'] = EmAppeal::where('created_by', $userID)->count();
          $lawer_created_case = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])->count();

          
          $data['pending_case']=$pending_case_assigned_lawer_count+$lawer_created_case;
         
         $data['pending_review_case'] = EmAppeal::whereIn('appeal_status', [ 'SEND_TO_DM_REVIEW'])
                                       ->orWhere(function ($query) {
                                              $query->where('review_applied_by', globalUserInfo()->id)
                                                    ->where('created_by', globalUserInfo()->id);
                                          })
                                       ->count();

         /*->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id)*/

         $data['running_review_case'] = EmAppeal::whereIn('appeal_status', [ 'ON_TRIAL_DM'])->where('is_applied_for_review',1)->orWhere(function ($query) {
                                              $query->where('review_applied_by', globalUserInfo()->id)
                                                    ->where('created_by', globalUserInfo()->id);
                                          })
                                       ->count();

         // ->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id)->count();
         // $data['running_case'] = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM'])->count();
         // $data['completed_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'CLOSED')->count();
         $data['draft_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'DRAFT')->count();
         $data['rejected_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'REJECTED')->count();
         $data['postpond_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'POSTPONED')->count();

         return $this->sendResponse($data, 'Advocate Data.');

        } elseif ($roleID == 24) {
            // Superadmin dashboard
            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();


        } elseif ($roleID == 25) {
            // Superadmin dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();



            $data['pending_case_list'] = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_NBR_CM'])->count();
            $data['trial_date_list'] = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_NBR_CM'])->where('next_date', date('Y-m-d', strtotime(now())))->count();
            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];


        } elseif ($roleID == 27) {
            $data['total_case'] = EmAppeal::whereIn('appeal_status', [ 'ON_TRIAL','CLOSED'])->where('court_id', $court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_EM'])->where('court_id', $court_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', $court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('court_id', $court_id)->count();
            $data['trial_date_list'] = EmAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('court_id', $court_id)->count();

            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->where('court_id', $court_id)->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->where('court_id', $court_id)->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->where('court_id', $court_id)->count();

            $data['pending_case_list'] = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_EM'])->where('court_id', $court_id)->count();
            
            // $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

            return $this->sendResponse($data, 'EM Data.');

        } elseif ($roleID == 28) {
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL','CLOSED'])->where('court_id', $court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_EM'])->where('court_id', $court_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', $court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('court_id', $court_id)->count();
            $data['trial_date_list'] = EmAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('court_id', $court_id)->count();

            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->where('court_id', $court_id)->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->where('court_id', $court_id)->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->where('court_id', $court_id)->count();

            $data['pending_case_list'] = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_EM'])->where('court_id', globalUserInfo()->court_id)->count();
            // $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];

            return $this->sendResponse($data, 'Asst Em Data.');

        } elseif ($roleID == 32) {
            $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // ULAO office
            // Counter
            // Counter
            $$data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();


        } elseif ($roleID == 33) {
            // $moujaIDs = $this->get_mouja_by_ulo_office_id(Auth::user()->office_id);
            // ULAO office
            // Counter
            // Counter
            $data['total_case'] = EmAppeal::where('created_by', $userID)->count();
            $data['running_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'ON_TRIAL')->count();
            $data['completed_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'CLOSED')->count();
            $data['rejected_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'DRAFT')->count();


        } elseif ($roleID == 34) {
            // Superadmin dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();

            $data['pending_case_list'] = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DIV_COM'])->count();
            $data['trial_date_list'] = EmAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by', globalUserInfo()->id)->count();
            $data['notifications'] = $data['pending_case_list'] + $data['trial_date_list'];



        }elseif($roleID == 36){

            $appeal_no = [];
            $totalCase_bibadi = 0;
            $totalRunningCase_bibadi = 0;
            $totalCompleteCase_bibadi = 0;
   
            $citizen_id = DB::table('em_citizens')
            ->where('citizen_NID', globalUserInfo()->citizen_nid)
            ->select('id')
            ->get();
   
            if (!empty($citizen_id)) {
               foreach ($citizen_id as $key => $value) {
                   // return $value;
                   $appeal_no= DB::table('em_appeal_citizens')
                       ->where('citizen_id', $value->id)
                       ->where('citizen_type_id', 2)
                       ->select('appeal_id')
                       ->get();
   
               }
           } else {
               $appeal_no=null;
           }
   
        
   
            if(!empty($appeal_no)){
               foreach ($appeal_no as $key => $value){
                  if ($value != '') {
                  // return $value;
                    $all_case = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM','CLOSED'])->first();
                    if($all_case){
                        $totalCase_bibadi ++;   
                    }
                    $running_case = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM'])->first();
                    if($running_case){
                        $totalRunningCase_bibadi ++;   
                    }
                    $completed_case = EmAppeal::where('id',$value->appeal_id)->whereIn('appeal_status', ['CLOSED'])->first();
                    if($completed_case){
                        $totalCompleteCase_bibadi ++;   
                    }
                  }
               }
            }
            $total_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['CLOSED','ON_TRIAL','ON_TRIAL_DM'])->count();
            $running_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['ON_TRIAL','ON_TRIAL_DM'])->count();
            $completed_case_badi = EmAppeal::where('created_by', $userID)->where('appeal_status', 'CLOSED')->count();
            $data['total_case'] = $totalCase_bibadi + $total_case_badi;
   
           // dd($total_case_badi);
   
            $data['running_case'] = $totalRunningCase_bibadi + $running_case_badi;
            $data['completed_case'] = $totalCompleteCase_bibadi + $completed_case_badi;
            // Counter
            // $data['total_case'] = EmAppeal::where('created_by', $userID)->count();
            $data['pending_case'] = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])->count();
            
               
   
            $data['pending_review_case'] = EmAppeal::whereIn('appeal_status', [ 'SEND_TO_DM_REVIEW'])
                                          ->where(function ($query) {
                                                 $query->where('review_applied_by', globalUserInfo()->id)
                                                       ->orWhere('created_by', globalUserInfo()->id);
                                             })
                                          ->count();
     
   
            /*->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id)*/
   
            $data['running_review_case'] = EmAppeal::whereIn('appeal_status', [ 'ON_TRIAL_DM'])->where('is_applied_for_review',1)->where(function ($query) {
                                                 $query->where('review_applied_by', globalUserInfo()->id)
                                                       ->orWhere('created_by',globalUserInfo()->id);
                                             })
                                          ->count();
   
            $data['draft_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'DRAFT')->count();
            $data['rejected_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('created_by', $userID)->where('appeal_status', 'POSTPONED')->count();
   
            
        return $this->sendResponse($data, 'Citizen Data.');

      }elseif ($roleID == 37) {

            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED','ON_TRIAL_DM'])->where('district_id', $district_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', [ 'SEND_TO_DM'])->where('district_id', $district_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', $district_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('district_id', $district_id)->count();
            $data['trial_date_list'] = EmAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('district_id', $district_id)->count();

            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->where('district_id', $district_id)->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->where('district_id', $district_id)->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->where('district_id', $district_id)->count();
            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->where('district_id', $district_id)->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();

            return $this->sendResponse($data, 'DM Data.');

        } elseif ($roleID == 38) {
            // Superadmin dashboard
            //  echo 'Hello'; exit;

            // Counter
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED','ON_TRIAL_DM'])->where('court_id', $court_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('court_id', $court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('court_id', $court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', [ 'SEND_TO_DM'])->where('court_id', $court_id)->count();
            $data['trial_date_list'] = EmAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('court_id', $court_id)->count();

            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->where('court_id', $court_id)->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->where('court_id', $court_id)->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->where('court_id', $court_id)->count();

            return $this->sendResponse($data, 'ADM Data.');

        } elseif ($roleID == 39) {
            // Superadmin dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED','ON_TRIAL_DM'])->where('court_id', $court_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('court_id', $court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('court_id', $court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_DM'])->where('court_id', $court_id)->count();
            $data['trial_date_list'] = EmAppeal::where('next_date', date('Y-m-d', strtotime(now())))->where('court_id', $court_id)->count();

            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->where('court_id', $court_id)->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->where('court_id', $court_id)->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->where('court_id', $court_id)->count();

            $data['total_office'] = DB::table('office')->where('is_gcc', 1)->whereNotIn('id', [1, 2, 7])->where('district_id', $district_id)->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
            $data['total_mouja'] = DB::table('mouja')->count();
            $data['total_ct'] = DB::table('case_type')->count();

            return $this->sendResponse($data, 'Adm Data.');

        }
    }

}
