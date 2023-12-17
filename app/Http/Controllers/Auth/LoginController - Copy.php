<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Repositories\NDoptorRepository;
use Illuminate\Support\Facades\Artisan;
use App\Repositories\CdapUserManagementRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function csLogin(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['success' => 'Successfully logged in!']);
        }
        elseif(Auth::attempt(['username' => $request->email, 'password' => $request->password]))
        {
            return response()->json(['success' => 'Successfully logged in!']);
        }
        elseif(Auth::attempt(['citizen_nid' => $request->email, 'password' => $request->password]))
        {
            return response()->json(['success' => 'Successfully logged in!']);
        } 
        else{
            $user_create = $this->test_login_fun($request->email, $request->password);
            //dd($user_create);
            if ($user_create) {
                if (Auth::attempt(['username' => $request->email, 'password' => 'THIS_IS_N_DOPTOR_USER_wM-zu+93Fh+bvn%T78=j*G62nWH-C'])) {
                    return response()->json(['success' => 'Successfully logged in!']);
                }
            }
            else{
                
            }
        }
        return response()->json(['error' => 'Please Enter Valid Credential!']);
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
                if(empty($response2['data']['office_info']))
                {
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
    public function cdap_user_login_verify(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $token = CdapUserManagementRepository::create_token();
        if ($token['status'] == 'success') {
            $data_from_cdap = CdapUserManagementRepository::call_login_curl($token['token'], $request->password, $request->email);
            if ($data_from_cdap['status'] == 'success') {

                $user_exits_check_by_nid=DB::table('users')
                ->where('citizen_nid','=',$data_from_cdap['data']['nid'])
                ->where('is_cdap_user','=',0)
                ->first();

                if(!empty($user_exits_check_by_nid))
                 {
                    return response()->json(['error' => 'আপনার এন আই ডি দিয়ে ইতিমধ্যে নিবন্ধভুক্ত আপনি সাধারণ লগইন বাটন দিয়ে লগইন করুন']);
                 }
                 
                 

                $cdap_user_exits = DB::table('cdap_users')
                    ->where('mobile', '=', $data_from_cdap['data']['mobile'])
                    ->where('nid', '=', $data_from_cdap['data']['nid'])
                    ->first();

                if (empty($cdap_user_exits)) {
                    if ($data_from_cdap['data']['nid_verify'] == 0) {
                        return response()->json(['error' => 'দয়া করে CDAP এ গিয়ে আপনার NID verify করুন']);
                        //return redirect()->back()->with('nid_error','দয়া করে CDAP এ গিয়ে আপনার NID verify করুন');
                    } else {
                        $userdata = CdapUserManagementRepository::create_cdap_user_with_login($data_from_cdap);

                        if (Auth::attempt(['username' => $userdata['username'], 'password' => '12345678'])) {
                            return response()->json(['success' => 'Successfully logged in!']);

                            //return redirect()->route('dashboard');
                        }
                    }
                } else {
                    $userdata = CdapUserManagementRepository::update_cdap_user_with_login($data_from_cdap);

                    if (Auth::attempt(['username' => $userdata['username'], 'password' => '12345678'])) {
                        return response()->json(['success' => 'Successfully logged in!']);

                        //return redirect()->route('dashboard');
                    }
                }
            }
            return response()->json(['error' => 'আপনাকে খুজে পাওয়া যায় নাই']);
        }
    }
  
}
