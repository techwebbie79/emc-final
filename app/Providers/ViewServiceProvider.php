<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use App\Providers\AppServiceProvider;
use App\Models\User;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use App\Models\EmAppeal;
use App\Models\RM_CaseRgister;
use App\Models\RM_CaseHearing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Models\Message;
use App\Models\SiteSetting;

class ViewServiceProvider extends AppServiceProvider
{
        public function boot()
    {

        $setting = SiteSetting::first();
        View::share('setting', $setting);

        // $this->messages_inc_search();

        // $this->composeFooter();
        // Schema::defaultstringLength(191);
        // Paginator::useBootstrap();

        // view()->composer('home', function ($view)
        // {
        //     $users = Auth::user()->id;

        //     $view->with('users', $users);
        // });

        

        view()->composer('messages.inc.search', function ($view)
        {
            $roleID = Auth::user()->role_id;
            $officeInfo = user_office_info();
            // Dorpdown
            $upazilas = NULL;
            $courts = DB::table('court')->select('id', 'court_name')->get();
            $divisions = DB::table('division')->select('id', 'division_name_bn')->get();
            $user_role = DB::table('role')->select('id', 'role_name')->get();

            if($roleID == 5 || $roleID == 6 || $roleID == 7 || $roleID == 8 || $roleID == 13 || $roleID == 16){
                $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
                $upazilas = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', $officeInfo->district_id)->get();

            }elseif($roleID == 9 || $roleID == 10 || $roleID == 11 || $roleID == 12){
                $courts = DB::table('court')->select('id', 'court_name')->where('district_id', $officeInfo->district_id)->orWhere('district_id', NULL)->get();
            }

            $gp_users = DB::table('users')->select('id', 'name')->where('role_id', 13)->get();

            $view->with([
                'upazilas' => $upazilas,
                'courts' => $courts,
                'divisions' => $divisions,
                'gp_users' => $gp_users,
                'user_role' => $user_role,
            ]);

        });
        if (Auth::check()) {
            view()->composer('*', function ($view)
            {
                $notification_count = 0;
                $case_status = [];
                $rm_case_status = [];
                $officeInfo = user_office_info();
                $roleID = Auth::user()->role_id;
                $districtID = DB::table('office')
                ->select('district_id')->where('id',Auth::user()->office_id)
                ->first()->district_id;

                if( $roleID == 9 || $roleID == 10 || $roleID == 11  || $roleID == 21 ){

                    $case_status = DB::table('case_register')
                        ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                        ->groupBy('case_register.cs_id')
                        ->where('case_register.upazila_id','=', $officeInfo->upazila_id)
                        ->where('case_register.action_user_group_id', $roleID)
                        ->get();
                    

                } elseif( $roleID == 22 || $roleID == 23){

                    $case_status = DB::table('case_register')
                        ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                        ->groupBy('case_register.cs_id')
                        ->where('case_register.upazila_id','=', $officeInfo->upazila_id)
                        ->where('case_register.action_user_group_id', $roleID)
                        ->get();
                   

                } elseif( $roleID == 14 ) {
                    $case_status = DB::table('case_register')
                        ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                        ->groupBy('case_register.cs_id')
                        ->where('case_register.action_user_group_id', $roleID)
                        ->get();

                } elseif( $roleID == 12 ) {
                    $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', Auth::user()->office_id)->pluck('mouja_id');
                    $case_status = DB::table('case_register')
                        ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                        ->groupBy('case_register.cs_id')
                        ->whereIn('case_register.mouja_id', $moujaIDs)
                        ->where('case_register.action_user_group_id', $roleID)
                        ->get();
                } elseif( $roleID == 2 ) {
                    $total_sf_count = DB::table('case_register')
                        ->where('is_sf', 1)
                        ->where('status', 1)
                        ->get()
                        ->count();
                    $CaseResultCount = DB::table('case_register')
                        ->where('status', '!=', 1)
                        ->get()
                        ->count();

                    $CaseHearingCount = DB::table('case_hearing')
                        ->distinct()
                        ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
                        ->where('case_register.status', 1)
                        ->select('case_id')
                        ->get()
                        ->count();

                  
                    // dd($dfsdf);

                    $notification_count = $CaseResultCount + $CaseHearingCount + $total_sf_count;

                } elseif( $roleID == 6 ) {
                    $total_pending_case = EnAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DC'])->count();
                    $CaseTrialCount = EnAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by', globalUserInfo()->id)->count();

                  
                    // dd($dfsdf);

                    $notification_count = $CaseTrialCount + $total_pending_case;

                } elseif( $roleID == 25 ) {
                    $total_pending_case = EnAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_NBR_CM'])->count();
                    $CaseTrialCount = EnAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by', globalUserInfo()->id)->count();

                  
                    // dd($dfsdf);

                    $notification_count = $CaseTrialCount + $total_pending_case;

                } elseif( $roleID == 27 ) {
                    $total_pending_case = EnAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_GCO'])->count();
                    $CaseTrialCount = EnAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->count();

                  
                    // dd($dfsdf);

                    $notification_count = $CaseTrialCount + $total_pending_case;

                }  elseif( $roleID == 28 ) {
                    $CaseTrialCount = EnAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->count();
                    $total_pending_case = EnAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_ASST_GCO'])->count();
                    
                    // dd($dfsdf);

                    $notification_count =  $CaseTrialCount + $total_pending_case ;
                } elseif( $roleID == 34 ) {
                    $total_pending_case = EnAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_DIV_COM'])->count();
                    $CaseTrialCount = EnAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('updated_by', globalUserInfo()->id)->count();

                  
                    // dd($dfsdf);

                    $notification_count = $CaseTrialCount + $total_pending_case;

                }  elseif( $roleID == 32 ) {
                    $CaseCrockCount = DB::table('em_case_shortdecision_templates')
                        ->where('em_case_shortdecision_templates.case_shortdecision_id','=', 9)
                        ->count();

                    $notification_count = $CaseCrockCount;

                }  elseif( $roleID == 33 ) {
                    $CaseWarrentCount = DB::table('em_case_shortdecision_templates')
                        ->where('em_case_shortdecision_templates.case_shortdecision_id','=', 19)
                        ->count();
                    $CaseInvestigationCount = DB::table('em_case_shortdecision_templates')
                        ->where('em_case_shortdecision_templates.case_shortdecision_id','=', 5)
                        ->count();

                    $notification_count = $CaseWarrentCount + $CaseInvestigationCount;

                }  elseif( $roleID == 35 ) {
                    $CaseTrialCount = EnAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('created_by', globalUserInfo()->id)->count();

                    $notification_count = $CaseTrialCount;

                }   elseif( $roleID == 36 ) {
                    $CaseTrialCount = EmAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('created_by', globalUserInfo()->id)->count();

                    $notification_count = $CaseTrialCount;

                }  else {
                    //for role id : 5,6,7,8,13
                    $case_status = DB::table('case_register')
                        ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                        ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                        ->groupBy('case_register.cs_id')
                        ->where('case_register.district_id','=', $officeInfo->district_id)
                        ->where('case_register.action_user_group_id', $roleID)
                        ->get();
                   
                    // dd($rm_case_status);
                }

               if( $roleID != 2 && $roleID != 6 && $roleID != 25 && $roleID != 27  && $roleID != 28 && $roleID != 32  && $roleID != 33 && $roleID != 34   && $roleID != 35  ){
                    foreach ($case_status as $row){
                         $notification_count += $row->total_case;
                    }
                    foreach ($rm_case_status as $row){
                         $notification_count += $row->total_case;
                    }

                    $view->with([
                        'notification_count' => $notification_count,
                        'case_status' => $case_status,
                        'rm_case_status' => $rm_case_status,
                    ]);

                } elseif ($roleID == 6 || $roleID == 25 || $roleID == 27 || $roleID == 28 || $roleID == 34) {
                    $view->with([
                        'notification_count' => $notification_count,
                        'total_pending_case' => $total_pending_case,
                        'CaseTrialCount' => $CaseTrialCount,
                    ]);
                }  elseif ($roleID == 32) {
                    $view->with([
                        'notification_count' => $notification_count,
                        'CaseCrockCount' => $CaseCrockCount,
                    ]);
                } elseif ($roleID == 33) {
                    $view->with([
                        'notification_count' => $notification_count,
                        'CaseWarrentCount' => $CaseWarrentCount,
                    ]);
                } elseif ($roleID == 35) {
                    $view->with([
                        'notification_count' => $notification_count,
                        'CaseTrialCount' => $CaseTrialCount,
                    ]);
                } else {
                    $view->with([
                        'notification_count' => $notification_count,
                        'CaseHearingCount' => $CaseHearingCount,
                        'CaseResultCount' => $CaseResultCount,
                        'total_sf_count' => $total_sf_count,
                    ]);
                }

                //Message Notification --- start
                $NewMessagesCount = Message::select('id')
                    ->where('user_receiver', Auth::user()->id)
                    ->where('receiver_seen', 0)
                    ->where('msg_reqest', 0)
                    ->count();
                $msg_request_count = Message::orderby('id', 'DESC')
                    // ->select('user_sender', 'user_receiver', 'msg_reqest')
                    ->Where('user_receiver', [Auth::user()->id])
                    ->Where('msg_reqest', 1)
                    ->groupby('user_sender')
                    ->count();
                $Ncount = $NewMessagesCount + $msg_request_count;

                $view->with([
                    'Ncount' => $Ncount,
                    'NewMessagesCount' => $NewMessagesCount,
                    'msg_request_count' => $msg_request_count,
                ]);
                //Message Notification  --- End



            });
        }

    }
    public function register()
    {
        //
    }

}
