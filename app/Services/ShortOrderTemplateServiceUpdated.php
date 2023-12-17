<?php

namespace App\Services;

use App\Models\CrpcSection;
use App\Models\EmCaseShortdecisionTemplates;
use App\Models\Upazila;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShortOrderTemplateServiceUpdated
{
    public static function getShortOrderTemplateListByAppealId($appealId)
    {
        $templateList = DB::table('em_case_shortdecision_templates')->where('appeal_id', $appealId)->get();
        return $templateList;
    }

    public static function deleteShortOrderTemplate($causeListId)
    {
        $shortOrderList = EmCaseShortdecisionTemplates::where('cause_list_id', $causeListId);
        // dd($shortOrderList);
        $shortOrderList->delete();
        return;
    }

    public static function storeShortOrderTemplate($shortOrderId, $appealId, $causeListId, $shortOrderTemplateContent, $templateName)
    {
        $shortOrderTemplate = new EmCaseShortdecisionTemplates();
        $shortOrderTemplate->appeal_id = $appealId;
        $shortOrderTemplate->cause_list_id = $causeListId;
        $shortOrderTemplate->case_shortdecision_id = $shortOrderId;
        $shortOrderTemplate->template_full = $shortOrderTemplateContent;
        $shortOrderTemplate->template_header = '';
        $shortOrderTemplate->template_body = '';
        $shortOrderTemplate->template_name = $templateName;
        $shortOrderTemplate->created_at = date('Y-m-d H:i:s');
        $shortOrderTemplate->created_by = Auth::user()->username;
        $shortOrderTemplate->updated_at = date('Y-m-d H:i:s');
        $shortOrderTemplate->updated_by = Auth::user()->username;
        $shortOrderTemplate->save();
        return $shortOrderTemplate->id;
    }
    public static function generateShortOrderTemplate($shortOrders, $appealId, $causeList, $requestInfo)
    {
        $appealInfo = AppealRepository::getAllAppealInfo($appealId);
        // self::deleteShortOrderTemplate($causeList->id);
        // if(count($shortOrders)>0){
        if ($shortOrders != null) {

            $templateIds = [];

            foreach ($shortOrders as $shortOrder) {

                //-------------------সমন জারী---------------------------//
                if ($shortOrder == 1) {
                    $templateName = "প্রসিডিং পূর্ব শোকজ";
                    $shortOrderTemplate = self::getShowCauseShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                if ($shortOrder == 5) {
                    $templateName = "তদন্ত";
                    $shortOrderTemplate = self::getinvestigationRequestShortOrderTemplate($appealInfo, 5, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                if ($shortOrder == 2) {
                    $templateName = "প্রসিডিং পূর্ব ইনকোয়ারি";
                    $shortOrderTemplate = self::getinvestigationRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo, 2, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                if ($shortOrder == 21) {
                    $templateName = "প্রাথমিক তদন্ত";
                    $shortOrderTemplate = self::getinvestigationRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo, 21, $requestInfo);
                    // dd($shortOrderTemplate);

                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------সমন জারী---------------------------//
                if ($shortOrder == 7) {
                    $templateName = "সমন জারী";
                    $shortOrderTemplate = self::getSommonRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------স্বাক্ষীর প্রতি সমন জারী---------------------------//
                if ($shortOrder == 8) {
                    $templateName = "স্বাক্ষীর প্রতি সমন জারী";
                    $shortOrderTemplate = self::getWitnesSommonRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------অন্তর্বর্তীকালীন মুচলেকা---------------------------//
                if ($shortOrder == 9) {
                    $templateName = "অন্তর্বর্তীকালীন মুচলেকা";
                    $shortOrderTemplate = self::getInterimBondRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------শুনানি---------------------------//
                if ($shortOrder == 10) {
                    $templateName = "শুনানি";
                    $shortOrderTemplate = self::getHearingRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------গ্রেফতারী পরোয়ানা---------------------------//
                if ($shortOrder == 19) {
                    $templateName = "গ্রেফতারী পরোয়ানা";
                    $shortOrderTemplate = self::getArrestWarrentShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------শান্তিরক্ষার মুচলেকা---------------------------//
                if ($shortOrder == 20) {
                    $templateName = "শান্তি রক্ষার মুচলেকা";
                    $shortOrderTemplate = self::getPeaceBondShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    // dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

                //-------------------কারণ দর্শানো নোটিশ---------------------------//
                if ($shortOrder == 22) {
                    $templateName = "কারণ দর্শানো নোটিশ";
                    $shortOrderTemplate = self::getShowCauseShortOrderTemplate($appealInfo, $shortOrder, $requestInfo);
                    //  dd($shortOrderTemplate);
                    $template_id = self::storeShortOrderTemplate($shortOrder, $appealId, null, $shortOrderTemplate, $templateName);
                    array_push($templateIds, $template_id);
                    return $templateIds;
                }

            }
        }

    }

    //----------- তদন্ত -----------------------------------------//
    public static function getInvestigationRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        
       
        $case_details_em=$requestInfo->complain_detail;
        $defaulter = $appealInfo['defaulterCitizen'];
       

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $conductBanglaDate = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));

        $conductBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $conductBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $modified_next_date = date_formater_helpers_v2(str_replace('/', '-', $requestInfo->trialDate));

        $NextBanglaDate = DataConversionService::toBangla(date('d', strtotime($modified_next_date)));

        $NextBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_next_date)));

        $NextBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_next_date)));

        $caseOrderConductBanglaDateFinal = $conductBanglaYear . ' সালের ' . $conductBanlaMonth . ' মাসের ' . $conductBanglaDate . ' তারিখ ';
        $defaulter_names = [];
        foreach ($defaulter as $key => $value) {
            array_push($defaulter_names, $value->citizen_name);
        }
        $template = '
        <body>

        <div class="container">
            <div class="row">
                <div class="col-md-12 pt-5">
                    <div>
                        <h4 class="text-center">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত</h4>
                        <h4 class="text-center"> জেলা ম্যাজিস্ট্রেট এর কার্যালয়, ' . user_district_name() . ' ।</h4>
                        <br><br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p > জনাব ' . $requestInfo->investigatorName . ', ' . $requestInfo->investigatorDesignation . ', ' . $requestInfo->investigatorInstituteName . ' সমীপে-</p>

                            <p style="text-align: justify">যেহেতু আমার নিকট সংবাদ দেওয়া হইয়াছে যে,(' . $case_details_em . ' , অপরাধ সংঘটিত হইয়াছে বা সংঘটিত হইয়াছে বলিয়া সন্দেহ করা হইতেছে) এবং আমার নিকট প্রতীয়মান হইয়াছে যে,অপরাধটি বা সন্দেহকৃত অপরাধটি সম্পর্কে এক্ষণে বিস্তারিত তদন্ত অত্যাবশ্যক;সেহেতু-এতদ্বারা আপনাকে ক্ষমতা ও নির্দেশ দেওয়া যাইতেছে যে,আপনি  উক্ত (' . implode(',', $defaulter_names) . ') ব্যক্তির নামে যে নালিশ করা হইয়াছে, এর জন্য তদন্ত চালাইবেন এবং উহার ফলাফল প্রতিবেদন আকারে  এই আদালতে হাজির করিবেন।
                            </p>
                            <div class="row">
                                <div class="col-md-4">তারিখ ঃ ' . $caseOrderConductBanglaDateFinal . '।</div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="color: blueviolet;">
                                 <p style="text-align:center;padding: 0;margin: 0;">সাক্ষরঃ <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50"></p>
                                 <p style="text-align:center;padding: 0;margin: 0;">এক্সিকিউটিভ ম্যাজিস্ট্রেট</p>
                                 <p style="text-align:center;padding: 0;margin: 0;">' . user_district_name() . '</p>
                                </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
        ';
         //dd($template);
        return $template;
    }

    //----------- সমন জারী -----------------------------------------//
    public static function getSommonRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        $law_section = CrpcSection::where('id', $appealInfo['appeal']->law_section)->select('crpc_id')->first()->crpc_id;
        // $location = $appealInfo['appeal']->office_name;
        //   $case_date = $appealInfo['appeal']->case_date;
        $defaulter = $appealInfo['defaulterCitizen'];
        //  $guarantorCitizen = $appealInfo['guarantorCitizen'];
        //  $case_details = str_replace('&nbsp;', '', strip_tags($appealInfo['appeal']->case_details));
        // dd($case_details);
        //  $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $modified_trial_date = date_formater_helpers($requestInfo->trialDate);

        //  $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->trial_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_trial_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_trial_date)));
        //   $trialTime = date('h:i:s a', strtotime($causeList->trial_time));
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_trial_date)));

        //   $caseBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($case_date)));
        //   $caseBanglaDay = DataConversionService::toBangla(date('d', strtotime($case_date)));
        //    $caseBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($case_date)));
        // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        //   $caseBanglaYear = DataConversionService::toBangla(date("Y", strtotime($case_date)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaDay_send_day = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth_send_month = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        $trialBanglaYear_send_year = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));
        $template = '
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 pt-10 ">
                            <div class="head_part text-center">
                                <h3 >নির্বাহী ম্যজিস্ট্রেট এর আদালত</h2>
                                <h4 >…………।</h4>
                                <h6>বাংলাদেশ ফর্ম নং-৩৩৮</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-9"></div>
                                <div class="col-md-3">
                                    <p>স্মারক নং..................</p>
                                    <p>তারিখ ২৯-০৮-২০২৩</p>
                                </div>
                            </div>
                            <h3 class="text-center">আসামীর প্রতি সমন</h3>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    <p>জিলা-ঢাকা   মোকাম শেখ রাসেল হাসান ।</p>
                                    <p>মোকদ্দমা নংDHAEM-1-12-2023-15    সন ২০২৩  ইং</p>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4 text-center">
                                    <p>আদালত</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <p > প্রাপক, <br> নাম: ' . $defaulter[0]->citizen_name . ' পিতা: ' . $defaulter[0]->father . ' ঠিকানা: ' . $defaulter[0]->present_address . ' সমীপে-</p>

                                    <p> যেহেতু আপনার বিরুদ্ধেফৌজদারী কার্যবিধির ১০৭ ধারার অভিযোগের অভিযোগ অসিয়াছে, সেহেতু উহার উত্তর প্রদানের জন্য আপনি ১৯৭০ সালের জানুয়ারী মাসের ০১ তারিখে স্বয়ং অথবা উকিলের মাধ্যমে আমার সমক্ষে হাজির হইবেন। ইহার যেন অন্যথা না হয়।</p>

                                    <p>তারিখঃ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' তারিখ। </p>
                                    <p style=" text-align : left; color: blueviolet;">
                                        <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">

                                    <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . globalUserRoleInfo()->role_name . ', ' . user_district_name() . '
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </body>
        ';

        // dd($template);
        return $template;
    }

    //----------- স্বাক্ষীর প্রতি সমন জারী -----------------------------------------//
    public static function getWitnesSommonRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        // dd($appealInfo);
        //$location = $appealInfo['appeal']->office_name;
        $case_date = $appealInfo['appeal']->case_date;
        $defaulter = $appealInfo['defaulterCitizen'];
        $witness = $appealInfo['witnessCitizen'];
        //$guarantorCitizen = $appealInfo['guarantorCitizen'];
        $case_details = str_replace('&nbsp;', '', strip_tags($appealInfo['appeal']->case_details));
        //$loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        $modified_trial_date = date_formater_helpers($requestInfo->trialDate);

        $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_trial_date)));
        $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_trial_date)));
        $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_trial_date)));
        $trialTime = date('h:i:s', strtotime($requestInfo->trial_time));
        $trialTimeAmPm = date('a', strtotime($requestInfo->trial_time));
        $time = '';
        if ($trialTimeAmPm == 'am') {
            $time = 'সকাল';
        } else {
            $time = 'বিকাল';
        }
        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_trial_date)));

        // $caseBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($case_date)));
        // $caseBanglaDay = DataConversionService::toBangla(date('d', strtotime($case_date)));
        // $caseBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($case_date)));
        // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        //  $caseBanglaYear = DataConversionService::toBangla(date("Y", strtotime($case_date)));
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $trialBanglaDay_send_day = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth_send_month = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        $trialBanglaYear_send_year = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $template = '
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                            padding: 10px;
                            font-weight: normal;
                        }
                    </style>
            <div >
                <span style="font-size:  medium;">বাংলাদেশ ফরম নং ১০২৮  </span>
                        <header>
                            <div style="text-align: center">
                                <h3>স্বাক্ষীর প্রতি সমন</h3>

                            </div>
                        </header>
             <br>

             <br>
             <br>
            <div style="height:100%">
                <div>
                    <p>' . $witness[0]->citizen_name . ' , ' . $witness[0]->present_address . '   সমীপে</p>
                </div>
                <div>
                    <p> যেহেতু আমার নিকট নালিশ করা হইয়াছে ' . $defaulter[0]->citizen_name . ' ঠিকানা ' . $defaulter[0]->present_address . ' স্থানে ' . $case_date . ' দিবসে ' . $case_details . '
                       অপরাধ করিয়াছে (বা করিয়াছে বলিয়া সন্দেহ করা হইতেছে) এবং আমার নিকট
                        প্রতীয়মান হইতেছে, আপনি সরকার পক্ষে গুরুত্বপূর্ণ সাক্ষ্য দিতে পারেন; সেহেতু</p>
                        <p>এতদ্বারা আপনাকে সমন দেওয়া যাইতেছে, আপনি ' . $trialBanglaDate . '  তারিখে ' . $time . ' ' . en2bn($trialTime) . ' ঘটিকায় এই আদালতে হাজির
                            হইয়া উক্ত নালিশ সম্পর্কে আপনি যাহা জানেন সেই সম্পর্কে সাক্ষ্য দিবেন, এবং আদালতের
                            অনুমতি ছাড়া আদালত ত্যাগ করিবেন না ; এবং এতদ্বারা আপনাকে সতর্ক করিয়া দেওয়া যাইতেছে
                            যে, আপনি যদি সঙ্গত কারন ব্যাতীত উক্ত তারিখে হাজির হইতে অবহেলা বা অস্বীকার করেন, তাহা
                            হইলে আপনাকে হাজির করিতে বাধ্য করিবার জন্য পরোয়ানা জারি করা হইবে।</p>

                </div>

                <div>
                    <p>তারিখঃ' . $trialBanglaYear_send_year . ' সালের ' . $trialBanlaMonth_send_month . ' মাসের ' . $trialBanglaDay_send_day . ' তারিখ। <br><br><br>
                    </p>
                    <p style=" text-align : left; color: blueviolet;">
                        <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">

                        <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . globalUserRoleInfo()->role_name . '
                    </p>

                </div>
            </div>';
        // dd($template);
        return $template;
    }

    //----------- অন্তর্বর্তীকালীন মুচলেকা -----------------------------------------//
    public static function getInterimBondRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        // dd($appealInfo);
        // $location = $appealInfo['appeal']->office_name;
        $case_date = $appealInfo['appeal']->case_date;
        $applicant = $appealInfo['applicantCitizen'];
        $defaulter = $appealInfo['defaulterCitizen'];
        // $witness = $appealInfo['witnessCitizen'];
        // $guarantorCitizen = $appealInfo['guarantorCitizen'];
        $case_details = str_replace('&nbsp;', '', strip_tags($appealInfo['appeal']->case_details));
        // $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loadate('h:i:s');n_amount);

        //  $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->trial_date)));
        // $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->trial_date)));
        // $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->trial_date)));
        date_default_timezone_set('Asia/Dhaka');
        $trialTime = date('h:i:s');
        $trialTimeAmPm = date('a', strtotime($requestInfo->trial_time));
        $time = '';
        if ($trialTimeAmPm == 'am') {
            $time = 'সকাল';
        } else {
            $time = 'বিকাল';
        }
        // $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->trial_date)));

        $caseBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($case_date)));
        //   $caseBanglaDay = DataConversionService::toBangla(date('d', strtotime($case_date)));
        $caseBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($case_date)));
        // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        $caseBanglaYear = DataConversionService::toBangla(date("Y", strtotime($case_date)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $trialBanglaDay_send_day = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth_send_month = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        $trialBanglaYear_send_year = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $template = '
                <body>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-10 ">
                                <div class="head_part text-center">
                                    <h3 >নির্বাহী ম্যজিস্ট্রেট এর আদালত</h2>
                                    <h4 >…………।</h4>
                                    <h6>বাংলাদেশ ফর্ম নং-৩৩৮</h6>
                                </div>

                                <div class="row">
                                    <div class="col-md-9"></div>
                                    <div class="col-md-3">
                                        <p>স্মারক নং..................</p>
                                        <p>তারিখ ২৯-০৮-২০২৩</p>
                                    </div>
                                </div>
                                <h3 class="text-center">আসামীর প্রতি সমন</h3>
                                <br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>জিলা-ঢাকা   মোকাম শেখ রাসেল হাসান ।</p>
                                        <p>মোকদ্দমা নংDHAEM-1-12-2023-15    সন ২০২৩  ইং</p>
                                    </div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-center">
                                        <p>আদালত</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">


                                        <p>যেহেতু ' . $applicant[0]->present_address . ' এর অধিবাসী আমাকে ' . $defaulter[0]->citizen_name . ' ' . en2bn($trialTime) . '  সময়ের জন্য (অথবা আদালতে
                                        এক্ষুণে ' . $case_details . ' বিষয় সম্পর্কে যে অনুসন্ধান চলিতেছে তাহা সমাপ্ত না হওয়া পর্যন্ত) বাংলাদেশ
                                        সরকার ও বাংলাদেশের সকল নাগরিকের প্রতি সদাচরনের নিমিত্ত একটি মুচলেকা সম্পাদন করিতে
                                        বলা হইয়াছে, সেহেতু আমি এতদ্বারা অঙ্গীকার করিতেছি, উক্ত সময়ের জন্য (অথবা উক্ত
                                        অনুসন্ধান সমাপ্ত না হওয়া পর্যন্ত) আমি বাংলাদেশ সরকার ও বাংলাদেশের সকল নাগরিকের প্রতি
                                        সদাচরন করিব, এবং ইহা লঙ্ঘন করিলে আমি বাংলাদেশ সরকারকে ' . $requestInfo->bond_amount . ' টাকা দিতে বাধ্য থাকিব।
                                    </p>

                                        <p>তারিখঃ' . $trialBanglaYear_send_year . ' সালের ' . $trialBanlaMonth_send_month . ' মাসের ' . $trialBanglaDay_send_day . ' তারিখ। </p>
                                        <p style=" text-align : left; color: blueviolet;">
                                            <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">

                                        <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . globalUserRoleInfo()->role_name . ', ' . user_district_name() . '
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </body>
            ';
        // dd($template);
        return $template;
    }

    //----------- শুনানি-----------------------------------------//
    public static function getHearingRequestShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        $case_details_em=$requestInfo->complain_detail;
        $applicantCitizen = $appealInfo['applicantCitizen'];
        $defaulterCitizen = $appealInfo['defaulterCitizen'];
        $witnessCitizen = $appealInfo['witnessCitizen'];
        $defaulerWithnessCitizen = $appealInfo['defaulterCitizen'];
        $lawerCitizen = $appealInfo['lawerCitizen'];
        $defaulerLawyerCitizen = $appealInfo['defaulerLawyerCitizen'];
        $hearing_names = [];
        
        foreach ($applicantCitizen as $key => $value) {
            array_push($hearing_names, $value->citizen_name);
        }
        foreach ($defaulterCitizen as $key => $value) {
            array_push($hearing_names, $value->citizen_name);
        }
        foreach ($witnessCitizen as $key => $value) {
            array_push($hearing_names, $value->citizen_name);
        }
        foreach ($defaulerWithnessCitizen as $key => $value) {
            array_push($hearing_names, $value->citizen_name);
        }
        
        array_push($hearing_names, $lawerCitizen->citizen_name);  
        array_push($hearing_names, $defaulerLawyerCitizen[0]->citizen_name);

        //dd($hearing_names);
        

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $conductBanglaDate = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));

        $conductBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $conductBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $modified_next_date = date_formater_helpers_v2(str_replace('/', '-', $requestInfo->trialDate));

        $NextBanglaDate = DataConversionService::toBangla(date('d', strtotime($modified_next_date)));

        $NextBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_next_date)));

        $NextBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_next_date)));

        $caseOrderConductBanglaDateFinal = $conductBanglaYear . ' সালের ' . $conductBanlaMonth . ' মাসের ' . $conductBanglaDate . ' তারিখ ';
        $caseNextBanglaDateFinal = $NextBanglaYear . ' সালের ' . $NextBanlaMonth . ' মাসের ' . $NextBanglaDate;

        $template = '<body>
        
        <div class="container">
            <div class="row">
                <div class="col-md-12 pt-5">
                    <div>
                        <h4 class="text-center">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত</h4>
                        <h4 class="text-center"> জেলা ম্যাজিস্ট্রেট এর কার্যালয়, ' . user_district_name() . ' ।</h4>
                        <br><br>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p > জনাব ' . implode(',',$hearing_names) . ' সমীপে-</p>

                            <p style="text-align: justify">যেহেতু আমার নিকট সংবাদ দেওয়া হইয়াছে যে ,(' . $case_details_em . ' , অপরাধ সংঘটিত হইয়াছে বা সংঘটিত হইয়াছে বলিয়া সন্দেহ করা হইতেছে) এবং আমার নিকট প্রতীয়মান হইয়াছে যে,অপরাধটি বা সন্দেহকৃত অপরাধটি সম্পর্কে এক্ষণে বিস্তারিত স্বাক্ষ্য গ্রহণ/বক্তব্য গ্রহণ অত্যাবশ্যক; সেহেতু এতদ্বারা ' .$caseNextBanglaDateFinal. ' তারিখে আপনার শুনানীর দিন ধার্য করা হইল। শুনানীর জুম লিংকটি যথা সময়ে প্রেরণ করা হবে। এতদ্বারা আমি আপনাকে নির্দেশ দিতেছি, আপনি শুনানীর ধার্যকৃত দিনে নির্ধারিত সময়ে উপস্থিত/সংযুক্ত  থাকিবেন। </p>
                            <div class="row">
                                <div class="col-md-4">তারিখ ঃ ' . $caseOrderConductBanglaDateFinal . '।</div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4" style="color: blueviolet;">
                                 <p style="text-align:center;padding: 0;margin: 0;">সাক্ষরঃ <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50"></p>
                                 <p style="text-align:center;padding: 0;margin: 0;">এক্সিকিউটিভ ম্যাজিস্ট্রেট</p>
                                 <p style="text-align:center;padding: 0;margin: 0;">' . user_district_name() . '</p>
                                </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>';
        // dd($template);

        return $template;
    }

    //----------- গ্রেফতারী পরোয়ানা-----------------------------------------//
    public static function getArrestWarrentShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        // dd($appealInfo);
        $law_section = CrpcSection::where('id', $appealInfo['appeal']->law_section)->select('crpc_id')->first()->crpc_id;
        //  $location = $appealInfo['appeal']->office_name;
        $upazila_name_bn = Upazila::where('id', $appealInfo['appeal']->upazila_id)->select('upazila_name_bn')->first()->upazila_name_bn;
        $case_date = $appealInfo['appeal']->case_date;
        //  $applicant = $appealInfo['applicantCitizen'];
        $defaulter = $appealInfo['defaulterCitizen'];
        //  $witness = $appealInfo['witnessCitizen'];
        //  $guarantorCitizen = $appealInfo['guarantorCitizen'];
        $case_details = str_replace('&nbsp;', '', strip_tags($appealInfo['appeal']->case_details));
        //$loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        //$trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->trial_date)));
        // $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->trial_date)));
        // $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->trial_date)));
        // $trialTime = date('h:i:s', strtotime($causeList->trial_time));
        //   $trialTimeAmPm = date('a', strtotime($causeList->trial_time));
        //   $time = '';
        //  if ($trialTimeAmPm == 'am') {
        //     $time = 'সকাল';
        // } else {
        //     $time = 'বিকাল';
        // }
        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $caseBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($modified_conduct_date)));
        $caseBanglaDay = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $caseBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        $caseBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $template = '
                    <style>
                        table, th, td {
                            border: none;
                            border-collapse: collapse;
                            font-weight: normal;
                        }
                    </style>
            <div >
                <span style="font-size:  medium;">বাংলাদেশ ফরম নং ৩৯০৫। <br> হাইকোর্ট ফৌজদারী পরোয়ানা ফরম নং ১২।  </span>
                        <header>
                            <div style="text-align: center">
                                <h2>গ্রেফতারী ওয়ারেন্ট</h2> <br>------------------------------<br>
                    <h5><b>(ফৌজদারী কার্যবিধির ' . en2bn($law_section) . ' ধারা)</b></h5>
                    ------------------------------<br>

                            </div>
                        </header>
             <br>

             <br>
             <br>
            <div style="height:100%">
                <table>
                    <tr width="100%">
                        <td style="text-align: left; padding-top: 10px;" width="30%" >
                            ' . en2bn(1) . ': নাম:- ' . $defaulter[0]->citizen_name . ', ঠিকানাঃ- ' . $defaulter[0]->present_address . '
                        </td>
                        <td width="40%">

                        </td>
                        <td style="text-align: left;"width="30%">
                            ' . en2bn(1) . ': ভারপ্রাপ্ত কর্মকর্তা(ওসি) ' . $upazila_name_bn . ' পুলিশ স্টেশন <br> এর প্রতি
                        </td>
                    </tr>
                </table>
                <p> ' . $defaulter[0]->present_address . ' নিবাসী ' . $case_details . ' অপরাধে  অভিযুক্ত হইয়াছে, অতএব আপনার প্রতি এতদ্বারা আদেশ করা যাইতেছে যে আপনি ' . $defaulter[0]->citizen_name . ' ধরিয়া আমার নিকটে উপস্থিত করিবেন। আপনি ইহা অমান্য করিবেন না।
                </p>
                <br><br>
                <p style="text-align: right">
                    তারিখঃ' . $caseBanglaYear . ' সালের ' . $caseBanlaMonth . ' মাসের ' . $caseBanglaDate . ' তারিখ। <br><br><br>


                </p>
                 <p style=" text-align : right; color: blueviolet;">
                        <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">

                        <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . globalUserRoleInfo()->role_name . ', ' . user_district_name() . '
                    </p>
            </div>';
        // dd($template);
        return $template;
    }

    //----------- শান্তিরক্ষার মুচলেকা-----------------------------------------//
    public static function getPeaceBondShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        // dd($appealInfo);
        // $location = $appealInfo['appeal']->office_name;
        $case_date = $appealInfo['appeal']->case_date;
        $applicant = $appealInfo['applicantCitizen'];
        $defaulter = $appealInfo['defaulterCitizen'];
        //$witness = $appealInfo['witnessCitizen'];
        //$guarantorCitizen = $appealInfo['guarantorCitizen'];
        $case_details = str_replace('&nbsp;', '', strip_tags($appealInfo['appeal']->case_details));
        //   $loanAmountBng = DataConversionService::toBangla($appealInfo['appeal']->loan_amount);

        //  $trialBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($causeList->trial_date)));
        //  $trialBanglaDay = DataConversionService::toBangla(date('d', strtotime($causeList->trial_date)));
        //  $trialBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($causeList->trial_date)));
        date_default_timezone_set('Asia/Dhaka');
        $trialTime = date('h:i:s');

        //$trialTimeAmPm = date('a', strtotime($causeList->trial_time));
        //    $time = '';
        //  if ($trialTimeAmPm == 'am') {
        //     $time = 'সকাল';
        // } else {
        //  $time = 'বিকাল';
        //}

        //  $trialBanglaYear = DataConversionService::toBangla(date("Y", strtotime($causeList->trial_date)));

        //     $caseBanglaDate = DataConversionService::toBangla(date('d-m-Y', strtotime($case_date)));
        //   //  $caseBanglaDay = DataConversionService::toBangla(date('d', strtotime($case_date)));
        //     $caseBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($case_date)));
        //     // $caseTime=date('h:i:s a',strtotime($causeList->case_time));
        //     $caseBanglaYear = DataConversionService::toBangla(date("Y", strtotime($case_date)));

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);
        $trialBanglaDay_send_day = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));
        $trialBanlaMonth_send_month = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));
        $trialBanglaYear_send_year = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $template = '
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                            padding: 10px;
                            font-weight: normal;
                        }
                    </style>
            <div >
                <span style="font-size:  medium;">বাংলাদেশ ফরম নং ১০২৮  </span>
                        <header>
                            <div style="text-align: center">
                                <h3>শান্তি রক্ষার মুচলেকা</h3>

                            </div>
                        </header>
             <br>

             <br>
             <br>
            <div style="height:100%">

                <p>যেহেতু ' . $applicant[0]->present_address . ' এর অধিবাসী আমাকে ' . $defaulter[0]->citizen_name . ' ' . en2bn($trialTime) . '  সময়ের জন্য (অথবা আদালতে
                     এক্ষুণে ' . $case_details . ' বিষয় সম্পর্কে যে অনুসন্ধান চলিতেছে তাহা সমাপ্ত না হওয়া পর্যন্ত) শান্তিরক্ষার নিমিত্ত একটি মুচলেকা সম্পাদন করিতে বলা হইয়াছে, সেহেতু আমি এতদ্বারা অঙ্গীকার করিতেছি যে, উক্ত সময়ের মধ্যে (অথবা উক্ত তদন্ত সমাপ্ত না হওয়া পর্যন্ত) আমি কোন প্রকার শান্তিভঙ্গ করিব না, অথবা শান্তিভঙ্গ হইতে পারে এমন কাজ করিব না, এবং ইহা লঙ্ঘন করিলে আমি বাংলাদেশ সরকারকে………… টাকা দিতে বাধ্য থাকিব।
                </p>
                <br><br>
                <p style="text-align: right">
                    তারিখঃ' . $trialBanglaYear_send_year . ' সালের ' . $trialBanlaMonth_send_month . ' মাসের ' . $trialBanglaDay_send_day . ' তারিখ। <br><br><br>

                        ............ <br>(স্বাক্ষর)
                </p>
            </div>';

        $template = '
        <body>

            <div class="container">
                <div class="row">
                    <div class="col-md-12 pt-10 ">
                        <div class="head_part text-center">
                            <h3 >নির্বাহী ম্যজিস্ট্রেট এর আদালত</h2>
                            <h4 >…………।</h4>
                            <h6>বাংলাদেশ ফর্ম নং-৩৩৮</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-9"></div>
                            <div class="col-md-3">
                                <p>স্মারক নং..................</p>
                                <p>তারিখ ' . $trialBanglaDate . '</p>
                            </div>
                        </div>
                        <h3 class="text-center">শান্তিরক্ষার মুচলেকা ( ১০৭ ধারা দ্রষ্টব্য )</h3>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <p>জিলা-' . user_district_name() . '   মোকাম ' . globalUserInfo()->name . ' ।</p>
                                <p>মোকদ্দমা নং' . $case_no . '    সন ' . $trialBanglaYear . '  ইং</p>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4 text-center">
                                <p>আদালত</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>
                                    যেহেতু ' . $applicant[0]->present_address . ' -এর অধিবাসী আমাকে ( ' . $defaulter[0]->citizen_name . ' ) ' . en2bn($trialTime) . ' সময়ের জন্য (অথবা ................................................. আদালতে এক্ষণে ' . $case_details . ' বিষয় সম্পর্কে যে অনুসন্ধান চলিতেছে তাহা সমাপ্ত না হওয়া পর্যন্ত ) শান্তি রক্ষার নিমিত্ত একটি মুচলেকা সম্পাদন করিতে বলা হইয়াছে , সেহেতু আমি এতদ্বারা অঙ্গীকার করিতেছি যে , উক্ত সময়ের মধ্যে ( অথবা উক্ত তদন্ত সমাপ্ত না হওয়া পর্যন্ত ) আমি কোন প্রকার শান্তি ভঙ্গ করিব না , অথবা শান্তি ভঙ্গ হইতে পারে এমন কোন কাজ করিব না , এবং ইহা লংঘন করিলে আমি বাংলাদেশ সরকারকে ...............টাকা দিতে বাধ্য থাকিব ।
                                </p>

                                <p>তারিখঃ' . $trialBanglaYear . ' সালের ' . $trialBanlaMonth . ' মাসের ' . $trialBanglaDay . ' তারিখ। </p>
                                <p style=" text-align : left; color: blueviolet;">
                                    <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50">

                                <br>' . '<b>' . globalUserInfo()->name . '</b>' . '<br> ' . globalUserRoleInfo()->role_name . ', ' . user_district_name() . '
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
	    </body>
        ';
        // dd($template);
        return $template;
    }

    //----------- কারণ দর্শানো নোটিশ-----------------------------------------//
    public static function getShowCauseShortOrderTemplate($appealInfo, $shortOrder, $requestInfo)
    {
        //dd($appealInfo);

        $case_no = $appealInfo['appeal']->case_no;
        $applicant = $appealInfo['applicantCitizen'];
        $defaulter = $appealInfo['defaulterCitizen'];
        $victim = $appealInfo['victimCitizen'];

        $modified_conduct_date = date_formater_helpers_v2($requestInfo->conductDate);

        $conductBanglaDate = DataConversionService::toBangla(date('d', strtotime($modified_conduct_date)));

        $conductBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_conduct_date)));

        $conductBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_conduct_date)));

        $modified_next_date = date_formater_helpers_v2(str_replace('/', '-', $requestInfo->trialDate));

        $NextBanglaDate = DataConversionService::toBangla(date('d', strtotime($modified_next_date)));

        $NextBanlaMonth = DataConversionService::getBanglaMonth((int) date('m', strtotime($modified_next_date)));

        $NextBanglaYear = DataConversionService::toBangla(date("Y", strtotime($modified_next_date)));

        $CaseTime = DataConversionService::timeConvetor($requestInfo->trialTime);

        $caseNextBanglaDateFinal = $NextBanglaYear . ' সালের ' . $NextBanlaMonth . ' মাসের ' . $NextBanglaDate;
        $caseOrderConductBanglaDateFinal = $conductBanglaYear . ' সালের ' . $conductBanlaMonth . ' মাসের ' . $conductBanglaDate . ' তারিখ ';

        // $defaulterpeople = [];
        $defaulter_names = [];
        foreach ($defaulter as $key => $value) {
            array_push($defaulter_names, $value->citizen_name);
        }
        //dd($applicant);
        if ($requestInfo->law_sec_id != 100) {
            $template = '
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <div>
                                <h4 class="text-center">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত</h4>
                                <h4 class="text-center"> জেলা ম্যাজিস্ট্রেট এর কার্যালয়, ' . user_district_name() . ' ।</h4>
                                <br>
                                <h6 class="text-center">ফৌজদারী কার্যবিধি আইনের ' . en2bn($requestInfo->law_sec_id) . ' ধারার বিধান মতে নোটিশ
                                </h6>
                                <h6 class="text-center">পিটিশন কেস নং ' . $case_no . '</h6>
                                <br>
                                <div class="text-center">
                                <h6>' . $applicant[0]->citizen_name . ' ১ম পক্ষ</h6>
                                <h6>বনাম</h6>
                                <h6>' . implode(',', $defaulter_names) . ' ২য় পক্ষ</h6>
                                </div>
                            </div>
                            <br><br>
                          <div class="row">
                             <div class="col-md-12" style="text-align: justify">
                          এতদ্বারা আপনি/ আপনাদিগকে (২য় পক্ষ)  জানানো যাইতেছে যে, ১ম পক্ষের দরখাস্ত মোতাবেক আপনি/ আপনাদের দ্বারা প্রথম পক্ষের আশু শান্তি ভঙ্গের আশংকা বিদ্যমান রয়েছে। সুতরাং ফৌজদারী কার্যবিধি ১৮৯৮ এর ১০৭ ধারার বিধান মতে আপনি/ আপনাদেরকে কেন ১ জন বিজ্ঞ কৌসুলি ও ১ জন স্থানীয় জামিনদারের জিম্মায় ' . en2bn($requestInfo->bond_amount) . ' টাকার বন্ডে  ' . en2bn($requestInfo->bond_period) . ' বছরের জন্য শান্তিরক্ষার মুচলেকা সম্পাদনের নির্দেশ দেয়া হবে না - এ মর্মে আগামী ' . $caseNextBanglaDateFinal . ' তারিখ ' . $CaseTime . ' ঘটিকার সময় নিম্ন স্বাক্ষরকারীর আদালতে হাজির হয়ে কারণ দর্শাতে বলা হল।
                             </div>
                          </div>
                          <br><br>
                          <div class="row">
                            <div class="col-md-4">তারিখ ঃ ' . $caseOrderConductBanglaDateFinal . '।</div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="color: blueviolet;">
                             <p style="text-align:center;padding: 0;margin: 0;">সাক্ষরঃ <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50"></p>
                             <p style="text-align:center;padding: 0;margin: 0;">এক্সিকিউটিভ ম্যাজিস্ট্রেট</p>
                             <p style="text-align:center;padding: 0;margin: 0;">' . user_district_name() . '</p>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </body>
         ';
        } else {

            $template = '
            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 pt-5">
                            <div>
                                <h4 class="text-center">এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালত</h4>
                                <h4 class="text-center"> জেলা ম্যাজিস্ট্রেট এর কার্যালয়, ' . user_district_name() . ' ।</h4>
                                <br>
                                <h6 class="text-center">ফৌজদারী কার্যবিধি আইনের ' . en2bn($requestInfo->law_sec_id) . ' ধারার বিধান মতে নোটিশ
                                </h6>
                                <h6 class="text-center">পিটিশন কেস নং ' . $case_no . '</h6>
                                <br>
                                <div class="text-center">
                                <h6>' . $applicant[0]->citizen_name . ' ১ম পক্ষ</h6>
                                <h6>বনাম</h6>
                                <h6>' . implode(',', $defaulter_names) . ' ২য় পক্ষ</h6>
                                </div>
                            </div>
                            <br><br>
                          <div class="row">
                             <div class="col-md-12" style="text-align: justify">
                             এতদ্বারা আপনি/আপনাদিগকে (২য় পক্ষ) জানানো যাইতেছে যে, ১ম পক্ষের দরখাস্ত মোতাবেক আপনি/ আপনারা ১ম পক্ষের স্ত্রী/পুত্র/পিতা/মাতা/ভিকটিম ' . $victim[0]->citizen_name . 'কে তাহার ইচ্ছার বিরদ্ধে জোরপূর্বক আটক করিয়া রাখিয়াছেন তাহাতে ১ম পক্ষের দাম্পত্য/ সাংসারিক জীবনে ব্যাঘাত ঘটিতেছে।অতএব আপনি / আপনাদিগকে ১ম পক্ষের স্ত্রী/পুত্র/পিতা/মাতা/ভিকটিম ' . $victim[0]->citizen_name . ' কে সহ আগামী ইং ' . $caseNextBanglaDateFinal . ' তারিখে অত্র আদালতে হাজির হইয়া কেন আটক করিয়া রাখিয়াছেন উহার কারন দর্শাতে বলা হইলো।।
                             </div>
                          </div>
                          <br><br>
                          <div class="row">
                            <div class="col-md-4">তারিখ ঃ ' . $caseOrderConductBanglaDateFinal . '।</div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4" style="color: blueviolet;">
                             <p style="text-align:center;padding: 0;margin: 0;">সাক্ষরঃ <img src="' . globalUserInfo()->signature . '" alt="signature" width="100" height="50"></p>
                             <p style="text-align:center;padding: 0;margin: 0;">এক্সিকিউটিভ ম্যাজিস্ট্রেট</p>
                             <p style="text-align:center;padding: 0;margin: 0;">' . user_district_name() . '</p>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </body>
         ';
        }

        // dd($template);
        return $template;
    }

}
