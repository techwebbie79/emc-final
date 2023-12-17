<?php

namespace App\Repositories;


use App\Models\Appeal;
use App\Models\LawBroken;
use App\Models\RaiOrder;
use App\Services\AdminAppServices;
use App\Services\DataConversionService;
use App\Services\ProjapotiServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\EmAppeal;
use App\Models\EmInvestigator;
use App\Models\EmCitizen;
use App\Models\User;

class InvestigatorRepository
{
    public static function multiexplode($delimiters, $string)
    {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }

    /*public static function checkAppealExist($appealId){
        if(isset($appealId)){
            $appeal=EmInvestigator::select('id')->where('appeal_id', $appealId)->first();
        }else{
            $appeal=new EmInvestigator();
        }
        return $appeal;
    }*/

    public static function storeInvestigator($appealID, $investigatorInfo){

        
        $user = globalUserInfo();
        try {
            $investigatorID=EmInvestigator::updateOrCreate(
                [       
                    'appeal_id'=>$appealID,
                    'type_id'=> $investigatorInfo->investigatorType,
                    'nothi_id'=> $investigatorInfo->nothiID,
                    'name' => $investigatorInfo->investigatorName,
                    'organization'=>$investigatorInfo->investigatorInstituteName,
                    'designation'=>$investigatorInfo->investigatorDesignation,
                    'mobile'=>$investigatorInfo->investigatorMobile,
                    'email'=>$investigatorInfo->investigatorEmail,
                    'created_by'=>$user->id,
                    'updated_by'=>$user->id,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s')
                ]
            );
            
        } catch (\Exception $e) {
            dd($e);
            $investigatorID=null;
        }
        return $investigatorID;
    }


    public static function destroyAppeal($appealId){

        $appeal=EmAppeal::where('id',$appealId);
        $appeal->delete();
        return;
    }






}
