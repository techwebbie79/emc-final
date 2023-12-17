<?php

namespace App\Repositories;


use App\Models\Appeal;
use App\Models\EmAppealCitizen;
use App\Models\EmCitizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class CitizenRepository
{
    public static function storeCitizen($appealInfo,$appealId){
        // dd($appealInfo->lawyer);
        $user = globalUserInfo();
        if (isset($appealInfo->lawyer)) {
           $citizenList['lawyer'] = $appealInfo->lawyer;
        }
        // dd($user);
        if($appealInfo->caseEntryType == 'others'){
            // dd(1);
            $citizenList['applicants'] = $appealInfo->applicant;
        }
        if($appealInfo->lawSection == 1){
            $citizenList['victim'] = $appealInfo->victim;
        }

        // $citizenList['defaulter'] = $appealInfo->defaulter;
        $multiCtz['defaulter'] = $appealInfo->defaulter;
        $multiCtz['witness'] = $appealInfo->witness;
        $transactionStatus=true;
        $storeId = [];

       // dd($citizenList);

        // dd($multiCtz);
        // $citizenArray = self::getCitizenByAppealId($appealId);
        // // dd($citizenArray);
        // foreach ($citizenArray as $citizen) {
        //     $citizen = self::getCitizenByCitizenId($citizen->id);
        //     if($citizen->delete()){
        //         $appealCitizen = self::getAppealCitizenByCitizenId($citizen->id);
        //         $appealCitizen->delete();
        //     }
        // }
        function storeCtg($appealId, $reqCitizen){
            $user = globalUserInfo();
            $citizen = CitizenRepository::checkCitizenExist($reqCitizen['id'],$reqCitizen['nid']);
            // dd($reqCitizen['type']);
           // dd($citizen);

            $citizen->citizen_name = $reqCitizen['name'];
            $citizen->citizen_phone_no = $reqCitizen['phn'];
            $citizen->citizen_NID = $reqCitizen['nid'];
            $citizen->citizen_gender = isset($reqCitizen['gender']) ? $reqCitizen['gender'] : null;
            $citizen->father = $reqCitizen['father'];
            $citizen->mother = $reqCitizen['mother'];
            $citizen->designation = $reqCitizen['designation'];
            $citizen->organization = $reqCitizen['organization'];
            $citizen->organization_id = $reqCitizen['organization_id'];
            $citizen->present_address = $reqCitizen['presentAddress'];
            $citizen->email = $reqCitizen['email'];
            $citizen->thana = $reqCitizen['thana'];
            $citizen->upazilla = $reqCitizen['upazilla'];
            $citizen->age = $reqCitizen['age'];
            $citizen->created_at = date('Y-m-d H:i:s');
            $citizen->updated_at = date('Y-m-d H:i:s');
            $citizen->created_by = $user->id;
            $citizen->updated_by = $user->id;
            return $citizen;
        }

        $i=1;
        foreach ($citizenList as $reqCitizen) {
            
            $citizen = storeCtg($appealId,  $reqCitizen);
            //dd( $citizen);
            if ($citizen->save()) {
                $storeId[$i] = $citizen;
                $i++;
                $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $reqCitizen['type']);
                if (!$transactionStatus) {
                    $transactionStatus = false;
                    break;
                }
            } else {
                $transactionStatus = false;
                break;
            }
            if($transactionStatus == false)
                break;
        }

        if($appealInfo->caseEntryType == 'own'){
            if($user->citizen_id != null){
                $userCtgId = $user->citizen_id;
            } else{
                $AuthCtg=new EmCitizen();
                $AuthCtg->citizen_name = $user->name;
                $AuthCtg->citizen_phone_no = $user->mobile_no;
                // $AuthCtg->citizen_NID = $user->nid;
                // $AuthCtg->citizen_gender = $user->gender;
                // $AuthCtg->father = $user->father;
                // $AuthCtg->mother = $user->mother;
                // $AuthCtg->designation = $user->designation;
                // $AuthCtg->organization = $user->organization;
                // $AuthCtg->present_address = $user->presentAddress;
                $AuthCtg->email = $user->email;
                // $AuthCtg->thana = $user->thana;
                // $AuthCtg->upazilla = $user->upazilla;
                // $AuthCtg->age = $user->age;
                $AuthCtg->created_at = date('Y-m-d H:i:s');
                $AuthCtg->updated_at = date('Y-m-d H:i:s');
                $AuthCtg->created_by = $user->id;
                $AuthCtg->updated_by = $user->id;
                $AuthCtg->save();
                $userCtgId = $AuthCtg->id;
            }

            $transactionStatus = AppealCitizenRepository::storeAppealCitizen($userCtgId, $appealId, 1);
            if (!$transactionStatus) {
                $transactionStatus = false;
            }
        }

        // return $multiCtz;
        foreach($multiCtz as $nominees){
            for ($i=0; $i<sizeof($nominees['name']); $i++) {
                $citizen = CitizenRepository::checkCitizenExist($nominees['id'][$i],$nominees['nid'][$i]);
            // return $multiCtz;
                // $citizen = new EmCitizen();

                $citizen->citizen_name = isset($nominees['name'][$i]) ? $nominees['name'][$i] : NULL ;
                $citizen->citizen_phone_no = isset($nominees['phn'][$i]) ? $nominees['phn'][$i] : NULL;
                $citizen->citizen_NID = isset($nominees['nid'][$i]) ? $nominees['nid'][$i] : NULL;
                $citizen->citizen_gender = isset($nominees['gender'][$i]) ? $nominees['gender'][$i] : NULL;
                $citizen->father = isset($nominees['father'][$i]) ? $nominees['father'][$i] : NULL;
                $citizen->mother = isset($nominees['mother'][$i]) ? $nominees['mother'][$i] : NULL;
                // $citizen->designation = isset($nominees['designation'][$i]);
                // $citizen->organization = isset($nominees['organization'][$i]);
                $citizen->present_address = isset($nominees['presentAddress'][$i]) ? $nominees['presentAddress'][$i] : NULL;
                $citizen->email = isset($nominees['email'][$i]) ? $nominees['email'][$i] : NULL;
                $citizen->thana = isset($nominees['thana'][$i]) ? $nominees['thana'][$i] : NULL;
                $citizen->upazilla = isset($nominees['upazilla'][$i]) ? $nominees['upazilla'][$i] : NULL;
                $citizen->age = isset($nominees['age'][$i]) ? $nominees['age'][$i] : NULL;

                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by =  $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;


                    // dd($citizen);
                if ($citizen->save()) {
                    $storeId[$i.'1'] = $citizen;
                    $transactionStatus = AppealCitizenRepository::storeAppealCitizen($citizen->id, $appealId, $nominees['type'][$i]);
                    if (!$transactionStatus) {
                        $transactionStatus = false;
                        break;
                    }
                } else {
                    $transactionStatus = false;
                    break;
                }

                if($transactionStatus == false)
                    break;

            }
        }

        // dd($storeId);

        return $transactionStatus;
    }

    public static function getCitizenByCitizenId($citizenId){
        $citizen=EmCitizen::find($citizenId);
        return $citizen;
    }
    public static function getAppealCitizenByCitizenId($citizenId){
        $appealCitizen=EmAppealCitizen::find($citizenId);
        return $appealCitizen;
    }
    public static function getCitizenByAppealId($appealId){

        // $citizen=DB::connection('appeal')
        //     ->select(DB::raw(
        //         "SELECT * FROM citizens
        //          JOIN appeal_citizens ac ON ac.citizen_id=citizens.id
        //          WHERE ac.appeal_id =$appealId"
        //     ));

        $citizens = DB::table('em_citizens')
        ->join('em_appeal_citizens as ac', 'ac.citizen_id', '=', 'em_citizens.id')
        ->where('ac.appeal_id', $appealId)
        ->get();

        return $citizens;
    }

    public static function destroyCitizen($citizenIds){

        foreach ($citizenIds as $citizenId){
            $citizen=EmCitizen::where('id',$citizenId);
            $citizen->delete();
        }

        return;
    }

    public static function getOffenderLawyerCitizen($appealId){
        $lawerCitizen=[];
        $offenderCitizen=[];

        $appeal = Appeal::find($appealId);
        //prepare applicant citizen,lawyer citizen,offender citizen
        $citizens=$appeal->appealCitizens;
        foreach ($citizens as $citizen){
            $citizenTypes = $citizen->citizenType;
            foreach ($citizenTypes as $citizenType){
                if($citizenType->id==1){
                    $offenderCitizen=$citizen;
                }
                if($citizenType->id==4){
                    $lawerCitizen=$citizen;
                }
            }
        }

        return ['offenderCitizen'=>$offenderCitizen,
                'lawerCitizen'=>$lawerCitizen ];

    }
    public static function checkCitizenExist($citizen_id,$nid){
        
        if(isset($citizen_id)){
            $citizen=EmCitizen::find($citizen_id);
        }
        elseif(isset($nid))
        {
            $citizen=EmCitizen::where('citizen_NID',$nid)->first();
            
        }

        if(isset($citizen))
        {
            return $citizen;
        } 
        else{
            $citizen=new EmCitizen();
            return $citizen;
        }
         //dd($citizen);
    }

    

}