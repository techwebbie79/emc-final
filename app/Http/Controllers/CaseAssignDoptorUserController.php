<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\NDoptorRepository;

class CaseAssignDoptorUserController extends Controller
{
    public function all_user_list_from_doptor_segmented_adm_case_assign($appeal_id)
    {
        $office_id = globalUserInfo()->doptor_office_id;

        $username = globalUserInfo()->username;
        $get_token_response = NDoptorRepository::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, $office_id);

            if ($response_after_decode['status'] == 'success') {
                $everything = NDoptorRepository::all_user_list_from_doptor_for_adc($response_after_decode['data'], decrypt($appeal_id));

                $list_of_others = json_decode($everything, true)['list_of_all'];

                $data['list_of_ADC'] = $list_of_others;

                $data['available_role'] = NDoptorRepository::rolelist_district();
                $data['office_id'] = $office_id;
                $data['available_court'] = NDoptorRepository::courtlist_district();
                $data['courtlist_distrcit_all'] = NDoptorRepository::courtlist_distrcit_all();

                $data['appeal_id'] = decrypt($appeal_id);

                $case_details = DB::table('em_appeals')
                    ->where('id', '=', decrypt($appeal_id))
                    ->get();

                $data['case_details'] = $case_details;

                $all_assigned_cases = DB::table('em_appeals')
                    ->join('users', 'em_appeals.assigned_adc_id', '=', 'users.id')
                    ->where('em_appeals.is_assigned', '=', 1)
                    ->select('users.username', 'em_appeals.case_no', 'em_appeals.id')
                    ->get();
                 
               

                $data['all_assigned_cases'] = $all_assigned_cases;
                $case_name = ' ';
                foreach ($case_details as $case_detail_single) {
                    $case_name = $case_detail_single->case_no;
                }
                $data['page_title'] = 'অতিরিক্ত জেলা প্রশাসক থেকে ' . $case_name . ' মামলার জন্য নির্বাচন করুন';

                return view('case_assign.user_list_adc_case_assign')->with($data);
            }
        } else {
            return redirect('/doptor/user/check')->with('success', 'you are not Doptor User');
        }
    }

    public function all_user_list_from_doptor_segmented_adm_case_assign_search($appeal_id, Request $request)
    {
        $office_id = globalUserInfo()->doptor_office_id;
        $list_of_others_fianl = [];
        $username = globalUserInfo()->username;
        $get_token_response = NDoptorRepository::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepository::get_employee_list_by_office($token, $office_id);

            if ($response_after_decode['status'] == 'success') {
                $everything = NDoptorRepository::all_user_list_from_doptor_for_adc($response_after_decode['data'], decrypt($appeal_id));

                $list_of_all = json_decode($everything, true)['list_of_all'];

                $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  অতিরিক্ত জেলা ম্যাজিস্ট্রেট';

                $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];

                foreach ($search_keys as $value) {
                    $search_by_key = NDoptorRepository::search_revisions($list_of_all, $request->search_key, $value);

                    if (!empty($search_by_key)) {
                        $list_of_others = [];

                        foreach ($search_by_key as $list) {
                            array_push($list_of_others, $list_of_all[$list]);
                        }
                        $list_of_others_fianl = $list_of_others;
                        break;
                    }
                }

                $data['list_of_ADC'] = $list_of_others_fianl;
                $data['available_role'] = NDoptorRepository::rolelist_district();
                $data['office_id'] = $office_id;
                $data['available_court'] = NDoptorRepository::courtlist_district();
                $data['courtlist_distrcit_all'] = NDoptorRepository::courtlist_distrcit_all();
                $data['appeal_id'] = decrypt($appeal_id);
                $case_details = DB::table('em_appeals')
                    ->where('id', '=', decrypt($appeal_id))
                    ->get();

                $data['case_details'] = $case_details;

                $all_assigned_cases = DB::table('em_appeals')
                    ->join('users', 'em_appeals.assigned_adc_id', '=', 'users.id')
                    ->where('em_appeals.is_assigned', '=', 1)
                    ->select('users.username', 'em_appeals.case_no', 'em_appeals.id')
                    ->get();

                $data['all_assigned_cases'] = $all_assigned_cases;
                $case_name = ' ';
                foreach ($case_details as $case_detail_single) {
                    $case_name = $case_detail_single->case_no;
                }
                $data['page_title'] = 'অতিরিক্ত জেলা প্রশাসক থেকে ' . $case_name . ' মামলার জন্য নির্বাচন করুন';

                return view('case_assign.user_list_adc_case_assign')->with($data);
            }
        }
        return redirect('/doptor/user/check')->with('success', 'you are not Doptor User');
    }
}
