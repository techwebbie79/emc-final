<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function index()
    {
        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'রিপোর্ট'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('report.index')->with($data);
    }

    public function pdf_generate(Request $request)
    {
        // Divition Number
        if ($request->btnsubmit == 'pdf_num_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;
            // return $request;
            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            // return $data['divisions'];


            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
                $data['results'][$key]['on_trial_em'] = $this->case_count_status_by_division('ON_TRIAL', $value->id, $data);
                $data['results'][$key]['on_trial_dm'] = $this->case_count_status_by_division('ON_TRIAL_DM', $value->id, $data);
                $data['results'][$key]['send_to_em'] = $this->case_count_status_by_division('SEND_TO_EM', $value->id, $data);
                $data['results'][$key]['send_to_adm'] = $this->case_count_status_by_division('SEND_TO_ADM', $value->id, $data);
                $data['results'][$key]['colsed'] = $this->case_count_status_by_division('CLOSED', $value->id, $data);
                $data['results'][$key]['rejected'] = $this->case_count_status_by_division('REJECTED', $value->id, $data);

            }
            // $data['result_data'];
            // dd($data['results']);

            // return $data;

            $html = view('report.pdf_num_division')->with($data);
            // dd($html);
            // Generate PDF
            $this->generatePDF($html);
        }

        // District Number
        if ($request->btnsubmit == 'pdf_num_district') {
            $data['page_title'] = 'জেলা ভিত্তিক রিপোর্ট'; //exit;

            // Validation
            $request->validate(
                ['division' => 'required'],
                ['division.required' => 'বিভাগ নির্বাচন করুন']
            );


            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            // Get Division
            $data['district_list'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
            // dd($request->division);->count()

            foreach ($data['district_list'] as $key => $value) {
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
                $data['results'][$key]['on_trial_em'] = $this->case_count_status_by_district('ON_TRIAL', $value->id, $data);
                $data['results'][$key]['on_trial_dm'] = $this->case_count_status_by_district('ON_TRIAL_DM', $value->id, $data);
                $data['results'][$key]['send_to_em'] = $this->case_count_status_by_district('SEND_TO_EM', $value->id, $data);
                $data['results'][$key]['send_to_adm'] = $this->case_count_status_by_district('SEND_TO_ADM', $value->id, $data);
                $data['results'][$key]['colsed'] = $this->case_count_status_by_district('CLOSED', $value->id, $data);
                $data['results'][$key]['rejected'] = $this->case_count_status_by_district('REJECTED', $value->id, $data);
            }

            //return $data;

            $html = view('report.pdf_num_district')->with($data);
            // Generate PDF
            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_num_upazila') {
            $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
            // dd($request->division);

            $request->validate(
                [
                    'division' => 'required',
                    'district' => 'required',
                ],
                [
                    'division.required' => 'বিভাগ নির্বাচন করুন',
                    'district.required' => 'জেলা নির্বাচন করুন',
                ]
            );



            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            // Get Division
            $data['upazila_list'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $request->district)->get();

            foreach ($data['upazila_list'] as $key => $value) {
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['district_name_bn'] = $value->upazila_name_bn;
                // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
                $data['results'][$key]['on_trial_em'] = $this->case_count_status_by_upazila('ON_TRIAL', $value->id, $data);
                $data['results'][$key]['on_trial_dm'] = $this->case_count_status_by_upazila('ON_TRIAL_DM', $value->id, $data);
                $data['results'][$key]['send_to_em'] = $this->case_count_status_by_upazila('SEND_TO_EM', $value->id, $data);
                $data['results'][$key]['send_to_adm'] = $this->case_count_status_by_upazila('SEND_TO_ADM', $value->id, $data);
                $data['results'][$key]['colsed'] = $this->case_count_status_by_upazila('CLOSED', $value->id, $data);
                $data['results'][$key]['rejected'] = $this->case_count_status_by_upazila('REJECTED', $value->id, $data);
            }

            //return $data;

            $html = view('report.pdf_num_upazila')->with($data);
            // Generate PDF
            $this->generatePDF($html);

        }

        if ($request->btnsubmit == 'pdf_crpc_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;

            // Get Division
            // return DB::table('mouja_ulo')->where('ulo_office_id', $officeID)->pluck('mouja_id');
            $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

            // return $data['divisions'];

            $data['crpc'] = DB::table('crpc_sections')->select('id', 'crpc_id', 'crpc_name')->get();

            //dd ($data['crpc']);

            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            foreach ($data['divisions'] as $key => $value) {
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['division_name_bn'] = $value->division_name_bn;
                // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
                foreach ($data['crpc'] as $crpc) {
                    $data['results'][$key][$crpc->crpc_id] = $this->case_count_status_by_crpc_division($value->id, $data, $crpc->id);
                }

            }
            // $data['result_data'];
            //dd($data);

            // return $data;

            $html = view('report.pdf_crpc_division')->with($data);
            // dd($html);
            // Generate PDF
            $this->generatePDF($html);
        }

        if ($request->btnsubmit == 'pdf_crpc_district') {
            $data['page_title'] = 'জেলা ভিত্তিক রিপোর্ট'; //exit;

            // Validation
            $request->validate(
                ['division' => 'required'],
                ['division.required' => 'বিভাগ নির্বাচন করুন']
            );

            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            // Get Division
            $data['district_list'] = DB::table('district')->select('id', 'district_name_bn')->where('division_id', $request->division)->get();
            // dd($request->division);->count()
            $data['crpc'] = DB::table('crpc_sections')->select('id', 'crpc_id', )->get();

            //dd ($data['crpc']);



            foreach ($data['district_list'] as $key => $value) {
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['district_name_bn'] = $value->district_name_bn;
                // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
                foreach ($data['crpc'] as $crpc) {
                    $data['results'][$key][$crpc->crpc_id] = $this->case_count_status_by_crpc_district($value->id, $data, $crpc->id);
                }

            }
            // $data['result_data'];
            //dd($data);

            // return $data;

            $html = view('report.pdf_crpc_district')->with($data);
            // dd($html);
            // Generate PDF
            $this->generatePDF($html);

        }

        if ($request->btnsubmit == 'pdf_crpc_upazila') {
            $data['page_title'] = 'উপজেলা ভিত্তিক রিপোর্ট'; //exit;
            // dd($request->division);

            $request->validate(
                [
                    'division' => 'required',
                    'district' => 'required',
                ],
                [
                    'division.required' => 'বিভাগ নির্বাচন করুন',
                    'district.required' => 'জেলা নির্বাচন করুন',
                ]
            );

            

            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;

            // Get Division
            $data['upazila_list'] = DB::table('upazila')->select('id', 'district_id', 'upazila_name_bn')->where('district_id', $request->district)->get();
            $data['crpc'] = DB::table('crpc_sections')->select('id', 'crpc_id', )->get();

            //dd ($data['crpc']);

            foreach ($data['upazila_list'] as $key => $value) {
                $data['results'][$key]['id'] = $value->id;
                $data['results'][$key]['upazila_name_bn'] = $value->upazila_name_bn;
                // $data['results'][$key]['num'] = $this->case_count_by_division($value->id, $data)->count();
                foreach ($data['crpc'] as $crpc) {
                    $data['results'][$key][$crpc->crpc_id] = $this->case_count_status_by_crpc_upazila($value->id, $data, $crpc->id);
                }

            }
            // $data['result_data'];
            //dd($data);

            // return $data;

            $html = view('report.pdf_crpc_upazila')->with($data);
            // dd($html);
            // Generate PDF
            $this->generatePDF($html);

        }

        if ($request->btnsubmit == 'pdf_case') {
            $data['page_title'] = 'মামলার তালিকা'; //exit;
            $data['date_start'] = $request->date_start;
            $data['date_end'] = $request->date_end;
            $data['division'] = $request->division;
            $data['district'] = $request->district;
            $data['upazila'] = $request->upazila;

            // Validation
            $request->validate(
                ['date_start' => 'required', 'date_end' => 'required'],
                ['date_start.required' => 'মামলা শুরুর তারিখ নির্বাচন করুন', 'date_end.required' => 'মামলা শেষের তারিখ নির্বাচন করুন']
            );

            // Get Division
            // $data['court'] = DB::table('court')->select('id', 'court_name')->where('id', $request->court)->first();
            $data['results'] = $this->case_list_filter($data);
            // dd($data['court']);

            $html = view('report.pdf_case')->with($data);
            // Generate PDF
            $this->generatePDF($html);
        }


    }

    public function caselist()
    {
        // Dropdown List
        $data['courts'] = DB::table('court')->select('id', 'court_name')->get();
        $data['roles'] = DB::table('role')->select('id', 'role_name')->where('in_action', 1)->get();
        $data['divisions'] = DB::table('division')->select('id', 'division_name_bn')->get();

        $data['getMonth'] = date('M', mktime(0, 0, 0));

        $data['page_title'] = 'মামলার রিপোর্ট ফরম'; //exit;
        // return view('case.case_add', compact('page_title', 'case_type'));
        return view('report.caselist')->with($data);
    }



    public function case_count_status_by_district($status, $id, $data)
    {
        // dd($data);
        if(isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
          }else{
              $dateFrom = 0;
              $dateTo = 0;

          }
        $query = DB::table('em_appeals')->where('district_id', $id)->where('appeal_status', $status);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->count();
        // return $query;
    }

    public function case_count_status_by_upazila($status, $id, $data)
    {
        // dd($data);
        if(isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
          }else{
              $dateFrom = 0;
              $dateTo = 0;

          }
        $query = DB::table('em_appeals')->where('upazila_id', $id)->where('appeal_status', $status);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->count();
        // return $query;
    }

    public function case_count_status_by_division($status, $id, $data)
    {
        // dd($data);
        if(isset($data['date_start']) && isset($data['date_end'])) {

          $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
          $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
        }else{
            $dateFrom = 0;
            $dateTo = 0;

        }

        $query = DB::table('em_appeals')->where('division_id', $id)->where('appeal_status', $status);
        if($dateFrom != 0 && $dateTo != 0) {
            // dd($dateFrom);
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }

        return $query->count();
        // return $query;
    }







    public function case_list_filter($data)
    {
        // Convert DB date formate
        $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
        $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));

        // Query
        $query = DB::table('em_appeals')
            ->select('em_appeals.id', 'em_appeals.case_no', 'em_appeals.case_date', 'division.division_name_bn', 'district.district_name_bn', 'upazila.upazila_name_bn', 'em_appeals.case_date')
            ->join('district', 'em_appeals.district_id', '=', 'district.id')
            ->join('upazila', 'em_appeals.upazila_id', '=', 'upazila.id')
            ->join('division', 'em_appeals.division_id', '=', 'division.id')
            ->orderBy('id', 'DESC');
        // ->where('em_appeals.id', '=', 29);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }
        if (!empty($data['division'])) {
            $query->where('em_appeals.division_id', $data['division']);
        }
        if (!empty($data['district'])) {
            $query->where('em_appeals.district_id', $data['district']);
        }
        if (!empty($data['upazila'])) {
            $query->where('em_appeals.upazila_id', $data['upazila']);
        }
        $result = $query->get();
        // $result = $query->toSql();
        // dd($result);
        return $result;
    }



    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->btnsubmit == 'pdf_division') {
            $data['page_title'] = 'বিভাগ ভিত্তিক রিপোর্ট'; //exit;
            $html = view('report.pdf_division')->with($data);
            // echo 'hello';

            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 12,
                'default_font' => 'kalpurush',
            ]);
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        }
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

    public function case_count_status_by_crpc_division($id, $data, $law_section)
    {

        if(isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
          }else{
              $dateFrom = 0;
              $dateTo = 0;

          }
        $query = DB::table('em_appeals')
            ->where('division_id', $id)->where('law_section', $law_section);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }
        return $query->count();
    }

    public function case_count_status_by_crpc_district($id, $data, $law_section)
    {
        if(isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
          }else{
              $dateFrom = 0;
              $dateTo = 0;

          }
        $query = DB::table('em_appeals')
            ->where('district_id', $id)->where('law_section', $law_section);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }

        return $query->count();
    }
    public function case_count_status_by_crpc_upazila($id, $data, $law_section)
    {
        if(isset($data['date_start']) && isset($data['date_end'])) {

            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $data['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $data['date_end'])));
          }else{
              $dateFrom = 0;
              $dateTo = 0;

          }
        $query = DB::table('em_appeals')
            ->where('upazila_id', $id)->where('law_section', $law_section);
        if ($dateFrom != 0 && $dateTo != 0) {
            $query->whereBetween('em_appeals.case_date', [$dateFrom, $dateTo]);
        }

        return $query->count();
    }
}
