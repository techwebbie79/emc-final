<?php

namespace App\Services;


use App\Models\Appeal;
use App\Models\AppealOrderSheet;
use App\Models\CaseShortdecisions;
use App\Models\CaseShortdecisionTemplates;
use App\Models\EmAppealCitizen;
use App\Models\EmAppealOrderSheet;
use App\Models\EmCaseShortdecisions;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mcms\Models\OrderSheet;

class AppealOrderSheetService
{
    public static function storeAppealOrderSheet($appealId,$appealObjectFromUi,$trialDate){
        $user = globalUserInfo();
        $appeal=AppealRepository::getAllAppealInfo($appealId);
        $orderSheetHeader=self::getAppealOrderSheetHeader($appeal);
        $orsheetTable=self::getAppealOrderSheetTable($appeal,$appealObjectFromUi,$trialDate);
        // dd($orsheetTable);
        $fullTableBody=$orsheetTable['body'];
        $tableTh=$orsheetTable['tableTh'];
        $tableBody=$orsheetTable['tableBody'];
        $tableClose=$orsheetTable['orderTableClose'];

        $appealOrderSheet=new EmAppealOrderSheet();
        $appealOrderSheet->appeal_id=$appealId;
        $appealOrderSheet->appeal_case_no=$appeal['appeal']->case_no ;//date('Y-m-d', strtotime(str_replace('/', '-', $trialDate)));
        $appealOrderSheet->order_header=$orderSheetHeader;
        $appealOrderSheet->order_detail_full_table=$fullTableBody;
        $appealOrderSheet->order_detail_table_body=$tableBody;
        $appealOrderSheet->order_detail_table_th=$tableTh;
        $appealOrderSheet->order_detail_table_close=$tableClose;

        $appealOrderSheet->created_at=date('Y-m-d H:i:s');
        $appealOrderSheet->created_by=$user->username;
        $appealOrderSheet->updated_at=date('Y-m-d H:i:s');
        $appealOrderSheet->updated_by=$user->username;
        $appealOrderSheet->save();

    }
    public static function storeAppealShortOrders($appealId,$appealObjectFromUi,$causeListId){
        $user = globalUserInfo();
        $appeal=AppealRepository::getAllAppealInfo($appealId);
        $orderSheetHeader=self::getAppealOrderSheetHeader($appeal);
        $orsheetTable=self::getAppealOrderSheetTable($appeal,$appealObjectFromUi);
        $fullTableBody=$orsheetTable['body'];
        $tableTh=$orsheetTable['tableTh'];


        $shortOrders=$appealObjectFromUi->shortOrder;

        foreach ($shortOrders as $shortOrder){
            $appealOrderSheet=new CaseShortdecisionTemplates();
            $appealOrderSheet->appeal_id=$appealId;
            $appealOrderSheet->cause_list_id=$causeListId;
            $appealOrderSheet->case_shortdecision_id=$shortOrder;
            $appealOrderSheet->template_header=$orderSheetHeader;
            $appealOrderSheet->template_body=$fullTableBody;

            $appealOrderSheet->created_at=date('Y-m-d H:i:s');
            $appealOrderSheet->created_by=$user->username;
            $appealOrderSheet->updated_at=date('Y-m-d H:i:s');
            $appealOrderSheet->updated_by=$user->username;
            $appealOrderSheet->save();
        }

    }

    public static function getLastOrderSheetByAppealId($appealId){

        $orderSheet=AppealOrderSheet::where('appeal_id',$appealId)
            ->orderBy('id', 'desc')
            ->first();
        return $orderSheet;
    }

    public static function destroyOrderSheetByOrderSheetId($orderSheetId){
        $orderSheet=AppealOrderSheet::where('id',$orderSheetId);
        $orderSheet->delete();
        return;
    }

    public static function getAppealOrderSheetHeader($appealInfo){
         $noteCauseList=$appealInfo['noteCauseList'];
         $appeal=$appealInfo['appeal'];
         $citizens =  EmAppealCitizen::with('Citizen')
                    ->where('appeal_id', $appeal->id)
                    ->whereIn('citizen_type_id', [1,2])
                    ->get();
        $data['applicant'] = [
            'citizen_name' => $citizens[0]->citizen_type_id == 1 ? $citizens[0]->citizen->citizen_name: $citizens[1]->citizen->citizen_name,
            'designation' => $citizens[0]->citizen_type_id == 1 ? $citizens[0]->citizen->designation: $citizens[1]->citizen->designation,
        ];
        $data['defaulter'] = [
            'citizen_name' => $citizens[0]->citizen_type_id == 2 ? $citizens[0]->citizen->citizen_name: $citizens[1]->citizen->citizen_name,
            'designation' => $citizens[0]->citizen_type_id == 2 ? $citizens[0]->citizen->designation: $citizens[1]->citizen->designation,
        ];
         $length=count($noteCauseList);
         $noteFirstDate = date('d-m-Y',strtotime($noteCauseList[0]->conduct_date));
         $noteLastDate = date('d-m-Y',strtotime($noteCauseList[$length-1]->conduct_date));
         $banglaYear=DataConversionService::toBangla(date("Y", strtotime($noteLastDate)));

        $mkHeader = '<p class="form-bd" style="text-align: left;">';
        $mkHeader .= 'বাংলাদেশ ফরম নম্বর - ৩৮৯০ <span style="float: right">ফৌঃ কাঃ বিঃ - ১০৭/১১৪/১১৭ (সি) ধারা</span>';
        $mkHeader .= '<br>';
        $mkHeader .= '</p>';
        $mkHeader .= '<p class="form-bd" style="text-align: left;">';
        $mkHeader .= '<sm>সুপ্রিম কোর্ট(হাইকোর্ট বিভাগ) ক্রিমিনাল ফরম নং(এম)১০৬ </sm>';
        $mkHeader .= '</p>';
        $mkHeader .= '<h2 style="text-align: center;"> ম্যাজিস্ট্রেটের রেকর্ডের জন্য আদেশনামা</h2>';
        $mkHeader .= '<p style="text-align: center;">';
        $mkHeader .= '(১৮৮৮ সালের ১১ই জুলাই এর ১ নম্বর পরিপক্ক যাহা ১৯০১ সালের ১৮ই নভেম্বর ৬ নম্বর পরিপক্ষ দ্বারা পুনঃ প্রবর্তিত ) ;<br>';
        $mkHeader .= '<span>আদেশপত্র, তারিখ  '. DataConversionService::toBangla($noteFirstDate) .' হইতে  '. DataConversionService::toBangla($noteLastDate) .' পর্যন্ত ।</span> <br>';
        $mkHeader .= '<span> জেলা/ উপজেলা : '. ($appeal->district_id != null ? $appeal->district->district_name_bn : '')  .', পি.আর  ...../'.$banglaYear .'ইং<br> '. DataConversionService::toBangla($noteLastDate) .' এর আদালত ।</span> <br><br>';
        $mkHeader .= '<span style="float: right"> সন: '.$banglaYear.'</span>';
        $mkHeader .= '<span style="float: left;"> মামলা নম্বর: '. DataConversionService::toBangla($appealInfo['appeal']->case_no) .'</span>';
        $mkHeader .= '</p>';
        $mkHeader .= '<div id="dependent">';
        $mkHeader .= '</span>';
        $mkHeader .= '</div><br><br>';
        $mkHeader .= '<span style="float: left;"> বাদী:- '. $data['applicant']['citizen_name'] .'</span> <span style="text-align: center;padding-left: 382px;">বনাম </span><span style="float: right;"> বিবাদী:- '.$data['defaulter']['citizen_name'].'</span></p>';
        $mkHeader .= '<div id="dependent">';
        $mkHeader .= '</span>';
        $mkHeader .= '</div><br>';
        return $mkHeader;

        //  $header="<p class=\"form-bd\" style=\"text-align: left;\">বাংলাদেশ ফরম নম্বর -  ৩৮৯০ &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp  ফৌঃ কাঃ বিঃ -  ১০৭/১১৪/১১৭ (সি) ধারা <br>" . "</p>" .
        //     "<p class=\"form-bd\" style=\"text-align: left;\"><sm>সুপ্রিম করত(হাইকোর্ট বিভাগ) ক্রিমিনাল ফরম নং(এম)১০৬ </sm>" . "</p>" .
        //     "        <h2 style=\"text-align: center;\"> ম্যাজিস্ট্রেটের রেকর্ডের জন্য আদেশনামা</h2>" .
        //     "        <p style=\"text-align: center;\">" .
        //     "           (১৮৮৮  সালের ১১ই জুলাই এর ১ নম্বর পরিপক্ক যাহা ১৯০১ সালের ১৮ই নভেম্বর ৬ নম্বর পরিপক্ষ দ্বারা পুনঃ প্রবর্তিত ) &nbsp;<br><span>" .
        //     "আদেশপত্র, তারিখ  ".DataConversionService::toBangla($noteFirstDate)." হইতে  ". DataConversionService::toBangla($noteLastDate)." পর্যন্ত ।</span> <br><span> ".
        //     "জেলা/ উপজেলা :".Session::get('districtName')." , &nbsp &nbsp পি.আর  &nbsp/".$banglaYear ."ইং<br> ". DataConversionService::toBangla($noteLastDate) ." এর আদালত ।</span> <br><br><span style='float: right'> ".
        //     "মামলার ধরন :".$appealInfo['appeal']->law_section."</span><span style='float: left;'> মামলা নম্বর-&nbsp;". DataConversionService::toBangla($appealInfo['appeal']->case_no) ."</span></p><div id=\"dependent\">" .
        //     " </span></div><br><br><span style='float: left'> ".
        //     "বাদী :".$appealInfo['appeal']->law_section."</span>"." <span style='float: center;'>বনাম </span>"."<span style='float: right;'> বিবাদী-&nbsp;". DataConversionService::toBangla($appealInfo['appeal']->case_no) ."</span></p><div id=\"dependent\">" .
        //     " </span></div><br>";

        //  return $header;
    }

    public static function getAppealOrderSheetTh(){
        $th = '<table cellspacing="0" cellpadding="0" border="1" width="100%">';
        $th .= '<thead>';
        $th .= '<tr>';
        $th .= '<td valign="middle" width="5%" align="center"> আদেশের ক্রমিক নং </td>';
        $th .= '<td valign="middle" width="10%" align="center"> তারিখ</td>';
        $th .= '<td valign="middle" width="75%" align="center"> আদেশ </td>';
        $th .= '<td valign="middle" width="10%" align="center"> স্বাক্ষর</td>';
        $th .= '</tr>';
        $th .= '</thead>';
        $th .= '<tbody>';
        return $th;
        // $th= "        <table cellspacing=\"0\" cellpadding=\"0\" border=\"1\" width=\"100%\">" .
        //     "            <thead><tr>" .
        //     "                <td valign=\"middle\" width=\"5%\" align=\"center\"> আদেশের ক্রমিক নং </td>" .
        //     "                <td valign=\"middle\" width=\"5%\" align=\"center\">  তারিখ</td>" .

        //     "                <td valign=\"middle\" width=\"75%\" align=\"center\"> আদেশ ও অফিসারের স্বাক্ষর</td>" .
        //     "                <td valign=\"middle\" width=\"10%\" align=\"center\">  আদেশের উপর গৃহীত ব্যবস্থা</td>" .
        //     "            </tr></thead>" .
        //     "            <tbody>" ;

        // return $th;
    }

    public static function getAppealOrderTableClose(){
        $tableClose = '</tbody>';
        $tableClose .= '</table>';
        return $tableClose;
        // $tableClose= "                " .
        //     "                ".
        //     "            </tbody>" .
        //     "        </table>" ;

        // return $tableClose;
    }

    public static function getAppealShortOrderTextForOrdersheet($shortOrders){

        $content='';
        $sl=1;

        // dd($shortOrders);
        // if(count($shortOrders)>0){
        if($shortOrders != null){
            foreach ($shortOrders as $shortOrder){
                $content.=DataConversionService::toBangla($sl).'। '.EmCaseShortdecisions::find($shortOrder)->case_short_decision .'<br>';
                $sl++;
            }
        }

        return $content;
    }

    public static function getAppealOrderSheetTableContent($appealObjectFromUi,$orderNoBng,$trialDate){
        $user = globalUserInfo();
        $userRole = globalUserRoleInfo();
        $signature ='';
        if($appealObjectFromUi->oldCaseFlag == '1'){
            $signature = '';
        }else{
            $signature = $user->username;
        }
        $shortOrdersText=self::getAppealShortOrderTextForOrdersheet($appealObjectFromUi->shortOrder);
        // dd('minar check test getAppealOrderSheetTableContent');
            $tableContent = '<tr>';
            $tableContent .= '<td valign="top" align="center"> <span class="underline" ;=""> '. $orderNoBng .'</span></td>';
            $tableContent .= '<td valign="top" align="center">'. DataConversionService::toBangla($trialDate) .'</td>';
            $tableContent .= '<td style="padding:5px; text-align : justify;">';
            $tableContent .= '<div>';
            $tableContent .= '<span>'.$appealObjectFromUi->note.'</span>';
            $tableContent .= '</div>';
            $tableContent .= '';
            $tableContent .= '</td>';
            $tableContent .= '<td style="padding:5px; text-align : center; color: blueviolet;">';
            // $tableContent .= 'স্বাক্ষর<br> অফিসারের নাম <br> অফিসারের পদবী <br>তারিখ';
            $tableContent .= '<img style="width: 100px;" src="'.asset($user->signature).'" alt="signature"/>';
            $tableContent .= '<br>'.'<b>'. $user->name .'</b>'.'<br> '.   $userRole->role_name .'';
            $tableContent .= '</td>';
            $tableContent .= '</tr>';
            return $tableContent;

        // $tableContent="             <tr></tr><td valign=\"top\" align=\"center\">" .
        //     "                    <span class=\"underline\" ;=\"\"> ". $orderNoBng ."</span><br>"
        //    . DataConversionService::toBangla($trialDate) .
        //     "                </td>" .
        //     "                <td style=\"padding:5px; text-align : justify;\"><div><span>".$appealObjectFromUi->note."</span></div>" .

        //     "                    <table  border=\"0\" width=\"100%\" align=\"center\">" .
        //     "                        <tbody>" .
        //     "                        <tr>" .
        //     "                            <td width=\"30%\">" .
        //     "                            </td>" .
        //     "                            <td width=\"70%\" align=\"center\">" .
        //     "                                <span>&nbsp;". DataConversionService::toBangla($trialDate)."</span>" .
        //     "                            </td>" .
        //     "                        </tr>" .
        //     "                        <tr>" .
        //     "                            <td width=\"30%\">" .
        //     "                            </td>" .
        //     "                            <td width=\"70%\" align=\"center\">" .
        //     "                                <span>".   $signature ."</span>" .
        //     "                            </td>" .
        //     "                        </tr>" .
        //     "                        <tr>" .
        //     "                            <td width=\"30%\">" .
        //     "                            </td>" .
        //     "                            <td width=\"70%\" align=\"center\">" .
        //     "                                <span>".   $user->designation_bng ."</span>" .
        //     "                            </td>" .
        //     "                        </tr>" .
        //     "                        <tr>" .
        //     "                            <td width=\"30%\">" .
        //     "                            </td>" .
        //     "                            <td width=\"70%\" align=\"center\">" .
        //     "                                <span>". $user->office_name_bng."</span>" .
        //     "                            </td>" .
        //     "                        </tr>" .
        //     "                        </tbody>" .
        //     "                    </table>" .
        //     "                </td>".
        //     "<td style=\"padding:5px; text-align : justify;\"><div><span>".$shortOrdersText."</span></div></td>";
        // return $tableContent;
    }

    public static function getAppealOrderSheetTable($appealInfo,$appealObjectFromUi,$trialDate){

        $appealId=$appealInfo['appeal']->id;

        $orders=EmAppealOrderSheet::where('appeal_id',$appealInfo['appeal']->id)
        ->get();
        $orderNoBng=DataConversionService::toBangla(count($orders)+1);

        $orderTableTh=self::getAppealOrderSheetTh();
        $orderTableClose=self::getAppealOrderTableClose();
        $orderTableBody=self::getAppealOrderSheetTableContent($appealObjectFromUi,$orderNoBng,$trialDate);
        // dd('minar check test getAppealOrderSheetTable ok' );

        $body= $orderTableTh.$orderTableBody.$orderTableClose;

        return ["body"=>$body,"tableBody"=>$orderTableBody,"tableTh"=>$orderTableTh,"orderTableClose"=>$orderTableClose];

    }

}
