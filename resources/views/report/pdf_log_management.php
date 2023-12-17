<?php use Illuminate\Support\Facades\DB; ?>
<?php 

        
        function x($investigation_report, $investigator_details)
        {
            // $investigator_from_db = DB::table('em_investigators')->where('id','=',$investigator_id)->first();
            // dd($investigator_from_db);
        
            $show='তদন্ত প্রতিবেদন দিয়েছেন';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির নাম' . $investigation_report->investigator_name . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির অফিসের নাম ' . $investigator_details->organization . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির পদবী ' . $investigator_details->designation . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির মোবাইল ' . $investigator_details->mobile . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির ইমেল ' . $investigator_details->email . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির বিয়য় ' . $investigation_report->investigation_subject . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির মন্তব্য ' . $investigation_report->investigation_comments . '</span>';
            $show .= '<br>';
            $show .= '<span>তদন্তকারির তারিখ ' . $investigation_report->investigation_date . '</span>';
            $show .= '<br>';
            $designation = $investigator_details->designation;
        
            $to_be_print['show'] = $show;
            $to_be_print['designation'] = $designation;
            return $to_be_print;
        }
    



?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= $page_title ?></title>
    <style type="text/css">
        .priview-body {
            font-size: 16px;
            color: #000;
            margin: 25px;
        }

        .priview-header {
            margin-bottom: 10px;
            text-align: center;
        }

        .priview-header div {
            font-size: 18px;
        }

        table,
        th,
        td {
            border: 1px solid;
        }

        .priview-memorandum,
        .priview-from,
        .priview-to,
        .priview-subject,
        .priview-message,
        .priview-office,
        .priview-demand,
        .priview-signature {
            padding-bottom: 20px;
        }

        .priview-office {
            text-align: center;
        }

        .priview-imitation ul {
            list-style: none;
        }

        .priview-imitation ul li {
            display: block;
        }

        .date-name {
            width: 20%;
            float: left;
            padding-top: 23px;
            text-align: right;
        }

        .date-value {
            width: 70%;
            float: left;
        }

        .date-value ul {
            list-style: none;
        }

        .date-value ul li {
            text-align: center;
        }

        .date-value ul li.underline {
            border-bottom: 1px solid black;
        }

        .subject-content {
            text-decoration: underline;
        }

        .headding {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .col-1 {
            width: 8.33%;
            float: left;
        }

        .col-2 {
            width: 16.66%;
            float: left;
        }

        .col-3 {
            width: 25%;
            float: left;
        }

        .col-4 {
            width: 33.33%;
            float: left;
        }

        .col-5 {
            width: 41.66%;
            float: left;
        }

        .col-6 {
            width: 50%;
            float: left;
        }

        .col-7 {
            width: 58.33%;
            float: left;
        }

        .col-8 {
            width: 66.66%;
            float: left;
        }

        .col-9 {
            width: 75%;
            float: left;
        }

        .col-10 {
            width: 83.33%;
            float: left;
        }

        .col-11 {
            width: 91.66%;
            float: left;
        }

        .col-12 {
            width: 100%;
            float: left;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            border: 1px solid #ddd;
        }

        .table tr.bottom-separate td,
        .table tr.bottom-separate td .table td {
            border-bottom: 1px solid #ddd;
        }

        .borner-none td {
            border: 0px solid #ddd;
        }

        .headding td,
        .total td {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .table td {
            padding: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        b {
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="priview-body">
        <div class="priview-header">
            <div class="row">
                <div class="col-3 text-left float-left" style="border: 0px solid red; font-size:small;text-align:left;">
                    <?= en2bn(date('d-m-Y')) ?>
                </div>
                <div class="col-6 text-center float-left" style="border: 0px solid red;">
                    <p class="text-center" style="margin-top: 0;"><span
                            style="font-size:25px;font-weight: bold;">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</span><br> <span
                            style="font-size:small">মন্ত্রিপরিষদ বিভাগ, বাংলাদেশ সচিবালয়, ঢাকা</span></p>
                    <!-- <div style="font-size:18px;"><u><?= $page_title ?></u></div> -->
                    <?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''
                    ?>
                    <?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''
                    ?>
                </div>
                <div class="col-2 text-center float-right" style="border: 0px solid red; font-size:small; float:right;">
                    আদালতের সকল সেবা এক ঠিকানায়
                </div>
            </div>
        </div>

        <div class="priview-memorandum">
            <div class="row">
                <div class="col-12 text-center">
                    <div style="font-size:18px;"><u><?= $page_title ?></u></div>
                    <div style="font-size:18px;"><u><?= en2bn(date('Y')) ?></u></div>
                    <?php //!empty($data_status)?'ব্যাক্তিগত ডাটার স্ট্যাটাসঃ '.func_datasheet_status($data_status).'<br>':''
                    ?>
                    <?php // !empty($division_info->div_name_bn)?'বিভাগঃ '.$division_info->div_name_bn.'<br>':''
                    ?>

                </div>
            </div>
        </div>

        <div class="priview-demand">
            <div class="row text-center">
                <div class="col-md-6">


                    <h5><span class="font-weight-bolder">মামলা নং: </span><?= en2bn($info->case_no) ?></h5>
                    <h5><span class="font-weight-bolder">আদালতের নাম: </span> <?= $info->court_name ?></h5>
                    <h5><span class="font-weight-bolder">জেলা: </span> <?= $info->district_name_bn ?></h5>


                </div>
                <div class="col-md-6">
                    <h5><span class="font-weight-bolder">উপজেলা: </span> <?= $info->upazila_name_bn ?></h5>
                    <h5><span class="font-weight-bolder">বিভাগ: </span> <?= $info->division_name_bn ?></h5>

                    <h5><span class="font-weight-bolder">মামলার ফলাফল: </span>
                        <?php
                        
                        switch ($info->appeal_status) {
                            case 'ON_TRIAL':
                                echo 'এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালেত বিচারাধীন';
                                break;
                            case 'ON_TRIAL_DM':
                                echo 'জেলা ম্যাজিস্ট্রেট আদালেত বিচারাধীন';
                                break;
                            case 'SEND_TO_EM':
                                echo 'গ্রহণের জন্য অপেক্ষমান (এক্সিকিউটিভ ম্যাজিস্ট্রেট)';
                                break;
                            case 'SEND_TO_ADM':
                                echo 'গ্রহণের জন্য অপেক্ষমান (জেলা ম্যাজিস্ট্রেট / অতিরিক্ত জেলা ম্যাজিস্ট্রেট)';
                                break;
                            case 'SEND_TO_ASST_EM':
                                echo 'গ্রহণের জন্য অপেক্ষমান (পেশকার)';
                                break;
                            case 'CLOSED':
                                echo 'নিষ্পন্ন';
                                break;
                            case 'REJECTED':
                                echo 'খারিজকৃত';
                                break;
                        
                            default:
                                echo 'Unknown';
                                break;
                        }
                        ?>



                    </h5>
                </div>
            </div>

            <div class="row" id="element-to-print">
                <div class="col-md-12">

                    <table class="table table-striped border">
                        <thead>
                            <tr><th class="h3" scope="col" colspan="4">বাদীর বিবরণ</th></tr>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $k=1;
                            foreach ($applicantCitizen as $badi)
                            {
                                ?>
                            <tr>
                                <td><?= en2bn($k) ?>.</td>
                                <td><?= $badi->citizen_name ?? '-' ?></td>
                                <td><?= $badi->father ?? '-' ?></td>
                                <td><?= $badi->present_address ?? '-' ?></td>
                            </tr>
                            <?php
                                $k++;
                            }
                                
                                 
                            ?>
                        </tbody>
                    </table>

                    <br>
                    <?php 
                           if (!empty($victimCitizen))
                           {
                             ?>
                    <table class="table table-striped border">
                       
                        <thead>
                            <tr>
                            <th class="h3" scope="col" colspan="4">ভিক্টিমের বিবরণ</th>
                            </tr>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k = 1; 
                                foreach ($victimCitizen as $victim)
                                {
                                    ?>

                            <tr>
                                <td><?= en2bn($k) ?>.</td>
                                <td><?= $victim->citizen_name ?? '-' ?></td>
                                <td><?= $victim->father ?? '-' ?></td>
                                <td><?= $victim->present_address ?? '-' ?></td>
                            </tr>
                            <?php
                                    $k++;
                                }
                                     ?>
                        </tbody>
                    </table>

                    <?php  
                           }
                       ?>


                    <br>
                    <table class="table table-striped border">
                        
                        <thead>
                            <tr>
                            <th class="h3" scope="col" colspan="4">বিবাদীর বিবরণ</th>
                            </tr>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k = 1; 
                            foreach ($defaulterCitizen as $bibadi)
                            {
                                  ?>
                            <tr>
                                <td><?= en2bn($k) ?>.</td>
                                <td><?= $bibadi->citizen_name ?? '-' ?></td>
                                <td><?= $bibadi->father ?? '-' ?></td>
                                <td><?= $bibadi->present_address ?? '-' ?></td>
                            </tr>
                            <?php
                            }
                                
                                 $k++; 
                                 ?>
                        </tbody>
                    </table>
                    <br>
                    <table class="table table-striped border">
                       
                        <thead>
                            <tr>
                            <th class="h3" scope="col" colspan="4">সাক্ষীর বিবরণ</th>
                            </tr>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $k = 1; 
                            foreach ($witnessCitizen as $witness)
                            {
                                ?>
                            <tr>
                                <td><?= en2bn($k) ?>.</td>
                                <td><?= $witness->citizen_name ?? '-' ?></td>
                                <td><?= $witness->father ?? '-' ?></td>
                                <td><?= $witness->present_address ?? '-' ?></td>
                            </tr>
                            <?php
                            }
                                
                                 $k++; 
                                 
                                 ?>
                        </tbody>
                    </table>
                    <br>

                </div>
                <div class="col-md-12">
                    <table class="table table-striped border">
                        <thead>
                            <tr>

                                <th class="h3" scope="col" colspan="2">ঘটনার তারিখ সময় ও স্থান </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>বিগত ইং <?= en2bn($appeal->case_date) ?> তারিখ মোতাবেক বাংলা
                                    <?= BnSal($appeal->case_date, 'Asia/Dhaka', 'j F Y') ?> সময়:
                                    <?php
                                    if (date('a', strtotime($appeal->created_at)) == 'pm') {
                                        echo 'বিকাল';
                                    } else {
                                        echo 'সকাল';
                                    }
                                    ?>

                                    <?= en2bn(date('h:i:s', strtotime($appeal->created_at))) ?>
                                    । <?= $appeal->division->division_name_bn ?? '-' ?> বিভাগের
                                    <?= $appeal->district->district_name_bn ?? '-' ?> জেলার
                                    <?= $appeal->upazila->upazila_name_bn ?? '-' ?> উপজেলায়।
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <table class="table table-striped border">
                        <thead>
                            <tr>

                                <th class="h3" scope="col" colspan="2">ঘটনার বিবরণ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>

                                    <?= str_replace('&nbsp;', '', strip_tags($appeal->case_details)) ?>
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>

                <?php 
                if ($guarantorCitizen)
                {
                    ?>

                <div class="col-md-6">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="3">জামানত কারীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>

                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td><?= $guarantorCitizen->citizen_name ?? '-' ?></td>
                                <td><?= $guarantorCitizen->father ?? '-' ?></td>
                                <td><?= $guarantorCitizen->organization ?? '-' ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <?php
                }
                ?>


                <?php 
                if ($lawerCitizen)
                {
                    ?>
                <div class="col-md-6">

                    <table class="table table-striped border">
                        <thead>
                            <tr>

                                <th class="h3" scope="col" colspan="3">আইনজীবীর বিবরণ</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>

                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td><?= $lawerCitizen->citizen_name ?? '-' ?></td>
                                <td><?= $lawerCitizen->father ?? '-' ?></td>
                                <td><?= $lawerCitizen->organization ?? '-' ?></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <?php
                }
                    
                ?>
                <div class="col-md-12 my-5">
                <table class="tg">
                    <thead>
                        <tr>
                            <th class="font-weight-bolder text-center">তারিখ ও সময়</th>
                            <th class="font-weight-bolder text-center">ব্যবহারকারীর নাম</th>
                            <th class="font-weight-bolder text-center">ব্যবহারকারীর পদবি</th>
                            <th class="font-weight-bolder text-center">অ্যাক্টিভিটি</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php 
                        foreach ($case_details as $case_details_single)
                        {
                            if ($case_details_single->user_id != 0) {
                                $user_name = DB::table('users')
                                    ->select('name')
                                    ->where('id', '=', $case_details_single->user_id)
                                    ->first();
                                $name = $user_name->name;
                                $designation = $case_details_single->designation;
                            } else {
                                if (!empty($case_details_single->investigation_report)) {
                                    $investigation_report = json_decode($case_details_single->investigation_report);
                                    //dd($investigation_report);
                                    $investigator_details = json_decode($case_details_single->investigator_details);
                                    $to_be_print = x($investigation_report, $investigator_details);
                                    $name = $investigation_report->investigator_name;
                                    $designation = $to_be_print['designation'];
                                    $show = $to_be_print['show'];
                                }
                            }
                            ?>
                             <tr>
                             <td><?= en2bn($case_details_single->created_at) ?></td>
                             <td><?= $name ?></td>
                             <td><?= $designation ?></td>
                             <td><?php 
                              echo $case_details_single->activity;
                              echo '<br>';
                              if (!empty($case_details_single->files)) {
                                $files = json_decode($case_details_single->files);
                            
                                if (!empty($files->file_path)) {
                                    echo '<a href="#" target="_blank" class="text-decoartion-none btn btn-sm btn-success font-size-h5 float-left mr-3">
                                                      <i class="fa fas fa-file-pdf"></i>
                                                      <b>জারিকারের রিপোর্ট ফাইল</b></a>';
                                } else {
                                    foreach ($files as $file) {
                                        echo '<a href="#" target="_blank" class="text-decoartion-none btn btn-sm btn-success font-size-h5 float-left mr-3">
                                                          <i class="fa fas fa-file-pdf"></i>
                                                          <b>' .
                                            $file->file_category .
                                            '</b></a>';
                                    }
                                }
                            
                                
                            }
                            
                            if (!empty($case_details_single->investigation_report)) {
                                $investigation_report = json_decode($case_details_single->investigation_report);
                                //dd($investigation_report);
                                $investigator_details = json_decode($case_details_single->investigator_details);
                                $to_be_print = x($investigation_report, $investigator_details);
                                $name = $investigation_report->investigator_name;
                                $designation = $to_be_print['designation'];
                                $show = $to_be_print['show'];
                                echo $show;
                                echo '<br>';
                                echo 'প্রধান রিপোর্ট ফাইল';
                                echo '<br>';
                            
                                if (!empty($investigation_report->investigation_attachment_main)) {
                                    if (is_array($investigation_report->investigation_attachment_main)) {
                                        $files = $investigation_report->investigation_attachment_main;
                                        foreach ($files as $file) {
                                            echo '<a href="#" target="_blank" class="text-decoartion-none text-decoartion-none text-decoartion-none btn btn-sm btn-success font-size-h5 float-left mr-3 ">
                                  <i class="fa fas fa-file-pdf"></i>
                                  <b>' .
                                                $file->file_category .
                                                '</b></a>';
                                        }
                                    } else {
                                        $files = json_decode($investigation_report->investigation_attachment_main);
                                        foreach ($files as $file) {
                                            echo '<a href="#" target="_blank" class="text-decoartion-none btn btn-sm btn-success font-size-h5 float-left mr-3 ">
                                  <i class="fa fas fa-file-pdf"></i>
                                  <b>' .
                                                $file->file_category .
                                                '</b></a>';
                                        }
                                    }
                                }
                                if (!empty($investigation_report->investigation_attachment_main_delete)) {
                                    //dd($investigation_report->investigation_attachment_main_delete);
                                    $files = $investigation_report->investigation_attachment_main_delete;
                                    foreach ($files as $file) {
                                        echo 'মুছে ফেলা প্রধান ফাইল নাম
                                                             <b>' .
                                            'তদন্তের প্রধান রিপোর্ট' .
                                            '</b></a>';
                                    }
                                }
                                echo '<br>';
                                echo '<br>';
                                echo '<br>';
                                echo '<br>';
                                echo 'সংযুক্তি তদন্ত অন্যান্য ';
                                echo '<br>';
                                if (!empty($investigation_report->investigation_attachment)) {
                                    if (is_array($investigation_report->investigation_attachment)) {
                                        $files = $investigation_report->investigation_attachment;
                                        foreach ($files as $file) {
                                            echo '<a href="#" target="_blank" class="text-decoartion-none btn btn-sm btn-success font-size-h5 float-left mr-3 ">
                                  <i class="fa fas fa-file-pdf"></i>
                                  <b>' .
                                                $file->file_category .
                                                '</b></a>';
                                        }
                                    } else {
                                        $files = json_decode($investigation_report->investigation_attachment);
                                        foreach ($files as $file) {
                                            echo '<a href="#" target="_blank" class="text-decoartion-none btn btn-sm btn-success font-size-h5 float-left mr-3 ">
                                  <i class="fa fas fa-file-pdf"></i>
                                  <b>' .
                                                $file->file_category .
                                                '</b></a>';
                                        }
                                    }
                                }
                                if (!empty($investigation_report->investigation_attachment_delete)) {
                                    $files = $investigation_report->investigation_attachment_delete;
                                    echo 'মুছে ফেলা অন্যান্য ফাইল নাম';
                                    foreach ($files as $file) {
                                        echo '
                                                             <b>' .
                                            $file->file_category .
                                            ' ,' .
                                            '</b></a>';
                                    }
                                }
                            }
                             ?></td>
                             </tr>
                            <?php

                        }
                        ?>
                            


                    </tbody>
                </table>
            </div>

            </div>




</body>

</html>
