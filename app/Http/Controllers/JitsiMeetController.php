<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JitsiMeetController extends Controller
{
    public function index($appeal_id)
    {
        $appeal_id = decrypt($appeal_id);
        $appels_details = DB::table('em_appeals')
            ->where('id', '=', $appeal_id)
            ->first();
        $jitsi_link = null;
        //citizen_phone_no

        $zoom_start_url = $appels_details->zoom_start_url;
        $zoom_join_url = $appels_details->zoom_join_url;

        $role_id = globalUserInfo()->role_id;

        if ($appels_details->appeal_status == 'ON_TRIAL' && $role_id == 27) {
            $data_mssdn = DB::table('em_citizens')
                ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->where('em_appeal_citizens.appeal_id', '=', $appeal_id)
                ->select('em_citizens.citizen_phone_no')
                ->get();

            $msisdn = [];
            foreach ($data_mssdn as $data_mssdn) {
                array_push($msisdn, $data_mssdn->citizen_phone_no);
            }
            $message = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট মহোদয়  এই লিংক এ ONLINE hearing এ আছেন আপনাকে যুক্ত হবার জন্য বলা হল লিংক ' . $zoom_join_url;
            $this->send_sms($msisdn, $message);
            DB::table('em_appeals')->where('id', '=', $appeal_id)->update([
                'is_hearing_host_active' => 1
            ]);

            return redirect()->away($zoom_start_url);
        } elseif ($appels_details->appeal_status == 'ON_TRIAL_DM' && $role_id == 38) {
            $data_mssdn = DB::table('em_citizens')
                ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->where('em_appeal_citizens.appeal_id', '=', $appeal_id)
                ->select('em_citizens.citizen_phone_no')
                ->get();

            $msisdn = [];
            foreach ($data_mssdn as $data_mssdn) {
                array_push($msisdn, $data_mssdn->citizen_phone_no);
            }
            $message = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট মহোদয়  এই লিংক এ ONLINE hearing এ আছেন আপনাকে যুক্ত হবার জন্য বলা হল লিংক ' . $zoom_join_url;
            $this->send_sms($msisdn, $message);

            DB::table('em_appeals')->where('id', '=', $appeal_id)->update([
                'is_hearing_host_active' => 1
            ]);

            return redirect()->away($zoom_start_url);
        } elseif ($appels_details->appeal_status == 'ON_TRIAL_DM' && $role_id == 7) {
            $data_mssdn = DB::table('em_citizens')
                ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
                ->where('em_appeal_citizens.appeal_id', '=', $appeal_id)
                ->select('em_citizens.citizen_phone_no')
                ->get();

            $msisdn = [];
            foreach ($data_mssdn as $data_mssdn) {
                array_push($msisdn, $data_mssdn->citizen_phone_no);
            }
            $message = 'অতিরিক্ত জেলা প্রশাসক মহোদয়  এই লিংক এ ONLINE hearing এ আছেন আপনাকে যুক্ত হবার জন্য বলা হল লিংক ' . $zoom_join_url;
            $this->send_sms($msisdn, $message);

            DB::table('em_appeals')->where('id', '=', $appeal_id)->update([
                'is_hearing_host_active' => 1
            ]);

            return redirect()->away($zoom_start_url);
        } else {
            return redirect()->away($zoom_join_url);
        }
    }
    public function index2()
    {
        $appeal_id = 5;
        $today = date('y-m-d');
        $appels_details = DB::table('gcc_appeals')
            ->where('id', '=', $appeal_id)
            ->first();
        $create_date = explode(' ', $appels_details->created_at)[0];
        $create_date_at = explode('-', $create_date);

        $jitsi_link = 'https://meet.jit.si/' . $create_date_at[0] . 'JitsiMeetOnlin' . '-' . $create_date_at[1] . '-' . 'eHearingbangladesh' . '-' . explode('-', $today)[0] . '-' . $appeal_id . '-' . $appels_details->court_id . 'APICertificateCourt' . '-' . explode('-', $today)[2] . '-' . $create_date_at[2] . '-' . 'VeryImportant' . '-' . $appels_details->office_id . '-' . 'people' . $appels_details->division_id . 'republicof' . '-' . $appels_details->district_id . '-' . explode('-', $today)[1] . '(BANGLADESH)' . '10-96-17-98-17';

        return redirect()->away($jitsi_link);
    }
    public function send_sms($msisdn, $message)
    {
        // print_r($msisdn).'sms' .print_r($message);exit('alis');
        //   var_dump($msisdn);
        //   var_dump($message);
        //   exit('zuel');
        //$msisdn=$mobile;

        Http::post('http://bulkmsg.teletalk.com.bd/api/sendSMS', [
            'auth' => [
                'username' => 'ecourt',
                'password' => 'A2ist2#0166',
                'acode' => 1005370,
            ],
            'smsInfo' => [
                'message' => $message,
                'is_unicode' => 1,
                'masking' => 8801552146224,
                'msisdn' => $msisdn,
            ],
        ]);
    }
}
