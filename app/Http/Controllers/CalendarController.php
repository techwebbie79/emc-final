<?php

namespace App\Http\Controllers;

use App\Http\Resources\calendar\GccAppealHearingCollection;
use App\Models\EmAppeal;
use App\Models\EmCauseList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_old()
    {
        $appealHearing = EmCauseList::select('id', 'appeal_id', 'case_decision_id', 'conduct_date', DB::raw('count(*) as total'))
            ->orderby('id', 'DESC')
            ->groupBy('conduct_date');

        $data['hearingCalender'] = GccAppealHearingCollection::collection($appealHearing->get());

        //  $hearingCalender = CaseHearing::select('id','case_id', 'hearing_comment', 'hearing_date' ,DB::raw('count(*) as total'))
        //     ->orderby('id', 'DESC')
        //     ->groupBy('hearing_date');
        // $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());
        $data['page_title'] = 'আদালত';
        return view('dashboard.calendar.calendar')->with($data);
    }
    public function index()
    {
        $appealHearing = EmAppeal::select('id', 'next_date', DB::raw('count(*) as total'));
        if (globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 28) {
            $appealHearing->where('court_id', globalUserInfo()->court_id)->whereIn('appeal_status', ['ON_TRIAL']);
        } elseif (globalUserInfo()->role_id == 38 || globalUserInfo()->role_id == 39) {
            $appealHearing->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('court_id', globalUserInfo()->court_id);
        } elseif (globalUserInfo()->role_id == 37) {
            $appealHearing->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('district_id', user_district());
        } elseif (globalUserInfo()->role_id == 7) {
            $appealHearing->whereIn('appeal_status', ['ON_TRIAL_DM'])->where('assigned_adc_id',globalUserInfo()->id)->where('district_id', user_district());
        }
        $appealHearing->where('is_hearing_required',1)->orderby('id', 'DESC')->groupBy('next_date');

        $data['hearingCalender'] = GccAppealHearingCollection::collection($appealHearing->get());

        //  $hearingCalender = CaseHearing::select('id','case_id', 'hearing_comment', 'hearing_date' ,DB::raw('count(*) as total'))
        //     ->orderby('id', 'DESC')
        //     ->groupBy('hearing_date');
        // $data['hearingCalender'] = CaseHearingCollection::collection($hearingCalender->get());
        $data['page_title'] = 'আদালত';
        return view('dashboard.calendar.calendar')->with($data);
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
