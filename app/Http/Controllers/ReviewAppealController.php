<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Appeal;
use App\Models\CauseList;
use App\Models\EmAppeal;
use App\Models\Attachment;
use App\Models\EmCauseList;
use Illuminate\Http\Request;
use App\Models\AppealCitizen;
use App\Models\EmAppealCitizen;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Services\ProjapotiServices;
use App\Repositories\NoteRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AppealRepository;
use App\Repositories\CitizenRepository;
use Illuminate\Support\Facades\Session;
use App\Repositories\AppealerRepository;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\CauseListRepository;
use App\Repositories\LawBrokenRepository;
use App\Repositories\UserAgentRepository;
use App\Repositories\AttachmentRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\AppealCitizenRepository;
use App\Repositories\CauseListShortDecisionRepository;

class ReviewAppealController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        // $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = EmAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal']  = $appeal;
        $data["notes"] = $appeal->appealNotes;
        $data["districtId"]= $officeInfo->district_id;
        $data["divisionId"]=$officeInfo->division_id;
        // $data["office_id"] = $office_id;
        // $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();
        $data['id']=$id;
        $data['page_title'] = 'রিভিউ আবেদন ফর্ম';
        // return $data;
        return view('reviewAppeal.reviewAppealCreate')->with($data);
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
        // return $request;
        $id = $request->appealId;
        $msg = 'মামলা সফলভাবে প্রেরণ করা হয়েছে!';
        $appeal = EmAppeal::findOrFail($id);
        $appeal->appeal_status=$request->status;
        $appeal->is_applied_for_review=1;
        $appeal->review_applied_date=date('Y-m-d');
        $appeal->updated_at=date('Y-m-d H:i:s');
        $appeal->updated_by= globalUserInfo()->id;
        $appeal->review_applied_by= globalUserInfo()->id;
        $appeal->save();

        $activity = 'মামলার আপিল আবেদন করেছেন ( নাগরিক )';
        $user = globalUserInfo();
        if (isset($user->designation)) {
            $designation = $user->designation;
        } else {
            $designation = 'সিটিজেন';
        }
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');
        $em_log_book = [
            'appeal_id' => $request->appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($em_log_book);
        DB::table('em_log_book')->insert($em_log_book);


        return redirect('appeal/all/list')->with('success', 'তথ্য সফলভাবে সংরক্ষণ করা হয়েছে');
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
