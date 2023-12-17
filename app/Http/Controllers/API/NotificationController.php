<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class NotificationController extends BaseController
{

    public function notify()
    {

        // return $this->sendResponse('minar', 'Dashboard Counter.');
        $data['notification_count'] = 0;
        // $data['case_status'] = [];
            $officeInfo = user_office_info();
            $roleID = Auth::user()->role_id;
            $districtID = DB::table('office')
            ->select('district_id')->where('id',Auth::user()->office_id)
            ->first()->district_id;

            if( $roleID == 9 || $roleID == 10 || $roleID == 11 ){

                $data['case_status'] = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.upazila_id','=', $officeInfo->upazila_id)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();

            } elseif( $roleID == 14 ) {
                $data['case_status'] = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();

            } elseif( $roleID == 12 ) {
                $moujaIDs = DB::table('mouja_ulo')->where('ulo_office_id', Auth::user()->office_id)->pluck('mouja_id');
                $data['case_status'] = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->whereIn('case_register.mouja_id', $moujaIDs)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
            } elseif( $roleID == 2 ) {
                $data['total_sf'] = DB::table('case_register')
                    ->where('is_sf', 1)
                    ->where('status', 1)
                    ->get();
                $data['total_sf_count'] = $data['total_sf']->count();

                $data['TotalCaseResult'] = DB::table('case_register')
                    ->where('status', '!=', 1)
                    ->get();
                    $data['TotalCaseResultCount'] = $data['TotalCaseResult']->count();

                $data['TotalCaseHearing'] = DB::table('case_hearing')
                    ->distinct()
                    ->join('case_register', 'case_hearing.case_id', '=', 'case_register.id')
                    ->where('case_register.status', 1)
                    ->select('case_id')
                    ->get();
                    $data['TotalCaseHearingCount'] = $data['TotalCaseHearing']->count();
                $data['notification_count'] = $data['TotalCaseResultCount'] + $data['TotalCaseHearingCount'] + $data['total_sf_count'];

            } else {
                //5,6,7,8,13
                $data['case_status'] = DB::table('case_register')
                    ->select('case_register.cs_id', 'case_status.status_name', DB::raw('COUNT(case_register.id) as total_case'))
                    ->leftJoin('case_status', 'case_register.cs_id', '=', 'case_status.id')
                    ->groupBy('case_register.cs_id')
                    ->where('case_register.district_id','=', $officeInfo->district_id)
                    ->where('case_register.action_user_group_id', $roleID)
                    ->get();
                // dd($case_status);

            }

            if( $roleID != 2 ){
               foreach ($data['case_status'] as $row){
                $data['notification_count'] += $row->total_case;
               }
            }
            return $this->sendResponse($data, 'Case Notification for all');


    }
}
