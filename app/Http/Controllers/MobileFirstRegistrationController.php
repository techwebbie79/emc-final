<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Repositories\NIDVerificationRepository;
use App\Repositories\CitizenNIDVerifyRepository;

class MobileFirstRegistrationController extends Controller
{
    public function applicant_login_registration()
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        $data['page_title'] = 'লগইন / নিবন্ধন';

        return view('mobile_first_registration._new_login_page_with_registration_btn')->with($data);
    }
    public function mobile_first_registration_opt_form(Request $request, $role_id)
    {
        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $data['results'] = $cookieData;
        }

        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();

        if (decrypt($role_id) == 36) {
            $data['role_id'] = 36;
            $data['page_title'] = 'নাগরিকের নাম এবং মোবাইল যাচাইকরণ ফর্ম';
            $data['name_field_label'] = 'নাগরিকের নাম';
            $data['mobile_field_label'] = 'নাগরিকের মোবাইল নং';
            $data['email_field_label'] = 'নাগরিকের ইমেইল';
        } elseif (decrypt($role_id) == 20) {
            $data['role_id'] = 20;
            $data['page_title'] = 'আইনজীবীর নাম এবং মোবাইল যাচাইকরণ ফর্ম';
            $data['name_field_label'] = 'আইনজীবীর নাম';
            $data['mobile_field_label'] = 'আইনজীবীর মোবাইল নং';
            $data['email_field_label'] = 'আইনজীবীর ইমেইল';
        } else {
            return redirect()->route('/');
        }

        return view('mobile_first_registration.mobile_number_form')->with($data);
    }
    public function mobile_first_registration_opt_send(Request $request)
    {
        $request->validate(
            [
                'input_name' => 'required',
                'email' => 'nullable|email|unique:users,email',
                'mobile_no' => 'required|unique:users,mobile_no|size:11|regex:/(01)[0-9]{9}/',
            ],
            [
                'input_name.required' => 'পুরো নাম লিখুন',
                'citizen_nid.unique' => 'আপনার জাতীয় পরিচয় পত্র দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'email.unique' => 'আপনার ইমেইল দিয়ে দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
                'mobile_no.required' => 'মোবাইল নং দিতে হবে',
                'mobile_no.size' => 'মোবাইল নং দিতে হবে ১১ সংখ্যার ইংরেজিতে',
                'mobile_no.unique' => 'আপনার মোবাইল নং দিয়ে ইতিমধ্যে নিবন্ধন করা হয়েছে',
            ],
        );
        $FourDigitRandomNumber = rand(1111, 9999);

        $result = DB::table('users')->insertGetId([
            'name' => $request->input_name,
            'username' => $request->mobile_no,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'otp' => $FourDigitRandomNumber,
            'password' => Hash::make('google_sso_login_password_14789_gcc_ourt_otp_based'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($result) {
            $message = ' সিস্টেমে নিবন্ধন সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $FourDigitRandomNumber . "\r\n" . 'ধন্যবাদ।';
            $mobile = $request->mobile_no;
            $this->send_sms($mobile, $message);
            return redirect()
                ->route('mobile.first.registration.citizen.mobile.check', ['user_id' => encrypt($result)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }
    public function mobile_first_registration_otp_check(Request $request, $user_id)
    {
        $cookieData = $request->cookie('Gmail_info');
        if (!empty($cookieData) && isset($cookieData)) {
            $data['gmail'] = $cookieData;
        }

        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        // return $data;

        $data['page_title'] = 'নাগরিক মোবাইল নম্বর ভেরিফিকেশন ফর্ম';
        $data['user_id'] = decrypt($user_id);
        $user = User::where('id', decrypt($user_id))->first();
        $data['updated_at_otp'] = $user->updated_at;
        $data['mobile'] = $user->mobile_no;
        return view('mobile_first_registration.mobile_check')->with($data);
    }
    public function mobile_first_registration_otp_resend($user_id)
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
                ->route('mobile.first.registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
        }
    }

    public function mobile_first_registration_otp_verify(Request $request)
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
                ->withErrors(['ওটিপি ভুল হয়েছে']);
        } else {
            $cookieData = $request->cookie('Gmail_info');
            if (!empty($cookieData) && isset($cookieData)) {
                User::where('id', $request->user_id)->update(['password' => Hash::make('google_sso_login_password_14789_gcc_ourtm#P52s@ap$V') ]);

                if (Auth::loginUsingId($request->user_id)) {
                    return redirect('/dashboard');
                }
            }

            return redirect()->route('reset.password.after.otp', ['user_id' => encrypt($request->user_id)]);
        }
    }

    public function reset_password_after_otp($user_id)
    {
        $data['short_news'] = News::orderby('id', 'desc')
            ->where('news_type', 1)
            ->where('status', 1)
            ->get();
        $data['big_news'] = News::orderby('id', 'desc')
            ->where('news_type', 2)
            ->where('status', 1)
            ->get();
        $data['user_id'] = decrypt($user_id);
        $data['page_title'] = 'পাসওয়ার্ড হালনাগাদ';
        return view('mobile_first_registration._registration_event_password')->with($data);
    }
    public function mobile_first_password_match(Request $request)
    {
        $request->validate(
            [
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6',
            ],
            [
                'password.required_with' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন ৬ সংখ্যার বেশি হতে হবে',
                'password.same' => 'উভয় ক্ষেত্রে একই পাসওয়ার্ড লিখুন',
                'confirm_password.min' => 'উভয় ক্ষেত্রে সঠিক পাসওয়ার্ড লিখুন, ৬ সংখ্যার বেশি হতে হবে',
            ],
        );

        User::where('id', $request->user_id)->update(['password' => Hash::make($request->password)]);
        return redirect()
            ->route('applicant.login.registration')
            ->with('success', 'পাসওয়ার্ড হালনাগাদ হয়েছে');
    }
    public function new_nid_verify_mobile_reg_first(Request $request,NIDVerificationRepository $nidVerificationRepository)
    {
        $fields_message = [
            'nid_number' => 'জাতীয় পরিচয় পত্র দিতে হবে',
            'dob_number' => 'জাতীয় পরিচয় পত্র অনুযায়ী জন্ম তারিখ দিতে হবে',
        ];
        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }
        if ($message != '') {
            return response()->json([
                'success' => 'error',
                'message' => $message,
            ]);
        }

        $dob_in_db = str_replace('/', '-', $request->dob_number);
        if (pull_from_api_not_local_dummi()) {
            
          
           return $nidVerificationRepository->new_nid_verify_mobile_reg_first_api_call($request);


        } else {
            $Nid_information = DB::table('dummy_nids')
                ->where('national_id', '=', $request->nid_number)
                ->where('dob', '=', $dob_in_db)
                ->first();
            $get_additional_info_citizen = CitizenNIDVerifyRepository::getAdditionalInfoFromCitizen($request);
            // dd($get_additional_info_citizen);
            if (!empty($Nid_information)) {
                return response()->json([
                    'success' => 'success',
                    'name_bn' => $Nid_information->name_bn,
                    'father' => $Nid_information->father,
                    'mother' => $Nid_information->mother,
                    'national_id' => $Nid_information->national_id,
                    'gender' => $Nid_information->gender,
                    'present_address' => $Nid_information->present_address,
                    'permanent_address' => $Nid_information->permanent_address,
                    'dob' => $request->dob_number,
                    'email' => $get_additional_info_citizen['email'],
                    'designation' => $get_additional_info_citizen['designation'],
                    'organization' => $get_additional_info_citizen['organization'],
                    'organization_id' => $get_additional_info_citizen['organization_id'],
                    'message' => 'এন আই ডি তে সফলভাবে তথ্য পাওয়া গিয়েছে',
                ]);
            } else {
                return response()->json([
                    'success' => 'error',
                    'message' => 'কোন তথ্য খুজে পাওয়া যায় নাই',
                ]);
            }
        }
    }
    public function verify_account_mobile_reg_first(Request $request)
    {
        $fields_message = [
            'citizen_nid' => 'জাতীয় পরিচয় পত্র দিতে হবে',
            'name' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে নাম দিতে হবে',
            'father' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে পিতার নাম দিতে হবে',
            'mother' => 'জাতীয় পরিচয় পত্র অনুযায়ী বাংলাতে মাতার নাম দিতে হবে',
            'dob' => 'জাতীয় পরিচয় পত্র অনুযায়ী জন্ম তারিখ দিতে হবে',
            'citizen_gender' => 'লিঙ্গ দিতে হবে',
            'permanentAddress' => 'জাতীয় পরিচয় পত্র অনুযায়ী স্থায়ী ঠিকানা দিতে হবে',
            'presentAddress' => 'জাতীয় পরিচয় পত্র অনুযায়ী বর্তমান ঠিকানা দিতে হবে',
        ];
        $message = '';
        foreach ($fields_message as $key => $value) {
            if (empty($request->$key)) {
                $message .= $value . ' ,';
            }
        }
       
        $exits_user_by_nid=DB::table('users')->where('citizen_nid',$request->citizen_nid)->first();
        if(!empty($exits_user_by_nid))
        {
            $message .=  'জাতীয় পরিচয় পত্র '.$request->citizen_nid.' দিয়ে ইতিমধ্যে '.$exits_user_by_nid->mobile_no. ' এর সাথে নিবন্ধিত করা হয়েছে';
        }

        if ($message != '') {
            return response()->json([
                'success' => 'error',
                'message' => $message,
            ]);
        }

        CitizenNIDVerifyRepository::verify_citizen_by_nid($request);

        return response()->json([
            'success' => 'success',
            'message' => 'সফলভাবে আপনার প্রোফাইল সত্যায়িত হয়েছে',
        ]);
    }


    //forget password page
    public function forget_password()
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

        $data['page_title'] = 'নাগরিক পাসওয়ার্ড রিসেট ফর্ম';

        return view('citizen.password_reset_form')->with($data);
    }

    public function user_check_forget_password(Request $request)
    {
        $request->validate(
            [
                'mobile_number' => 'required',
            ],
            [
                'mobile_number.required' => 'মোবাইল নং লিখুন',
            ],
        );

        $user = DB::table('users')
            ->where('mobile_no', '=', $request->mobile_number)
            ->first();
        if (!empty($user)) {
            $otp = rand(1111, 9999);

            $update_otp = DB::table('users')
                ->where('id', '=', $user->id)
                ->update([
                    'otp' => $otp,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            if ($update_otp) {
                $message = ' সিস্টেমে পাসওয়ার্ড রিসেট সম্পন্ন করার জন্য নিম্নোক্ত ওটিপি ব্যবহার করুন। ওটিপি: ' . $otp . "\r\n" . 'ধন্যবাদ।';
                $mobile = $user->mobile_no;
                $this->send_sms($mobile, $message);
                return redirect()
                    ->route('mobile.first.registration.citizen.mobile.check', ['user_id' => encrypt($user->id)])
                    ->with('success', 'আপনার প্রদত্ত মোবাইল নম্বরে একটি ওটিপি প্রদান করা হয়েছে।  সেই ওটিপি প্রদান করে আপনার মোবাইল নম্বর যাচাই করুন');
            }
        } else {
            return redirect()
                ->back()
                ->with('Errormessage', 'আপনার তথ্য পাওয়া যায়নি');
        }
    }
    
    
    public function send_sms($mobile, $message)
    {
        // print_r($mobile.' , '.$message);exit('zuel');
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
}
