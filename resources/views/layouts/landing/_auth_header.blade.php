@php
    
    //==========Notification Count=======//
    
    if (Auth::check()) {
        $notification_count = 0;
        $case_status = [];
        $rm_case_status = [];
        $officeInfo = user_office_info();
        $roleID = Auth::user()->role_id;
    
        $appeal_ids_with_investigation = DB::table('em_investigation_report')
            ->select('appeal_id')
            ->distinct()
            ->get();
        $appeal_id_in_appeal_table = [];
        foreach ($appeal_ids_with_investigation as $value) {
            array_push($appeal_id_in_appeal_table, $value->appeal_id);
        }
    
        if ($roleID == 6 || $roleID == 37) {
            $total_pending_case_dm = App\Models\EmAppeal::whereIn('appeal_status', ['SEND_TO_DM'])
                ->where('district_id', user_district())
                ->count();
            // $total_pending_review_case = App\Models\ App\Models\EmAppeal::orderby('id', 'desc')
            //     ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
            //     ->where('district_id',user_district())
            //     ->count();
    
            $CaseWithInvestigationReport = DB::table('em_appeals')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district())
                ->count();
    
            $CaseTrialCount = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->count();
            $CaseRunningCountActionRequired = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('action_required', 'EM_DM')
                ->count();
    
            $notification_count = $CaseTrialCount + $total_pending_case_dm + $CaseWithInvestigationReport + $CaseRunningCountActionRequired;
        } elseif ($roleID == 38) {
            $total_pending_case_dm = App\Models\EmAppeal::whereIn('appeal_status', ['SEND_TO_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id)
                ->count();
    
            $CaseTrialCount = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id)
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->count();
    
            $CaseWithInvestigationReport = DB::table('em_appeals')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id)
                ->count();
            $CaseRunningCountActionRequired = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'EM_DM')
                ->count();
            $notification_count = $CaseTrialCount + $total_pending_case_dm + $CaseWithInvestigationReport + $CaseRunningCountActionRequired;
        } elseif ($roleID == 7) {
            $CaseTrialCount = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('assigned_adc_id', globalUserInfo()->id)
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->count();
    
            $CaseWithInvestigationReport = DB::table('em_appeals')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district())
                ->where('em_appeals.assigned_adc_id', globalUserInfo()->id)
                ->count();
    
            $CaseRunningCountActionRequired = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('action_required', 'EM_DM')
                ->where('em_appeals.assigned_adc_id', globalUserInfo()->id)
                ->count();
    
            $notification_count = $CaseTrialCount + $CaseWithInvestigationReport + $CaseRunningCountActionRequired;
        } elseif ($roleID == 39) {
            $total_pending_case_asst_dm = App\Models\EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id)
                ->count();
    
            $CaseTrialCount = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id)
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->count();
            $CaseRunningCountActionRequired = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'PESH')
                ->count();
            // dd($dfsdf);
            $CaseWithInvestigationReport = DB::table('em_appeals')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id)
                ->count();
    
            $notification_count = $CaseTrialCount + $total_pending_case_asst_dm + $CaseRunningCountActionRequired + $CaseWithInvestigationReport;
        } elseif ($roleID == 27) {
            $total_pending_case_em = App\Models\EmAppeal::whereIn('appeal_status', ['SEND_TO_EM'])
                ->where('court_id', globalUserInfo()->court_id)
                ->count();
    
            $CaseTrialCount = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->count();
    
            $CaseWithInvestigationReport = DB::table('em_appeals')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id)
                ->count();
            $CaseRunningCountActionRequired = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'EM_DM')
                ->count();
            $notification_count = $CaseTrialCount + $total_pending_case_em + $CaseWithInvestigationReport + $CaseRunningCountActionRequired;
        } elseif ($roleID == 28) {
            $CaseTrialCount = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->count();
    
            $total_pending_case_asst_em = App\Models\EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_EM'])
                ->where('court_id', globalUserInfo()->court_id)
                ->count();
            $CaseRunningCountActionRequired = App\Models\EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('action_required', 'PESH')
                ->count();
            $CaseWithInvestigationReport = DB::table('em_appeals')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id)
                ->count();
            $notification_count = $CaseTrialCount + $total_pending_case_asst_em + $CaseRunningCountActionRequired + $CaseWithInvestigationReport;
        } elseif ($roleID == 20) {
            $CaseTrialCount = DB::table('em_appeal_citizens')
                ->join('em_appeals', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->where('em_appeals.next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4, 7])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->count();
            //dd($CaseTrialIDs);
    
            $notification_count = $CaseTrialCount;
        } elseif ($roleID == 36) {
            $CaseTrialCount = DB::table('em_appeal_citizens')
                ->join('em_appeals', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->where('em_appeals.next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->count();
    
            $notification_count = $CaseTrialCount;
        } else {
            //for role id : 5,6,7,8,13
            $total_pending_case = App\Models\EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_NBR_CM'])
                ->count();
            $CaseTrialCount = App\Models\EmAppeal::orderby('id', 'desc')
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->where('updated_by', globalUserInfo()->id)
                ->count();
    
            // dd($rm_case_status);
        }
    
        if ($roleID != 1 && $roleID != 2 && $roleID != 6 && $roleID != 7 && $roleID != 25 && $roleID != 27 && $roleID != 28 && $roleID != 32 && $roleID != 33 && $roleID != 34 && $roleID != 36 && $roleID != 37 && $roleID != 38 && $roleID != 39 && $roleID != 20) {
            foreach ($case_status as $row) {
                $notification_count += $row->total_case;
            }
            foreach ($rm_case_status as $row) {
                $notification_count += $row->total_case;
            }
    
            $view->with([
                'notification_count' => $notification_count,
                'case_status' => $case_status,
                'rm_case_status' => $rm_case_status,
            ]);
        } elseif ($roleID == 27) {
            $notification_count = $notification_count;
            $total_pending_case = $total_pending_case_em;
            $CaseTrialCount = $CaseTrialCount;
            $CaseWithInvestigationReport = $CaseWithInvestigationReport;
            $CaseRunningCountActionRequired = $CaseRunningCountActionRequired;
        } elseif ($roleID == 28) {
            $notification_count = $notification_count;
            $total_pending_case = $total_pending_case_asst_em;
            $CaseTrialCount = $CaseTrialCount;
            $CaseRunningCountActionRequired = $CaseRunningCountActionRequired;
        } elseif ($roleID == 37) {
            $notification_count = $notification_count;
            $total_pending_case = $total_pending_case_dm;
            // $total_pending_review_case = $total_pending_review_case;
            $CaseTrialCount = $CaseTrialCount;
            $CaseWithInvestigationReport = $CaseWithInvestigationReport;
            $CaseRunningCountActionRequired = $CaseRunningCountActionRequired;
        } elseif ($roleID == 38) {
            $notification_count = $notification_count;
            $total_pending_case = $total_pending_case_dm;
            $CaseTrialCount = $CaseTrialCount;
            $CaseWithInvestigationReport = $CaseWithInvestigationReport;
            $CaseRunningCountActionRequired = $CaseRunningCountActionRequired;
        } elseif ($roleID == 7) {
            $notification_count = $notification_count;
            $CaseTrialCount = $CaseTrialCount;
            $CaseWithInvestigationReport = $CaseWithInvestigationReport;
            $CaseRunningCountActionRequired = $CaseRunningCountActionRequired;
        } elseif ($roleID == 39) {
            $notification_count = $notification_count;
            $total_pending_case = $total_pending_case_asst_dm;
            $CaseTrialCount = $CaseTrialCount;
            $CaseRunningCountActionRequired = $CaseRunningCountActionRequired;
        } elseif ($roleID == 36) {
            $notification_count = $notification_count;
            $CaseTrialCount = $CaseTrialCount;
        } elseif ($roleID == 20) {
            $notification_count = $notification_count;
            $CaseTrialCount = $CaseTrialCount;
        } else {
            $notification_count = '';
            $CaseHearingCount = '';
            $CaseResultCount = '';
            $total_sf_count = '';
        }
    }
    
    //==========//Notification Count=======//
    //===========//Menu Permission==========//
    use Illuminate\Support\Facades\Auth;
    
    if (Auth::check()) {
        global $menu;
        $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 80];
        if (globalUserInfo()->role_id == 1) {
            $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 99, 37, 33, 38, 39, 80];
        } elseif (globalUserInfo()->role_id == 2) {
            // Admin
            $menu = [1, 2, 3, 6, 7, 8, 9, 10, 23, 24, 26, 27, 33, 35, 99, 37, 33, 38, 39, 40, 80]; // 35 = Report // 99 role permission create
        } elseif (globalUserInfo()->role_id == 6) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 6)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 20) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 20)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 7) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 7)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 24) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 24)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 25) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 25)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 27) {
            // Executive Magistrate
    
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 27)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 28) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 28)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 32) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 32)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 33) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 33)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 34) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 34)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 35) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 35)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 36) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 36)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 37) {
            // District Megistrate
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 37)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 38) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 38)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        } elseif (globalUserInfo()->role_id == 39) {
            $assigned_permission = DB::table('role_permission')
                ->where('role_id', 39)
                ->where('status', 1)
                ->select('permission_id')
                ->get();
    
            $assigned_permissions = [];
            foreach ($assigned_permission as $assigned_permission) {
                array_push($assigned_permissions, $assigned_permission->permission_id);
            }
            $menu = $assigned_permissions;
        }
    
        //dd($assigned_permissions);
    }
    //=================//Menu Permission=======//
@endphp

<style type="text/css">
    .notification {
        position: absolute;
        top: 0;
        right: 40px;
    }
</style>
<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    @if(citizen_auth_menu())
    <div class="container align-items-stretch justify-content-between">
        <!--begin::Topbar-->
        <div class="topbar_wrapper">
            <div class="topbar">
                @auth
                    @if (in_array(1, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ route('dashboard') }}"
                                    class="navi-link {{ request()->is('dashboard') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary" style="padding-left: 0 !important;">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24">
                                                    </rect>
                                                    <rect fill="#000000" x="4" y="4" width="7"
                                                        height="7" rx="1.5"></rect>
                                                    <path
                                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <p class="navi-text">ড্যাশবোর্ড</p>
                                        </span>
                                        <span class="pulse-ring"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (in_array(99, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ route('role-permission.index') }}"
                                    class="navi-link {{ request()->is('role-permission/index') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z"
                                                        fill="#000000" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">রোল</p>
                                        </span>


                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif


                    {{-- @if (in_array(37, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ route('log.index') }}" class="navi-link">
                                    <div class="btn  btn-clean btn-dropdown btn-lg mr-5 pulse pulse-primary">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <rect fill="#000000" x="4" y="4" width="7"
                                                        height="7" rx="1.5"></rect>
                                                    <path
                                                        d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                                        fill="#000000" opacity="0.3"></path>
                                                </g>
                                            </svg>
                                            <p class="navi-text">মামলা কার্যকলাপ নিরীক্ষা</p>
                                        </span>
                                        <span class="pulse-ring"></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif --}}


                    @if (in_array(5, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('citizen/appeal/create', 'appeal/draft_list', 'appeal/list', 'appeal/closed_list', 'appeal/postponed_list', 'appeal/rejected_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                                    fill="#000000" />
                                                <path
                                                    d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">কোর্ট পরিচালনা</p>
                                    </span>
                                </div>
                            </div>


                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if (in_array(6, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('citizen.appeal.create') }}"
                                                class="navi-link {{ request()->is('citizen/appeal/create') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">অভিযোগ দায়ের করুন</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(7, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.draft_list') }}"
                                                class="navi-link {{ request()->is('appeal/draft_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                <rect fill="#000000" opacity="0.3" x="5"
                                                                    y="20" width="15" height="2"
                                                                    rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> খসড়া মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(8, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.index') }}"
                                                class="navi-link {{ request()->is('appeal/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z"
                                                                    fill="#000000" />
                                                                <path
                                                                    d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> চলমান মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(9, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.closed_list') }}"
                                                class="navi-link {{ request()->is('appeal/closed_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24"></rect>
                                                                <path
                                                                    d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z"
                                                                    fill="#000000" opacity="0.3"></path>
                                                                <path
                                                                    d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                    fill="#000000"></path>
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> নিষ্পত্তিকৃত মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(10, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.postponed_list') }}"
                                                class="navi-link {{ request()->is('appeal/postponed_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> মুলতবি মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(11, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.rejected_list') }}"
                                                class="navi-link {{ request()->is('appeal/rejected_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M12,16 C14.209139,16 16,14.209139 16,12 C16,9.790861 14.209139,8 12,8 C9.790861,8 8,9.790861 8,12 C8,14.209139 9.790861,16 12,16 Z M12,20 C7.581722,20 4,16.418278 4,12 C4,7.581722 7.581722,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 Z"
                                                                    fill="#000000" fill-rule="nonzero" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">বাতিলকৃত মামলা</span>
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->


                        </div>
                    @endif


                    @if (in_array(22, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('citizen/appeal/create', 'report') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                                    fill="#000000" />
                                                <path
                                                    d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">অভিযোগ দায়ের </p>
                                    </span>
                                </div>
                            </div>

                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->

                                    <li class="navi-item">
                                        <a href="{{ route('citizen.appeal.create') }}"
                                            class="navi-link {{ request()->is('citizen/appeal/create') ? 'menu-item-active' : '' }}">
                                            <span class="symbol symbol-20 mr-3">
                                                <span class="svg-icon menu-icon svg-icon-primary">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" />
                                                            <path
                                                                d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                fill="#000000" opacity="0.3" />
                                                            <path
                                                                d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                fill="#000000" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                            </span>
                                            <span class="navi-text">অভিযোগ দায়ের করুন</span>
                                        </a>
                                    </li>

                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->

                        </div>
                    @endif

                    {{-- @if (in_array(38, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                                data-placement="right" title data-original-title="" aria-haspopup="true">
                                <a href="{{ route('user-management.index') }}" class="navi-link">

                                    <div class="btn  btn-clean btn-dropdown btn-lg mr-5">
                                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                            <span class="svg-icon svg-icon-primary svg-icon-2x">
                                <a href="{{ route('user-management.index') }}" class="navi-link {{ request()->is('user-management/index') ? 'menu-item-active' : '' }}">

                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x"> 
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">দপ্তর ইউজার </p>
                                        </span>

                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif --}}
                    @if (in_array(28, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item cs_notification" data-toggle="dropdown" data-offset="10px,0px"
                                title="">

                                <div class=" btn-clean btn-dropdown mr-2">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                                    fill="#000000" />
                                                <rect fill="#000000" opacity="0.3" x="10" y="16"
                                                    width="4" height="4" rx="2" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">নোটিফিকেশন</p>
                                    </span>

                                    @if ($notification_count != 0)
                                        <span class="menu-label notification">
                                            <span class="label label-rounded label-danger cs_notification_count"
                                                data-notification={{ $notification_count }}></span>
                                        </span>
                                    @endif
                                </div>
                            </div>




                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @if (in_array(29, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.pending_list') }}"
                                                class="navi-link {{ request()->is('appeal/pending/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) "
                                                                    x="11" y="1" width="2"
                                                                    height="12" rx="1" />
                                                                <path
                                                                    d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                <path
                                                                    d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z"
                                                                    fill="#000000" fill-rule="nonzero" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">গ্রহণের জন্য অপেক্ষমাণ</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($total_pending_case) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(41, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.pending_review_list') }}"
                                                class="navi-link {{ request()->is('appeal/pending/review/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) "
                                                                    x="11" y="1" width="2"
                                                                    height="12" rx="1" />
                                                                <path
                                                                    d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z"
                                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                                <path
                                                                    d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z"
                                                                    fill="#000000" fill-rule="nonzero" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">গ্রহণের জন্য অপেক্ষমাণ রিভিউ আবেদন</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($total_pending_review_case) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(30, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.trial_date_list') }}"
                                                class="navi-link {{ request()->is('appeal/trial_date_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> শুনানির তারিখ</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseTrialCount) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(31, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.arrest_warrent_list') }}"
                                                class="navi-link {{ request()->is('appeal/arrest_warrent_list') ? 'menu-item-active' : '' }}">

                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text"> গ্রেপ্তারি পরোয়ানা জারি</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseWarrentCount) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(42, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.with_investigation_report') }}"
                                                class="navi-link {{ request()->is('appeal/with/investigation/report') ? 'menu-item-active' : '' }}">

                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">তদন্তের রিপোর্টযুক্ত আবেদন</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseWithInvestigationReport) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(43, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.appeal_with_action_required') }}"
                                                class="navi-link {{ request()->is('appeal/with/action/required') ? 'menu-item-active' : '' }}">

                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">চলমান মামলাতে পদক্ষেপ নিতে হবে</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseRunningCountActionRequired) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif




                    @if (in_array(32, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title=""
                                aria-haspopup="true">
                                <a href="#!"
                                    class="navi-link {{ request()->is('appeal/arrest_investigation_list') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                            <i style="color: #FF1703" class="fas fa-bell"></i>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">ইনভেস্টিগেশন</p>
                                        </span>


                                        @if ($CaseInvestigationCount != 0)
                                            <span class="menu-label notification">
                                                <span
                                                    class="label label-rounded label-danger">{{ en2bn($CaseInvestigationCount) }}</span>
                                            </span>
                                        @endif

                                    </div>
                                </a>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->

                                    @if (in_array(32, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('appeal.arrest_investigation_list') }}"
                                                class="navi-link {{ request()->is('appeal/arrest_investigation_list') ? 'menu-item-active' : '' }}">

                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                            <path
                                                                d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                            <path
                                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">তদন্তের আদেশ জারি</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ en2bn($CaseInvestigationCount) }}
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif


                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif


                    @if (in_array(23, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">

                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('setting/crpc-section', 'setting/division', 'setting/short-decision', 'court', 'case-mapping/index') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z"
                                                    fill="#000000" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">সেটিংস</p>
                                    </span>
                                </div>
                            </div>


                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->


                                    @if (in_array(24, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('setting.crpcsection') }}"
                                                class="navi-link {{ request()->is('setting/crpc-section') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">ধারা (সিআরপিসি সেকশন)</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(25, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('setting.division') }}"
                                                class="navi-link {{ request()->is('setting/division') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">বিভাগ</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(26, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('setting.short-decision') }}"
                                                class="navi-link {{ request()->is('setting/short-decision') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সংক্ষিপ্ত আদেশ</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(80, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('peshkar.short.decision') }}"
                                                class="navi-link {{ request()->is('peshkar-short-decision') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">পেশকার সংক্ষিপ্ত আদেশ</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(27, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('court') }}"
                                                class="navi-link {{ request()->is('court') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">আদালত</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(36, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('case-mapping.index') }}"
                                                class="navi-link {{ request()->is('case-mapping/index') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(13.000000, 6.000000) rotate(-450.000000) translate(-13.000000, -6.000000) "
                                                                    x="12" y="8.8817842e-16" width="2"
                                                                    height="12" rx="1" />
                                                                <path
                                                                    d="M9.79289322,3.79289322 C10.1834175,3.40236893 10.8165825,3.40236893 11.2071068,3.79289322 C11.5976311,4.18341751 11.5976311,4.81658249 11.2071068,5.20710678 L8.20710678,8.20710678 C7.81658249,8.59763107 7.18341751,8.59763107 6.79289322,8.20710678 L3.79289322,5.20710678 C3.40236893,4.81658249 3.40236893,4.18341751 3.79289322,3.79289322 C4.18341751,3.40236893 4.81658249,3.40236893 5.20710678,3.79289322 L7.5,6.08578644 L9.79289322,3.79289322 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(7.500000, 6.000000) rotate(-270.000000) translate(-7.500000, -6.000000) " />
                                                                <rect fill="#000000" opacity="0.3"
                                                                    transform="translate(11.000000, 18.000000) scale(1, -1) rotate(90.000000) translate(-11.000000, -18.000000) "
                                                                    x="10" y="12" width="2"
                                                                    height="12" rx="1" />
                                                                <path
                                                                    d="M18.7928932,15.7928932 C19.1834175,15.4023689 19.8165825,15.4023689 20.2071068,15.7928932 C20.5976311,16.1834175 20.5976311,16.8165825 20.2071068,17.2071068 L17.2071068,20.2071068 C16.8165825,20.5976311 16.1834175,20.5976311 15.7928932,20.2071068 L12.7928932,17.2071068 C12.4023689,16.8165825 12.4023689,16.1834175 12.7928932,15.7928932 C13.1834175,15.4023689 13.8165825,15.4023689 14.2071068,15.7928932 L16.5,18.0857864 L18.7928932,15.7928932 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(16.500000, 18.000000) scale(1, -1) rotate(270.000000) translate(-16.500000, -18.000000) " />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">ম্যাপিং</span>
                                            </a>
                                        </li>
                                    @endif

                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->

                        </div>
                    @endif


                    @if (in_array(33, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->

                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('peshkar/adm/dm/list', 'doptor/user/management/office_list') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path
                                                    d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path
                                                    d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">ইউজার </p>
                                    </span>
                                </div>
                            </div>




                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->

                                    @if (in_array(33, $menu))
                                        @if (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2)
                                            <li class="navi-item d-none">
                                                <a href="{{ route('admin.doptor.management.import.offices.search') }}"
                                                    class="navi-link {{ request()->is('admin/doptor/management/import/dortor/offices/search') ? 'menu-item-active' : '' }}">

                                                    <span class="symbol symbol-20 mr-3">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <path
                                                                        d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        opacity="0.3" />
                                                                    <path
                                                                        d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                        fill="#000000" fill-rule="nonzero" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <span class="navi-text"> দপ্তর ইউজার</span>
                                                </a>
                                            </li>
                                        @else
                                            @if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 38)
                                                <li class="navi-item">
                                                    <a href="{{ route('peshkar.adm.dm.list') }}"
                                                        class="navi-link {{ request()->is('peshkar/adm/dm/list') ? 'menu-item-active' : '' }}">
                                                        <span class="symbol2 symbol-20 mr-3">
                                                            <span
                                                                class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                                                <i style="color: #3699ff; margin-top: 0 !important;"
                                                                    class="fas fa-user"></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text">ইউজার</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endif

                                    @endif

                                    @if (in_array(38, $menu))
                                        @if (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2)
                                            <li class="navi-item">
                                                <a href="{{ route('admin.doptor.management.import.offices.search') }}"
                                                    class="navi-link {{ request()->is('admin/doptor/management/import/dortor/offices/search') ? 'menu-item-active' : '' }}">

                                                    <span class="symbol symbol-20 mr-3">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <path
                                                                        d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        opacity="0.3" />
                                                                    <path
                                                                        d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                        fill="#000000" fill-rule="nonzero" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <span class="navi-text"> দপ্তর ইউজার</span>
                                                </a>
                                            </li>
                                        @else
                                            <li class="navi-item">
                                                <a href="{{ route('doptor.user.management.pick.role') }}"
                                                    class="navi-link {{ request()->is('doptor/user/management/office_list') ? 'menu-item-active' : '' }}">

                                                    <span class="symbol symbol-20 mr-3">
                                                        <span
                                                            class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                                height="24px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                                    <path
                                                                        d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                                        fill="#000000" fill-rule="nonzero"
                                                                        opacity="0.3" />
                                                                    <path
                                                                        d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                                        fill="#000000" fill-rule="nonzero" />
                                                                </g>
                                                            </svg>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                    <span class="navi-text"> দপ্তর ইউজার</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endif


                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif






                    <!-- //Citizen ber -->

                    @if (in_array(12, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title=""
                                aria-haspopup="true">
                                <a href="{{ route('role-permission.index') }}"
                                    class="navi-link {{ request()->is('messages_recent', 'messages_request', 'messages') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x"><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
                                                        fill="#000000" />
                                                    <path
                                                        d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
                                                        fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">বার্তা</p>
                                        </span>

                                    </div>
                                </a>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @php
                                        $NewMessagesCount = $msg_request_count = 0;
                                    @endphp
                                    @if (in_array(13, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages_recent') }}"
                                                class="navi-link {{ request()->is('messages_recent') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সাম্প্রতিক বার্তা</span>
                                                @if ($NewMessagesCount != 0)
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ $NewMessagesCount = 5 }}</span>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(14, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages_request') }}"
                                                class="navi-link {{ request()->is('messages_request') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                    fill="#000000" />
                                                                <path
                                                                    d="M6,14 C6.55228475,14 7,14.4477153 7,15 L7,17 C7,17.5522847 6.55228475,18 6,18 C5.44771525,18 5,17.5522847 5,17 L5,15 C5,14.4477153 5.44771525,14 6,14 Z M6,21 C5.44771525,21 5,20.5522847 5,20 C5,19.4477153 5.44771525,19 6,19 C6.55228475,19 7,19.4477153 7,20 C7,20.5522847 6.55228475,21 6,21 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">নতুন বার্তা অনুরোধ</span>
                                                {{-- @if ($NewMessagesCount != 0) --}}
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $msg_request_count = 2 }}</span>
                                                </span>
                                                {{-- @endif --}}
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(15, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages') }}"
                                                class="navi-link {{ request()->is('messages') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">ব্যবহারকারীর তালিকা</span>
                                                {{-- @if ($NewMessagesCount != 0) --}}
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $msg_request_count = 2 }}</span>
                                                </span>
                                                {{-- @endif --}}
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif


                    @if (in_array(12, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title=""
                                aria-haspopup="true">
                                <a href="{{ route('role-permission.index') }}"
                                    class="navi-link {{ request()->is('role-permission/index') ? 'menu-item-active' : '' }}">
                                    <div class="btn-dropdown mr-2 pulse pulse-primary">
                                        <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x"><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24" />
                                                    <path
                                                        d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"
                                                        fill="#000000" />
                                                    <path
                                                        d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"
                                                        fill="#000000" opacity="0.3" />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                            <p class="navi-text">নোটিফিকেশন</p>
                                        </span>

                                    </div>
                                </a>
                            </div>
                            <!--begin::Dropdown-->
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @php
                                        $NewMessagesCount = $msg_request_count = 0;
                                    @endphp
                                    @if (in_array(13, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages_recent') }}"
                                                class="navi-link {{ request()->is('messages_recent') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M6,2 L18,2 C18.5522847,2 19,2.44771525 19,3 L19,12 C19,12.5522847 18.5522847,13 18,13 L6,13 C5.44771525,13 5,12.5522847 5,12 L5,3 C5,2.44771525 5.44771525,2 6,2 Z M7.5,5 C7.22385763,5 7,5.22385763 7,5.5 C7,5.77614237 7.22385763,6 7.5,6 L13.5,6 C13.7761424,6 14,5.77614237 14,5.5 C14,5.22385763 13.7761424,5 13.5,5 L7.5,5 Z M7.5,7 C7.22385763,7 7,7.22385763 7,7.5 C7,7.77614237 7.22385763,8 7.5,8 L10.5,8 C10.7761424,8 11,7.77614237 11,7.5 C11,7.22385763 10.7761424,7 10.5,7 L7.5,7 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M3.79274528,6.57253826 L12,12.5 L20.2072547,6.57253826 C20.4311176,6.4108595 20.7436609,6.46126971 20.9053396,6.68513259 C20.9668779,6.77033951 21,6.87277228 21,6.97787787 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6.97787787 C3,6.70173549 3.22385763,6.47787787 3.5,6.47787787 C3.60510559,6.47787787 3.70753836,6.51099993 3.79274528,6.57253826 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সাম্প্রতিক বার্তা</span>
                                                @if ($NewMessagesCount != 0)
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ $NewMessagesCount = 5 }}</span>
                                                    </span>
                                                @endif
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif
                    @if (in_array(16, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="নোটিফিকেশন">
                                <div
                                    class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 {{ request()->is('hearing_date', 'results_completed', 'messages_request', 'messages') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                                    fill="#000000" />
                                                <rect fill="#000000" opacity="0.3" x="10" y="16"
                                                    width="4" height="4" rx="2" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                            </div>
                            <!--end::Toggle-->
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->
                                    @php
                                        $NewMessagesCount = $msg_request_count = 0;
                                    @endphp
                                    @if (in_array(17, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('hearing_date') }}"
                                                class="navi-link {{ request()->is('hearing_date') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                                                    fill="#000000" />
                                                                <path
                                                                    d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">শুনানির তারিখ নির্ধারণ করা
                                                    হয়েছে</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $CaseHearingCount = 5 }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(18, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('results_completed') }}"
                                                class="navi-link {{ request()->is('results_completed') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path
                                                                    d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) " />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">ফলাফল সম্পন্ন</span>
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $CaseResultCount = 5 }}</span>
                                                </span>
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(19, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages_request') }}"
                                                class="navi-link {{ request()->is('messages_request') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                    fill="#000000" />
                                                                <path
                                                                    d="M6,14 C6.55228475,14 7,14.4477153 7,15 L7,17 C7,17.5522847 6.55228475,18 6,18 C5.44771525,18 5,17.5522847 5,17 L5,15 C5,14.4477153 5.44771525,14 6,14 Z M6,21 C5.44771525,21 5,20.5522847 5,20 C5,19.4477153 5.44771525,19 6,19 C6.55228475,19 7,19.4477153 7,20 C7,20.5522847 6.55228475,21 6,21 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">নতুন বার্তা অনুরোধ</span>
                                                {{-- @if ($NewMessagesCount != 0) --}}
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $msg_request_count = 2 }}</span>
                                                </span>
                                                {{-- @endif --}}
                                            </a>
                                        </li>
                                    @endif
                                    @if (in_array(20, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('messages') }}"
                                                class="navi-link {{ request()->is('messages') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">ব্যবহারকারীর তালিকা</span>
                                                {{-- @if ($NewMessagesCount != 0) --}}
                                                <span class="menu-label">
                                                    <span
                                                        class="label label-rounded label-danger">{{ $msg_request_count = 2 }}</span>
                                                </span>
                                                {{-- @endif --}}
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif
                    @if (in_array(21, $menu))
                        <div class="dropdown">
                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                                <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                                    @if (Auth::user()->profile_pic != null)
                                        <img class="h-20px w-20px rounded-sm"
                                            src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}"
                                            alt="">
                                    @else
                                        <img class="h-20px w-20px rounded-sm"
                                            src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
                                            alt="">
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (in_array(39, $menu))
                        <div class="dropdown">
                            <!--begin::Toggle-->

                            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" title="">
                                <div
                                    class=" btn-clean btn-dropdown mr-2 {{ request()->is('register/list', 'citizen/appeal/cause_list', 'support/center', 'log_index' . 'calendar', 'report') ? 'menu-item-active' : '' }}">
                                    <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                            viewBox="0 0 24 24" version="1.1">

                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" cx="12" cy="5"
                                                    r="2" />
                                                <circle fill="#000000" cx="12" cy="12"
                                                    r="2" />
                                                <circle fill="#000000" cx="12" cy="19"
                                                    r="2" />
                                            </g>
                                        </svg>
                                        <p class="navi-text">অন্যান্য</p>

                                    </span>
                                </div>
                            </div>
                            <!--begin::Dropdown-->
                            <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                                <!--begin::Nav-->
                                <ul class="navi navi-hover py-4">
                                    <!--begin::Item-->

                                    @if (in_array(3, $menu))
                                        <li class="navi-item">
                                            <a href="{{ url('register/list') }}"
                                                class="navi-link {{ request()->is('register/list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                                                    fill="#000000" fill-rule="nonzero"
                                                                    transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                                                <rect fill="#000000" opacity="0.3" x="5"
                                                                    y="20" width="15" height="2"
                                                                    rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">রেজিস্টার </span>
                                            </a>
                                        </li>
                                    @endif


                                    @if (in_array(4, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('calendar') }}"
                                                class="navi-link {{ request()->is('calendar') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <rect fill="#000000" opacity="0.3" x="4"
                                                                    y="4" width="4" height="4"
                                                                    rx="1" />
                                                                <path
                                                                    d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">ক্যালেন্ডার</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(34, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('citizen.appeal.cause_list') }}"
                                                class="navi-link {{ request()->is('citizen/appeal/cause_list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" x="10"
                                                                    y="9" width="7" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="7"
                                                                    y="9" width="2" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="7"
                                                                    y="13" width="2" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="10"
                                                                    y="13" width="7" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="7"
                                                                    y="17" width="2" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="10"
                                                                    y="17" width="7" height="2"
                                                                    rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">কার্যতালিকা</span>
                                            </a>
                                        </li>
                                    @endif


                                    @if (in_array(35, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('report') }}"
                                                class="navi-link {{ request()->is('report') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <rect fill="#000000" opacity="0.3" x="2"
                                                                    y="3" width="20" height="18"
                                                                    rx="2" />
                                                                <path
                                                                    d="M9.9486833,13.3162278 C9.81256925,13.7245699 9.43043041,14 9,14 L5,14 C4.44771525,14 4,13.5522847 4,13 C4,12.4477153 4.44771525,12 5,12 L8.27924078,12 L10.0513167,6.68377223 C10.367686,5.73466443 11.7274983,5.78688777 11.9701425,6.75746437 L13.8145063,14.1349195 L14.6055728,12.5527864 C14.7749648,12.2140024 15.1212279,12 15.5,12 L19,12 C19.5522847,12 20,12.4477153 20,13 C20,13.5522847 19.5522847,14 19,14 L16.118034,14 L14.3944272,17.4472136 C13.9792313,18.2776054 12.7550291,18.143222 12.5298575,17.2425356 L10.8627389,10.5740611 L9.9486833,13.3162278 Z"
                                                                    fill="#000000" fill-rule="nonzero" />
                                                                <circle fill="#000000" opacity="0.3" cx="19"
                                                                    cy="6" r="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">রিপোর্ট</span>
                                            </a>
                                        </li>
                                    @endif

                                    @if (in_array(2, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('support.center') }}"
                                                class="navi-link {{ request()->is('support/center') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <circle fill="#000000" opacity="0.3" cx="12"
                                                                    cy="12" r="10" />
                                                                <path
                                                                    d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
                                                                    fill="#000000" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">সাপোর্ট</span>
                                            </a>
                                        </li>
                                    @endif


                                    @if (in_array(37, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('log.index') }}"
                                                class="navi-link {{ request()->is('log_index') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3">
                                                    <span class="svg-icon auth-svg-icon-bar menu-icon svg-icon-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none"
                                                                fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24"
                                                                    height="24" />
                                                                <path
                                                                    d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z"
                                                                    fill="#000000" opacity="0.3" />
                                                                <path
                                                                    d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z"
                                                                    fill="#000000" />
                                                                <rect fill="#000000" opacity="0.3" x="10"
                                                                    y="9" width="7" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="7"
                                                                    y="9" width="2" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="7"
                                                                    y="13" width="2" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="10"
                                                                    y="13" width="7" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="7"
                                                                    y="17" width="2" height="2"
                                                                    rx="1" />
                                                                <rect fill="#000000" opacity="0.3" x="10"
                                                                    y="17" width="7" height="2"
                                                                    rx="1" />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                </span>
                                                <span class="navi-text">মামলা নিরীক্ষা</span>
                                            </a>
                                        </li>
                                    @endif


                                    @if (in_array(40, $menu))
                                        <li class="navi-item">
                                            <a href="{{ route('news.list') }}"
                                                class="navi-link {{ request()->is('news.list') ? 'menu-item-active' : '' }}">
                                                <span class="symbol symbol-20 mr-3 auth-svg-icon-bar ">
                                                    <i class=" ml-1 fas fa-newspaper"
                                                        style="color: #acdefe !important"></i>
                                                </span>
                                                <span class="navi-text">ফিচার নিউজ</span>
                                            </a>
                                        </li>
                                    @endif
                                    <!--end::Item-->
                                </ul>
                                <!--end::Nav-->
                            </div>
                            <!--end::Dropdown-->
                        </div>
                    @endif

                    <div class="topbar-item">
                        <div class="btn  -mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle" style="margin: -12px">
                            <span class="text-muted font-size-base d-none d-md-inline mr-1">
                                @if (Auth::user()->profile_pic != null)
                                    @if (Auth::user()->doptor_user_flag == 1)
                                        <img src="{{ Auth::user()->profile_pic }}">
                                    @else
                                        <img
                                            src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}">
                                    @endif
                                @else
                                    <img src="{{ url('/') }}/uploads/profile/default.jpg">
                                @endif

                            </span>
                            <span class="text-dark font-size-base d-none d-md-inline mr-3 text-left">
                                <i style="float: right; padding-left: 20px; padding-top: 12px;"
                                    class="fas fa-chevron-down"></i>
                                <b>{{ auth()->user()->name }}</b><br>{{ Auth::user()->role->role_name }}
                            </span>
                            <!-- <span class="symbol symbol-lg-35 symbol-25 symbol-light-info bg-primary p-2 text-light rounded">
                                                                    <span class="">{{ Auth::user()->role->role_name }}</span>
                                                                </span> -->
                        </div>
                    </div>
                @else
                    <div class="tpbar_text_menu topbar-item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">ধারা
                                ভিত্তিক অভিযোগের ধরণ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu topbar-item mr-2">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">প্রসেস
                                ম্যাপ</a>
                        </div>
                    </div>
                    <div class="tpbar_text_menu tpbar_text_mlast topbar-item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <a href="" class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">আইন ও
                                বিধি</a>
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(109, 91, 220);" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 320 512">Copyright 2022 Fonticons, Inc. --><path
                                        d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"
                                        fill="#6d5bdc"></path></svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-twitter"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="topbar-item mr-8">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="topbar_social_icon">
                            <a href="" class="social-svg-icon svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-youtube"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"
                                        fill="#6c5adc"></path>
                                </svg>
                            </a>
                        </div>
                    </div>




                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                <svg style="color: rgb(108, 90, 220);" xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16" fill="currentColor" class="bi bi-play-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"
                                        fill="#6c5adc"></path>
                                </svg>
                                <!--end::Svg Icon-->
                            </span><b> Online Course</b>
                            <!-- <input type="button" id="loginID" class="btn btn-info" value="{{ __('লগইন') }}"
                                                                    data-toggle="modal" data-target="#exampleModalLong"> -->
                        </div>
                    </div>
                    <div class="topbar-item">
                        <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-primary svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M12,22 C6.4771525,22 2,17.5228475 2,12 C2,6.4771525 6.4771525,2 12,2 C17.5228475,2 22,6.4771525 22,12 C22,17.5228475 17.5228475,22 12,22 Z M11.613922,13.2130341 C11.1688026,13.6581534 10.4887934,13.7685037 9.92575695,13.4869855 C9.36272054,13.2054673 8.68271128,13.3158176 8.23759191,13.760937 L6.72658218,15.2719467 C6.67169475,15.3268342 6.63034033,15.393747 6.60579393,15.4673862 C6.51847004,15.7293579 6.66005003,16.0125179 6.92202169,16.0998418 L8.27584113,16.5511149 C9.57592638,16.9844767 11.009274,16.6461092 11.9783003,15.6770829 L15.9775173,11.6778659 C16.867756,10.7876271 17.0884566,9.42760861 16.5254202,8.3015358 L15.8928491,7.03639343 C15.8688153,6.98832598 15.8371895,6.9444475 15.7991889,6.90644684 C15.6039267,6.71118469 15.2873442,6.71118469 15.0920821,6.90644684 L13.4995401,8.49898884 C13.0544207,8.94410821 12.9440704,9.62411747 13.2255886,10.1871539 C13.5071068,10.7501903 13.3967565,11.4301996 12.9516371,11.8753189 L11.613922,13.2130341 Z"
                                            fill="#000000" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span><b>333</b>
                            <!-- <a href="{{ url('/citizenRegister') }}" type="button" class="btn btn-info"
                                                                    value="">{{ __('নাগরিক নিবন্ধন') }}</a> -->
                        </div>
                    </div>
                @endauth
                <!--end::User-->
            </div>
        </div>
        <!--end::Topbar-->
    </div>
    @else
     @include('mobile_first_registration.non_verified_account_header')
    @endif
    
    <!--end::Container-->
</div>
