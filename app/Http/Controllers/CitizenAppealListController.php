<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/12/17
 * Time: 12:56 PM
 */

namespace App\Http\Controllers;

use App\Models\Appeal;
use App\Models\EmAppeal;
use App\Repositories\AppealRepository;
use GrahamCampbell\ResultType\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;


class citizenAppealListController extends Controller
{
    public $permissionCode='certificateList';

    public function index(Request $request)
    {
        // return globalUserInfo();
        $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->paginate(5);
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        }
        if(!empty($_GET['case_no'])) {
            $results = EmAppeal::orderby('id', 'desc')->whereIn('appeal_status', ['ON_TRIAL', 'SEND_TO_GCO'])->where('case_no','=',$_GET['case_no'])->paginate(5);
        }
        // return $results->appealCitizens;
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }

        if(globalUserInfo()->role_id == 6){
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'SEND_TO_DC')->paginate(5);
        }
        if(globalUserInfo()->role_id == 34){
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'SEND_TO_DIV_COM')->paginate(5);
        }
        if(globalUserInfo()->role_id == 25){
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'SEND_TO_NBR_CM')->paginate(5);
        }
        if(globalUserInfo()->role_id == 33){
            $results = EmAppeal::orderby('id', 'desc')
            ->whereHas('causelistCaseshortdecision', function($query){
                $query->where('case_shortdecision_id', 7);
            })
            ->paginate(5);
        }
        $page_title  = 'চলমান মামলার তালিকা';
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }
    public function draft_list(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'DRAFT')->paginate(5);

        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'DRAFT')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        }
        if(!empty($_GET['case_no'])) {
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'DRAFT')->where('case_no','=',$_GET['case_no'])->paginate(5);
        }
        // return $results->appealCitizens;
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = 'খসড়া মামলার তালিকা';
        //return view('citizenAppealList.appeallist')->with('date',$date);
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }
    public function rejected_list(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'REJECTED')->paginate(20);
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'REJECTED')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        }
        if(!empty($_GET['case_no'])) {
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'REJECTED')->where('case_no','=',$_GET['case_no'])->paginate(5);
        }
        $date=date($request->date);
        $caseStatus = 1;
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = 'বর্জনকৃত মামলার তালিকা';
        // return $results;
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }
    public function closed_list(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->paginate(20);
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        }
        if(!empty($_GET['case_no'])) {
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'CLOSED')->where('case_no','=',$_GET['case_no'])->paginate(5);
        }
        // return $results->appealCitizens;
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = 'নিষ্পত্তিকৃত মামলার তালিকা';
        //return view('citizenAppealList.appeallist')->with('date',$date);
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }
    public function postponed_list(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'POSTPONED')->paginate(20);
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'POSTPONED')->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        }
        if(!empty($_GET['case_no'])) {
            $results = EmAppeal::orderby('id', 'desc')->where('appeal_status', 'POSTPONED')->where('case_no','=',$_GET['case_no'])->paginate(5);
        }
        // return $results->appealCitizens;
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = ' মুলতবি মামলার তালিকা';
        //return view('citizenAppealList.appeallist')->with('date',$date);
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }


    
    public function trial_date_list(Request $request)
    {
        $results = EmAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->paginate(20);
        if(!empty($_GET['date_start'])  && !empty($_GET['date_end'])){
            // dd(1);
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_start'])));
            $dateTo =  date('Y-m-d', strtotime(str_replace('/', '-', $_GET['date_end'])));
            $results = EmAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->whereBetween('case_date', [$dateFrom, $dateTo])->paginate(5);
        }
        if(!empty($_GET['case_no'])) {
            $results = EmAppeal::orderby('id', 'desc')->where('next_date', date('Y-m-d', strtotime(now())))->where('case_no','=',$_GET['case_no'])->paginate(5);
        }
        // return $results->appealCitizens;
        $date=date($request->date);
        $caseStatus = 1;
        // $userRole=Session::get('userRole');
        $userRole=Auth::user()->role_id;
        $gcoUserName='';
        if($userRole=='GCO'){
            // $gcoUserName=Session::get('userInfo')->username;
            $gcoUserName=Auth::user()->username;
        }
        $page_title  = ' শুনানির তারিখ হয়েছে এমন মামলার তালিকা';
        // return $results;
        //return view('appealList.appeallist')->with('date',$date);
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus', 'page_title', 'results'));
    }

    public function appealData(Request $request)
    {
        $usersPermissions = Session::get('userPermissions');
        $appeals=AppealRepository::getAppealListBySearchParam($request);

        return response()->json([
            'data' => $appeals,
            'userPermissions' => $usersPermissions,
            'userName'=>Session::get('userInfo')->username

        ]);
    }

    public function closedList(Request $request)
    {
        $date=date($request->date);
        $caseStatus = 3;
        $userRole=Session::get('userRole');
        $gcoUserName='';
        if($userRole=='GCO'){
            $gcoUserName=Session::get('userInfo')->username;
        }
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus'));

    }

    public function postponedList(Request $request)
    {
        $date=date($request->date);
        $caseStatus = 2;
        $userRole=Session::get('userRole');
        $gcoUserName='';
        if($userRole=='GCO'){
            $gcoUserName=Session::get('userInfo')->username;
        }
        return view('citizenAppealList.appealCasewiseList', compact('date','gcoUserName','caseStatus'));
    }
}
