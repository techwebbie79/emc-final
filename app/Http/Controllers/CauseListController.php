<?php

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\EmAppeal;
use App\Models\CaseHearing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use GrahamCampbell\ResultType\Result;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\PeshkarNoteRepository;
use App\Services\ShortOrderTemplateService;
use App\Http\Resources\calendar\CaseHearingCollection;

class CauseListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', now())));
        $data['divisions'] = DB::table('division')
            ->select('id', 'division_name_bn')
            ->get();
        $division_name = null;
        $district_name = null;
        $court_name = null;

        $appeal = EmAppeal::where('case_no', '!=', 'অসম্পূর্ণ মামলা')->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM']);

        if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $appeal = $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
        } else {
            $appeal = $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
        }

        if (!empty($_GET['division'])) {
            $division_name = DB::table('division')
                ->select('division_name_bn')
                ->where('id', $_GET['division'])
                ->first()->division_name_bn;

            $appeal = $appeal->where('division_id', '=', $_GET['division']);
        }
        if (!empty($_GET['district'])) {
            $district_name = DB::table('district')
                ->select('district_name_bn')
                ->where('id', $_GET['district'])
                ->first()->district_name_bn;

            $appeal = $appeal->where('district_id', '=', $_GET['district']);
        }
        if (!empty($_GET['court'])) {
            $court_details = DB::table('court')
                ->where('id', $_GET['court'])
                ->first();
            $court_name = $court_details->court_name;
            //dd($court_details);
            $appeal = $appeal->where('court_id', '=', $_GET['court']);
        } 
        if (!empty($_GET['case_no'])) {
            $appeal = $appeal->where('case_no', '=', bn2en($_GET['case_no']))->orWhere('manual_case_no', '=', $_GET['case_no']);
        }

        if (!empty($_GET['offset'])) {
            $offset = $_GET['offset'] - 1;
            $offset = $offset * 10;
        } else {
            $offset = 0;
        }

        $data['running_case_paginate'] = $appeal->count();

        $appeal = $appeal
            ->offset($offset)
            ->limit(10)
            ->get();

        if ($appeal != null || $appeal != '') {
            foreach ($appeal as $key => $value) {
                $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                $notes = PeshkarNoteRepository::get_last_order_list($value->id);
                if (isset($citizen_info) && !empty($citizen_info)) {
                    $citizen_info = $citizen_info;
                } else {
                    $citizen_info = null;
                }
                if (isset($notes) && !empty($notes)) {
                    $notes = $notes;
                } else {
                    $notes = null;
                }

                $data['appeal'][$key]['citizen_info'] = $citizen_info;
                $data['appeal'][$key]['notes'] = $notes;
                // $data["notes"] = $value->appealNotes;
            }
        } else {
            $data['appeal'][$key]['citizen_info'] = '';
            $data['appeal'][$key]['notes'] = '';
        }

        $data['dateFrom'] = $dateFrom;
        $data['dateTo'] = $dateTo;
        $data['division_name'] = $division_name;
        $data['district_name'] = $district_name;
        $data['court_name'] = $court_name;
        $data['page_title'] = 'মামলার কার্যতালিকা';

        $data['offset_page'] = $offset;

        //dd($data);

        return view('causeList.appealCauseList')->with($data);
    }

    public function paginate_causelist_auth_user(Request $request)
    {
        $role_id = globalUserInfo()->role_id;

        $page_no = $request->page_no - 1;
        $offset = $page_no * 10;

        if ($role_id == 37 || $role_id == 38 || $role_id == 39 || $role_id == 7) {
            $appeal = EmAppeal::where('district_id', user_district())
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->offset($offset)
                ->limit(10)
                ->get();
        } elseif ($role_id == 27 || $role_id == 28) {
            $appeal = EmAppeal::where('district_id', user_district())
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
                ->where('court_id', '=', globalUserInfo()->court_id)
                ->offset($offset)
                ->limit(10)
                ->get();
        } elseif ($role_id == 36) {
            $appeal_no = DB::table('em_appeals')
                ->join('em_appeal_citizens', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2])
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->select('em_appeals.id as appeal_id')
                ->get();

            $cause_list_ids = [];
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $value) {
                    array_push($cause_list_ids, $value->appeal_id);
                }
            }

            $appeal = EmAppeal::whereIn('id', $cause_list_ids)
                ->offset($offset)
                ->limit(10)
                ->get();
        } elseif ($role_id == 20) {
            $appeal_no = DB::table('em_appeals')
                ->join('em_appeal_citizens', 'em_appeals.id', '=', 'em_appeal_citizens.appeal_id')
                ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4])
                ->whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM', 'CLOSED'])
                ->where('em_appeal_citizens.citizen_id', globalUserInfo()->citizen_id)
                ->select('em_appeals.id as appeal_id')
                ->get();

            $cause_list_ids = [];
            if (!empty($appeal_no)) {
                foreach ($appeal_no as $value) {
                    array_push($cause_list_ids, $value->appeal_id);
                }
            }

            $appeal = EmAppeal::whereIn('id', $cause_list_ids)
                ->offset($offset)
                ->limit(10)
                ->get();
        }

        if ($appeal != null || $appeal != '') {
            foreach ($appeal as $key => $value) {
                $citizen_info = AppealRepository::getCauselistCitizen($value->id);
                $notes = PeshkarNoteRepository::get_last_order_list($value->id);
                if (isset($citizen_info) && !empty($citizen_info)) {
                    $citizen_info = $citizen_info;
                } else {
                    $citizen_info = null;
                }
                if (isset($notes) && !empty($notes)) {
                    $notes = $notes;
                } else {
                    $notes = null;
                }

                $appeal[$key]['citizen_info'] = $citizen_info;
                $appeal[$key]['notes'] = $notes;
                // $data["notes"] = $value->appealNotes;
            }
        } else {
            $appeal[$key]['citizen_info'] = '';
            $appeal[$key]['notes'] = '';
        }

        $html = '';

        $html .= '<table class="table mb-6 font-size-h5">
       <thead class="thead-customStyleCauseList font-size-h6 text-center">
           <tr>
               <th scope="col" width="100">ক্রমিক নং</th>
               <th scope="col">মামলা নম্বর</th>
               <th scope="col">পক্ষ </th>
               <!-- <th scope="col">অ্যাডভোকেট </th> -->
               <th scope="col">পরবর্তী তারিখ</th>
               <th scope="col">সর্বশেষ আদেশ</th>
           </tr>
       </thead>';
        if (!empty($appeal)) {
            foreach ($appeal as $key => $value) {
                $html .= '<tbody>';
                $html .= '<tr>';
                $html .= '<td scope="row" class="text-center">' . en2bn($key + $offset + 1) . '</td>';
                $html .= '<td class="text-center">' . en2bn($value['citizen_info']['case_no']) . '</td>';
                $html .= '<td class="text-center">';
                if (isset($value['citizen_info']['applicant_name'])) {
                    $html .= $value['citizen_info']['applicant_name'];
                } else {
                    $html .= '---';
                }
                $html .= '<br> <b>vs</b><br>';
                if (isset($value['citizen_info']['defaulter_name'])) {
                    $html .= $value['citizen_info']['defaulter_name'];
                } else {
                    $html .= '---';
                }
                $html .= '</td>';

                if ($value['citizen_info']['appeal_status'] == 'ON_TRIAL' || $value['citizen_info']['appeal_status'] == 'ON_TRIAL_DM') {
                    if (date('Y-m-d', strtotime(now())) == $value['citizen_info']['next_date']) {
                        $html .= '<td class="blink_me text-danger"><span>*</span>' . en2bn($value['citizen_info']['next_date']) . '<span>*</span></td>';
                    } else {
                        $html .= '<td>' . en2bn($value['citizen_info']['next_date']) . '</td>';
                    }
                } else {
                    $html .= '<td class="text-danger">' . appeal_status_bng($value['citizen_info']['appeal_status']) . '</td>';
                }

                $html .= '<td class="text-center">';
                if (!empty($value['notes']->short_order_name)) {
                    $html .= $value['notes']->short_order_name;
                } else {
                    $html .= '----';
                }
                $html .= '</td>';
                $html .= '</tr></tbody>';
            }
        } else {
            $html .= '<p>কোনো তথ্য খুঁজে পাওয়া যায় নি </p>';
        }

        return response()->json([
            'success' => 'success',
            'html' => $html,
        ]);
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
