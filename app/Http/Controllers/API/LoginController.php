<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\EmAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\NDoptorRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CdapUserManagementRepository;
use App\Http\Controllers\API\BaseController as BaseController;

class LoginController extends BaseController
{
    public function test()
    {
        // Counter
        //$data['total_case'] = DB::table('case_register')->count();
        $data['Hello'] = 'Hello';
        // dd($data);
        // echo 'Hellollll'; exit;
        return $this->sendResponse($data, 'test successfully.');
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
                'err_res' => '',
                'status' => 200,
                'data' => null,
            ]);
        }

        // echo 'Hello'; exit;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // return $user;
            // dd($user);

            // role name //
            $roleName = DB::table('role')
                ->select('role_name')
                ->where('id', $user->role_id)
                ->first()->role_name;

            // Results
            $success['user_id'] = isset($user->id) ? $user->id : null;
            $success['name'] = isset($user->name) ? $user->name : null;
            $success['email'] = isset($user->email) ? $user->email : null;
            $success['profile_pic'] = isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id'] = isset($user->role_id) ? $user->role_id : null;
            $success['court_id'] = isset($user->court_id) ? $user->court_id : null;
            $success['role_name'] = isset($roleName) ? $roleName : null;
            $success['office_id'] = isset($user->office_id) ? $user->office_id : null;

            // Office name //
            if (($user->role_id == 36 || $user->role_id == 20) && $user->office_id == null) {
                $success['office_name'] = null;
                $success['division_id'] = null;
                $success['district_id'] = null;
                $success['upazila_id'] = null;
            } else {
                $officeInfo = DB::table('office')
                    ->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')
                    ->where('id', $user->office_id)
                    ->first();
                $success['office_name'] = $officeInfo->office_name_bn;
                $success['division_id'] = $officeInfo->division_id;
                $success['district_id'] = $officeInfo->district_id;
                $success['upazila_id'] = $officeInfo->upazila_id;
            }

            $success['token'] = $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } elseif (Auth::attempt(['username' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // return $user;
            // dd($user);

            // role name //
            $roleName = DB::table('role')
                ->select('role_name')
                ->where('id', $user->role_id)
                ->first()->role_name;

            // Results
            $success['user_id'] = isset($user->id) ? $user->id : null;
            $success['name'] = isset($user->name) ? $user->name : null;
            $success['email'] = isset($user->email) ? $user->email : null;
            $success['profile_pic'] = isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id'] = isset($user->role_id) ? $user->role_id : null;
            $success['court_id'] = isset($user->court_id) ? $user->court_id : null;
            $success['role_name'] = isset($roleName) ? $roleName : null;
            $success['office_id'] = isset($user->office_id) ? $user->office_id : null;

            // Office name //
            if ($user->role_id == 36 && $user->office_id == null) {
                $success['office_name'] = null;
                $success['division_id'] = null;
                $success['district_id'] = null;
                $success['upazila_id'] = null;
            } else {
                $officeInfo = DB::table('office')
                    ->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')
                    ->where('id', $user->office_id)
                    ->first();
                $success['office_name'] = $officeInfo->office_name_bn;
                $success['division_id'] = $officeInfo->division_id;
                $success['district_id'] = $officeInfo->district_id;
                $success['upazila_id'] = $officeInfo->upazila_id;
            }

            $success['token'] = $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } elseif (Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // return $user;
            // dd($user);

            // role name //
            $roleName = DB::table('role')
                ->select('role_name')
                ->where('id', $user->role_id)
                ->first()->role_name;

            // Results
            $success['user_id'] = isset($user->id) ? $user->id : null;
            $success['name'] = isset($user->name) ? $user->name : null;
            $success['email'] = isset($user->email) ? $user->email : null;
            $success['profile_pic'] = isset($user->profile_pic) ? $user->profile_pic : null;
            $success['role_id'] = isset($user->role_id) ? $user->role_id : null;
            $success['court_id'] = isset($user->court_id) ? $user->court_id : null;
            $success['role_name'] = isset($roleName) ? $roleName : null;
            $success['office_id'] = isset($user->office_id) ? $user->office_id : null;

            // Office name //
            if (($user->role_id == 36 || $user->role_id == 20) && $user->office_id == null) {
                $success['office_name'] = null;
                $success['division_id'] = null;
                $success['district_id'] = null;
                $success['upazila_id'] = null;
            } else {
                $officeInfo = DB::table('office')
                    ->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')
                    ->where('id', $user->office_id)
                    ->first();
                $success['office_name'] = $officeInfo->office_name_bn;
                $success['division_id'] = $officeInfo->division_id;
                $success['district_id'] = $officeInfo->district_id;
                $success['upazila_id'] = $officeInfo->upazila_id;
            }

            $success['token'] = $user->createToken('Login')->accessToken;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            $user_create = $this->test_login_fun($request->email, $request->password);
            //dd($user_create);
            if ($user_create) {
                if (Auth::attempt(['username' => $request->email, 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    $user = Auth::user();
                    // return $user;
                    // dd($user);

                    // role name //
                    $roleName = DB::table('role')
                        ->select('role_name')
                        ->where('id', $user->role_id)
                        ->first()->role_name;

                    // Results
                    $success['user_id'] = isset($user->id) ? $user->id : null;
                    $success['name'] = isset($user->name) ? $user->name : null;
                    $success['email'] = isset($user->email) ? $user->email : null;
                    $success['profile_pic'] = isset($user->profile_pic) ? $user->profile_pic : null;
                    $success['role_id'] = isset($user->role_id) ? $user->role_id : null;
                    $success['court_id'] = isset($user->court_id) ? $user->court_id : null;
                    $success['role_name'] = isset($roleName) ? $roleName : null;
                    $success['office_id'] = isset($user->office_id) ? $user->office_id : null;

                    // Office name //
                    if (($user->role_id == 36 || $user->role_id == 20) && $user->office_id == null) {
                        $success['office_name'] = null;
                        $success['division_id'] = null;
                        $success['district_id'] = null;
                        $success['upazila_id'] = null;
                    } else {
                        $officeInfo = DB::table('office')
                            ->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')
                            ->where('id', $user->office_id)
                            ->first();
                        $success['office_name'] = $officeInfo->office_name_bn;
                        $success['division_id'] = $officeInfo->division_id;
                        $success['district_id'] = $officeInfo->district_id;
                        $success['upazila_id'] = $officeInfo->upazila_id;
                    }

                    $success['token'] = $user->createToken('Login')->accessToken;

                    return $this->sendResponse($success, 'User login successfully.');
                }
            }
        }

        return $this->sendError('Unauthorised.', ['error' => 'User login failed.'], 401);
    }

    public function cdap_user_login_verify(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
                'err_res' => '',
                'status' => 200,
                'data' => null,
            ]);
        }

        $token = CdapUserManagementRepository::create_token();
        if ($token['status'] == 'success') {
            $data_from_cdap = CdapUserManagementRepository::call_login_curl($token['token'], $request->password, $request->email);
            if ($data_from_cdap['status'] == 'success') {
                $user_exits_check_by_nid = DB::table('users')
                    ->where('citizen_nid', '=', $data_from_cdap['data']['nid'])
                    ->whereNotNull('citizen_nid')
                    ->where('is_cdap_user', '=', 0)
                    ->first();

                if (!empty($user_exits_check_by_nid)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'আপনার এন আই ডি দিয়ে ইতিমধ্যে নিবন্ধভুক্ত আপনি সাধারণ লগইন বাটন দিয়ে লগইন করুন',
                        'err_res' => '',
                        'status' => 200,
                        'data' => null,
                    ]);
                }

                $cdap_user_exits = DB::table('cdap_users')
                    ->where('mobile', '=', $data_from_cdap['data']['mobile'])
                    ->where('nid', '=', $data_from_cdap['data']['nid'])
                    ->first();

                if (empty($cdap_user_exits)) {
                    if ($data_from_cdap['data']['nid_verify'] == 0) {
                        return response()->json([
                            'success' => false,
                            'message' => 'দয়া করে CDAP এ গিয়ে আপনার NID verify করুন',
                            'err_res' => '',
                            'status' => 200,
                            'data' => null,
                        ]);
                    } else {
                        $userdata = CdapUserManagementRepository::create_cdap_user_with_login($data_from_cdap);

                        if (Auth::attempt(['username' => $userdata['username'], 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                            $user = Auth::user();
                            $roleName = DB::table('role')
                                ->select('role_name')
                                ->where('id', $user->role_id)
                                ->first()->role_name;

                            // Results
                            $success['user_id'] = isset($user->id) ? $user->id : null;
                            $success['name'] = isset($user->name) ? $user->name : null;
                            $success['email'] = isset($user->email) ? $user->email : null;
                            $success['profile_pic'] = isset($user->profile_pic) ? $user->profile_pic : null;
                            $success['role_id'] = isset($user->role_id) ? $user->role_id : null;
                            $success['court_id'] = isset($user->court_id) ? $user->court_id : null;
                            $success['role_name'] = isset($roleName) ? $roleName : null;
                            $success['office_id'] = isset($user->office_id) ? $user->office_id : null;

                            // Office name //
                            if ($user->role_id == 36 && $user->office_id == null) {
                                $success['office_name'] = null;
                                $success['division_id'] = null;
                                $success['district_id'] = null;
                                $success['upazila_id'] = null;
                            } else {
                                $officeInfo = DB::table('office')
                                    ->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')
                                    ->where('id', $user->office_id)
                                    ->first();
                                $success['office_name'] = $officeInfo->office_name_bn;
                                $success['division_id'] = $officeInfo->division_id;
                                $success['district_id'] = $officeInfo->district_id;
                                $success['upazila_id'] = $officeInfo->upazila_id;
                            }

                            $success['token'] = $user->createToken('Login')->accessToken;

                            return $this->sendResponse($success, 'User login successfully.');
                        }
                    }
                } else {
                    $userdata = CdapUserManagementRepository::update_cdap_user_with_login($data_from_cdap);

                    if (Auth::attempt(['username' => $userdata['username'], 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                        $user = Auth::user();
                        $roleName = DB::table('role')
                            ->select('role_name')
                            ->where('id', $user->role_id)
                            ->first()->role_name;

                        // Results
                        $success['user_id'] = isset($user->id) ? $user->id : null;
                        $success['name'] = isset($user->name) ? $user->name : null;
                        $success['email'] = isset($user->email) ? $user->email : null;
                        $success['profile_pic'] = isset($user->profile_pic) ? $user->profile_pic : null;
                        $success['role_id'] = isset($user->role_id) ? $user->role_id : null;
                        $success['court_id'] = isset($user->court_id) ? $user->court_id : null;
                        $success['role_name'] = isset($roleName) ? $roleName : null;
                        $success['office_id'] = isset($user->office_id) ? $user->office_id : null;

                        // Office name //
                        if ($user->role_id == 36 && $user->office_id == null) {
                            $success['office_name'] = null;
                            $success['division_id'] = null;
                            $success['district_id'] = null;
                            $success['upazila_id'] = null;
                        } else {
                            $officeInfo = DB::table('office')
                                ->select('office_name_bn', 'division_id', 'district_id', 'upazila_id')
                                ->where('id', $user->office_id)
                                ->first();
                            $success['office_name'] = $officeInfo->office_name_bn;
                            $success['division_id'] = $officeInfo->division_id;
                            $success['district_id'] = $officeInfo->district_id;
                            $success['upazila_id'] = $officeInfo->upazila_id;
                        }

                        $success['token'] = $user->createToken('Login')->accessToken;

                        return $this->sendResponse($success, 'User login successfully.');
                    }
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'আপনাকে খুজে পাওয়া যায়  নাই , আপনার প্রদান করা তথ্যগুলো ঠিক ভাবে প্রদান করুন ',
                'err_res' => '',
                'status' => 200,
                'data' => null,
            ]);
        }
    }

    /**
     * cause list  api
     *
     * @return \Illuminate\Http\Response
     */
    public function cause_list(Request $request)
    {
        $data = [];
        $appeal = EmAppeal::whereIn('appeal_status', ['ON_TRIAL', 'ON_TRIAL_DM']);
        if (!empty($request->date_start) && !empty($request->date_end)) {
            $dateFrom = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_start)));
            $dateTo = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
            $appeal->whereBetween('next_date', [$dateFrom, $dateTo]);
        } else {
            $appeal->whereBetween('next_date', [date('Y-m-d'), date('Y-m-d')]);
        }

        if (!empty($request->division)) {
            $appeal->where('division_id', '=', $request->division);
        }

        if (!empty($request->district)) {
            $appeal->where('district_id', '=', $request->district);
        }

        if (!empty($request->case_no)) {
            $case_no = bn2en($request->case_no);
           
               $appeal->where('case_no', '=', $case_no);
           
       }
        if (!empty($request->court)) {
           
           $appeal->where('court_id', '=', $request->court);
       
       }
       

        $appeal = $appeal->select('id', 'case_no', 'case_date', 'next_date', 'office_id', 'office_name', 'district_id', 'district_name', 'division_id', 'division_name', 'law_section', 'loan_amount_text', 'loan_amount', 'peshkar_office_id', 'peshkar_name', 'peshkar_email', 'gco_name', 'gco_office_id', 'gco_office_id', 'court_id', 'created_at')->get();

        if ($appeal != null || !empty($appeal)) {
            foreach ($appeal as $key => $value) {
                $data['appeal'][$key]['appealInfo'] = $value;

                //applicant and defaulter info
                $citizenLists = DB::table('em_appeal_citizens')
                    ->select('citizen_id', 'citizen_type_id', 'appeal_id')
                    ->where('appeal_id', $value->id)
                    ->get();

                foreach ($citizenLists as $citizenList) {
                    if ($citizenList->citizen_type_id == 1) {
                        $data['appeal'][$key]['applicantCitizen'] = DB::table('em_citizens')
                            ->select('id as citizen_id', 'citizen_name')
                            ->where('id', $citizenList->citizen_id)
                            ->get();
                    } elseif ($citizenList->citizen_type_id == 2) {
                        $data['appeal'][$key]['defaulterCitizen'] = DB::table('em_citizens')
                            ->select('id as citizen_id', 'citizen_name')
                            ->where('id', $citizenList->citizen_id)
                            ->get();
                    }
                }
                // return $citizenLists;

                // case note
                $data['appeal'][$key]['notes'] = DB::table('em_notes')
                    ->where('appeal_id', $value->id)
                    ->leftjoin('em_case_shortdecisions', 'em_notes.case_short_decision_id', '=', 'em_case_shortdecisions.id')
                    ->select('em_notes.appeal_id', 'em_case_shortdecisions.case_short_decision')
                    ->orderBy('em_notes.id', 'desc')
                    ->first();
            }
        }

        if (empty($data)) {
            return $this->sendResponse($data, 'Data Not Found.');
        } else {
            return $this->sendResponse($data, 'Data Found Success.');
        }
    }

    public function test_login_fun($test_email, $test_password)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => DOPTOR_ENDPOINT().'/api/user/verify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => ['username' => $test_email, 'password' => $test_password],
            CURLOPT_HTTPHEADER => ['api-version: 1'],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        $response2 = json_decode($response, true);
        $response = json_decode($response);

        if ($response->status == 'success') {
            $username = DB::table('users')
                ->where('username', $response->data->user->username)
                ->first();

            if (empty($username)) {
                if (empty($response2['data']['office_info'])) {
                    return 0;
                }
                $ref_origin_unit_org_id = $response2['data']['organogram_info'][array_key_first($response2['data']['organogram_info'])]['ref_origin_unit_org_id'];

                $office_info = $response->data->office_info[0];

                if ($ref_origin_unit_org_id == 533) {
                    NDoptorRepository::Divisional_Commissioner_create($response, $office_info, $ref_origin_unit_org_id);
                }

                if ($ref_origin_unit_org_id == 51) {
                    NDoptorRepository::DC_create($response, $office_info, $ref_origin_unit_org_id);
                }
            } else {
                return 1;
            }
        }
    }

    public function update_password(Request $request)
    {
        $userid = Auth::guard('api')->user()->id;

        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        if ($validator->fails()) {
            $arr = $this->sendError($validator->errors()->first(), ['error' => $validator->errors()->first()]);
        } else {
            try {
                if (Hash::check(request('current_password'), Auth::user()->password) == false) {
                    $arr = $this->sendError('Check your old password.', ['error' => 'Your old password not match.']);
                } elseif (Hash::check(request('new_password'), Auth::user()->password) == true) {
                    $arr = $this->sendError('Make sure your current password does not match your new password.', ['error' => 'Please enter a new password which is not similar then current password.']);
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($request->new_password)]);
                    return $this->sendResponse(null, 'Password updated successfully.');
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = $this->sendError($msg, ['error' => $msg]);
            }
        }
        return $arr;
    }
}
