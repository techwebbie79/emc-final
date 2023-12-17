<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Repositories\CdapUserManagementRepository;

class CdapUserManagementController extends Controller
{
    public function cdap_v2_login()
    {
        $redirect_url = route('home') . '/cdap/v2/callback/url';
        $random = Str::random(40);
        $queries = http_build_query([
            'response_type' => 'code',
            'client_id' =>  mygov_client_id(),
            'redirect_uri' => $redirect_url,
            'scope' => 'openid',
            'state' => $random,
        ]);

        return redirect(mygov_endpoint() . '/oauth/authorize?' . $queries);
    }

    public function call_back_function_from_mygov(Request $request)
    {
        $redirect_url = route('home') . '/cdap/v2/callback/url';

        $response = Http::post(
            mygov_endpoint() . '/oauth/token',

            [
                'grant_type' => 'authorization_code',
                'client_id' => mygov_client_id(),
                'client_secret' => mygov_client_secret(),
                'redirect_uri' => $redirect_url,
                'code' => $request->code,
            ]
        );
        $data = $response->json();
        if (empty($data)) {
            return redirect()->away(route('home'));
        }
        $access_token = $data['access_token'];

        session(['access_token_cdap' => $access_token]);
        Cookie::queue('access_token_cdap', $access_token, 120);

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        //dd(json_decode($response1, true));

        $data_from_cdap = json_decode($response1, true);

        $user_exits_check_by_nid = DB::table('users')
            ->where('citizen_nid', '=', $data_from_cdap['data']['nid'])
            ->whereNotNull('citizen_nid')
            ->where('is_cdap_user', '=', 0)
            ->first();

        if (!empty($user_exits_check_by_nid)) {
            return redirect()->route('show_log_in_page')->with(['cdap_nid_error' => 'আপনার এন আই ডি দিয়ে ইতিমধ্যে নিবন্ধভুক্ত আপনি সাধারণ লগইন বাটন দিয়ে লগইন করুন']);
        }

        $cdap_user_exits = DB::table('cdap_users')
            ->where('mobile', '=', $data_from_cdap['data']['mobile'])
            ->where('nid', '=', $data_from_cdap['data']['nid'])
            ->first();

        if (empty($cdap_user_exits)) {
            if ($data_from_cdap['data']['nid_verify'] == 0) {

                return redirect()->route('cdap.nid.error');

            } else {
                return redirect()->route('cdap.user.select.role');

            }
        } else {
            $userdata = CdapUserManagementRepository::update_cdap_user_with_login($data_from_cdap);

            if (Auth::attempt(['username' => $userdata['username'], 'password' => $userdata['password']])) {
                return redirect()->route('dashboard');

                //return redirect()->route('dashboard');
            }
        }

    }

    public static function logout()
    {
        $access_token = Session::get('access_token_cdap');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => mygov_endpoint() . '/api/logout',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $access_token",
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        session()->forget('access_token_cdap');

        return redirect()->route('home');

    }
    public function cdap_user_select_role()
    {
        $data['short_news'] = News::orderby('id', 'desc')->where('news_type', 1)->where('status', 1)->get();
        $data['big_news'] = News::orderby('id', 'desc')->where('news_type', 2)->where('status', 1)->get();
        // return $data;
        return view('cdapSSOcitizen.registration')->with($data);
    }
    public function cdap_user_create_citizen(Request $request)
    {

        $access_token = $request->cookie('access_token_cdap');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        $data_from_cdap = json_decode($response1, true);
        //create_cdap_user_citizen_with_login
        $userdata = CdapUserManagementRepository::create_cdap_user_citizen_with_login($data_from_cdap);

        if (Auth::attempt(['username' => $userdata['username'], 'password' => $userdata['password']])) {
            return redirect()->route('dashboard');
        }
    }
    public function cdap_user_create_advocate(Request $request)
    {

        $access_token = $request->cookie('access_token_cdap');
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => mygov_endpoint() . '/api/user',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Accept: application/json', 'api-version: 1', 'Authorization: Bearer ' . $access_token],
        ]);

        $response1 = curl_exec($curl);

        curl_close($curl);

        $data_from_cdap = json_decode($response1, true);
        //create_cdap_user_citizen_with_login
        $userdata = CdapUserManagementRepository::create_cdap_user_advocate_with_login($data_from_cdap);

        if (Auth::attempt(['username' => $userdata['username'], 'password' => $userdata['password']])) {
            return redirect()->route('dashboard');
        }
    }
}
