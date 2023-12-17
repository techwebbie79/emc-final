<?php


namespace App\Repositories;


use App\Models\EmAppealCitizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class AppealCitizenRepository
{
    public static function storeAppealCitizen($citizenId,$appealId,$citizenTypeId){
        $user = globalUserInfo();
        $transactionStatus=false;
        $appealCitizen=self::getAppealCitizenByAppealIdAndCitizenId($appealId,$citizenId,$citizenTypeId);
        //dd($citizenId);
        if($appealCitizen == null){
            $appealCitizen=new EmAppealCitizen();
        }
       // dd($appealCitizen);
        $appealCitizen->appeal_id=$appealId;
        $appealCitizen->citizen_id=$citizenId;
        $appealCitizen->citizen_type_id=$citizenTypeId;
        $appealCitizen->created_at=date('Y-m-d H:i:s');
        $appealCitizen->created_by=$user->id;
        $appealCitizen->updated_at=date('Y-m-d H:i:s');
        $appealCitizen->updated_by=$user->id;
        if($appealCitizen->save()){
            // dd($appealCitizen);
            $transactionStatus=true;
        };
        return $transactionStatus;
    }

    public static function destroyAppealCitizen($appealId){
        $citizen=array();
        $i=0;
        $appealCitizens=EmAppealCitizen::where('appeal_id',$appealId)->get();
        foreach ($appealCitizens as $appealCitizen){
            $citizen[$i]=$appealCitizen->citizen_id;
            $appealCitizen->delete();
            $i++;
        }

        return $citizen;
    }
    public static function getAppealCitizenByAppealIdAndCitizenId($appealId,$citizenId,$citizenTypeId){
       
        $appealCitizen=EmAppealCitizen::where('appeal_id', $appealId)
        ->where('citizen_id', $citizenId)
        ->where('citizen_type_id', $citizenTypeId)
        ->first();
        return $appealCitizen;
    }

    public static function checkAppealCitizenExist($citizen_id){
        if(isset($citizen_id)){
            $citizen = EmAppealCitizen::where('citizen_id', $citizen_id)->first();
        }else{
            $citizen=new EmAppealCitizen();
        }
        // dd($citizen);
        return $citizen;
    }
    public static function checkAppealCitizenExistByAppelCitizen($appealId, $citizen_id){
        $appealCitizen = EmAppealCitizen::where('citizen_id', $citizen_id)->where('appeal_id', $appealId);
        return $appealCitizen;
    }


}
