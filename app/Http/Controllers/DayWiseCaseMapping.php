<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DayWiseCaseMapping extends Controller
{
    public function index()
    {
        $all_em_court_with_district=Court::where('district_id',user_district())->where('level',0)->where('status',1)->get();
        $all_em_with_district=DB::table('users')->join('office','users.office_id','office.id')->where('office.district_id',user_district())->where('users.role_id',27)->where('users.doptor_user_active',1)->select('users.id','users.name','users.court_id','users.days_active')->get();
        
        $page_title='Day Wise Case Mapping';
        $data=[
             'page_title'=>$page_title,
             'all_em_court_with_district'=>$all_em_court_with_district,
             'all_em_with_district'=>$all_em_with_district
        ];

        return view('dayWiseMapping.index')->with($data);
    }
    public function store(Request $request)
    { 
      //dd($request);
      
      foreach($request->user_id as $key=>$user_id)
      {
        $day_value_str='';
         if(isset($request->day_check)&& !empty($request->day_check))
         {
            if(isset($request->day_check[$key]) && !empty($request->day_check[$key]))
            {
                $day_value_str=implode(",", $request->day_check[$key]);
            }else{
                $day_value_str=null;
            } 
            
         }else
         {
            $day_value_str=null;
         }
         $data=['court_id'=>$request->court[$key],'days_active'=>$day_value_str];
         DB::table('users')->where('id',$user_id)->update($data);
         
      }
      return redirect()->back();
    }
}
