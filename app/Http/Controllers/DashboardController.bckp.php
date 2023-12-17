<?php

namespace App\Http\Controllers;

// use Auth;
use App\Models\EmAppeal;
use App\Models\Dashboard;
use App\Models\EmCauseList;
use App\Models\CaseRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Repositories\NDoptorRepository;
use App\Repositories\PeshkarNoteRepository;
use App\Http\Resources\calendar\GccAppealHearingCollection;

// use Illuminate\Foundation\Auth\AuthenticatesUsers;
// use App\Http\Controllers\CommonController;

class DashboardController extends Controller
{

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        NDoptorRepository::signature();
        NDoptorRepository::profilePicture();

        $officeInfo = user_office_info();
        $user = globalUserInfo();
        $userID = globalUserInfo()->id;
        $roleID = Auth::user()->role_id;
        //   dd($roleID);
        // $districtID = DB::table('office')
        // ->select('district_id')->where('id',$user->office_id)
        // ->first()->district_id;
        // $upazilaID = DB::table('office')
        // ->select('upazila_id')->where('id',$user->office_id)
        //                   ->first()->upazila_id;
        $data = [];
        $data['rm_case_status'] = [];

        if ($roleID == 1) {
            // Superadmi dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereNotIn('appeal_status', ['DRAFT'])->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_EM','SEND_TO_ASST_DM','SEND_TO_DM','SEND_TO_EM'])->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->count();
            $data['rejected_case'] = EmAppeal::where('appeal_status', 'REJECTED')->count();
            $data['postpond_case'] = EmAppeal::where('appeal_status', 'POSTPONED')->count();
            $data['draft_case'] = EmAppeal::where('appeal_status', 'DRAFT')->count();

            $data['total_office'] = DB::table('office')->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en','division.division_bbs_code')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->division_bbs_code);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn','district.district_bbs_code')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    

                    $dis_data[$division->division_bbs_code][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

                    
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
                    ->where('division_id', $division->id)->get();

                    foreach ($upazila_list as $upazila) {
                        $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->district_bbs_code];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->division_bbs_code];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->division_bbs_code, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
               // $data['dis_upa_data'] = array_merge($upazilatdata);
            }




             
            // dd($result);
            // $data['divisiondata'] = $divisiondata;
            // dd($data['division_arr']);

            // View
            $data['page_title'] = 'সুপার অ্যাডমিন ড্যাশবোর্ড';
            return view('dashboard.superadmin')->with($data);

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

            $data['total_office'] = DB::table('office')->where('is_dm_adm_em', 1)->whereNotIn('id', [1, 2, 7])->count();
            $data['total_user'] = DB::table('users')->count();
            $data['total_court'] = DB::table('court')->whereNotIn('id', [1, 2])->count();
           // $data['total_mouja'] = DB::table('mouja')->count();
            //$data['total_ct'] = DB::table('case_type')->count();

            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            // Drildown Statistics
            $division_list = DB::table('division')
                ->select('division.id', 'division.division_name_bn', 'division.division_name_en','division.division_bbs_code')
                ->get();

            $divisiondata = array();
            $districtdata = array();
            
            $upazilatdata = array();

            // Division List
            foreach ($division_list as $division) {
                
                $data['divisiondata'][] = array('name' => $division->division_name_bn, 'y' => $this->get_drildown_case_count($division->id), 'drilldown' => $division->division_bbs_code);

                // District List
                $district_list = DB::table('district')->select('district.id', 'district.district_name_bn','district.district_bbs_code')->where('division_id', $division->id)->get();
                foreach ($district_list as $district) {
                    

                    $dis_data[$division->division_bbs_code][] = array('name' => $district->district_name_bn, 'y' => $this->get_drildown_case_count('', $district->id), 'drilldown' => $district->district_bbs_code);

                    
                    $upazila_list = DB::table('upazila')->select('upazila.id', 'upazila.upazila_name_bn')->where('district_id', $district->id)
                    ->where('division_id', $division->id)->get();

                    foreach ($upazila_list as $upazila) {
                        $upa_data[$district->district_bbs_code][] = array($upazila->upazila_name_bn, $this->get_drildown_case_count('', '', $upazila->id));
                    }

                    $upadata = $upa_data[$district->district_bbs_code];
                    $upazilatdata[] = array('name' => $district->district_name_bn, 'id' => $district->district_bbs_code, 'data' => $upadata);
                }

                $disdata = $dis_data[$division->division_bbs_code];
                $districtdata[] = array('name' => $division->division_name_bn, 'id' => $division->division_bbs_code, 'data' => $disdata);

                $data['dis_upa_data'] = array_merge($upazilatdata, $districtdata); //$districtdata;  $upazilatdata;
               // $data['dis_upa_data'] = array_merge($upazilatdata);
            }
            // $data['divisiondata'] = $divisiondata;
             //dd($data['dis_upa_data']);

            // CRPC Section Statistics
            $crpc_section_list = DB::table('crpc_sections')
                ->select('crpc_sections.id', 'crpc_sections.crpc_id', 'crpc_sections.crpc_name')
                ->get();

            $crpcdata = array();
            // Division List
            foreach ($crpc_section_list as $crpc) {
                // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
                // Division Data
                $data['crpcdata'][] = array('name' => $crpc->crpc_id, 'y' => $this->get_drildown_crpc_case_count($crpc->id));
            }

            // dd($data['crpcdata'][0]['y']);

            // return $data;
            // View
            $data['page_title'] = 'অ্যাডমিন ড্যাশবোর্ড';
            return view('dashboard.monitoring_admin')->with($data);

            // return view('ux-asad.dashboard.dashboard')->with($data);

        } elseif ($roleID == 7) {
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DM'])->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->count();

            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_DM'])->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->count();
           
            $appeal = EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->limit(10)->get();
            // $data['appeal']  = $appeal;
            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_district())->get();

            $data['running_case_paginate'] = EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count(); 

            // View
            $data['page_title'] = 'অতিরিক্ত জেলা প্রশাসকের ড্যাশবোর্ড';
            return view('dashboard.admin_dm')->with($data);

        }  elseif ($roleID == 20) {
            // dd(1);
            $appeal_no = [];
            $totalCase_bibadi = 0;
            $totalRunningCase_bibadi = 0;
            $totalCompleteCase_bibadi = 0;
            $pending_case_assigned_lawer_count = 0;

            $citizen_id = DB::table('em_citizens')
                ->where('citizen_NID', globalUserInfo()->citizen_nid)
                ->select('id')
                ->get();
            if (!empty($citizen_id)) {
                foreach ($citizen_id as $key => $value) {
                    // return $value;
                    $appeal_no = DB::table('em_appeal_citizens')
                        ->where('citizen_id', $value->id)
                        ->whereIN('citizen_type_id', [2, 4,7])
                        ->select('appeal_id')
                        ->get();

                }
            } else {
                $appeal_no = null;
            }
            // return $appeal_no;

            if (!empty($appeal_no)) {
                foreach ($appeal_no as $key => $value) {
                    if (!empty($value)) {
                        // return $value;
                        $all_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])->first();
                        if ($all_case) {
                            $totalCase_bibadi++;
                        }
                        $running_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->first();
                        if ($running_case) {
                            $totalRunningCase_bibadi++;
                        }
                        $completed_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['CLOSED'])->first();
                        if ($completed_case) {
                            $totalCompleteCase_bibadi++;
                        }
                        $pending_case_assigned_lawer = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])->first();
                        if ($pending_case_assigned_lawer) {
                            $pending_case_assigned_lawer_count++;
                        }
                    }
                }
            }

            $total_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DM'])->count();
            $running_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count();
            $completed_case_badi = EmAppeal::where('created_by', $userID)->where('appeal_status', 'CLOSED')->count();
            $data['total_case'] = $totalCase_bibadi + $total_case_badi;
            $data['running_case'] = $totalRunningCase_bibadi + $running_case_badi;
            $data['completed_case'] = $totalCompleteCase_bibadi + $completed_case_badi;
            // Counter
            // $data['total_case'] = EmAppeal::where('created_by', $userID)->count();
            $lawer_created_case = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])->count();

            $data['pending_case'] = $pending_case_assigned_lawer_count + $lawer_created_case;

           
            $appeal_no = DB::table('em_appeals')
                ->join('em_appeal_citizens', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4,7])
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->select('em_appeals.id as appeal_id')->get();

            $cause_list_ids = [];
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $value) {
                    array_push($cause_list_ids, $value->appeal_id);
                }
            }

            $appeal = EmAppeal::whereIn('id', $cause_list_ids)->limit(10)->get();

            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            // dd($data['case_status']);
            // return $data;
            $data['running_case_paginate'] = EmAppeal::whereIn('id', $cause_list_ids)->count(); 

            $data['page_title'] = 'আইনজীবী  ড্যাশবোর্ড';

            return view('dashboard.advocate')->with($data);

        }   elseif ($roleID == 27) {
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_EM'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            

           
            
            $crpc_section_list = DB::table('crpc_sections')
                ->select('crpc_sections.id', 'crpc_sections.crpc_id', 'crpc_sections.crpc_name')
                ->get();

            $crpcdata = array();
            
            foreach ($crpc_section_list as $crpc) {
               
                $data['crpcdata'][] = array('name' => $crpc->crpc_id, 'y' => $this->courtwisecrpcstatistics($crpc->id));
            }

            $appeal = EmAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->where('court_id', '=', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->limit(10)->get();
            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['running_case_paginate'] =EmAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->where('court_id', '=', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count(); 

            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট ড্যাশবোর্ড';
            return view('dashboard.admin_em')->with($data);

        } elseif ($roleID == 28) {
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_EM'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('court_id', globalUserInfo()->court_id)->count();
            
            // Drildown Statistics
           
            $crpc_section_list = DB::table('crpc_sections')
                ->select('crpc_sections.id', 'crpc_sections.crpc_id', 'crpc_sections.crpc_name')
                ->get();

            $crpcdata = array();
            
            foreach ($crpc_section_list as $crpc) {
                
                $data['crpcdata'][] = array('name' => $crpc->crpc_id, 'y' => $this->courtwisecrpcstatistics($crpc->id));
            }

            $appeal = EmAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->where('court_id', '=', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->limit(10)->get();
            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['running_case_paginate'] =EmAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->where('court_id', '=', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count(); 
            // View
            $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট পেশকার ড্যাশবোর্ড';
            return view('dashboard.admin_em')->with($data);

        } elseif ($roleID == 36) {

            // Get case status by group
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
                    $appeal_no = DB::table('em_appeal_citizens')
                        ->where('citizen_id', $value->id)
                        ->where('citizen_type_id', 2)
                        ->select('appeal_id')
                        ->get();

                }
            } else {
                $appeal_no = null;
            }

            if (!empty($appeal_no)) {
                foreach ($appeal_no as $key => $value) {
                    if ($value != '') {
                        // return $value;
                        $all_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])->first();
                        if ($all_case) {
                            $totalCase_bibadi++;
                        }
                        $running_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->first();
                        if ($running_case) {
                            $totalRunningCase_bibadi++;
                        }
                        $completed_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['CLOSED'])->first();
                        if ($completed_case) {
                            $totalCompleteCase_bibadi++;
                        }
                    }
                }
            }
            $total_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DM'])->count();
            $running_case_badi = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count();
            $completed_case_badi = EmAppeal::where('created_by', $userID)->where('appeal_status', 'CLOSED')->count();


            $data['total_case'] = $totalCase_bibadi + $total_case_badi;

            $data['running_case'] = $totalRunningCase_bibadi + $running_case_badi;
            $data['completed_case'] = $totalCompleteCase_bibadi + $completed_case_badi;
            // Counter
            // $data['total_case'] = EmAppeal::where('created_by', $userID)->count();
            $data['pending_case'] = EmAppeal::where('created_by', $userID)->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])->count();

            

            $appeal_no = DB::table('em_appeals')
                ->join('em_appeal_citizens', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->select('em_appeals.id as appeal_id')->get();

            $cause_list_ids = [];
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $value) {
                    array_push($cause_list_ids, $value->appeal_id);
                }
            }

            $appeal = EmAppeal::whereIn('id', $cause_list_ids)->limit(10)->get();

            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['running_case_paginate'] = EmAppeal::whereIn('id', $cause_list_ids)->count(); 
            //dd($data['appeal']);
            // return $data;
            $data['page_title'] = 'নাগরিকের ড্যাশবোর্ড';
            return view('dashboard.citizen')->with($data);

        } elseif ($roleID == 37) {
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DM'])->where('district_id', user_district())->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_DM'])->where('district_id', user_district())->count();
           
            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->count();
            
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district())->count();
           

           

            $appeal = EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->limit(10)->get();
            // $data['appeal']  = $appeal;
            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_district())->get();

            $data['running_case_paginate'] =EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count(); 

            $data['page_title'] = 'জেলা ম্যাজিস্ট্রেটের ড্যাশবোর্ড';
            //  return $data;
            return view('dashboard.admin_dm')->with($data);

        } elseif ($roleID == 38) {

            //dd(AppealRepository::getCauselistCitizen(13502));
            // DM dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();

            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();
            

            $data['total_office'] = DB::table('office')->where('is_dm_adm_em', 1)->whereNotIn('id', [1, 2, 7])->where('district_id', user_district())->count();
    
         

            $appeal = EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->limit(10)->get();
            // $data['appeal']  = $appeal;
            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_district())->get();

            $data['running_case_paginate'] =EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count(); 

            $data['page_title'] = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেটের ড্যাশবোর্ড';
            return view('dashboard.admin_dm')->with($data);

        } elseif ($roleID == 39) {
            // DM dashboard

            // Counter
            $data['total_case'] = EmAppeal::whereIn('appeal_status', ['CLOSED', 'ON_TRIAL_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();

            $data['running_case'] = EmAppeal::whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();
            $data['completed_case'] = EmAppeal::where('appeal_status', 'CLOSED')->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();
            $data['pending_case'] = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->count();
            

            $data['upazilas'] = DB::table('upazila')->select('id', 'upazila_name_bn')->where('district_id', user_district())->get();

            $appeal = EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->limit(10)->get();

            if ($appeal != null || $appeal != '') {
                foreach ($appeal as $key => $value) {
                    $citizen_info=AppealRepository::getCauselistCitizen($value->id);
                    $notes=PeshkarNoteRepository::get_last_order_list($value->id);
                    if(isset($citizen_info) && !empty($citizen_info))
                    {
                        $citizen_info=$citizen_info;
                    }
                    else
                    {
                        $citizen_info=null;
                    }
                    if(isset($notes) && !empty($notes))
                    {
                        $notes=$notes;
                    }
                    else
                    {
                        $notes=null;
                    }
                 
                    $data['appeal'][$key]['citizen_info'] = $citizen_info;
                    $data['appeal'][$key]['notes'] =$notes; 
                    // $data["notes"] = $value->appealNotes;
                }
            } else {
              
                $data['appeal'][$key]['citizen_info'] = '';
                $data['appeal'][$key]['notes'] = '';
            }

            $data['running_case_paginate'] =EmAppeal::where('district_id', user_district())->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->count(); 

            // View
            $data['page_title'] = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেটের পেশকারের ড্যাশবোর্ড';
            return view('dashboard.admin_dm')->with($data);

        }
    }

    public function ajaxCrpc(Request $request)
    {
        // dd($request->division);
        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering
        if ($request) {
            if ($roleID == 2) { // Superadmin
                if ($request->division) {
                    $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                    $str = $divisionName . ' বিভাগের ';
                }
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str .= $districtName . ' জেলার ';
                }
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str .= $upazilaName . ' উপজেলা/থানার ';
                   
                }
                
                if($request->division)
                {

                    $str .='তথ্য';
                }

            } elseif ($roleID == 34) { // Divitional Comm.
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str = $districtName . ' জেলার তথ্য';
                }
            } elseif ($roleID == 37) { // DM
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            } elseif ($roleID == 38) { // ADM
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            }

            // Get Statistics
            $result[100] = $this->statistics_case_crpc(1, $data);
            $result[107] = $this->statistics_case_crpc(2, $data);
            $result[108] = $this->statistics_case_crpc(3, $data);
            $result[109] = $this->statistics_case_crpc(4, $data);
            $result[110] = $this->statistics_case_crpc(5, $data);
            $result[144] = $this->statistics_case_crpc(6, $data);
            $result[145] = $this->statistics_case_crpc(7, $data);
        } else {
            if ($roleID == 2) { // Superadmin
                $str = 'সকল বিভাগের তথ্য';
            } elseif ($roleID == 34) { // Divitional Comm.
                $str = 'সকল জেলার তথ্য';
            } elseif ($roleID == 37) { // DM
                $str = 'সকল উপজেলা/থানার তথ্য';
            } elseif ($roleID == 38) { // ADM
                $str = 'সকল উপজেলা/থানার তথ্য';
            }

            $result[100] = $this->statistics_case_crpc(1, '');
            $result[107] = $this->statistics_case_crpc(2, '');
            $result[108] = $this->statistics_case_crpc(3, '');
            $result[109] = $this->statistics_case_crpc(4, '');
            $result[110] = $this->statistics_case_crpc(5, '');
            $result[144] = $this->statistics_case_crpc(6, '');
            $result[145] = $this->statistics_case_crpc(7, '');
        }
        // print_r($result); exit;

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function ajaxCaseStatus(Request $request)
    {
        // dd($request->division);
        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering
        if ($request) {
            if ($roleID == 2) { // Superadmin
                if ($request->division) {
                    $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                    $str = $divisionName . ' বিভাগের ';
                }
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str .= $districtName . ' জেলার ';
                }
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str .= $upazilaName . ' উপজেলা/থানার ';
                   
                }
                
                if($request->division)
                {

                    $str .='তথ্য';
                }

            } elseif ($roleID == 34) { // Divitional Comm.
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str = $districtName . ' জেলার তথ্য';
                }
            } elseif ($roleID == 37) { // DM
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            } elseif ($roleID == 38) { // ADM
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            }

            // Get Statistics
            $result['ON_TRIAL'] = $this->statistics_case_status('ON_TRIAL', $data);
            $result['ON_TRIAL_DM'] = $this->statistics_case_status('ON_TRIAL_DM', $data);
            $result['SEND_TO_EM'] = $this->statistics_case_status('SEND_TO_EM', $data);
            $result['SEND_TO_DM'] = $this->statistics_case_status('SEND_TO_DM', $data);
            $result['CLOSED'] = $this->statistics_case_status('CLOSED', $data);
            $result['REJECTED'] = $this->statistics_case_status('REJECTED', $data);
        } else {
            if ($roleID == 2) { // Superadmin
                $str = 'সকল বিভাগের তথ্য';
            } elseif ($roleID == 34) { // Divitional Comm.
                $str = 'সকল জেলার তথ্য';
            } elseif ($roleID == 37) { // DM
                $str = 'সকল উপজেলা/থানার তথ্য';
            } elseif ($roleID == 38) { // ADM
                $str = 'সকল উপজেলা/থানার তথ্য';
            }

            $result['ON_TRIAL'] = $this->statistics_case_status('ON_TRIAL', '');
            $result['ON_TRIAL_DM'] = $this->statistics_case_status('ON_TRIAL_DM', '');
            $result['SEND_TO_EM'] = $this->statistics_case_status('SEND_TO_EM', '');
            $result['SEND_TO_DM'] = $this->statistics_case_status('SEND_TO_DM', '');
            $result['CLOSED'] = $this->statistics_case_status('CLOSED', '');
            $result['REJECTED'] = $this->statistics_case_status('REJECTED', '');
        }
        // print_r($result); exit;

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function ajaxPieChart(Request $request)
    {
        // dd($request->division);
        // Get Data
        $roleID = Auth::user()->role_id;
        $result = [];
        $str = '';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering
        if ($request) {
            if ($roleID == 2) { // Superadmin
                if ($request->division) {
                    $divisionName = $division = DB::table('division')->select('division_name_bn')->where('id', $request->division)->first()->division_name_bn;
                    $str = $divisionName . ' বিভাগের তথ্য';
                }
            } elseif ($roleID == 34) { // Divitional Comm.
                if ($request->district) {
                    $districtName = DB::table('district')->select('district_name_bn')->where('id', $request->district)->first()->district_name_bn;
                    $str = $districtName . ' জেলার তথ্য';
                }
            } elseif ($roleID == 37) { // DM
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            } elseif ($roleID == 38) { // ADM
                if ($request->upazila) {
                    $upazilaName = DB::table('upazila')->select('upazila_name_bn')->where('id', $request->upazila)->first()->upazila_name_bn;
                    $str = $upazilaName . ' উপজেলা/থানার তথ্য';
                }
            }

            // Get Statistics
            $result[100] = $this->statistics_case_crpc(1, $data);
            $result[107] = $this->statistics_case_crpc(2, $data);
            $result[108] = $this->statistics_case_crpc(3, $data);
            $result[109] = $this->statistics_case_crpc(4, $data);
            $result[110] = $this->statistics_case_crpc(5, $data);
            $result[144] = $this->statistics_case_crpc(6, $data);
            $result[145] = $this->statistics_case_crpc(7, $data);
        } else {
            if ($roleID == 2) { // Superadmin
                $str = 'সকল বিভাগের তথ্য';
            } elseif ($roleID == 34) { // Divitional Comm.
                $str = 'সকল জেলার তথ্য';
            } elseif ($roleID == 37) { // DM
                $str = 'সকল উপজেলা/থানার তথ্য';
            } elseif ($roleID == 38) { // ADM
                $str = 'সকল উপজেলা/থানার তথ্য';
            }

            $result[100] = $this->statistics_case_crpc(1, '');
            $result[107] = $this->statistics_case_crpc(2, '');
            $result[108] = $this->statistics_case_crpc(3, '');
            $result[109] = $this->statistics_case_crpc(4, '');
            $result[110] = $this->statistics_case_crpc(5, '');
            $result[144] = $this->statistics_case_crpc(6, '');
            $result[145] = $this->statistics_case_crpc(7, '');
        }
        // print_r($result); exit;

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function ajaxCaseStatistics(Request $request)
    {
        // dd($request->division);
        // Get Data
        $result = [];
        $str = 'সকল বিভাগের তথ্য';
        $data['division'] = $request->division;
        $data['district'] = $request->district;
        $data['upazila'] = $request->upazila;
        // Convert DB date formate
        $data['dateFrom'] = isset($request->dateFrom) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateFrom))) : null;
        $data['dateTo'] = isset($request->dateTo) ? date('Y-m-d', strtotime(str_replace('/', '-', $request->dateTo))) : null;

        // Data filtering
        /*if($request){
        if($request->division){
        $divisionName = $division =  DB::table('division')->select('division_name_bn')->where('id',$request->division)->first()->division_name_bn;
        $str = $divisionName.' বিভাগের তথ্য';
        }

        // Get Statistics
        $result[1] = $this->statistics_case_area(1, $data);
        $result[2] = $this->statistics_case_area(2, $data);
        $result[3] = $this->statistics_case_area(3, $data);
        $result[4] = $this->statistics_case_area(4, $data);
        $result[5] = $this->statistics_case_area(5, $data);
        $result[6] = $this->statistics_case_area(6, $data);
        $result[7] = $this->statistics_case_area(7, $data);
        $result[8] = $this->statistics_case_area(8, $data);
        }else{*/
        $str = 'সকল বিভাগের তথ্য';
        $result = $this->statistics_case_area();
        /*$result = [
        ['Opening Move', 'মামলা'],
        ["বরিশাল", 21],
        ["চট্টগ্রাম", 44],
        ["ঢাকা", 65],
        ["খুলনা", 5],
        ["রাজশাহী", 55],
        ['রংপুর', 3],
        ["সিলেট", 44],
        ["ময়মনসিংহ", 76],
        ];*/
        // }
        // print_r($result); exit;

        return response()->json(['msg' => $str, 'data' => $result]);
    }

    public function statistics_case_crpc($law_section, $data = null)
    {
        $query = DB::table('em_appeals')->where('law_section', $law_section);
        if ($data['division']) {
            $query->where('division_id', '=', $data['division']);
        }
        if ($data['district']) {
            $query->where('district_id', '=', $data['district']);
        }
        if ($data['upazila']) {
            $query->where('upazila_id', '=', $data['upazila']);
        }
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            $query->whereBetween('case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->count();
    }

    public function statistics_case_status($status, $data = null)
    {
        $query = DB::table('em_appeals')->where('appeal_status', $status);

        if ($data['division']) {
            $query->where('division_id', '=', $data['division']);
        }
        if ($data['district']) {
            $query->where('district_id', '=', $data['district']);
        }
        if ($data['upazila']) {
            $query->where('upazila_id', '=', $data['upazila']);
        }
        if ($data['dateFrom'] != null && $data['dateTo'] != null) {
            $query->whereBetween('case_date', [$data['dateFrom'], $data['dateTo']]);
        }

        return $query->count();
        // return $query;
    }

    public function statistics_case_area()
    {
        $division_list = DB::table('division')->select('division.id', 'division.division_name_bn', 'division.division_name_en')->get();

        $data = array();

        // Division List
        foreach ($division_list as $division) {
            // $data_arr[$item->id] = $this->get_drildown_case_count($item->id);
            // Division Data
            $data[$division->division_name_bn] = $this->get_drildown_case_count($division->id);
        }
        /*$data = [
        ['Opening Move', 'মামলা'],
        ["বরিশাল", 21],
        ["চট্টগ্রাম", 44],
        ["ঢাকা", 65],
        ["খুলনা", 5],
        ["রাজশাহী", 55],
        ['রংপুর', 3],
        ["সিলেট", 44],
        ["ময়মনসিংহ", 76],
        ];*/
        // }

        return $data;

        /*$query = DB::table('em_appeals');

    if ($divisionID) {
    $query->where('division_id', '=', $divisionID);
    }else{

    }
    // if ($data['district']) {
    //    $query->where('district_id', '=', $data['district']);
    // }
    // if ($data['upazila']) {
    //    $query->where('upazila_id', '=', $data['upazila']);
    // }

    return $query->count();*/
    }

    public function testReport(Request $request)
    {
        //  $request->validate([
        //   'division'      => 'required'
        // ]);

        // $data = $request->all();
        #create or update your data here

        return response()->json(['success' => 'Ajax request submitted successfully']);
    }

    public function hearing_date_today()
    {

        // dd($data['hearing']);

        $data['page_title'] = 'আজকের দিনে শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_date_tomorrow()
    {

        // dd($data['hearing']);

        $data['page_title'] = 'আগামী দিনে শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_date_nextWeek()
    {

        // dd($data['hearing']);

        $data['page_title'] = 'আগামী সপ্তাহের শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_date_nextMonth()
    {
        $d = date('Y-m-d', strtotime('+1 month'));
        /* $m = date('m',strtotime($d));
        dd($d);*/

        // dd($data['hearing']);

        $data['page_title'] = 'আগামী মাসের শুনানী/মামলার তারিখ';
        return view('dashboard.hearing_date')->with($data);
    }

    public function hearing_case_details($id)
    {

        // Dropdown
        $data['roles'] = DB::table('role')
            ->select('id', 'role_name')
            ->where('in_action', '=', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        // dd($data['bibadis']);

        $data['page_title'] = 'শুনানী মামলার বিস্তারিত তথ্য';
        return view('dashboard.hearing_case_details')->with($data);
    }

    public function get_drildown_crpc_case_count($crpcID)
    {
        $query = DB::table('em_appeals')->where('law_section', $crpcID)->whereNotIn('appeal_status', ['DRAFT']);

        return $query->count();
    }

    public function get_drildown_case_count($division = null, $district = null, $upazila = null, $status = null)
    {
        $query = DB::table('em_appeals')->whereNotIn('appeal_status', ['DRAFT']);

        if ($division != null) {
            $query->where('division_id', $division);
        }
        if ($district != null) {
            $query->where('district_id', $district);
        }
        if ($upazila != null) {
            $query->where('upazila_id', $upazila);
        }

        return $query->count();
    }

    public function get_mouja_by_ulo_office_id($officeID)
    {
        return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
        // return DB::table('mouja_ulo')->select('mouja_id')->where('ulo_office_id', $officeID)->get();
        // return DB::table('division')->select('id', 'division_name_bn')->get();
    }

    public function courtwisecrpcstatistics($crpcID)
    {
        $query = DB::table('em_appeals')->where('law_section', $crpcID)->where('court_id', globalUserInfo()->court_id)->whereNotIn('appeal_status', ['DRAFT']);

        return $query->count();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CaseRegister  $caseRegister
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$validator = \Validator::make($request->all(), [
    'group' => 'required',
    'comment' => 'required',
    ]);

    if ($validator->fails())
    {
    return response()->json(['errors'=>$validator->errors()->all()]);
    }

    // User Info
    $user = Auth::user();

    // Inputs
    $roleGroup = $request->group;
    $caseID = $request->case_id;
    $input = $request->all();

    // Roles
    if($roleGroup == 1){
    // Superadmin
    $caseStatus = '';
    }elseif($roleGroup == 5){
    // DC Assistant
    $caseStatus = '';
    }elseif($roleGroup == 6){
    // DC
    $caseStatus = 2;
    }elseif($roleGroup == 7){
    // ADC (Revenue)
    $caseStatus = 3;
    }elseif($roleGroup == 8){
    // AC (RM)
    $caseStatus = 4;
    }elseif($roleGroup == 9){
    // AC (Land)
    $caseStatus = 5;
    }elseif($roleGroup == 10){
    // Survyor
    $caseStatus = 6;
    }elseif($roleGroup == 11){
    // Kanongo
    $caseStatus = 7;
    }elseif($roleGroup == 12){
    // ULAO
    $caseStatus = 8;
    }elseif($roleGroup == 13){
    // GP
    $caseStatus = 9;
    }elseif($roleGroup == 14){
    // ULAO
    $caseStatus = 10;
    }

    // Get Case Data
     */
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    /*public function edit_sf(Request $request)
    {
    $validator = \Validator::make($request->all(), [
    'sf_details' => 'required',
    ]);

    if ($validator->fails())
    {
    return response()->json(['errors'=>$validator->errors()->all()]);
    }

    // Inputs
    $caseID = $request->case_id;
    $sfID = $request->sf_id;
    $sfDetails = $request->sf_details;
    // $input = $request->all();
    // dd($input);

    // Update Case SF table
    $sf_data = [
    'sf_details'  => $sfDetails,
    'updated_at'  => date('Y-m-d H:i:s'),
    ];
    DB::table('case_sf')->where('id', $sfID)->update($sf_data);

    return response()->json(['success'=>'Data is successfully updated','sfdata'=> 'SF Details']);
    }*/

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }

    public function logincheck()
    {
        // return 1;
        if (Auth::check()) {
            // dd('checked');
            return redirect('dashboard');
        } else {
            return redirect('/');
        }
    }
    public function public_home()
    {
        if (Auth::check()) {
            // dd('checked');
            return redirect('dashboard');
        } else {
            return view('public_home');
            //  return redirect('login');
        }
    }
}
