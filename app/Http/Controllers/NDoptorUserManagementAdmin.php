<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Repositories\NDoptorRepositoryAdmin;

class NDoptorUserManagementAdmin extends Controller
{
    public function all_user_list_from_doptor_segmented($office_id)
    {
        $office_id = decrypt($office_id);

        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
        } else {
            $username = 100000006515;
        }

        $get_token_response = NDoptorRepositoryAdmin::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepositoryAdmin::get_employee_list_by_office($token, $office_id);

            if ($response_after_decode['status'] == 'success') {
                $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

                $list_of_all = json_decode($everything, true)['list_of_all'];

                $doptor_office_status_from_db = DB::table('doptor_offices')
                    ->where('office_id', '=', $office_id)
                    ->first();

                if ($doptor_office_status_from_db->office_layer_id == 21 && $doptor_office_status_from_db->office_origin_id == 15) {
                    $division_details = DB::table('geo_divisions')
                        ->where('id', '=', $doptor_office_status_from_db->geo_division_id)
                        ->first();

                        if(empty($division_details))
                        {
                            return Redirect::back()->with('withError','তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                        }

                    $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  ' . $division_details->division_name_bng . ' বিভাগের বিভাগীয় কমিশনার অফিসার নির্বাচন';
                    $data['list_of_all'] = $list_of_all;
                    $data['office_id'] = $office_id;
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_division();

                    return view('user_doptor_admin.div_com_office')->with($data);
                } elseif ($doptor_office_status_from_db->office_layer_id == 22 && $doptor_office_status_from_db->office_origin_id == 16) {
                     
                    
                    $get_district_from_geo_distcrict_with_district=NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);
                    $get_division_from_geo_division_with_division=NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    
                    if(empty($get_district_from_geo_distcrict_with_district))
                    {
                        return Redirect::back()->with('withError','তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if(empty($get_division_from_geo_division_with_division))
                    {
                        return Redirect::back()->with('withError','তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }

                    $district_id=$get_district_from_geo_distcrict_with_district->id;
                    $division_id=$get_division_from_geo_division_with_division->id;

                    $district_name_bng =$get_district_from_geo_distcrict_with_district->district_name_bng;


                    $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  ' . $district_name_bng . ' জেলার , জেলা প্রশাসকের কার্যালয়ের অফিসার নির্বাচন';
                    $data['list_of_all'] = $list_of_all;
                    $data['office_id'] = $office_id;
                    $data['available_court'] = NDoptorRepositoryAdmin::courtlist_distrcit_all($district_id,$division_id);
                    $data['courtlist_district'] = NDoptorRepositoryAdmin::courtlist_district($district_id,$division_id);
                    $data['courtlist_upazila'] = NDoptorRepositoryAdmin::courtlist_upazila($district_id,$division_id);
                    $data['district_majistrate_court'] = NDoptorRepositoryAdmin::district_majistrate_court($district_id,$division_id);
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_district();

                    
                    return view('user_doptor_admin.dis_com_office')->with($data);
                          




                } elseif ($doptor_office_status_from_db->office_layer_id == 23 && $doptor_office_status_from_db->office_origin_id == 17) {

                    $get_district_from_geo_distcrict_with_district=NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);

                    $get_division_from_geo_division_with_division=NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    $get_upazila_from_geo_upazila_with_upazila=NDoptorRepositoryAdmin::get_upazila_from_geo_upazila_with_upazila($doptor_office_status_from_db->geo_upazila_id);
                    
                    if(empty($get_upazila_from_geo_upazila_with_upazila))
                    {
                        return Redirect::back()->with('withError','তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if(empty($get_district_from_geo_distcrict_with_district))
                    {
                        return Redirect::back()->with('withError','তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }
                    if(empty($get_division_from_geo_division_with_division))
                    {
                        return Redirect::back()->with('withError','তথ্য পাওয়া যায় নাই ')->with('error', 'তথ্য পাওয়া যায় নাই');
                    }

                    $district_id=$get_district_from_geo_distcrict_with_district->id;
                    $division_id=$get_division_from_geo_division_with_division->id;
                    $upazila_id=$get_upazila_from_geo_upazila_with_upazila->id;

                    $upazila_name_bn =$get_upazila_from_geo_upazila_with_upazila->upazila_name_bn;


                    $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  ' . $upazila_name_bn . ' উপজেলার , উপজেলা নির্বাহী কার্যালয়ের অফিসার নির্বাচন';
                    $data['list_of_all'] = $list_of_all;
                    $data['office_id'] = $office_id;
                    $data['available_court'] = NDoptorRepositoryAdmin::courtlist_upazila($district_id,$division_id);
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_upazila();

                    return view('user_doptor_admin.uno_office')->with($data);

                }
            }
        }
    }

    public function all_user_list_from_doptor_segmented_search($office_id, Request $request)
    {
        //dd($request->search_key);

        


        $office_id = decrypt($office_id);

        if (globalUserInfo()->doptor_user_flag == 1) {
            $username = globalUserInfo()->username;
        } else {
            $username = 100000006515;
        }

        $get_token_response = NDoptorRepositoryAdmin::getToken($username);

        if ($get_token_response['status'] == 'success') {
            $token = $get_token_response['data']['token'];

            $response_after_decode = NDoptorRepositoryAdmin::get_employee_list_by_office($token, $office_id);
            $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

            $list_of_all = json_decode($everything, true)['list_of_all'];

            $doptor_office_status_from_db = DB::table('doptor_offices')
                ->where('office_id', '=', $office_id)
                ->first();
                if ($doptor_office_status_from_db->office_layer_id == 21 && $doptor_office_status_from_db->office_origin_id == 15) {

                    $list_of_others_fianl=[];

                    $division_details = DB::table('geo_divisions')
                        ->where('id', '=', $doptor_office_status_from_db->geo_division_id)
                        ->first();

                    $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  ' . $division_details->division_name_bng . ' বিভাগের বিভাগীয় কমিশনার অফিসার নির্বাচন';
                    $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];


                    $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

                    $list_of_all = json_decode($everything, true)['list_of_all'];

                          
                   
                    foreach ($search_keys as $value) {
                        
                        $search_by_key = NDoptorRepositoryAdmin::search_revisions($list_of_all, $request->search_key, $value);

                        if (!empty($search_by_key)) {

                             $list_of_others=[];

                            foreach($search_by_key  as $list)
                            {
                                array_push($list_of_others,$list_of_all[$list]);

                            }
                            $list_of_others_fianl=$list_of_others;
                            break;
                        }
                    }


                    $data['list_of_all'] = $list_of_others_fianl;
                    $data['office_id'] = $office_id;
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_division();

                    return view('user_doptor_admin.div_com_office')->with($data);
                    
                } elseif ($doptor_office_status_from_db->office_layer_id == 22 && $doptor_office_status_from_db->office_origin_id == 16) {

                    $list_of_others_fianl=[];
                    
                    $get_district_from_geo_distcrict_with_district=NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);
                    $get_division_from_geo_division_with_division=NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    $district_id=$get_district_from_geo_distcrict_with_district->id;
                    $division_id=$get_division_from_geo_division_with_division->id;

                    $district_name_bng =$get_district_from_geo_distcrict_with_district->district_name_bng;


                    $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  ' . $district_name_bng . ' জেলার , জেলা প্রশাসকের কার্যালয়ের অফিসার নির্বাচন';

                    $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

                    $list_of_all = json_decode($everything, true)['list_of_all'];

                    $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];      
                   
                    foreach ($search_keys as $value) {
                        
                        $search_by_key = NDoptorRepositoryAdmin::search_revisions($list_of_all, $request->search_key, $value);

                        if (!empty($search_by_key)) {

                             $list_of_others=[];

                            foreach($search_by_key  as $list)
                            {
                                array_push($list_of_others,$list_of_all[$list]);

                            }
                            $list_of_others_fianl=$list_of_others;
                            break;
                        }
                    }


                    $data['list_of_all'] = $list_of_others_fianl;
                    $data['office_id'] = $office_id;
                    $data['available_court'] = NDoptorRepositoryAdmin::courtlist_distrcit_all($district_id,$division_id);
                    $data['courtlist_district'] = NDoptorRepositoryAdmin::courtlist_district($district_id,$division_id);
                    $data['courtlist_upazila'] = NDoptorRepositoryAdmin::courtlist_upazila($district_id,$division_id);
                    $data['district_majistrate_court'] = NDoptorRepositoryAdmin::district_majistrate_court($district_id,$division_id);
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_district();
                    return view('user_doptor_admin.dis_com_office')->with($data);

                } elseif ($doptor_office_status_from_db->office_layer_id == 23 && $doptor_office_status_from_db->office_origin_id == 17) {
                    $list_of_others_fianl=[];

                    $get_district_from_geo_distcrict_with_district=NDoptorRepositoryAdmin::get_district_from_geo_distcrict_with_district($doptor_office_status_from_db->geo_district_id);

                    $get_division_from_geo_division_with_division=NDoptorRepositoryAdmin::get_division_from_geo_division_with_division($doptor_office_status_from_db->geo_division_id);

                    $get_upazila_from_geo_upazila_with_upazila=NDoptorRepositoryAdmin::get_upazila_from_geo_upazila_with_upazila($doptor_office_status_from_db->geo_upazila_id);


                    $district_id=$get_district_from_geo_distcrict_with_district->id;
                    $division_id=$get_division_from_geo_division_with_division->id;
                    $upazila_id=$get_upazila_from_geo_upazila_with_upazila->id;

                    $upazila_name_bn =$get_upazila_from_geo_upazila_with_upazila->upazila_name_bn;


                    $data['page_title'] = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  ' . $upazila_name_bn . ' উপজেলার , উপজেলা নির্বাহী কার্যালয়ের অফিসার নির্বাচন';
                    
                    $everything = NDoptorRepositoryAdmin::all_user_list_from_doptor_segmented($response_after_decode['data']);

                    $list_of_all = json_decode($everything, true)['list_of_all'];

                    

                    $search_keys = ['username', 'designation_bng', 'designation_eng', 'unit_name_en', 'unit_name_bn', 'employee_name_bng', 'employee_name_eng'];      
                   
                    foreach ($search_keys as $value) {
                        
                        $search_by_key = NDoptorRepositoryAdmin::search_revisions($list_of_all, $request->search_key, $value);
                        

                        if (!empty($search_by_key)) {

                             $list_of_others=[];

                            foreach($search_by_key  as $list)
                            {
                                array_push($list_of_others,$list_of_all[$list]);

                            }
                            $list_of_others_fianl=$list_of_others;
                            break;
                        }
                    }

                    

                    $data['list_of_all'] = $list_of_others_fianl;  
                    $data['office_id'] = $office_id;
                    $data['available_court'] = NDoptorRepositoryAdmin::courtlist_upazila($district_id,$division_id);
                    $data['available_role'] = NDoptorRepositoryAdmin::rolelist_upazila();

                    return view('user_doptor_admin.uno_office')->with($data);
                }
        }
    }

    public function divisional_commissioner_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'role_id' => $request->role_id,
                    ];


                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);


                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Div_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->role_id == 0) {
                                $role_name = 'No_role';
                            } else {
                                $role = NDoptorRepositoryAdmin::rolelist_division();
                                foreach ($role as $rolelist) {
                                    if ($rolelist->id == $request->role_id) {
                                        $role_name = $rolelist->role_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'role_name' => $role_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'role_id' => $request->role_id,
                    ];

                    
                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Div_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            $role = NDoptorRepositoryAdmin::rolelist_division();
                            foreach ($role as $rolelist) {
                                if ($rolelist->id == $request->role_id) {
                                    $role_name = $rolelist->role_name;
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'role_name' => $role_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function district_commissioner_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::Dis_Commissioner_Update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::district_majistrate_court($request_court_details->district_id,$request_court_details->division_id);

                               

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }

                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::Dis_Commissioner_Create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::district_majistrate_court($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }
    

    public function adm_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                //var_dump('g');
                //exit();
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::ADM_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_district($request_court_details->district_id,$request_court_details->division_id);

                               

                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }

                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::ADM_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_district($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function em_dc_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::EM_DC_Office_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                                
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::EM_DC_Office_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }

    }
    



    public function peskar_em_dc_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::peshkar_em_dc_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                                
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::peshkar_em_dc_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }

    public function peskar_adm_dc_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::peshkar_dm_adm_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_district($request_court_details->district_id,$request_court_details->division_id);
                                
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::peshkar_dm_adm_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_district($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }
    public function em_uno_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::EM_UNO_Office_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                                
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::EM_UNO_Office_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }
    public function peskar_em_uno_create_by_admin(Request $request)
    {
        $get_current_desk = NDoptorRepositoryAdmin::current_desk($request->username);

        if ($get_current_desk['status'] == 'success') {
            $username = DB::table('users')
                ->where('username', $request->username)
                ->first();

            if (!empty($username)) {
                
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }

                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                    
                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $updated = NDoptorRepositoryAdmin::peshkar_em_uno_update($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);

                        if ($updated) {
                            if ($request->court_id == 0) {
                                $court_name = 'No_court';
                            } else {
                                    
                                $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                                $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                                
                                foreach ($court as $courtlist) {
                                    if ($courtlist->id == $request->court_id) {
                                        $court_name = $courtlist->court_name;
                                    }
                                }
                            }
                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                }
            } else {
                if (!empty($get_current_desk['data']['employee_info'])) {
                    $employee_info_from_api = $get_current_desk['data']['employee_info'];
                    $office_info_from_request = [
                        'office_name_bn' => $request->office_name_bn,
                        'office_name_en' => $request->office_name_en,
                        'unit_name_bn' => $request->unit_name_bn,
                        'unit_name_en' => $request->unit_name_en,
                        'office_id' => $request->office_id,
                    ];
                    $user_info_from_request = [
                        'designation_bng' => $request->designation_bng,
                        'username' => $request->username,
                        'employee_name_bng' => $request->employee_name_bng,
                        'court_id' => $request->court_id,
                    ];

                    if (globalUserInfo()->doptor_user_flag == 1) {
                        $username = globalUserInfo()->username;
                    } else {
                        $username = 100000006515;
                    }
                    $get_token_response = NDoptorRepositoryAdmin::getToken($username);
                  

                    if ($get_token_response['status'] == 'success') {
                        $token = $get_token_response['data']['token'];
                        $get_office_basic_info = NDoptorRepositoryAdmin::get_office_basic_info($token, $request->office_id);

                        $created = NDoptorRepositoryAdmin::peshkar_em_uno_create($employee_info_from_api, $office_info_from_request, $user_info_from_request, $get_office_basic_info);
                        if ($created) {
                            
                            $request_court_details=DB::table('court')->where('id','=',$request->court_id)->first();

                            $court = NDoptorRepositoryAdmin::courtlist_upazila($request_court_details->district_id,$request_court_details->division_id);
                            
                            foreach ($court as $courtlist) {
                                if ($courtlist->id == $request->court_id) {
                                    $court_name = $courtlist->court_name;
                                }
                            } 


                            return response()->json([
                                'success' => 'success',
                                'message' => 'অনুমোদিত করা হল',
                                'court_name' => $court_name,
                            ]);
                        }
                    } else {
                        return response()->json([
                            'success' => 'error',
                            'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                        ]);
                    }
                } else {
                    return response()->json([
                        'success' => 'error',
                        'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
                    ]);
                }
            }
        } else {
            return response()->json([
                'success' => 'error',
                'message' => 'দপ্তরে সঠিক ভাবে তথ্য খুজে পাওয়া যায় নাই',
            ]);
        }
    }
}
