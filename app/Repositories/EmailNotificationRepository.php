<?php

namespace App\Repositories;

use App\Models\EmAppeal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EmailNotificationRepository
{
    public static function send_email_notification($requestInfo, $appealId, $caseNo, $sms_details, $disName,$shortorderTemplateUrl,$shortorderTemplateName)
    {
        $applicantName = null;
        $defaulterName = null;
        $victinName = null;
        $investigatorName = null;
        $warrantExecutorName = null;
        $witnessName = null;
        $nextDate = isset($requestInfo->trialDate) ? str_replace('/', '-', $requestInfo->trialDate) : null;
       

        if ($requestInfo->shortOrder[0] == 21) {

            /*single email */

            $investigatorName = $requestInfo->investigatorName;
            $investigatorEmail = $requestInfo->investigatorEmail;
            if (empty($investigatorEmail)) {
                return;
            }
            $tracking_code = EmAppeal::select('investigation_tracking_code')->where('id', $appealId)
                ->first()->investigation_tracking_code;
            $victinName = self::get_vicitim_people($appealId)->citizen_name;

            $court_details = self::get_court_details($disName->court_id);

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            $message_tracking = "গোপন নম্বর  " . $tracking_code . "\r\n" . $court_details->court_name . ", " . $disName->district->district_name_bn;

            $message = $message . $message_tracking;

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $investigatorEmail);
            array_push($receivers_names_array, $investigatorName);
            $email_subject = DB::table('em_case_shortdecisions')->where('id', 21)->select('case_short_decision')->first()->case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 2 || $requestInfo->shortOrder[0] == 5) {
            $investigatorName = $requestInfo->investigatorName;
            $investigatorEmail = $requestInfo->investigatorEmail;
            if (empty($investigatorEmail)) {
                return;
            }
            
            $applicantName=self::get_applicant_info($appealId)->citizen_name;
            $defaulterpeople=self::get_defaulter_people($appealId);
            foreach ($defaulterpeople as $single_defalulter) {
                $defaulterName .= $single_defalulter->citizen_name. ',';;
            }

            $tracking_code = EmAppeal::select('investigation_tracking_code')->where('id', $appealId)
                ->first()->investigation_tracking_code;

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            $court_details = self::get_court_details($disName->court_id);

            $message_tracking = "গোপন নম্বর  " . $tracking_code . "\r\n" . $court_details->court_name . ", " . $disName->district->district_name_bn;

            $message = $message . $message_tracking;
           
            /* email Start */
            $emails = [];
            $email_single['email_address_receiver'] = $investigatorEmail;
            $email_single['name_of_receiver'] = $investigatorName;
            if ($requestInfo->shortOrder[0] == 2) {
                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 2)->select('case_short_decision')->first()->case_short_decision;
            } else {

                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 5)->select('case_short_decision')->first()->case_short_decision;
            }
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $investigatorEmail);
            array_push($receivers_names_array, $investigatorName);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 19) {
            $warrantExecutorName = $requestInfo->warrantExecutorName;

            $warrantExecutorEmail = $requestInfo->warrantExecutorEmail;

            if (empty($warrantExecutorEmail)) {
                return;
            }

            $applicantName=self::get_applicant_info($appealId)->citizen_name;
            $defaulterpeople=self::get_defaulter_people($appealId);
            foreach ($defaulterpeople as $single_defalulter) {
                $defaulterName .= $single_defalulter->citizen_name. ',';;
            }

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            
            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 19)->select('case_short_decision')->first()->case_short_decision;
            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $warrantExecutorEmail);
            array_push($receivers_names_array, $warrantExecutorName);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 4 || $requestInfo->shortOrder[0] == 24) {
            $applicantInfo = self::get_applicant_info($appealId);

            if (empty($applicantInfo->email)) {
                return;
            }
            $applicantName=self::get_applicant_info($appealId)->citizen_name;
            $defaulterpeople=self::get_defaulter_people($appealId);
            foreach ($defaulterpeople as $single_defalulter) {
                $defaulterName .= $single_defalulter->citizen_name. ',';;
            }

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            if ($requestInfo->shortOrder[0] == 4) {
                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 4)->select('case_short_decision')->first()->case_short_decision;
            } else {

                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 24)->select('case_short_decision')->first()->case_short_decision;
            }

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $applicantInfo->email);
            array_push($receivers_names_array, $applicantInfo->citizen_name);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 1) {

            $defaulterInfo = EmailNotificationRepository::get_defaulter_people($appealId);
            if (count($defaulterInfo) > 0) {
                
                    foreach ($defaulterInfo as $single_defalulter) {
                        $defaulterName .= $single_defalulter->citizen_name. ',';
                    }
                $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);
                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 1)->select('case_short_decision')->first()->case_short_decision;

                /* email Start */
                $receivers_emails_array = [];
                $receivers_names_array = [];
                foreach ($defaulterInfo as $single_defalulter) {

                    array_push($receivers_emails_array, $single_defalulter->email);
                    array_push($receivers_names_array, $single_defalulter->citizen_name);
                }
                $email_subject = $case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                return;
            }

        } elseif ($requestInfo->shortOrder[0] == 9) {

            $defaulterInfo = EmailNotificationRepository::get_defaulter_people($appealId);
            if (count($defaulterInfo) > 0) {

                $Payable = $requestInfo->bond_amount;
                $Payableyear = $requestInfo->bond_period;

                $receivers_emails_array = [];
                $receivers_names_array = [];
                foreach ($defaulterInfo as $single_defalulter) {

                    array_push($receivers_emails_array, $single_defalulter->email);
                    array_push($receivers_names_array, $single_defalulter->citizen_name);
                    $defaulterName .= $single_defalulter->citizen_name . ', ';
                }

                $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#Payable}', '{#year}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $Payable, $Payableyear, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);

                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 9)->select('case_short_decision')->first()->case_short_decision;

                /* email Start */

                $email_subject = $case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                return;
            }

        } elseif ($requestInfo->shortOrder[0] == 13) {

            $defaulterInfo = EmailNotificationRepository::get_defaulter_people($appealId);
            if (count($defaulterInfo) > 0) {
                $applicantName=self::get_applicant_info($appealId)->citizen_name;
                
                foreach ($defaulterInfo as $single_defalulter) {
                    $defaulterName .= $single_defalulter->citizen_name. ',';
                }
                $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);
                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 13)->select('case_short_decision')->first()->case_short_decision;

                /* email Start */
                $receivers_emails_array = [];
                $receivers_names_array = [];
                foreach ($defaulterInfo as $single_defalulter) {

                    array_push($receivers_emails_array, $single_defalulter->email);
                    array_push($receivers_names_array, $single_defalulter->citizen_name);
                }
                $email_subject = $case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                return;
            }

        } elseif ($requestInfo->shortOrder[0] == 15) {
            $applicantInfo = self::get_applicant_info($appealId);

            if (empty($applicantInfo->email)) {
                return;
            }
            $defaulterpeople=self::get_defaulter_people($appealId);
            foreach ($defaulterpeople as $single_defalulter) {
                $defaulterName .= $single_defalulter->citizen_name. ',';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 15)->select('case_short_decision')->first()->case_short_decision;

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $applicantInfo->email);
            array_push($receivers_names_array, $applicantInfo->citizen_name);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 16) {

            /* multimple email */

            // $law_enforcement_forces_Mobile , $zillSuperMobile

            $law_enforcement_forces_Name = $requestInfo->law_enforcement_forces_Name;
            $law_enforcement_forces_Email = $requestInfo->law_enforcement_forces_Email;

            $zillSuperName = $requestInfo->zillSuperName;
            $zillSuperEmail = $requestInfo->zillSuperEmail;

            if (empty($law_enforcement_forces_Email) && empty($zillSuperEmail)) {
                return;
            }
            $defaulterpeople=self::get_defaulter_people($appealId);
            foreach ($defaulterpeople as $single_defalulter) {
                $defaulterName .= $single_defalulter->citizen_name. ',';;
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);
            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 16)->select('case_short_decision')->first()->case_short_decision;

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $law_enforcement_forces_Email, $zillSuperEmail);
            array_push($receivers_names_array, $law_enforcement_forces_Name, $zillSuperName);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 7) {

            $law_enforcement_forces_Name = $requestInfo->law_enforcement_forces_Name;
            $law_enforcement_forces_Email = $requestInfo->law_enforcement_forces_Email;
            if (empty($law_enforcement_forces_Email)) {
                return;
            }
            $defaulterpeople=self::get_defaulter_people($appealId);
            foreach ($defaulterpeople as $single_defalulter) {
                $defaulterName .= $single_defalulter->citizen_name. ',';
            }
            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 7)->select('case_short_decision')->first()->case_short_decision;

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $law_enforcement_forces_Email);
            array_push($receivers_names_array, $law_enforcement_forces_Name);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 26) {
            /**Multiple email defaulterpeople with law_enforcement_forces_Mobile */
            $law_enforcement_forces_Name = $requestInfo->law_enforcement_forces_Name;
            $law_enforcement_forces_Email = $requestInfo->law_enforcement_forces_Email;

            $defaulterInfo = EmailNotificationRepository::get_defaulter_people($appealId);
            if (count($defaulterInfo) > 0 || !empty($law_enforcement_forces_Email)) {

                $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

                $warrantExecutorName = $requestInfo->law_enforcement_forces_Name;

                $defaulterpeople=self::get_defaulter_people($appealId);
                foreach ($defaulterpeople as $single_defalulter) {
                    $defaulterName .= $single_defalulter->citizen_name. ',';
                }

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);

                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 26)->select('case_short_decision')->first()->case_short_decision;

                /* email Start */
                $receivers_emails_array = [];
                $receivers_names_array = [];
                foreach ($defaulterInfo as $single_defalulter) {

                    array_push($receivers_emails_array, $single_defalulter->email);
                    array_push($receivers_names_array, $single_defalulter->citizen_name);
                }
                if (!empty($law_enforcement_forces_Email)) {

                    array_push($receivers_emails_array, $law_enforcement_forces_Email);
                    array_push($receivers_names_array, $law_enforcement_forces_Name);
                }

                $email_subject = $case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                return;
            }

        } elseif ($requestInfo->shortOrder[0] == 29) {
            $law_enforcement_forces_Name = $requestInfo->law_enforcement_forces_Name;
            $law_enforcement_forces_Email = $requestInfo->law_enforcement_forces_Email;
            if (empty($law_enforcement_forces_Email)) {
                return;
            }

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, explode(';',$sms_details)[0]);

            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 29)->select('case_short_decision')->first()->case_short_decision;

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $law_enforcement_forces_Email);
            array_push($receivers_names_array, $law_enforcement_forces_Name);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

            /* email Start receiver Crock adesh END*/
            if (empty($requestInfo->receiver_Email)) {
                return;
            }

            $dummy_receiver = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}','{#ReceiverName}'];
            $original_reciver = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate,$requestInfo->receiver_Name];
            $message_receiver = str_replace($dummy_receiver, $original_reciver, explode(';',$sms_details)[1]);
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $requestInfo->receiver_Email);
            array_push($receivers_names_array, $requestInfo->receiver_Name);
            $email_subject = $case_short_decision;
            $email_body = $message_receiver;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);  


        } elseif ($requestInfo->shortOrder[0] == 28) {

            if (empty($requestInfo->receiver_Email)) {
                return;
            }

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 28)->select('case_short_decision')->first()->case_short_decision;

            /* email Start */
            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $requestInfo->receiver_Email);
            array_push($receivers_names_array, $requestInfo->receiver_Name);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 23) {

            $law_enforcement_forces_Name = $requestInfo->law_enforcement_forces_Name;
            $law_enforcement_forces_Email = $requestInfo->law_enforcement_forces_Email;
            if (empty($law_enforcement_forces_Email)) {
                return;
            }

            $victinName = self::get_vicitim_people($appealId)->citizen_name;

            $dummy = ['{#caseNo}', '{#name1}', '{#name2}', '{#victim}', '{#investogator}', '{#warrantExecutor}', '{#witness}', '{#nextDate}'];

            $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

            $message = str_replace($dummy, $original, $sms_details);

            $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 23)->select('case_short_decision')->first()->case_short_decision;

            $receivers_emails_array = [];
            $receivers_names_array = [];
            array_push($receivers_emails_array, $requestInfo->law_enforcement_forces_Email);
            array_push($receivers_names_array, $requestInfo->law_enforcement_forces_Name);
            $email_subject = $case_short_decision;
            $email_body = $message;
            self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

        } elseif ($requestInfo->shortOrder[0] == 10) {
            /** defaulter email mulitple */
            $defaulterInfo = EmailNotificationRepository::get_defaulter_people($appealId);
            $applicantInfo = self::get_applicant_info($appealId);
            if (count($defaulterInfo) > 0 || !empty($applicantInfo->email)) {

                $receivers_emails_array = [];
                $receivers_names_array = [];
               
                foreach ($defaulterInfo as $single_defalulter) {

                    array_push($receivers_emails_array, $single_defalulter->email);
                    array_push($receivers_names_array, $single_defalulter->citizen_name);
                    $defaulterName .= $single_defalulter->citizen_name . ', ';
                }

                $dummy = ["{#caseNo}", "{#name1}", "{#name2}", "{#victim}", "{#investogator}", "{#warrantExecutor}", "{#witness}", "{#nextDate}"];

                $applicantName = $applicantInfo->citizen_name;

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $timeOfhearing = explode(' ', date("g:i a", strtotime($requestInfo->trialTime)));
                if ($timeOfhearing[1] == 'pm') {
                    $time_string = 'শুনানির সময় বিকাল ' . $timeOfhearing[0];
                } else {
                    $time_string = 'শুনানির সময় সকাল ' . $timeOfhearing[0];
                }

                $message = str_replace($dummy, $original, $sms_details) . $time_string;

                array_push($receivers_emails_array, $applicantInfo->email);
                array_push($receivers_names_array, $applicantInfo->citizen_name);

                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 10)->select('case_short_decision')->first()->case_short_decision;

                $email_subject = $case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);

            } else {
                return;
            }

        } elseif ($requestInfo->shortOrder[0] == 22) {
            /** defaulter email mulitple */

            $defaulterInfo = EmailNotificationRepository::get_defaulter_people($appealId);
            if (count($defaulterInfo) > 0) {

                if ($requestInfo->law_sec_id == 100) {

                    $victinName = self::get_vicitim_people($appealId)->citizen_name;
                }
                $applicantName=self::get_applicant_info($appealId)->citizen_name;
                $defaulterpeople=self::get_defaulter_people($appealId);
                foreach ($defaulterpeople as $single_defalulter) {
                    $defaulterName .= $single_defalulter->citizen_name. ',';;
                }
                $dummy = ["{#caseNo}", "{#name1}", "{#name2}", "{#victim}", "{#investogator}", "{#warrantExecutor}", "{#witness}", "{#nextDate}"];

                $original = [$caseNo, $applicantName, $defaulterName, $victinName, $investigatorName, $warrantExecutorName, $witnessName, $nextDate];

                $message = str_replace($dummy, $original, $sms_details);
                $case_short_decision = DB::table('em_case_shortdecisions')->where('id', 22)->select('case_short_decision')->first()->case_short_decision;

                /* email Start */
                $receivers_emails_array = [];
                $receivers_names_array = [];
                foreach ($defaulterInfo as $single_defalulter) {

                    array_push($receivers_emails_array, $single_defalulter->email);
                    array_push($receivers_names_array, $single_defalulter->citizen_name);
                }
                $email_subject = $case_short_decision;
                $email_body = $message;
                self::send_email($receivers_emails_array, $receivers_names_array, $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName);
            } else {
                return;
            }
        }

    }
    public static function get_court_details($court_id)
    {
        return DB::table('court')->where('id', '=', $court_id)->first();

    }

    public static function get_applicant_info($appealId)
    {
        $applicant_people = DB::table('em_citizens')
            ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->where('em_appeal_citizens.appeal_id', '=', $appealId)
            ->where('em_appeal_citizens.citizen_type_id', '=', 1)
            ->select('em_citizens.citizen_name', 'em_citizens.email')
            ->first();

        return $applicant_people;
    }
    public static function get_defaulter_people($appealId)
    {
        $defaulter_people = DB::table('em_citizens')
            ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->where('em_appeal_citizens.appeal_id', '=', $appealId)
            ->where('em_appeal_citizens.citizen_type_id', '=', 2)
            ->select('em_citizens.citizen_name', 'em_citizens.email')
            ->get();

        return $defaulter_people;
    }
    public static function get_withness_people($appealId)
    {
        $withness_people = DB::table('em_citizens')
            ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->where('em_appeal_citizens.appeal_id', '=', $appealId)
            ->whereIn('em_appeal_citizens.citizen_type_id',[5,6])
            ->select('em_citizens.citizen_name', 'em_citizens.email')
            ->get();

        return $withness_people;
    }

    public static function get_vicitim_people($appealId)
    {
        $victim_people = DB::table('em_citizens')
            ->join('em_appeal_citizens', 'em_citizens.id', '=', 'em_appeal_citizens.citizen_id')
            ->where('em_appeal_citizens.appeal_id', '=', $appealId)
            ->where('em_appeal_citizens.citizen_type_id', '=', 8)
            ->select('em_citizens.citizen_name', 'em_citizens.email')
            ->first();

        return $victim_people;
    }

    public static function send_email($receivers_emails_array = [], $receivers_names_array = [], $email_body, $email_subject,$shortorderTemplateUrl,$shortorderTemplateName)
    {
        //dd($receivers_emails_array);
        foreach($receivers_emails_array as $key=>$value)
        {
            if(empty($receivers_emails_array[$key]))
            {
                unset($receivers_emails_array[$key]);
                unset($receivers_names_array[$key]);
            }
        }
        if(empty($receivers_emails_array))
        {
            return;
        }
        $appealId = $_POST['appealId'];

        $court_district = DB::table('em_appeals')
            ->join('court', 'em_appeals.court_id', 'court.id')
            ->join('district', 'em_appeals.district_id', 'district.id')
            ->where('em_appeals.id', $appealId)
            ->select('court.court_name as court_name', 'district.district_name_bn as district_name_bn')
            ->first();
        
        $month_name_mapping = [
            '01' => 'জানুয়ারি',
            '02' => 'ফেব্রুয়ারী',
            '03' => 'মার্চ',
            '04' => 'এপ্রিল',
            '05' => 'মে',
            '06' => 'জুন',
            '07' => 'জুলাই',
            '08' => 'আগষ্ট',
            '09' => 'সেপ্টেম্বর',
            '10' => 'অক্টোবর',
            '11' => 'নভেম্বর',
            '12' => 'ডিসেম্বর',

        ];
       
        $user = globalUserInfo();
        $details = [
            'receivers_emails_array' => $receivers_emails_array,
            'email_subject' => $email_subject,
            'email_body' => $email_body,
            'court_name'=>$court_district->court_name,
            'district_name_bn'=>$court_district->district_name_bn,
            'month_name'=>$month_name_mapping[date('m')],
            'day'=>en2bn(date('m')),
            'year'=>en2bn(date('Y')),
            'user_name'=>$user->name,
            'user_designation'=>$user->role->role_name,
            'receivers_names_array' => $receivers_names_array,
            'shortorderTemplateUrl' => $shortorderTemplateUrl,
            'shortorderTemplateName'=>$shortorderTemplateName
        ];
        
        $job = (new \App\Jobs\SendQueueEmail($details))
            ->delay(now()->addSeconds(2));

        dispatch($job);

    }
}
