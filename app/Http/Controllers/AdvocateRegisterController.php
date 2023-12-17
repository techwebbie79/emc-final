<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\News;
use App\Models\User;
use App\Models\DummyNid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;

class AdvocateRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }
    public function nid_check()
    {
        //
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'আইনজীবী  এনআইডি যাচাইকরণ ফর্ম';

        return view('advocate.nid_check')->with($data);
    }

    public function nid_verify(Request $request)
    {
        $request->validate(
            [
                'nid_no' => 'required|unique:users,citizen_nid',
            ],
            [
                'nid_no.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            ],
        );

        $dob = date('Y-m-d', strtotime($request->dob));
        $result = DummyNid::where('national_id', $request->nid_no)
            ->where('dob', $dob)
            ->first();
        if (empty($result)) {
            return redirect()
                ->back()
                ->withErrors(['আপনার তথ্য পাওয়া যায়নি'])
                ->withInput();
        } else {
            $data['results'] = $result;
            $data['page_title'] = 'আইনজীবী  এনআইডি যাচাইকরণ ফর্ম';
            session(['nidData' => $result]);

            return redirect('/advocateRegister');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $SesionData = Session::get('nidData');
        $data['results'] = $SesionData;

        $data['page_title'] = 'আইনজীবী নিবন্ধন ফরম';

        return view('advocate.add')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $request->validate(
            [
                'name' => 'required',
                'citizen_nid' => 'required|unique:users,citizen_nid',
                'email' => 'nullable|email|unique:users,email',
                'mobile_no' => 'required|size:11|regex:/(01)[0-9]{9}/',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6',
            ],
            [
                'name.required' => 'পুরো নাম লিখুন',
                'citizen_nid.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.unique' => 'আপনার ইমেইল দিয়ে দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                // 'email.required' => 'আপনার ইমেইল লিখুন',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'mobile_no.size' => 'মোবাইল নং দিতে হবে 11 digit ',
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
            ],
        );

        $FourDigitRandomNumber = rand(1111, 9999);

        $data = [
            'citizen_name' => $request->name,
            'citizen_phone_no' => $request->mobile_no,
            'citizen_NID' => $request->citizen_nid,
            'citizen_gender' => $request->citizen_gender,
            'present_address' => $request->presentAddress,
            'permanent_address' => $request->permanentAddress,
            'dob' => $request->dob,
            'email' => $request->email,
            'father' => $request->father,
            'mother' => $request->mother,
            'created_at' =>date('Y-m-d H:i:s')
        ];

        $nid_exits = DB::table('em_citizens')
            ->where('citizen_NID', $request->citizen_nid)
            ->first();
        if (!empty($nid_exits)) {
            DB::table('em_citizens')
                ->where('citizen_NID', $request->citizen_nid)
                ->update($data);
            $ID = $nid_exits->id;
        } else {
            $ID = DB::table('em_citizens')->insertGetId($data);
        }

        if ($request->password == 'google_sso_login_password_14789_gcc_ourt') {
            $password = 'm#P52s@ap$V';
        } else {
            $password = $request->password;
        }
        $result = DB::table('users')->insertGetId([
            'citizen_id' => $ID,
            'citizen_nid' => $request->citizen_nid,
            'name' => $request->name,
            'username' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'role_id' => 20,
            'otp' => $FourDigitRandomNumber,
            'password' => Hash::make($password),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($result) {
            $message = ' সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . "\r\n" . 'ধন্যবাদ।';
            $mobile = $request->mobile_no;
            $this->send_sms($mobile, $message);
            return redirect()
                ->route('advocate.mobile_check', ['user_id' => encrypt($result)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন। ');
        }
    }
    public function mobile_check($user_id)
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'আইনজীবী মোবাইল নম্বর ভেরিফিকেশন ফর্ম';
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        $data['updated_at_otp'] = $user->updated_at;
        $data['mobile'] = $user->mobile_no;
        return view('advocate.mobile_check')->with($data);
    }

    public function mobile_verify(Request $request)
    {
        $otp = $request->otp_1 . $request->otp_2 . $request->otp_3 . $request->otp_4;
        // return $otp;
        $result = User::where('otp', $otp)
            ->where('id', $request->user_id)
            ->first();
        // return $result;
        if (empty($result)) {
            return redirect()
                ->back()
                ->withErrors(['আপনার তথ্য পাওয়া যায়নি']);
        } else {
            $data['results'] = $result;
            if (Auth::loginUsingId($result->id)) {
                return redirect('/dashboard');
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['আপনার তথ্য পাওয়া যায়নি']);
            }
        }
    }

    public function advocate_registration_otp_resend($user_id)
    {
        $otp = rand(1111, 9999);

        $update_otp = DB::table('users')
            ->where('id', '=', decrypt($user_id))
            ->update([
                'otp' => $otp,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($update_otp) {
            $user = User::where('id', decrypt($user_id))->first();

            $mobile = $user->mobile_no;

            $message = ' সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . "\r\n" . 'ধন্যবাদ।';

            $this->send_sms($mobile, $message);

            return redirect()
                ->route('advocate.mobile_check', ['user_id' => encrypt($user->id)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন। ');
        }
    }

    public function send_sms($mobile, $message)
    {
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
                'msisdn' => [
                    '0' => $mobile,
                ],
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function old_send_sms($mobile, $message)
    {
        // print_r($mobile.' , '.$message);exit('zuel');
        $api_key = 'C20019945dde54c4697d80.43761214';
        $contacts = $mobile;
        $senderid = '8804445629106';
        $sms = $message;

        $URL = 'http://sms.nanoitworld.com/smsapi?api_key=' . urlencode($api_key) . '&type=text&contacts=' . urlencode($contacts) . '&senderid=' . urlencode($senderid) . '&msg=' . urlencode($sms);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        try {
            $output = $content = curl_exec($ch);
            // print_r($output);
        } catch (Exception $ex) {
            $output = '-100';
        }
        return $output;
    }
}
