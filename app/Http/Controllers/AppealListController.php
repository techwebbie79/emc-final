<?php

namespace App\Http\Controllers;

use App\Models\EmAppeal;
use App\Repositories\AppealRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AppealListController extends Controller
{
    public $permissionCode = 'certificateList';

    public function index(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district());

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('district_id', user_district())
                ->where('assigned_adc_id', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 20) {
            //=================Advocate==================//

            $total_case = [];

            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4, 7])
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 36) {
            //=================Citizen==================//
            $total_case = [];
            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'ON_TRIAL_DM', 'SEND_TO_DM', 'SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_NBR_CM'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        } elseif (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
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

    public function pending_case(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 27) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        }
        if (globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_ASST_EM'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DM', 'SEND_TO_ASST_DM'])
                ->where('district_id', user_district())
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DM', 'SEND_TO_ASST_DM'])
                ->where('district_id', user_district())
                ->where('assigned_adc_id', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 38) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DM', 'SEND_TO_ASST_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_ASST_DM'])
                ->where('district_id', user_district())
                ->where('court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 20) {
            //=================Advocate==================//

            $total_case = [];

            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 4, 7])
                ->whereIn('em_appeals.appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'SEND_TO_DM', 'SEND_TO_EM'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 36) {
            //=================Citizen==================//
            $total_case = [];
            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1])
                ->whereIn('em_appeals.appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'SEND_TO_DM', 'SEND_TO_EM'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'ON_TRIAL_DM', 'SEND_TO_DM', 'SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_NBR_CM'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        } elseif (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        // return $results;

        $page_title = 'গ্রহণের জন্য অপেক্ষমাণ মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function all_case(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL', 'CLOSED'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM', 'CLOSED'])
                ->where('district_id', user_district());

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM', 'CLOSED'])
                ->where('district_id', user_district())
                ->where('assigned_adc_id', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM', 'CLOSED'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 20) {
            //=================Advocate==================//

            $total_case = [];

            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4, 7])
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 36) {
            //=================Citizen==================//
            $total_case = [];
            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL', 'CLOSED'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereNotIn('appeal_status', ['ON_TRIAL_DM', 'ON_TRIAL', 'CLOSED'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'ON_TRIAL_DM', 'SEND_TO_DM', 'SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_NBR_CM', 'CLOSED'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        } elseif (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        // return $results;

        $page_title = 'সকল মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function closed_list(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['CLOSED'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['CLOSED'])
                ->where('district_id', user_district());

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['CLOSED'])
                ->where('district_id', user_district())
                ->where('assigned_adc_id', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['CLOSED'])
                ->where('court_id', globalUserInfo()->court_id);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 20) {
            //=================Advocate==================//

            $total_case = [];

            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4, 7])
                ->whereIn('em_appeals.appeal_status', ['CLOSED'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 36) {
            //=================Citizen==================//
            $total_case = [];
            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->whereIn('em_appeals.appeal_status', ['CLOSED'])
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereNotIn('appeal_status', ['CLOSED'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereNotIn('appeal_status', ['CLOSED'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_ASST_DM', 'SEND_TO_DM', 'SEND_TO_DC', 'SEND_TO_DIV_COM', 'SEND_TO_NBR_CM', 'CLOSED'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        } elseif (globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['CLOSED'])
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['CLOSED'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['CLOSED'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        // return $results;

        $page_title = 'নিষ্পত্তিকৃত মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function trial_date_list(Request $request)
    {
        if (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('appeal_status', 'ON_TRIAL_DM')
                ->where('district_id', user_district())
                ->where('is_hearing_required', 1);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('court_id', globalUserInfo()->court_id)
                ->where('appeal_status', 'ON_TRIAL_DM')
                ->where('is_hearing_required', 1);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('court_id', globalUserInfo()->court_id)
                ->where('is_hearing_required', 1)
                ->where('appeal_status', 'ON_TRIAL');
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('district_id', user_district())
                ->where('assigned_adc_id', globalUserInfo()->id)
                ->where('is_hearing_required', 1)
                ->where('appeal_status', 'ON_TRIAL_DM');
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 20) {
            //=================Advocate==================//

            $total_case = [];

            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4, 7])
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        } elseif (globalUserInfo()->role_id == 36) {
            //=================Citizen==================//
            $total_case = [];

            $appeal_ids_from_db = DB::table('em_appeal_citizens')
                ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
                ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->where('next_date', date('Y-m-d', strtotime(now())))
                ->where('is_hearing_required', 1)
                ->select('em_appeal_citizens.appeal_id')
                ->get();

            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($total_case, $appeal_ids_from_db_single->appeal_id);
            }

            $results = EmAppeal::orderby('id', 'DESC')->WhereIn('ID', $total_case);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
        }

        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        // $userRole=Session::get('userRole');
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = ' শুনানির তারিখ হয়েছে এমন মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function pending_review_case(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
                ->where('district_id', user_district())
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->where('district_id', user_district())
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->where('district_id', user_district())
                    ->paginate(10);
            }
        } else {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
                ->where(function ($query) {
                    $query->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id);
                })
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
                    ->where(function ($query) {
                        $query->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id);
                    })
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['SEND_TO_DM_REVIEW'])
                    ->where(function ($query) {
                        $query->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id);
                    })
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }

        if (globalUserInfo()->role_id == 6) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'SEND_TO_DC')
                ->paginate(10);
        }
        if (globalUserInfo()->role_id == 34) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'SEND_TO_DIV_COM')
                ->paginate(10);
        }
        if (globalUserInfo()->role_id == 25) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'SEND_TO_NBR_CM')
                ->paginate(10);
        }
        /*if(globalUserInfo()->role_id == 33){
        $results = EmAppeal::orderby('id', 'desc')
        ->whereHas('causelistCaseshortdecision', function($query){
        $query->where('case_shortdecision_id', 7);
        })
        ->paginate(10);
        }*/
        $page_title = 'গ্রহণের জন্য অপেক্ষমাণ মামলার তালিকা';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function running_review_case(Request $request)
    {
        // return globalUserInfo()->id;
        if (globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('is_applied_for_review', 1)
                ->where('district_id', user_district())
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                    ->where('is_applied_for_review', 1)
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->where('district_id', user_district())
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                    ->where('is_applied_for_review', 1)
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->where('district_id', user_district())
                    ->paginate(10);
            }
        } else {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                ->where('is_applied_for_review', 1)
                ->where(function ($query) {
                    $query->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id);
                })
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                    ->where('is_applied_for_review', 1)
                    ->where(function ($query) {
                        $query->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id);
                    })
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->whereIn('appeal_status', ['ON_TRIAL_DM'])
                    ->where('is_applied_for_review', 1)
                    ->where(function ($query) {
                        $query->where('review_applied_by', globalUserInfo()->id)->orWhere('created_by', globalUserInfo()->id);
                    })
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }

        if (globalUserInfo()->role_id == 6) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'SEND_TO_DC')
                ->paginate(10);
        }
        if (globalUserInfo()->role_id == 34) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'SEND_TO_DIV_COM')
                ->paginate(10);
        }
        if (globalUserInfo()->role_id == 25) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'SEND_TO_NBR_CM')
                ->paginate(10);
        }
        /*if(globalUserInfo()->role_id == 33){
        $results = EmAppeal::orderby('id', 'desc')
        ->whereHas('causelistCaseshortdecision', function($query){
        $query->where('case_shortdecision_id', 7);
        })
        ->paginate(10);
        }*/
        $page_title = 'চলমান রিভিউ মামলার তালিকা';
        return view('appealList.appealReviewCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function draft_list(Request $request)
    {
        if (globalUserInfo()->role_id != 36) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'DRAFT')
                ->paginate(10);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'DRAFT')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'DRAFT')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        } else {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('created_by', globalUserInfo()->id)
                ->where('appeal_status', 'DRAFT')
                ->paginate(10);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('created_by', globalUserInfo()->id)
                    ->where('appeal_status', 'DRAFT')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('created_by', globalUserInfo()->id)
                    ->where('appeal_status', 'DRAFT')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'খসড়া মামলার তালিকা';
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function rejected_list(Request $request)
    {
        if (globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'REJECTED')
                ->where('district_id', user_district())
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'REJECTED')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->where('district_id', user_district())
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'REJECTED')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->where('district_id', user_district())
                    ->paginate(10);
            }
        } elseif (globalUserInfo()->role_id == 27) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'REJECTED')
                ->where('court_id', globalUserInfo()->court_id)
                ->paginate(10);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'REJECTED')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->where('court_id', globalUserInfo()->court_id)
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'REJECTED')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->where('court_id', globalUserInfo()->court_id)
                    ->paginate(10);
            }
        } else {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('created_by', globalUserInfo()->id)
                ->where('appeal_status', 'REJECTED')
                ->paginate(20);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('created_by', globalUserInfo()->id)
                    ->where('appeal_status', 'REJECTED')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('created_by', globalUserInfo()->id)
                    ->where('appeal_status', 'REJECTED')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }

        $date = date($request->date);
        $caseStatus = 1;
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Auth::user()->username;
        }
        $page_title = 'খারিজকৃত মামলার তালিকা';
        // return $results;
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function postponed_list(Request $request)
    {
        if (globalUserInfo()->role_id != 36) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('appeal_status', 'POSTPONED')
                ->paginate(20);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'POSTPONED')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('appeal_status', 'POSTPONED')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        } else {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('created_by', globalUserInfo()->id)
                ->where('appeal_status', 'POSTPONED')
                ->paginate(20);
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('created_by', globalUserInfo()->id)
                    ->where('appeal_status', 'POSTPONED')
                    ->whereBetween('case_date', [$dateFrom, $dateTo])
                    ->paginate(10);
            }
            if (!empty($_GET['case_no'])) {
                $results = EmAppeal::orderby('id', 'desc')
                    ->where('created_by', globalUserInfo()->id)
                    ->where('appeal_status', 'POSTPONED')
                    ->where('case_no', '=', $_GET['case_no'])
                    ->orWhere('manual_case_no', '=', $_GET['case_no'])
                    ->paginate(10);
            }
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = ' মুলতবি মামলার তালিকা';
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function arrest_warrent_list(Request $request)
    {
        // $results = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->paginate(20);
        $results = DB::table('em_case_shortdecision_templates')
            ->join('em_appeals', 'em_case_shortdecision_templates.appeal_id', '=', 'em_appeals.id')
            ->select('em_case_shortdecision_templates.appeal_id', 'em_case_shortdecision_templates.template_name', 'em_case_shortdecision_templates.template_full', 'em_appeals.*')
            ->where('em_case_shortdecision_templates.case_shortdecision_id', 19)
            ->orderby('em_appeals.id', 'DESC')
            ->paginate(10);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = DB::table('em_case_shortdecision_templates')
                ->join('em_appeals', 'em_case_shortdecision_templates.appeal_id', '=', 'em_appeals.id')
                ->select('em_case_shortdecision_templates.appeal_id', 'em_case_shortdecision_templates.template_name', 'em_case_shortdecision_templates.template_full', 'em_appeals.*')
                ->where('em_case_shortdecision_templates.case_shortdecision_id', 19)
                ->whereBetween('em_appeals.next_date', [$dateFrom, $dateTo])
                ->orderby('em_appeals.id', 'DESC')
                ->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = DB::table('em_case_shortdecision_templates')
                ->join('em_appeals', 'em_case_shortdecision_templates.appeal_id', '=', 'em_appeals.id')
                ->select('em_case_shortdecision_templates.appeal_id', 'em_case_shortdecision_templates.template_name', 'em_case_shortdecision_templates.template_full', 'em_appeals.*')
                ->where('em_case_shortdecision_templates.case_shortdecision_id', 19)
                ->where('em_appeals.case_no', '=', $_GET['case_no'])
                ->orderby('em_appeals.id', 'DESC')
                ->paginate(10);
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = ' গ্রেপ্তারি পরোয়ানা জারি হয়েছে এমন মামলার তালিকা';
        // return $results;
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseWarrentList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function arrest_investigation_list(Request $request)
    {
        // $results = GccAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->paginate(20);
        $results = DB::table('em_case_shortdecision_templates')
            ->join('em_appeals', 'em_case_shortdecision_templates.appeal_id', '=', 'em_appeals.id')
            ->select('em_case_shortdecision_templates.appeal_id', 'em_case_shortdecision_templates.template_name', 'em_case_shortdecision_templates.template_full', 'em_appeals.*')
            ->where('em_case_shortdecision_templates.case_shortdecision_id', 5)
            ->orderby('em_appeals.id', 'DESC')
            ->paginate(10);
        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = DB::table('em_case_shortdecision_templates')
                ->join('em_appeals', 'em_case_shortdecision_templates.appeal_id', '=', 'em_appeals.id')
                ->select('em_case_shortdecision_templates.appeal_id', 'em_case_shortdecision_templates.template_name', 'em_case_shortdecision_templates.template_full', 'em_appeals.*')
                ->where('em_case_shortdecision_templates.case_shortdecision_id', 5)
                ->whereBetween('em_appeals.next_date', [$dateFrom, $dateTo])
                ->orderby('em_appeals.id', 'DESC')
                ->paginate(10);
        }
        if (!empty($_GET['case_no'])) {
            $results = DB::table('em_case_shortdecision_templates')
                ->join('em_appeals', 'em_case_shortdecision_templates.appeal_id', '=', 'em_appeals.id')
                ->select('em_case_shortdecision_templates.appeal_id', 'em_case_shortdecision_templates.template_name', 'em_case_shortdecision_templates.template_full', 'em_appeals.*')
                ->where('em_case_shortdecision_templates.case_shortdecision_id', 5)
                ->where('em_appeals.case_no', '=', $_GET['case_no'])
                ->orderby('em_appeals.id', 'DESC')
                ->paginate(10);
        }
        // return $results->appealCitizens;
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName = Auth::user()->username;
        }
        $page_title = ' তদন্তের আদেশ জারি হয়েছে এমন মামলার তালিকা';
        // return $results;
        //return view('appealList.appeallist')->with('date',$date);
        return view('appealList.appealCasewiseInvestigationList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function appealData(Request $request)
    {
        $usersPermissions = Session::get('userPermissions');
        $appeals = AppealRepository::getAppealListBySearchParam($request);

        return response()->json([
            'data' => $appeals,
            'userPermissions' => $usersPermissions,
            'userName' => Session::get('userInfo')->username,
        ]);
    }

    public function closedList(Request $request)
    {
        $date = date($request->date);
        $caseStatus = 3;
        $userRole = Session::get('userRole');
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Session::get('userInfo')->username;
        }
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus'));
    }

    public function postponedList(Request $request)
    {
        $date = date($request->date);
        $caseStatus = 2;
        $userRole = Session::get('userRole');
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Session::get('userInfo')->username;
        }
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus'));
    }

    public function appeal_with_investigation_report(Request $request)
    {
        $appeal_ids_with_investigation = DB::table('em_investigation_report')
            ->select('appeal_id')
            ->distinct()
            ->get();
        $appeal_id_in_appeal_table = [];
        foreach ($appeal_ids_with_investigation as $value) {
            array_push($appeal_id_in_appeal_table, $value->appeal_id);
        }

        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district());

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('em_appeals.id', $appeal_id_in_appeal_table)
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district())
                ->where('em_appeals.assigned_adc_id', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        }
        $results = $results->paginate(10);
        $page_title = 'তদন্তের রিপোর্টযুক্ত আবেদন তালিকা';
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }

    public function appeal_with_action_required(Request $request)
    {
        if (globalUserInfo()->role_id == 27) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('em_appeals.action_required', 'EM_DM')
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 37) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('em_appeals.action_required', 'EM_DM')
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district());

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 38) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('em_appeals.action_required', 'EM_DM')
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 7) {
            $results = EmAppeal::orderby('id', 'desc')
                ->where('em_appeals.action_required', 'EM_DM')
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district())
                ->where('em_appeals.assigned_adc_id', globalUserInfo()->id);

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 39) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL_DM'])
                ->where('em_appeals.district_id', user_district())
                ->where('em_appeals.court_id', globalUserInfo()->court_id)
                ->where('em_appeals.action_required', 'PESH');

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        } elseif (globalUserInfo()->role_id == 28) {
            $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('em_appeals.appeal_status', ['ON_TRIAL'])
                ->where('em_appeals.court_id', globalUserInfo()->court_id)
                ->where('em_appeals.action_required', 'PESH');

            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('em_appeals.case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }
        }

        $results = $results->paginate(10);
        $page_title = 'চলমান মামলাতে পদক্ষেপ নিতে হবে';
        $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
    public function case_by_em(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')
                ->whereIn('appeal_status', ['ON_TRIAL'])
                ->where('court_id', globalUserInfo()->court_id)
                ->where('em_id',globalUserInfo()->id);
                
            if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
                // dd(1);
                $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
                $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
                $results = $results->whereBetween('case_date', [$dateFrom, $dateTo]);
            }
            if (!empty($_GET['case_no'])) {
                $results = $results->where('case_no', '=', $_GET['case_no'])->orWhere('manual_case_no', '=', $_GET['case_no']);
            }

            $results = $results->paginate(10);
            $date = date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole = Auth::user()->role_id;
        $gcoUserName = '';
        // return $results;

        $page_title = 'আপনার পরিচালিত মামলাসমূহ';
        return view('appealList.appealCasewiseList', compact('date', 'gcoUserName', 'caseStatus', 'page_title', 'results'));
    }
}
