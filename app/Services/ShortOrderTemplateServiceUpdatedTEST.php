<?php

namespace App\Services;

class ShortOrderTemplateServiceUpdated
{
    public static function getShowCauseShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        // dd($appealInfo);
        //  $law_section = CrpcSection::where('id', $appealInfo['appeal']->law_section)->select('crpc_id')->first()->crpc_id;
        // $location = $appealInfo['appeal']->office_name;
        // $upazila_name_bn = Upazila::where('id', $appealInfo['appeal']->upazila_id)->select('upazila_name_bn')->first()->upazila_name_bn;
        $case_date = $appealInfo['appeal']->case_date;
        $next_date = $appealInfo['appeal']->next_date;
        $case_no = $appealInfo['appeal']->case_no;
        $applicant = $appealInfo['applicantCitizen'];
        $defaulter = $appealInfo['defaulterCitizen'];
        //  $witness = $appealInfo['witnessCitizen'];
        //  $guarantorCitizen = $appealInfo['guarantorCitizen'];
        $case_details = str_replace('&nbsp;', '', strip_tags($appealInfo['appeal']->case_details));
        //  $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        //  $trialNextBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($next_date)));
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        //     $trialTime = date('h:i:s', strtotime($causeList->trial_time));
        // $trialTimeAmPm = date('a', strtotime($causeList->trial_time));
        // $time = '';
        // if ($trialTimeAmPm == 'am') {
        //     $time = 'সকাল';
        // } else {
        //     $time = 'বিকাল';
        // }
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        //   $caseBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($case_date)));
        //  $caseBanglaDay = DataConversionService::toBangla(date('d', strtotime($case_date)));
        //   $caseBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($case_date)));
        // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        //   $caseBanglaYear = DataConversionService::toBangla(date("Y", strtotime($case_date)));
        //   $trialNextBanglaYear = DataConversionService::toBangla(date("Y", strtotime($next_date)));

        $caseNextBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($next_date)));
        //     $caseNextBanglaDay = DataConversionService::toBangla(date('d', strtotime($next_date)));
        //     $caseNextBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($next_date)));
        // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        //    $caseNextBanglaYear = DataConversionService::toBangla(date("Y", strtotime($next_date)));

        $template = '
            <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                            padding: 10px;
                            font-weight: normal;
                        }
                    </style>
            <div style="text-align: center">
                <span style="font-size: medium;text-align: center;">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট<br>বাংলাদেশ ফর্ম নং-৩৩৮ </span>
            </div>
            <div style="text-align: right">
                <span style="font-size: medium;">স্মারক নং.................. </span>
            </div>
            <div style="text-align: left">
                <span style="font-size: medium;">তারিখ ' . $trialBanglaDate . '</span>
            </div>
                        <header>
                            <div style="text-align: center">
                                <h2>কারন দর্শাইবার নোটিশ</h2> <br>
                            </div>
                        </header>
             <br>

             <br>
             <br>
             <div style="height:100%; padding: 10px;">
                <span style="float: left; font-size: medium">জিলা-' . user_district_name() . '   মোকাম ' . globalUserInfo()->name . ' এর<br>আদালত <br>মোকদ্দমা নং :' . $case_no . '    সন ' . $trialBanglaYear . '   ইং
                </span>
                <br><br><br><br><br>
                <span style="float: center;">
                      নাম:- ' . $defaulter[0]->citizen_name . ', ঠিকানাঃ- ' . $defaulter[0]->present_address . ' ।
                </span>
                <br><br><br><br><br>

                 <span style="float: left;">যেহেতু ' . $applicant[0]->citizen_name . ' অত্র আদালতে দরখাস্ত করিয়াছেন যে,
                                            ' . $case_details . '
                                            অতএব আপনাকে এতদ্বারা সাবধান করিয়া দেওয়া যাইতেছে যে,আপনি স্বয়ং বা রীতিমত উপদেশ প্রাপ্ত ' . $caseNextBanglaDate . '  তারিখ পূর্বাহ্নে বেলা ১০ ঘটিকার  সময় এই আদালতে উপস্থিত হইয়া উক্ত দরখাস্তের বিরুদ্ধে কারন  দর্শাইবেন নতুবা উক্ত দরখাস্তের একতরফা শুনাণী ও বিচার হইবে।


                 </span>
                <br><br><br>
                <br>
                <p>ইতি-অদ্য সন ' . $trialBanglaYear . '  সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' তারিখে

                    </p>

                 <p style=" text-align : left; color: blueviolet;">
                        <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">

                        <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . globalUserRoleInfo()->role_name . ', ' . user_district_name() . '
                    </p>
            </div>';
        // dd($template);
        return $template;
    }

}
