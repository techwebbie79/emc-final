<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class LogManagementRepository
{
    public static function citizen_appeal_store($request_data, $appealId, $log_file_data)
    {
        $case_basic_info = [
            'appealId' => $appealId,
            'appealEntryType' => $request_data->appealEntryType,
            'caseEntryType' => $request_data->caseEntryType,
            'is_own_case' => $request_data->is_own_case,
            'caseDate' => $request_data->caseDate,
            'lawSection' => $request_data->lawSection,
            'division' => $request_data->division,
            'district' => $request_data->district,
            'upazila' => $request_data->upazila,
            'case_details' => $request_data->case_details,
            'note' => $request_data->note,
            'status' => $request_data->status,
        ];

        $case_basic_info = json_encode($case_basic_info);
        $applicant = json_encode($request_data->applicant);
        $victim = json_encode($request_data->victim);
        $lawyer = json_encode($request_data->lawyer);

        $defaulter = [];

        $outeriteration = sizeof($request_data->defaulter['name']);
        for ($i = 0; $i < $outeriteration; $i++) {
            // $defaulterchild=[
            //  'name'=>isset($request_data->defaulter['name'][$i]) ? $request_data->defaulter['name'][$i] : NULL,
            //  'type'=>isset($request_data->defaulter['type'][$i]) ? $request_data->defaulter['type'][$i] : NUll,
            //  'id'=>isset($request_data->defaulter['id'][$i]) ? $request_data->defaulter['id'][$i] : NULL,
            //  'thana'=>isset($request_data->defaulter['thana'][$i] ) ? $request_data->defaulter['thana'][$i] : NUll,
            //  'upazilla'=>isset($request_data->defaulter['upazilla'][$i]) ? $request_data->defaulter['upazilla'][$i]: NULL,
            //  'age'=>isset($request_data->defaulter['age'][$i] )? $request_data->defaulter['age'][$i]: NULL,
            //  'gender'=>isset($request_data->defaulter['gender'][$i] ) ? $request_data->defaulter['gender'][$i] : NULL,
            //  'father'=>isset($request_data->defaulter['father'][$i]) ? $request_data->defaulter['father'][$i]: NULL ,
            //  'mother'=>isset($request_data->defaulter['mother'][$i]) ? $request_data->defaulter['mother'][$i]: NULL,
            //  'nid'=>isset($request_data->defaulter['nid'][$i]) ? $request_data->defaulter['nid'][$i]: NULL,
            //  'phn'=>isset($request_data->defaulter['phn'][$i]) ? $request_data->defaulter['phn'][$i]: NULL,
            //  'presentAddress'=>isset($request_data->defaulter['presentAddress'][$i]) ? $request_data->defaulter['presentAddress'][$i]: NULL,
            //  'email'=>isset($request_data->defaulter['email'][$i]) ? $request_data->defaulter['email'][$i]: NULL,
            // ];

            $defaulterchild = [];
            foreach ($request_data->defaulter as $key => $value) {
                $defaulterchild[$key] = isset($request_data->defaulter[$key][$i]) ? $request_data->defaulter[$key][$i] : null;
            }

            array_push($defaulter, $defaulterchild);
        }

        //dd($defaulter);

        $witness = [];

        $outeriteration = sizeof($request_data->witness['name']);
        for ($i = 0; $i < $outeriteration; $i++) {
            $witnesschild = [];
            foreach ($request_data->witness as $key => $value) {
                $witnesschild[$key] = isset($request_data->witness[$key][$i]) ? $request_data->witness[$key][$i] : null;
            }

            array_push($witness, $witnesschild);
        }

        //dd($witness);

        $user = globalUserInfo();
        if ($user->role_id == 28) {
            $activity = 'সংশোধন ও প্রেরণ এক্সিকিউটিভ ম্যাজিস্ট্রেট বরাবর';
            $activity .= '<br>';
            $activity .= '<span>মন্তব্য : ' . $request_data->peshkar_comment . '<span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (ইএম)';
            }
        } elseif ($user->role_id == 36) {
            $activity = 'অভিযোগ দায়ের (সিটিজেন)   ';
            $activity .= '<br>';
            $activity .= '<span>মামলার নোট  : ' . $request_data->note . '<span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'সিটিজেন';
            }
        } elseif ($user->role_id == 39) {
            $activity = 'সংশোধন ও প্রেরণ জেলা ম্যাজিস্ট্রেট বরাবর';
            $activity .= '<br>';
            $activity .= '<span>মন্তব্য : ' . $request_data->peshkar_comment . '<span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (এডিএম)';
            }
        } elseif ($user->role_id == 20) {
            $activity = 'অভিযোগ দায়ের (আইনজীবী)   ';
            $activity .= '<br>';
            $activity .= '<span>মামলার নোট  : ' . $request_data->note . '<span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'আইনজীবী';
            }
        }

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');
        $em_log_book = [
            'appeal_id' => $appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'files' => $log_file_data,
            'case_basic_info' => $case_basic_info,
            'applicant' => $applicant,
            'victim' => $victim,
            'defaulter' => json_encode($defaulter),
            'witness' => json_encode($witness),
            'lawyer' => $lawyer,
            'details_url' => '/log/logid/details',
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($em_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function peskar_appeal_store($request_data, $appealId, $log_file_data)
    {
        if (!empty($request_data->defaulter_change)) {
            $defaulter = [];

            $outeriteration = sizeof($request_data->defaulter['name']);
            for ($i = 0; $i < $outeriteration; $i++) {
                $defaulterchild = [];
                foreach ($request_data->defaulter as $key => $value) {
                    $defaulterchild[$key] = isset($request_data->defaulter[$key][$i]) ? $request_data->defaulter[$key][$i] : null;
                }

                array_push($defaulter, $defaulterchild);
            }
        } else {
            $defaulter = null;
        }

        if (!empty($request_data->defaulter_withness_change)) {
            $defaulerWithness = [];

            $outeriteration = sizeof($request_data->defaulerWithness['name']);
            for ($i = 0; $i < $outeriteration; $i++) {
                $defaulerWithnesschild = [];
                foreach ($request_data->defaulerWithness as $key => $value) {
                    $defaulerWithnesschild[$key] = isset($request_data->defaulerWithness[$key][$i]) ? $request_data->defaulerWithness[$key][$i] : null;
                }

                array_push($defaulerWithness, $defaulerWithnesschild);
            }
        } else {
            $defaulerWithness = null;
        }

        if (!empty($request_data->defaulter_lawyer_change)) {
            $defaulerLawyer = [];

            $outeriteration = sizeof($request_data->defaulerLawyer['name']);
            for ($i = 0; $i < $outeriteration; $i++) {
                $defaulerLawyerchild = [];
                foreach ($request_data->defaulerLawyer as $key => $value) {
                    $defaulerLawyerchild[$key] = isset($request_data->defaulerLawyer[$key][$i]) ? $request_data->defaulerLawyer[$key][$i] : null;
                }

                array_push($defaulerLawyer, $defaulerLawyerchild);
            }
        } else {
            $defaulerLawyer = null;
        }
        
        if(!empty($request_data->defaulter_change) || !empty($request_data->defaulter_withness_change) || !empty($request_data->defaulter_lawyer_change) )
        {
            $details_url = '/log/logid/details';
        }
        else
        {
            $details_url = null;
        }

        $user = globalUserInfo();
        if ($user->role_id == 28) {
            if ($request_data->status = 'SEND_TO_EM') {
                $activity = 'সংশোধন ও প্রেরণ এক্সিকিউটিভ ম্যাজিস্ট্রেট বরাবর';
                $activity .= '<br>';
                $activity .= $request_data->note;
            } else {
                $activity = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট বরাবর';
                $activity .= '<br>';
                $activity = '<span>মামলা চলমান : ' . $request_data->note . '</span>';
            }

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (ইএম)';
            }
        } elseif ($user->role_id == 39) {
            if ($request_data->status = 'SEND_TO_DM') {
                $activity = 'সংশোধন ও প্রেরণ জেলা ম্যাজিস্ট্রেট বরাবর';
                $activity .= '<br>';
                $activity .= $request_data->note;
            } else {
                $activity = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট বরাবর';
                $activity .= '<br>';
                $activity = '<span>মামলা চলমান : ' . $request_data->note . '</span>';
            }

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (এডিএম)';
            }
        }

        if (isset($request_data->manual_case_no)) {
            $activity .= '<br>';
            $activity .= '<span>ম্যানুয়াল মামলা নং  : ' . $request_data->manual_case_no . '</span>';
        }
        if (isset($request_data->court_fee_amount)) {
            $activity .= '<br>';
            $activity .= '<span>কোর্ট ফি পরিমাণ  : ' . $request_data->court_fee_amount . '</span>';
        }

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'files' => $log_file_data,
            //'case_basic_info' => $case_basic_info,
            // 'applicant' => $applicant,
            //'victim' => $victim,
            'defaulter' => isset($defaulter) ? json_encode($defaulter) : null,
            'defaulter_witness' => isset($defaulerWithness) ? json_encode($defaulerWithness) : null,
            'defaulter_lawyer' => isset($defaulerLawyer) ? json_encode($defaulerLawyer) : null,
            //'lawyer' => $lawyer,
            'details_url' => isset($details_url) ? $details_url : null,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($em_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function Appealfiledelete($attachment, $appeal_id)
    {
        $user = globalUserInfo();

        if ($user->role_id == 28) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে পেশকার (ইএম)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (ইএম)';
            }
        } elseif ($user->role_id == 27) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(এক্সিকিউটিভ ম্যাজিস্ট্রেট)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(জেলা ম্যাজিস্ট্রেট)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে(অতিরিক্ত জেলা ম্যাজিস্ট্রেট)</span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 39) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে পেশকার (ডিম / এডিম) </span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'পেশকার (ডিম / এডিম)';
            }
        } elseif ($user->role_id == 7) {
            $activity = '<span>ফাইল মুছে ফেলা হয়েছে অতিরিক্ত জেলা প্রশাসক (এডিসি) </span>';
            $activity .= '<br>';
            $activity .= '<span>ফাইল এর নাম <strong>' . $attachment->file_category . '</strong></span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function storeOnTrialInfo($request_data, $appealId, $log_file_data)
    {
        //dd($log_file_data);

        $user = globalUserInfo();

        if ($request_data->status == 'CLOSED') {
            $activity = '<span>মামলা নিষ্পত্তি করা হয়েছে : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সম্পূর্ণ আদেশ প্রকাশের তারিখ : ' . $request_data->finalOrderPublishDate . '</span>';
            $activity .= '<br>';
            if ($request_data->orderPublishDecision == 1) {
                $activity .= '<span>সম্পূর্ণ আদেশ প্রকাশ  হ্যাঁ </span>';
            } else {
                $activity .= '<span>সম্পূর্ণ আদেশ প্রকাশ  না </span>';
            }
        } elseif ($request_data->status == 'REJECTED') {
            $activity = '<span>মামলা বাতিল করা হয়েছে : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>পরবর্তী তারিখ : ' . $request_data->trialDate . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সময়  : ' . $request_data->trialTime . '</span>';
        } elseif ($request_data->status == 'ON_TRIAL') {
            $activity = '<span>মামলা চলমান : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>পরবর্তী তারিখ : ' . $request_data->trialDate . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সময়  : ' . $request_data->trialTime . '</span>';
        } else {
            $activity = '<span>মামলা গ্রহণ ও সংক্ষিপ্ত আদেশ : ' . $request_data->note . '</span>';
            $activity .= '<br>';
            $activity .= '<span>পরবর্তী তারিখ : ' . $request_data->trialDate . '</span>';
            $activity .= '<br>';
            $activity .= '<span>সময়  : ' . $request_data->trialTime . '</span>';
        }

        $activity .= '<br>';

        if (isset($request_data->nothiID)) {
            $activity .= '<span>তদন্তকারীর নথি  : ' . $request_data->nothiID . '</span>';
        }
        if (isset($request_data->investigatorName)) {
            $activity .= '<br>';
            $activity .= '<span>তদন্তকারীর নাম  : ' . $request_data->investigatorName . '</span>';
        }
        if (isset($request_data->investigatorInstituteName)) {
            $activity .= '<br>';
            $activity .= '<span>তদন্তকারীর প্রতিষ্ঠানের নাম  : ' . $request_data->investigatorInstituteName . '</span>';
        }
        if (isset($request_data->investigatorMobile)) {
            $activity .= '<br>';
            $activity .= '<span>তদন্তকারীর মোবাইল  : ' . $request_data->investigatorMobile . '</span>';
        }
        if (isset($request_data->investigatorEmail)) {
            $activity .= '<br>';
            $activity .= '<span>তদন্তকারীর ইমেইল  : ' . $request_data->investigatorEmail . '</span>';
        }
        if (isset($request_data->investigatorDesignation)) {
            $activity .= '<br>';
            $activity .= '<span>তদন্তকারীর পদবী  : ' . $request_data->investigatorDesignation . '</span>';
        }

        if (isset($request_data->warrantExecutorName)) {
            $activity .= '<br>';
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারীর নাম  : ' . $request_data->warrantExecutorName . '</span>';
        }
        if (isset($request_data->warrantExecutorInstituteName)) {
            $activity .= '<br>';
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারীর প্রতিষ্ঠানের নাম  : ' . $request_data->warrantExecutorInstituteName . '</span>';
        }
        if (isset($request_data->warrantExecutorMobile)) {
            $activity .= '<br>';
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারীর মোবাইল  : ' . $request_data->warrantExecutorMobile . '</span>';
        }
        if (isset($request_data->warrantExecutorEmail)) {
            $activity .= '<br>';
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারীর ইমেইল  : ' . $request_data->warrantExecutorEmail . '</span>';
        }
        if (isset($request_data->warrantExecutorDesignation)) {
            $activity .= '<br>';
            $activity .= '<span>ওয়ারেন্ট বাস্তবায়নকারীর পদবী  : ' . $request_data->warrantExecutorDesignation . '</span>';
        }

        if (isset($request_data->law_enforcement_forces_Name)) {
            $activity .= '<br>';
            $activity .= '<span>আইনশৃঙ্খলা বাহিনী নাম  : ' . $request_data->law_enforcement_forces_Name . '</span>';
        }
        if (isset($request_data->law_enforcement_forces_InstituteName)) {
            $activity .= '<br>';
            $activity .= '<span>আইনশৃঙ্খলা বাহিনী প্রতিষ্ঠানের নাম  : ' . $request_data->law_enforcement_forces_InstituteName . '</span>';
        }
        if (isset($request_data->law_enforcement_forces_Mobile)) {
            $activity .= '<br>';
            $activity .= '<span>আইনশৃঙ্খলা বাহিনী মোবাইল  : ' . $request_data->law_enforcement_forces_Mobile . '</span>';
        }
        if (isset($request_data->law_enforcement_forces_Email)) {
            $activity .= '<br>';
            $activity .= '<span>আইনশৃঙ্খলা বাহিনী ইমেইল  : ' . $request_data->law_enforcement_forces_Email . '</span>';
        }
        if (isset($request_data->law_enforcement_forces_Designation)) {
            $activity .= '<br>';
            $activity .= '<span>আইনশৃঙ্খলা বাহিনী পদবী  : ' . $request_data->law_enforcement_forces_Designation . '</span>';
        }

        if (isset($request_data->zillSuperName)) {
            $activity .= '<br>';
            $activity .= '<span>জেল সুপার  নাম  : ' . $request_data->zillSuperName . '</span>';
        }
        if (isset($request_data->zillSuperInstituteName)) {
            $activity .= '<br>';
            $activity .= '<span>জেল সুপার প্রতিষ্ঠানের নাম  : ' . $request_data->zillSuperInstituteName . '</span>';
        }
        if (isset($request_data->zillSuperMobile)) {
            $activity .= '<br>';
            $activity .= '<span>জেল সুপার মোবাইল  : ' . $request_data->zillSuperMobile . '</span>';
        }
        if (isset($request_data->zillSuperEmail)) {
            $activity .= '<br>';
            $activity .= '<span>জেল সুপার ইমেইল  : ' . $request_data->zillSuperEmail . '</span>';
        }

        if (isset($request_data->receiver_Name)) {
            $activity .= '<br>';
            $activity .= '<span> রিসিভার নাম  : ' . $request_data->receiver_Name . '</span>';
        }
        if (isset($request_data->receiver_InstituteName)) {
            $activity .= '<br>';
            $activity .= '<span> রিসিভার প্রতিষ্ঠানের নাম  : ' . $request_data->receiver_InstituteName . '</span>';
        }
        if (isset($request_data->receiver_Mobile)) {
            $activity .= '<br>';
            $activity .= '<span>  রিসিভার মোবাইল  : ' . $request_data->receiver_Mobile . '</span>';
        }
        if (isset($request_data->receiver_Email)) {
            $activity .= '<br>';
            $activity .= '<span>  রিসিভার ইমেইল  : ' . $request_data->receiver_Email . '</span>';
        }

        if (isset($request_data->bond_amount)) {
            $activity .= '<br>';
            $activity .= '<span> বন্ড টাকা  : ' . $request_data->bond_amount . '</span>';
        }
        if (isset($request_data->bond_period)) {
            $activity .= '<br>';
            $activity .= '<span> সময় (বছর)  : ' . $request_data->bond_period . '</span>';
        }
        if(isset($request_data->complain_detail))
        {
            $activity .= '<br>';
            $activity .= '<span> অভিযোগের সংক্ষিপ্ত বিবরণ: ' . $request_data->complain_detail . '</span>';
        }

        $activity .= '<br>';

        if ($user->role_id == 27) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 7) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'files' => $log_file_data,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function investigationreportsubmit($request_data, $investigator_details_array)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $request_data['appeal_id'],
            'user_id' => '',
            'activity' => 'তদন্ত রিপোর্ট জমা দেয়া হয়েছে',
            'investigation_report' => json_encode($request_data),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function investigationreportAccept($request_data, $investigator_details_array)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $request_data['appeal_id'],
            'user_id' => '',
            'activity' => 'তদন্ত রিপোর্ট জমা দেয়া হয়েছে',
            'investigation_report' => json_encode($request_data),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function investigationreportDelete($investigation_report_array, $investigator_details_array, $appeal_id)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 28) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন পেশকার (ইএম)</span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'ইএম';
            }
        } elseif ($user->role_id == 27) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (এক্সিকিউটিভ ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (অতিরিক্ত জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 7) {
            $activity = '<span>তদন্ত রিপোর্ট মুছে ফেলেছেন (অতিরিক্ত জেলা প্রশাসক (এডিসি))</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'investigation_report' => json_encode($investigation_report_array),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function investigationreportApprove($investigation_report_array, $investigator_details_array, $appeal_id)
    {
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 28) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন পেশকার (ইএম)</span>';
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = ' পেশকার ইএম';
            }
        } elseif ($user->role_id == 27) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (এক্সিকিউটিভ ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (অতিরিক্ত জেলা ম্যাজিস্ট্রেট)</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 7) {
            $activity = '<span>তদন্ত রিপোর্ট গ্রহণ করেছেন (অতিরিক্ত জেলা প্রশাসক (এডিসি))</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'investigation_report' => json_encode($investigation_report_array),
            'investigator_details' => json_encode($investigator_details_array),
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function assign_ADC($appeal_id, $user_adc)
    {
        // dd($user);

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 37) {
            $activity = '<span>অতিরিক্ত জেলা প্রশাসক কে এই মামলাটি  আসাইন করেছেন জেলা ম্যাজিস্ট্রেট</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মামলা ' . $user_adc['name'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মোবাইল ' . $user_adc['mobile_no'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর ইমেইল ' . $user_adc['email'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর দপ্তর আইডি / ইউজারনেম ' . $user_adc['username'] . '</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }

    public static function remove_assign_ADC($appeal_id, $user_adc)
    {
        //dd($user);

        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $user = globalUserInfo();

        if ($user->role_id == 37) {
            $activity = '<span>অতিরিক্ত জেলা প্রশাসক কে এই মামলাটি থেকে আবসান করেছেন জেলা ম্যাজিস্ট্রেট</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মামলা ' . $user_adc['name'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর নাম মোবাইল ' . $user_adc['mobile_no'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর ইমেইল ' . $user_adc['email'] . '</span>';
            $activity .= '<br>';
            $activity .= '<span>অতিরিক্ত জেলা প্রশাসক এর দপ্তর আইডি / ইউজারনেম ' . $user_adc['username'] . '</span>';

            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        }

        $em_log_book = [
            'appeal_id' => $appeal_id,
            'user_id' => $user->id,
            'activity' => $activity,
            'designation' => $designation,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
    public static function RejectAppeal($request_data)
    {
        $user = globalUserInfo();

      if ($request_data->status == 'REJECTED') {
            $activity = '<span>মামলা বাতিল করা হয়েছে : ' . $request_data->note . '</span>';
            $activity .= '<br>';
         
        } 

        $activity .= '<br>';

        if ($user->role_id == 27) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'এক্সিকিউটিভ ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 37) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 38) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা ম্যাজিস্ট্রেট';
            }
        } elseif ($user->role_id == 7) {
            if (isset($user->designation)) {
                $designation = $user->designation;
            } else {
                $designation = 'অতিরিক্ত জেলা প্রশাসক (এডিসি)';
            }
        }
        $obj = new UserAgentRepository();

        $browser = $obj->detect()->getInfo();
        date_default_timezone_set('Asia/Dhaka');

        $em_log_book = [
            'appeal_id' => $request_data->appealId,
            'user_id' => $user->id,
            'designation' => $designation,
            'activity' => $activity,
            'browser' => $browser,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        //dd($gcc_log_book);
        DB::table('em_log_book')->insert($em_log_book);
    }
}
