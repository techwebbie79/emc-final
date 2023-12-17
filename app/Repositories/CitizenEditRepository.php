<?php

namespace App\Repositories;

use App\Models\Appeal;
use App\Models\EmAppealCitizen;
use App\Models\EmCitizen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CitizenEditRepository
{
    public static function storeatEditCitizen($requestInfo)
    {
        $user = globalUserInfo();

        $requestInfo->defaulter['name'];
        foreach ($requestInfo->defaulter['id'] as $key => $value) {
           
            $checkExitsCitizen = self::checkExitsCitizen($value, $requestInfo->defaulter['nid'][$key]);
            //dd($requestInfo->defaulter['nid'][$key]);
            //dd($checkExitsCitizen);
            if (!empty($checkExitsCitizen['exits_citizen_id_by_nid'])) {
                $citizen = $checkExitsCitizen['citizen_model'];
                $citizen->citizen_name = isset($requestInfo->defaulter['name'][$key]) ? $requestInfo->defaulter['name'][$key] : null;
                $citizen->citizen_phone_no = isset($requestInfo->defaulter['phn'][$key]) ? $requestInfo->defaulter['phn'][$key] : null;
                $citizen->citizen_NID = isset($requestInfo->defaulter['nid'][$key]) ? $requestInfo->defaulter['nid'][$key] : null;
                $citizen->citizen_gender = isset($requestInfo->defaulter['gender'][$key]) ? $requestInfo->defaulter['gender'][$key] : null;
                $citizen->father = isset($requestInfo->defaulter['father'][$key]) ? $requestInfo->defaulter['father'][$key] : null;
                $citizen->mother = isset($requestInfo->defaulter['mother'][$key]) ? $requestInfo->defaulter['mother'][$key] : null;
                // $citizen->designation = isset($requestInfo->defaulter['designation'][$key]);
                // $citizen->organization = isset($requestInfo->defaulter['organization'][$key]);
                $citizen->present_address = isset($requestInfo->defaulter['presentAddress'][$key]) ? $requestInfo->defaulter['presentAddress'][$key] : null;
                $citizen->email = isset($requestInfo->defaulter['email'][$key]) ? $requestInfo->defaulter['email'][$key] : null;
                $citizen->thana = isset($requestInfo->defaulter['thana'][$key]) ? $requestInfo->defaulter['thana'][$key] : null;
                $citizen->upazilla = isset($requestInfo->defaulter['upazilla'][$key]) ? $requestInfo->defaulter['upazilla'][$key] : null;
                $citizen->age = isset($requestInfo->defaulter['age'][$key]) ? $requestInfo->defaulter['age'][$key] : null;

                //$citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                //$citizen->created_by = $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;

                $citizen->save();

                DB::table('em_appeal_citizens')
                    ->where([
                        'appeal_id' => $requestInfo->appealId,
                        'citizen_type_id' => 2,
                        'citizen_id' => $checkExitsCitizen['old_citizen_id_from_id'],
                    ])->update([
                        'citizen_id' => $citizen->id,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'created_by'=>$user->id,
                        'updated_by'=>$user->id
                    ]);

                if($checkExitsCitizen['will_citizen_delete'])
                {
                   DB::table('em_citizens')->where('id',$checkExitsCitizen['old_citizen_id_from_id'])->delete();
                }
                    
            } else {
                $citizen = $checkExitsCitizen['citizen_model'];
                $citizen->citizen_name = isset($requestInfo->defaulter['name'][$key]) ? $requestInfo->defaulter['name'][$key] : null;
                $citizen->citizen_phone_no = isset($requestInfo->defaulter['phn'][$key]) ? $requestInfo->defaulter['phn'][$key] : null;
                $citizen->citizen_NID = isset($requestInfo->defaulter['nid'][$key]) ? $requestInfo->defaulter['nid'][$key] : null;
                $citizen->citizen_gender = isset($requestInfo->defaulter['gender'][$key]) ? $requestInfo->defaulter['gender'][$key] : null;
                $citizen->father = isset($requestInfo->defaulter['father'][$key]) ? $requestInfo->defaulter['father'][$key] : null;
                $citizen->mother = isset($requestInfo->defaulter['mother'][$key]) ? $requestInfo->defaulter['mother'][$key] : null;
                // $citizen->designation = isset($requestInfo->defaulter['designation'][$key]);
                // $citizen->organization = isset($requestInfo->defaulter['organization'][$key]);
                $citizen->present_address = isset($requestInfo->defaulter['presentAddress'][$key]) ? $requestInfo->defaulter['presentAddress'][$key] : null;
                $citizen->email = isset($requestInfo->defaulter['email'][$key]) ? $requestInfo->defaulter['email'][$key] : null;
                $citizen->thana = isset($requestInfo->defaulter['thana'][$key]) ? $requestInfo->defaulter['thana'][$key] : null;
                $citizen->upazilla = isset($requestInfo->defaulter['upazilla'][$key]) ? $requestInfo->defaulter['upazilla'][$key] : null;
                $citizen->age = isset($requestInfo->defaulter['age'][$key]) ? $requestInfo->defaulter['age'][$key] : null;

                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;

                $citizen->save();

                DB::table('em_appeal_citizens')
                    ->where([
                        'appeal_id' => $requestInfo->appealId,
                        'citizen_type_id' => 2,
                        'citizen_id' => $checkExitsCitizen['old_citizen_id_from_id'],
                    ])
                    ->update(['citizen_id' => $citizen->id, 
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$user->id,
                    'updated_by'=>$user->id
                ]);
            }
        }
        foreach ($requestInfo->defaulerWithness['nid'] as $key => $value) {
           // dd($requestInfo->defaulerWithness['presentAddress'][$key]);
            if (!empty($value)) {
                $citizen=self::checkExitsCitizenBYNID($value);
                $citizen->citizen_name = isset($requestInfo->defaulerWithness['name'][$key]) ? $requestInfo->defaulerWithness['name'][$key] : null;
                $citizen->citizen_phone_no = isset($requestInfo->defaulerWithness['phn'][$key]) ? $requestInfo->defaulerWithness['phn'][$key] : null;
                $citizen->citizen_NID = isset($requestInfo->defaulerWithness['nid'][$key]) ? $requestInfo->defaulerWithness['nid'][$key] : null;
                $citizen->citizen_gender = isset($requestInfo->defaulerWithness['gender'][$key]) ? $requestInfo->defaulerWithness['gender'][$key] : null;
                $citizen->father = isset($requestInfo->defaulerWithness['father'][$key]) ? $requestInfo->defaulerWithness['father'][$key] : null;
                $citizen->mother = isset($requestInfo->defaulerWithness['mother'][$key]) ? $requestInfo->defaulerWithness['mother'][$key] : null;
                // $citizen->designation = isset($requestInfo->defaulerWithness['designation'][$key]);
                // $citizen->organization = isset($requestInfo->defaulerWithness['organization'][$key]);
                $citizen->present_address = isset($requestInfo->defaulerWithness['presentAddress'][$key]) ? $requestInfo->defaulerWithness['presentAddress'][$key] : null;
                //$citizen->email = isset($requestInfo->defaulerWithness['email'][$key]) ? $requestInfo->defaulerWithness['email'][$key] : null;
                $citizen->thana = isset($requestInfo->defaulerWithness['thana'][$key]) ? $requestInfo->defaulerWithness['thana'][$key] : null;
                $citizen->upazilla = isset($requestInfo->defaulerWithness['upazilla'][$key]) ? $requestInfo->defaulerWithness['upazilla'][$key] : null;
                $citizen->age = isset($requestInfo->defaulerWithness['age'][$key]) ? $requestInfo->defaulerWithness['age'][$key] : null;

                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;

                $citizen->save();

                DB::table('em_appeal_citizens')
                ->updateOrInsert(
                    [
                     'appeal_id' => $requestInfo->appealId,
                     'citizen_type_id' => 6,
                     'citizen_id' =>$citizen->id,
                    ],
                    ['citizen_id' =>$citizen->id, 
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$user->id,
                    'updated_by'=>$user->id]
                );
            }
        }
        
        foreach ($requestInfo->defaulerLawyer['nid'] as $key => $value) {
            if (!empty($value)) {
                $citizen=self::checkExitsCitizenBYNID($value);
                $citizen->citizen_name = isset($requestInfo->defaulerLawyer['name'][$key]) ? $requestInfo->defaulerLawyer['name'][$key] : null;
                $citizen->citizen_phone_no = isset($requestInfo->defaulerLawyer['phn'][$key]) ? $requestInfo->defaulerLawyer['phn'][$key] : null;
                $citizen->citizen_NID = isset($requestInfo->defaulerLawyer['nid'][$key]) ? $requestInfo->defaulerLawyer['nid'][$key] : null;
                $citizen->citizen_gender = isset($requestInfo->defaulerLawyer['gender'][$key]) ? $requestInfo->defaulerLawyer['gender'][$key] : null;
                $citizen->father = isset($requestInfo->defaulerLawyer['father'][$key]) ? $requestInfo->defaulerLawyer['father'][$key] : null;
                $citizen->mother = isset($requestInfo->defaulerLawyer['mother'][$key]) ? $requestInfo->defaulerLawyer['mother'][$key] : null;
                $citizen->designation = isset($requestInfo->defaulerLawyer['designation'][$key]) ? $requestInfo->defaulerLawyer['designation'][$key] :null;
                $citizen->organization_id = isset($requestInfo->defaulerLawyer['organization_id'][$key]) ? $requestInfo->defaulerLawyer['organization_id'][$key] : null;
                $citizen->organization = isset($requestInfo->defaulerLawyer['organization'][$key]) ? $requestInfo->defaulerLawyer['organization'][$key] : null;  	
                $citizen->present_address = isset($requestInfo->defaulerLawyer['presentAddress'][$key]) ? $requestInfo->defaulerLawyer['presentAddress'][$key] : null;
                $citizen->email = isset($requestInfo->defaulerLawyer['email'][$key]) ? $requestInfo->defaulerLawyer['email'][$key] : null;
                $citizen->thana = isset($requestInfo->defaulerLawyer['thana'][$key]) ? $requestInfo->defaulerLawyer['thana'][$key] : null;
                $citizen->upazilla = isset($requestInfo->defaulerLawyer['upazilla'][$key]) ? $requestInfo->defaulerLawyer['upazilla'][$key] : null;
                $citizen->age = isset($requestInfo->defaulerLawyer['age'][$key]) ? $requestInfo->defaulerLawyer['age'][$key] : null;

                $citizen->created_at = date('Y-m-d H:i:s');
                $citizen->updated_at = date('Y-m-d H:i:s');
                // $citizen->created_by = Session::get('userInfo')->username;
                $citizen->created_by = $user->id;
                // $citizen->updated_by = Session::get('userInfo')->username;
                $citizen->updated_by = $user->id;

                $citizen->save();

                DB::table('em_appeal_citizens')
                ->updateOrInsert(
                    [
                     'appeal_id' => $requestInfo->appealId,
                     'citizen_type_id' => 7,
                     'citizen_id' =>$citizen->id,
                    ],
                    ['citizen_id' =>$citizen->id, 
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'created_by'=>$user->id,
                    'updated_by'=>$user->id]
                );
            }
        }


    }
    public static function checkExitsCitizen($citizen_id, $citizen_nid)
    {
       if (isset($citizen_nid)) {
            $citizen = EmCitizen::where('citizen_NID', $citizen_nid)->first();
            $citizen_by_both_nid_citizen_id = EmCitizen::where('citizen_NID', $citizen_nid)->where('id',$citizen_id)->first();

            if(isset($citizen_by_both_nid_citizen_id))
            {
                return [
                    'exits_citizen_id_by_nid' => $citizen_by_both_nid_citizen_id->id,
                    'old_citizen_id_from_id' => $citizen_id,
                    'citizen_model' => $citizen_by_both_nid_citizen_id,
                    'will_citizen_delete'=>false
                ];
            }
            elseif (isset($citizen)) {
                return [
                    'exits_citizen_id_by_nid' => $citizen->id,
                    'old_citizen_id_from_id' => $citizen_id,
                    'citizen_model' => $citizen,
                    'will_citizen_delete'=>true
                ];
            } else {
                $citizen = new EmCitizen();
                return [
                    'exits_citizen_id_by_nid' => null,
                    'old_citizen_id_from_id' => $citizen_id,
                    'citizen_model' => EmCitizen::find($citizen_id),
                    'will_citizen_delete'=>false
                ];
            }
        }else
        {
            $citizen = EmCitizen::where('citizen_NID', $citizen_nid)->first();
            return [
                'exits_citizen_id_by_nid' => null,
                'old_citizen_id_from_id' => $citizen_id,
                'citizen_model' => EmCitizen::find($citizen_id),
            ];

        }
    }
    public static function checkExitsCitizenBYNID($citizen_nid)
    {
        $citizen = EmCitizen::where('citizen_NID', $citizen_nid)->first();
        if (!empty($citizen)) {
            return $citizen;
        } else {
            $citizen = new EmCitizen();
            return $citizen;
        }
    }
}
