<?php

function index(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {

            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL'])->where('court_id', globalUserInfo()->court_id)->paginate(5);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL'])->whereBetween('case_date', [$dateFrom, $dateTo])->where('court_id', globalUserInfo()->court_id)->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL'])->where('case_no', '=', $_GET['case_no'])->where('court_id', globalUserInfo()->court_id)->paginate(5);
            }

        } elseif (globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL'])->paginate(5);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL'])->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'ON_TRIAL_DM', 'SEND_TO_DM', 'SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_NBR_CM'])->where('case_no', '=', $_GET['case_no'])->paginate(5);
            }
        } elseif (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2) {

            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->paginate(5);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where('case_no', '=', $_GET['case_no'])->paginate(5);
            }
        } elseif (globalUserInfo()->role_id == 37) {

            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->paginate(5);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->whereBetween('case_date', [$dateFrom, $dateTo])->where('district_id', user_district())->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('case_no', '=', $_GET['case_no'])->where('district_id', user_district())->paginate(5);
            }

        } elseif (globalUserInfo()->role_id == 7) {

            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->paginate(5);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->whereBetween('case_date', [$dateFrom, $dateTo])->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('case_no', '=', $_GET['case_no'])->where('district_id', user_district())->where('assigned_adc_id', globalUserInfo()->id)->paginate(5);
            }

        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {

            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->paginate(5);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->whereBetween('case_date', [$dateFrom, $dateTo])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('case_no', '=', $_GET['case_no'])->where('district_id', user_district())->where('court_id', globalUserInfo()->court_id)->paginate(5);
            }

        } elseif (globalUserInfo()->role_id == 20) {
            //=================Advocate==================//
            $badi_case = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where('created_by', globalUserInfo()->id)->paginate(5);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $badi_case = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where('created_by', globalUserInfo()->id)->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $badi_case = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where('created_by', globalUserInfo()->id)->where('case_no', '=', $_GET['case_no'])->paginate(5);
            }
            //=====for Bibadi Case============//

            $citizen_id = DB::table('em_citizens')
                ->where('citizen_NID', globalUserInfo()->citizen_nid)
                ->select('id')
                ->get();
            if (!empty($citizen_id)) {
                foreach ($citizen_id as $key => $value) {
                    // return $value;
                    $appeal_no = DB::table('em_appeal_citizens')
                        ->where('citizen_id', $value->id)
                        ->whereIN('citizen_type_id', [2, 4])
                        ->select('appeal_id')
                        ->get();

                }
            } else {
                $appeal_no = null;
            }

            if (!empty($appeal_no)) {
                foreach ($appeal_no as $key => $value) {
                    if ($value != '') {
                        $bibadi_case = EmAppeal::where('id', $value->appeal_id)->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->first();
                        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                            $bibadi_case = EmAppeal::orderby('id', 'desc')->where('id', $value->appeal_id)->whereBetween('case_date', [$dateFrom, $dateTo])->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->first();
                        }
                        if (!empty($_GET['case_no'])) {
                            $bibadi_case = EmAppeal::orderby('id', 'desc')->where('id', $value->appeal_id)->where('case_no', '=', $_GET['case_no'])->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->first();
                        }
                        if (!empty($bibadi_case)) {
                            $badi_case->push((object) $bibadi_case);
                        }
                    }
                }
            }
            $results = $badi_case;
        } else {
            //=================Citizen==================//
            $appealIDs = array();

            //=====for Bibadi Case============//
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
            // dd($appeal_no);
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $key => $value) {
                    if ($value != '') {
                        array_push($appealIDs, $value->appeal_id);

                    }
                }
            }
            $badi_case = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where(function ($query) use ($appealIDs) {
                $query->where('created_by', globalUserInfo()->id)
                    ->orWhereIn('id', $appealIDs);
            })->paginate(5);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $badi_case = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where(function ($query) use ($appealIDs) {
                    $query->where('created_by', globalUserInfo()->id)
                        ->orWhereIn('id', $appealIDs);
                })->paginate(5);
            }
            if (!empty($_GET['case_no'])) {
                $badi_case = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])->where('case_no', '=', $_GET['case_no'])->where(function ($query) use ($appealIDs) {
                    $query->where('created_by', globalUserInfo()->id)
                        ->orWhereIn('id', $appealIDs);
                })->paginate(5);
            }
            $results = $badi_case;
        }
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        // return $results;

        $page_title = 'চলমান মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }