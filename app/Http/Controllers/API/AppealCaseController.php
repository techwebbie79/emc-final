<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Appeal;
// use Validator;
use App\Models\EmAppeal;
use App\Repositories\AppealCitizenRepository;
use App\Repositories\CitizenRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// use Validator;

class AppealCaseController extends BaseController
{
    public function test()
    {
        $data[] = "Test";
        return $this->sendResponse($data, 'test successfully.');
    }

    // use AuthenticatesUsers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //appeal execute api
    public function court_execute(Request $request)
    {
        $roleID = $request->role_id;
        $status = $request->status;
        $court_id = $request->court_id;
        $division_id = $request->division_id;
        $userID = $request->user_id;
        $district_id = $request->district_id;
        $offset = 0;
        $limit = 5;
        if (($request->page != 1) && ($request->page != 0)) {
            $offset = ($request->page - 1) * $limit;
        }
        $data = array();

        if ($roleID == 2) {
            // get supper admin data
            if (isset($status)) {
                $appeal = EmAppeal::where('appeal_status', $status)
                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                    ->leftjoin('role', 'users.role_id', '=', 'role.id');
            } else {
                $appeal = EmAppeal::whereNotIn('appeal_status', ['DRAFT', 'SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'ON_TRIAL_DM', 'SEND_TO_DM', 'SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_NBR_CM'])
                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                    ->leftjoin('role', 'users.role_id', '=', 'role.id');
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Super admin Data.');
        } elseif ($roleID == 7) {
             
            if (isset($status)) {
               
                    $appeal = EmAppeal::where('appeal_status', $status)->where('district_id', $district_id)
                             ->where('district_id', user_district())
                             ->where('assigned_adc_id', $userID)
                             ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                             ->leftjoin('role', 'users.role_id', '=', 'role.id');
                
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'ADC Data.');


        } elseif ($roleID == 20) {
            if (isset($status)) {
                if ($status == 'ON_TRIAL') {
                    $badi_case = EmAppeal::orderby('id', 'desc')
                        ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                        ->where('created_by', globalUserInfo()->id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id')
                        ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
                    //=====for Bibadi Case============//
                    $citizen_id = DB::table('em_citizens')
                        ->where('citizen_NID', globalUserInfo()->citizen_nid)
                        ->select('id')
                        ->get();
                    if ($citizen_id != '') {
                        foreach ($citizen_id as $key => $value) {
                            // return $value;
                            $appeal_no = DB::table('em_appeal_citizens')
                                ->where('citizen_id', $value->id)
                                ->whereIN('citizen_type_id', [2, 4])
                                ->select('appeal_id')
                                ->get();
                        }
                    } else {
                        $appeal_no = '';
                    }
                    if (!empty($appeal_no)) {
                        foreach ($appeal_no as $key => $value) {
                            if ($value != '') {
                                $bibadi_case = EmAppeal::where('em_appeals.id', $value->appeal_id)
                                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                                    ->leftjoin('role', 'users.role_id', '=', 'role.id')
                                    ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->first();
                                if (!empty($bibadi_case)) {
                                    if ($bibadi_case != '') {
                                        $badi_case->push((object) $bibadi_case);
                                    }
                                }
                            }
                        }
                    }
                    // dd($badi_case);
                    $appeal = $badi_case;
                } elseif ($status == 'SEND_TO_ASST_EM') {
                    $badi_case = EmAppeal::orderby('id', 'desc')
                        ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'SEND_TO_DM', 'SEND_TO_EM'])
                        ->where('created_by', globalUserInfo()->id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id')
                        ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
                    //=====for Bibadi Case============//

                    $appeal = $badi_case;
                } else {
                    $badi_case = EmAppeal::orderby('id', 'desc')
                        ->where('appeal_status', $status)
                        ->where('created_by', globalUserInfo()->id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id')
                        ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
                    //=====for Bibadi Case============//
                    $citizen_id = DB::table('em_citizens')
                        ->where('citizen_NID', globalUserInfo()->citizen_nid)
                        ->select('id')
                        ->get();
                    if ($citizen_id != '') {
                        foreach ($citizen_id as $key => $value) {
                            // return $value;
                            $appeal_no = DB::table('em_appeal_citizens')
                                ->where('citizen_id', $value->id)
                                ->whereIN('citizen_type_id', [2, 4])
                                ->select('appeal_id')
                                ->get();
                        }
                    } else {
                        $appeal_no = '';
                    }
                    if (!empty($appeal_no)) {
                        foreach ($appeal_no as $key => $value) {
                            if ($value != '') {
                                $bibadi_case = EmAppeal::where('em_appeals.id', $value->appeal_id)
                                    ->where('appeal_status', $status)
                                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                                    ->leftjoin('role', 'users.role_id', '=', 'role.id')
                                    ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->first();
                                if (!empty($bibadi_case)) {
                                    if ($bibadi_case != '') {
                                        $badi_case->push((object) $bibadi_case);
                                    }
                                }
                            }
                        }
                    }
                    $appeal = $badi_case;
                }
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }
            //var_dump($appeal->count());
            //exit();
            $data['appeal'] = $appeal;

            //=================Citizen case count==================//
            $appeal_count = $appeal->count();
            // dd($appeal_count);
            $data['total'] = $appeal_count;

            return $this->sendResponse($data, 'Advocate Data.');

        } elseif ($roleID == 27) {
            if (isset($status)) {
                if ($status == 'SEND_TO_EM') {
                    $appeal = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM'])->where('em_appeals.court_id', $court_id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id');
                } else {
                    $appeal = EmAppeal::where('appeal_status', $status)->where('em_appeals.court_id', $court_id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id');
                }
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
        

            return $this->sendResponse($data, 'EM Data.');

        } elseif ($roleID == 28) {

            if (isset($status)) {
                $appeal = EmAppeal::where('appeal_status', $status)->where('em_appeals.court_id', $court_id)
                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                    ->leftjoin('role', 'users.role_id', '=', 'role.id');
            }
            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }
            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Asst Em Data.');

        } elseif ($roleID == 36) {
            // get user data
            //=================Citizen==================//
            if (isset($status)) {
                if ($status == 'ON_TRIAL') {
                    $badi_case = EmAppeal::orderby('id', 'desc')
                        ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                        ->where('created_by', globalUserInfo()->id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id')
                        ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
                    //=====for Bibadi Case============//
                    $citizen_id = DB::table('em_citizens')
                        ->where('citizen_NID', globalUserInfo()->citizen_nid)
                        ->select('id')
                        ->get();
                    if ($citizen_id != '') {
                        foreach ($citizen_id as $key => $value) {
                            // return $value;
                            $appeal_no = DB::table('em_appeal_citizens')
                                ->where('citizen_id', $value->id)
                                ->where('citizen_type_id', 2)
                                ->select('appeal_id')
                                ->get();
                        }
                    } else {
                        $appeal_no = '';
                    }
                    if (!empty($appeal_no)) {
                        foreach ($appeal_no as $key => $value) {
                            if ($value != '') {
                                $bibadi_case = EmAppeal::where('em_appeals.id', $value->appeal_id)
                                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                                    ->leftjoin('role', 'users.role_id', '=', 'role.id')
                                    ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->first();
                                if (!empty($bibadi_case)) {
                                    if ($bibadi_case != '') {
                                        $badi_case->push((object) $bibadi_case);
                                    }
                                }
                            }
                        }
                    }
                    // dd($badi_case);
                    $appeal = $badi_case;
                } elseif ($status == 'SEND_TO_ASST_EM') {
                    $badi_case = EmAppeal::orderby('id', 'desc')
                        ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'SEND_TO_DM', 'SEND_TO_EM'])
                        ->where('created_by', globalUserInfo()->id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id')
                        ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
                    //=====for Bibadi Case============//

                    $appeal = $badi_case;
                } else {
                    $badi_case = EmAppeal::orderby('id', 'desc')
                        ->where('appeal_status', $status)
                        ->where('created_by', globalUserInfo()->id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id')
                        ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();
                    //=====for Bibadi Case============//
                    $citizen_id = DB::table('em_citizens')
                        ->where('citizen_NID', globalUserInfo()->citizen_nid)
                        ->select('id')
                        ->get();
                    if ($citizen_id != '') {
                        foreach ($citizen_id as $key => $value) {
                            // return $value;
                            $appeal_no = DB::table('em_appeal_citizens')
                                ->where('citizen_id', $value->id)
                                ->where('citizen_type_id', 2)
                                ->select('appeal_id')
                                ->get();
                        }
                    } else {
                        $appeal_no = '';
                    }
                    if (!empty($appeal_no)) {
                        foreach ($appeal_no as $key => $value) {
                            if ($value != '') {
                                $bibadi_case = EmAppeal::where('em_appeals.id', $value->appeal_id)
                                    ->where('appeal_status', $status)
                                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                                    ->leftjoin('role', 'users.role_id', '=', 'role.id')
                                    ->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->first();
                                if (!empty($bibadi_case)) {
                                    if ($bibadi_case != '') {
                                        $badi_case->push((object) $bibadi_case);
                                    }
                                }
                            }
                        }
                    }
                    $appeal = $badi_case;
                }
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }
            //var_dump($appeal->count());
            //exit();
            $data['appeal'] = $appeal;

            //=================Citizen case count==================//
            $appeal_count = $appeal->count();
            // dd($appeal_count);
            $data['total'] = $appeal_count;

            return $this->sendResponse($data, 'User Data.');
        } elseif ($roleID == 37) {
            // get adm or dm data
            if (isset($status)) {
                if ($status == 'SEND_TO_DM') {
                    $appeal = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_DM', 'SEND_TO_DM'])->where('district_id', $district_id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id');
                } else {
                    $appeal = EmAppeal::where('appeal_status', $status)->where('district_id', $district_id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id');
                }
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Dm Data.');
        } elseif ($roleID == 38) {
            if (isset($status)) {
                if ($status == 'SEND_TO_DM') {
                    $appeal = EmAppeal::whereIn('appeal_status', ['SEND_TO_ASST_DM', 'SEND_TO_DM'])->where('district_id', $district_id)
                        ->where('court_id', globalUserInfo()->court_id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id');
                } else {
                    $appeal = EmAppeal::where('appeal_status', $status)->where('district_id', $district_id)
                        ->where('court_id', globalUserInfo()->court_id)
                        ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                        ->leftjoin('role', 'users.role_id', '=', 'role.id');
                }
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }

            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'ADM Data.');
        } elseif ($roleID == 39) {

            if (isset($status)) {
                $appeal = EmAppeal::where('appeal_status', $status)->where('district_id', $district_id)
                    ->where('court_id', globalUserInfo()->court_id)
                    ->leftjoin('users', 'em_appeals.created_by', '=', 'users.id')
                    ->leftjoin('role', 'users.role_id', '=', 'role.id');
            }

            if (!empty($request->date_start) && !empty($request->date_end)) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
                $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
            }
            if (!empty($request->case_no)) {
                $case_no = bn2en($request->case_no);
                $appeal->where('case_no', '=', $case_no);
            }

            $data['total'] = $appeal->count();
            $data['appeal'] = $appeal->select('em_appeals.id', 'em_appeals.appeal_status', 'em_appeals.case_no', 'em_appeals.case_date', 'em_appeals.next_date', 'em_appeals.office_id', 'em_appeals.office_name', 'em_appeals.district_id', 'em_appeals.district_name', 'em_appeals.division_id', 'em_appeals.division_name', 'em_appeals.law_section', 'em_appeals.loan_amount_text', 'em_appeals.loan_amount', 'em_appeals.peshkar_office_id', 'em_appeals.peshkar_name', 'em_appeals.peshkar_email', 'em_appeals.gco_name', 'em_appeals.gco_office_id', 'em_appeals.court_id', 'em_appeals.created_at', 'em_appeals.is_hearing_host_active', 'role.role_name as role_name', 'users.name as applicant_name', 'em_appeals.created_by as applicant_id')->offset($offset)->limit($limit)->get();

            return $this->sendResponse($data, 'Asst. dm Data.');
        }
    }

    // appeal case details api
    public function appealCaseDetails(Request $request)
    {
        $data = array();
        $data['appeal'] = $this->getCaseAppealInfo($request->appeal_id);
        if (date('a', strtotime($data['appeal']->created_at)) == 'pm') {
            $time = 'বিকাল';
        } else {
            $time = 'সকাল';
        };
        $division = $data['appeal']->division_name ?? '-';
        $district = $data['appeal']->district_name ?? '-';
        $upazila = $data['appeal']->upazila_name ?? '-';

        $placeTime = 'বিগত ইং' . en2bn($data['appeal']->case_date) . 'তারিখ মোতাবেক বাংলা' . BnSal($data['appeal']->case_date, 'Asia/Dhaka', 'j F Y') . '। সময়: ' . $time . ' ' . en2bn(date('h:i:s', strtotime($data['appeal']->created_at))) . '।' . $division . ' বিভাগের ' . $district . ' জেলার ' . $upazila . ' থানা/উপজেলায়।';
        $data['placeTime'] = $placeTime;
        $data['applicantCitizen'] = [];
        $data['defaulterCitizen'] = [];
        $data['guarantorCitizen'] = [];
        $data['lawerCitizen'] = [];
        $data['witnessCitizen'] = [];
        $data['victimCitizen'] = [];
        $citizen_types = $this->getCitizenTypes($request->appeal_id);

        foreach ($citizen_types as $row) {
            if ($row->citizen_type_id == 1) {
                $data['applicantCitizen'] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 2) {
                $data['defaulterCitizen'][] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 3) {
                $data['guarantorCitizen'] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 4) {
                $data['lawerCitizen'] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 5) {
                $data['witnessCitizen'][] = $this->getCitizenInfo($row->citizen_id);
            }
            if ($row->citizen_type_id == 8) {
                $data['victimCitizen'] = $this->getCitizenInfo($row->citizen_id);
            }

        }

        return $this->sendResponse($data, 'Appeal Case Details Data.');
    }

    public function checkHearingHostStatus($id)
    {
        $appeal = DB::table('em_appeals as em')->where('em.id', '=', $id)
            ->select('em.is_hearing_host_active', 'em.next_date_trial_time', 'em.next_date', 'em.hearing_key')
            ->first();
        return $this->sendResponse($appeal, 'Appeal Case Hearing Host Active Check Data.');
    }

    public function hearingHostActiveStatusUpdate($id)
    {
        // dd($id);
        $appeal = DB::table('em_appeals')->where('id', '=', $id)->update(
            [
                'is_hearing_host_active' => 1,
            ]
        );
        return $this->sendResponse($appeal, 'Appeal Case Hearing Host Active Status Updated.');
    }

    public function getCitizenInfo($id)
    {
        $citizenInfo = DB::table('em_citizens')->where('em_citizens.id', '=', $id)
            ->select(
                'em_citizens.id as citizen_id',
                'em_citizens.citizen_name',
                'em_citizens.father',
                'em_citizens.mother',
                'em_citizens.citizen_gender',
                'em_citizens.designation',
                'em_citizens.present_address',
                'em_citizens.citizen_NID',
                'em_citizens.email',
            )->first();

        return $citizenInfo;
    }

    public function getCitizenTypes($appeal_id)
    {
        $appeal = DB::table('em_appeal_citizens as em')->where('em.appeal_id', '=', $appeal_id)
            ->select(
                'em.appeal_id as appeal_id',
                'em.citizen_id',
                'em.citizen_type_id',
            )->get();

        return $appeal;
    }

    public function getCaseAppealInfo($appealId)
    {
        // dd($appealId);
        $appeal = DB::table('em_appeals as em')->where('em.id', '=', $appealId)
            ->leftjoin('users', 'em.created_by', '=', 'users.id')
            ->leftjoin('role', 'users.role_id', '=', 'role.id')
            ->leftjoin('division', 'em.division_id', '=', 'division.id')
            ->leftjoin('district', 'em.district_id', '=', 'district.id')
            ->leftjoin('upazila', 'em.upazila_id', '=', 'upazila.id')
            ->select(
                'em.id as appeal_id',
                'em.case_no',
                'em.case_date',
                'em.appeal_status',
                'em.next_date_trial_time',
                'em.next_date',
                'em.created_at',
                'em.case_details',
                'em.hearing_key',
                'em.zoom_join_meeting_id',
                'em.zoom_join_meeting_password',
                'em.is_hearing_host_active',
                'users.id as created_user_id',
                'users.name as created_by',
                'users.role_id as role_id',
                'role.role_name as role_name',
                'division.division_name_bn as division_name',
                'district.district_name_bn as district_name',
                'upazila.upazila_name_bn as upazila_name',
            )->first();
        // dd($appeal);
        return $appeal;
    }

    //  appeal tracking api
    public function appealCaseTracking($id)
    {
        $data = array();
        $data['appeal'] = $this->getCaseAppealInfo($id);
        
         $em_notes=DB::table('em_notes')->where('appeal_id',$id)->get();
         $CaseTracking=[];
         
         foreach($em_notes as $em_note_single)
         {
            $CaseTracking_single=[];
            $CaseTracking_single['trial_date']=explode(' ',$em_note_single->created_date)[0];
            $CaseTracking_single['template_name']=$this->get_template_name_by_id($em_note_single->case_short_decision_id);

            array_push($CaseTracking,$CaseTracking_single);
         }
         
         
        $data['CaseTracking'] =$CaseTracking;

        return $this->sendResponse($data, 'Appeal Case Tracking Data.');
    }
    
    public function get_template_name_by_id($case_short_decision_id)
    {
         $short_order_template_name= DB::table('em_case_shortdecisions')->where('id',$case_short_decision_id)->first();

         return $short_order_template_name->case_short_decision;

    } 




    // this section appeal create api section
    public function getUser($id)
    {
        return DB::table('users')->where('users.id', '=', $id)
            ->leftjoin('role', 'users.role_id', '=', 'role.id')
            ->select('users.id', 'users.office_id', 'users.role_id', 'role.role_name')->first();
    }

    public function store(Request $request)
    {
        // dd($_FILES['file_name']['name']);
        // return $user_id = $request->$user_id;
        // return $user = $this->getUser($request->user_id);

        $data = array();
        try {
            $appealId = $this->storeAppeal($request);
            $this->storeCitizen($request, $appealId);

            /* if ($request->file_type && $_FILES['file_name']['name']) {
            $log_file_data = AttachmentRepository::storeAttachment('APPEAL', $appealId, 1, $request->file_type);
            } else {
            $log_file_data = null;
            }
            LogManagementRepository::citizen_appeal_store($request,$appealId,$log_file_data); */

            return $this->sendResponse($data, 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে.');
        } catch (\Exception $e) {
            // dd($e);
            $error['error'] = 'দুঃখিত! তথ্য সংরক্ষণ করা হয়নি.';
            return $this->sendError($e, $error);
        }
        return $this->sendResponse($data, 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে.');
    }

    public function storeCitizen($request, $appealId)
    {
        $user = $this->getUser($request->user_id);
        if (isset($request->lawyer)) {
            $citizenList['lawyer'] = $request->lawyer;
        }

        if ($request->caseEntryType == 'others') {
            $citizenList['applicants'] = $request->applicant;
        }

        if ($request->lawSection == 1) {
            $citizenList['victim'] = $request->victim;
        }

        $multiCtz['defaulter'] = $request->defaulter;
        $multiCtz['witness'] = $request->witness;
        $transactionStatus = true;
        $storeId = [];

        // $this->storeCtg($appealId, $reqCitizen);

        $i = 1;
        foreach ($citizenList as $reqCitizen) {
            $citizen = storeCtg($appealId, $reqCitizen);
            if ($citizen->save()) {
                $storeId[$i] = $citizen;
                $i++;
                $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $reqCitizen['type']);
                if (!$transactionStatus) {
                    $transactionStatus = false;
                    break;
                }
            } else {
                $transactionStatus = false;
                break;
            }
            if ($transactionStatus == false) {
                break;
            }

        }

        if ($request->caseEntryType == 'own') {
            if ($user->citizen_id != null) {
                $userCtgId = $user->citizen_id;
            } else {
                $AuthCtg = new EmCitizen();
                $AuthCtg->citizen_name = $user->name;
                $AuthCtg->citizen_phone_no = $user->mobile_no;
                // $AuthCtg->citizen_NID = $user->nid;
                // $AuthCtg->citizen_gender = $user->gender;
                // $AuthCtg->father = $user->father;
                // $AuthCtg->mother = $user->mother;
                // $AuthCtg->designation = $user->designation;
                // $AuthCtg->organization = $user->organization;
                // $AuthCtg->present_address = $user->presentAddress;
                $AuthCtg->email = $user->email;
                // $AuthCtg->thana = $user->thana;
                // $AuthCtg->upazilla = $user->upazilla;
                // $AuthCtg->age = $user->age;
                $AuthCtg->created_at = date('Y-m-d H:i:s');
                $AuthCtg->updated_at = date('Y-m-d H:i:s');
                $AuthCtg->created_by = $user->id;
                $AuthCtg->updated_by = $user->id;
                $AuthCtg->save();
                $userCtgId = $AuthCtg->id;
            }

            $transactionStatus = AppealCitizenRepository::storeAppealCitizen($userCtgId, $appealId, 1);
            if (!$transactionStatus) {
                $transactionStatus = false;
            }
        }

        // return $multiCtz;
        foreach ($multiCtz as $nominees) {
            for ($i = 0; $i < sizeof($nominees['name']); $i++) {
                $citizen = CitizenRepository::checkCitizenExist($nominees['id'][$i]);
                // return $multiCtz;
                // $citizen = new EmCitizen();

                $citizen->citizen_name = isset($nominees['name'][$i]) ? $nominees['name'][$i] : null;
                $citizen->citizen_phone_no = isset($nominees['phn'][$i]) ? $nominees['phn'][$i] : null;
                $citizen->citizen_NID = isset($nominees['nid'][$i]) ? $nominees['nid'][$i] : null;
                $citizen->citizen_gender = isset($nominees['gender'][$i]) ? $nominees['gender'][$i] : null;
                $citizen->father = isset($nominees['father'][$i]) ? $nominees['father'][$i] : null;
                $citizen->mother = isset($nominees['mother'][$i]) ? $nominees['mother'][$i] : null;
                // $citizen->designation = isset($nominees['designation'][$i]);
                // $citizen->organization = isset($nominees['organization'][$i]);
                $citizen->present_address = isset($nominees['presentAddress'][$i]) ? $nominees['presentAddress'][$i] : null;
                $citizen->email = isset($nominees['email'][$i]) ? $nominees['email'][$i] : null;
                $citizen->thana = isset($nominees['thana'][$i]) ? $nominees['thana'][$i] : null;
                $citizen->upazilla = isset($nominees['upazilla'][$i]) ? $nominees['upazilla'][$i] : null;
                $citizen->age = isset($nominees['age'][$i]) ? $nominees['age'][$i] : null;

                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by = $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;

                // dd($citizen);
                if ($citizen->save()) {
                    $storeId[$i . '1'] = $citizen;
                    $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $nominees['type'][$i]);
                    if (!$transactionStatus) {
                        $transactionStatus = false;
                        break;
                    }
                } else {
                    $transactionStatus = false;
                    break;
                }

                if ($transactionStatus == false) {
                    break;
                }

            }
        }

        return $transactionStatus;
    }

    public function storeCtg($appealId, $reqCitizen)
    {
        $user = globalUserInfo();
        $citizen = CitizenRepository::checkCitizenExist($reqCitizen['id']);
        // dd($reqCitizen['type']);
        $citizen->citizen_name = $reqCitizen['name'];
        $citizen->citizen_phone_no = $reqCitizen['phn'];
        $citizen->citizen_NID = $reqCitizen['nid'];
        $citizen->citizen_gender = isset($reqCitizen['gender']) ? $reqCitizen['gender'] : null;
        $citizen->father = $reqCitizen['father'];
        $citizen->mother = $reqCitizen['mother'];
        // $citizen->designation = $reqCitizen['designation'];
        // $citizen->organization = $reqCitizen['organization'];
        $citizen->present_address = $reqCitizen['presentAddress'];
        $citizen->email = $reqCitizen['email'];
        $citizen->thana = $reqCitizen['thana'];
        $citizen->upazilla = $reqCitizen['upazilla'];
        $citizen->age = $reqCitizen['age'];
        $citizen->created_at = date('Y-m-d H:i:s');
        $citizen->updated_at = date('Y-m-d H:i:s');
        $citizen->created_by = $user->id;
        $citizen->updated_by = $user->id;
        return $citizen;
    }

    public function storeAppeal($request)
    {
        if ($request->status == 'SEND_TO_ASST_EM') {
            $em_court_id = DB::table('case_mapping')->select('court_id')->where('district_id', $request->district)->where('upazilla_id', $request->upazila)->where('status', 1)->first();
            // dd($em_court_id->court_id);
        } elseif ($request->status == 'SEND_TO_ASST_DM') {
            $em_court_id = DB::table('court')->select('id')->where('district_id', $request->district)->where('status', 1)->where('level', 1)->first();
            // dd($em_court_id->id);
        }

        $user = $this->getUser($request->user_id);
        $caseDate = bn2en($request->caseDate);
        $appeal = self::checkAppealExist($request->appealId);
        try {

            $appeal->case_entry_type = $request->caseEntryType;
            $appeal->is_own_case = $request->is_own_case;
            $appeal->case_date = date('Y-m-d', strtotime(str_replace('/', '-', $caseDate)));
            $appeal->law_section = $request->lawSection;
            $appeal->division_id = $request->division;
            $appeal->district_id = $request->district;
            $appeal->upazila_id = $request->upazila;
            $appeal->case_details = $request->case_details;
            $appeal->initial_note = $request->note;
            $appeal->case_no = "অসম্পূর্ণ মামলা";

            if ($request->appealEntryType == 'edit') {
                $appeal->peshkar_comment = $request->peshkar_comment;
            }
            if ($request->status == 'SEND_TO_ASST_EM') {
                $appeal->court_id = $em_court_id->court_id;
            }
            if ($request->status == 'SEND_TO_ASST_DM') {
                $appeal->court_id = $em_court_id->id;
            }
            $appeal->appeal_status = $request->status;
            $appeal->applicant_type = $request->applicant['type'];
            $appeal->flag_on_trial = 0;

            if ($request->appealEntryType == 'create') {
                $appeal->created_by = $user->id;
            } else {
                $appeal->updated_by = $user->id;
            }
            $appeal->updated_by = $user->id;
            $appeal->office_id = $user->office_id;
            $appeal->office_unit_id = $user->role_id;
            $appeal->office_unit_name = $user->role_name;
            $appeal->created_at = date('Y-m-d H:i:s');
            $appeal->updated_at = date('Y-m-d H:i:s');

            $appeal->save();
            $appealId = $appeal->id;
        } catch (\Exception $e) {
            $appealId = null;
        }
        return $appealId;
    }

    public static function checkAppealExist($appealId)
    {
        if (isset($appealId)) {
            $appeal = EmAppeal::find($appealId);
        } else {
            $appeal = new EmAppeal();
        }
        return $appeal;
    }

}
