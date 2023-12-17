<?php

namespace App\Repositories;

use App\Appeal;

use App\Models\EmCitizenAttendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CitizenAttendanceRepository
{

    public static function saveCitizenAttendance($citizenAttendance){
        $transactionStatus=true;
        foreach ($citizenAttendance as $citizen) {
            if($citizen['id']!=null){
                $citizenAttendanceData = self::getCitizenAttendance($citizen['id']);
                $citizenAttendanceData->attendance = $citizen['attendance'];
            }else{
                $citizenAttendanceData = new EmCitizenAttendance();
                $citizenAttendanceData->appeal_id = $citizen['appealId'];
                $citizenAttendanceData->citizen_id = $citizen['citizenId'];
                $citizenAttendanceData->attendance_date = date('Y-m-d',strtotime($citizen['attendanceDate']));
                $citizenAttendanceData->attendance = $citizen['attendance'];
                $citizenAttendanceData->created_at = date('Y-m-d H:i:s');
                $citizenAttendanceData->created_by = globalUserInfo()->id;
                // $citizenAttendanceData->created_by = Session::get('userInfo')->username;
                $citizenAttendanceData->updated_at = date('Y-m-d H:i:s');
                $citizenAttendanceData->updated_by = globalUserInfo()->id;
                // $citizenAttendanceData->updated_by = Session::get('userInfo')->username;
            }
            if (!$citizenAttendanceData->save()) {
                $transactionStatus = false;
                break;
            }
        }
        return $transactionStatus;
    }
    public static function getCitizenAttendance($citizenAttendanceId){
        $citizenAttendance=EmCitizenAttendance::find($citizenAttendanceId);
        return $citizenAttendance;
    }
    public static function getCitizenAttendanceByParameter($appealId,$citizenId,$attendanceDate){
        // dd(EmCitizenAttendance::all());
        $citizenAttendances=EmCitizenAttendance::where('appeal_id',$appealId)
            ->where('citizen_id',$citizenId)
            ->where('attendance_date',$attendanceDate)
            ->first();
        return $citizenAttendances;
    }
    public static function deletCitizenAttendanceByPreviousCaseDate($attendanceDate,$appealId){
        $citizenAttendances=EmCitizenAttendance::where('attendance_date',$attendanceDate)->where('appeal_id',$appealId)->get();
        foreach ($citizenAttendances as $citizenAttendance){
            $citizenAttendance=EmCitizenAttendance::find($citizenAttendance->id);
            $citizenAttendance->delete();
        }
        return;
    }
    public static function getCitizenAttendanceByAppealId($appealId){

        $citizenAttendances=DB::connection('mysql')
            ->select(DB::raw(
                "select
                  c.citizen_name,
                  c.designation,
                  c.id as citizenId,
                  ca.id as citizenAttendanceId,
                  ca.attendance,
                  ca.attendance_date
                from em_citizen_attendances ca
                JOIN em_citizens c on c.id=ca.citizen_id
                where ca.appeal_id=$appealId;
                "
            ));
            // dd($citizenAttendances  );
            // $citizenAttendances = EmCitizenAttendance::all();
            // $citizenAttendances = EmCitizenAttendance::where('appeal_id', $appealId)->get();

        return $citizenAttendances;
    }

}
