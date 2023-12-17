<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\ZoomRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class CitizenCaseCountRepository
{
    public static function total_running_case_count_citizen()
    {
      
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1,2])
            ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();
            
            return ['total_count'=>count($appeal_ids_from_db),'appeal_id_array'=>''];
    }
    public static function total_case_count_citizen()
    {
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1,2])
            ->whereIn('em_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DM'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();
            
            $appeal_id_array=[];
            $count=0;
            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
                $count++; 
            }
           
         return ['total_count'=>$count,'appeal_id_array'=>$appeal_id_array];
      
    }
    public static function total_pending_case_count_citizen()
    {
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1])
            ->whereIn('em_appeals.appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();
      
            // $appeal_id_array=[];
            // $count=0;
            // foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            //     array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
            //     $count++; 
            // }
           
            return ['total_count'=>count($appeal_ids_from_db),'appeal_id_array'=>''];
      
    }
    public static function total_completed_case_count_citizen()
    {
      
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1,2])
            ->whereIn('em_appeals.appeal_status', ['CLOSED'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();

           
        return ['total_count'=>count($appeal_ids_from_db),'appeal_id_array'=>''];
    }
    public static function total_running_case_count_advocate()
    {
      
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4,7])
            ->whereIn('em_appeals.appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();
            
            return ['total_count'=>count($appeal_ids_from_db),'appeal_id_array'=>''];
    }
    public static function total_case_count_advocate()
    {
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4,7])
            ->whereIn('em_appeals.appeal_status', ['CLOSED', 'ON_TRIAL', 'ON_TRIAL_DM'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();
            
            $appeal_id_array=[];
            $count=0;
            foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
                array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
                $count++; 
            }
           
         return ['total_count'=>$count,'appeal_id_array'=>$appeal_id_array];
      
    }
    public static function total_pending_case_count_advocate()
    {
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4,7])
            ->whereIn('em_appeals.appeal_status', ['SEND_TO_ASST_EM', 'SEND_TO_EM', 'SEND_TO_DM', 'SEND_TO_ASST_DM'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();
      
            // $appeal_id_array=[];
            // $count=0;
            // foreach ($appeal_ids_from_db as $appeal_ids_from_db_single) {
            //     array_push($appeal_id_array, $appeal_ids_from_db_single->appeal_id);
            //     $count++; 
            // }
           
            return ['total_count'=>count($appeal_ids_from_db),'appeal_id_array'=>''];
      
    }
    public static function total_completed_case_count_advocate()
    {
      
      $appeal_ids_from_db = DB::table('em_appeal_citizens')
            ->join('em_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->join('em_appeals', 'em_appeal_citizens.appeal_id', 'em_appeals.id')
            ->where('em_citizens.citizen_NID', '=', globalUserInfo()->citizen_nid)
            ->whereIn('em_appeal_citizens.citizen_type_id', [1, 2, 4,7])
            ->whereIn('em_appeals.appeal_status', ['CLOSED'])
            ->select('em_appeal_citizens.appeal_id')
            ->get();

           
        return ['total_count'=>count($appeal_ids_from_db),'appeal_id_array'=>''];
    }
}