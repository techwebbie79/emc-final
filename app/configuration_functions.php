<?php

use Illuminate\Support\Facades\DB;

if (!function_exists('mobile_first_registration')) {
    function mobile_first_registration()
    {
        return true;
    }
}

if (!function_exists('citizen_auth_menu')) {
    function citizen_auth_menu()
    {
        if (!mobile_first_registration()) {

            return true;
        } elseif (mobile_first_registration() && globalUserInfo()->is_verified_account == 1 && in_array(globalUserInfo()->role_id, [20, 36])) {
            return true;
        } elseif (mobile_first_registration() && globalUserInfo()->is_verified_account == 0 && !in_array(globalUserInfo()->role_id, [20, 36])) {
            return true;
        } elseif (mobile_first_registration() && globalUserInfo()->is_verified_account == 0 && globalUserInfo()->is_cdap_user == 1 && in_array(globalUserInfo()->role_id, [20, 36])) {
            return true;
        } else {
            return false;
        }
    }
}
if (!function_exists('pull_from_api_not_local_dummi')) {
    function pull_from_api_not_local_dummi()
    {
        return false;
    }
}
if(!function_exists('get_the_applicant_by_id'))
{
    function get_the_applicant_by_id($appealId)
    {
        $applicantcitizen_name=DB::table('em_appeals')
        ->join('em_appeal_citizens','em_appeals.id','=','em_appeal_citizens.appeal_id')
        ->join('em_citizens','em_citizens.id','=','em_appeal_citizens.citizen_id')
        ->where('em_appeals.id','=',$appealId)
        ->where('em_appeal_citizens.citizen_type_id','=',1)
        ->select('em_citizens.citizen_name')
        ->first()->citizen_name;

        return $applicantcitizen_name;
    }
}