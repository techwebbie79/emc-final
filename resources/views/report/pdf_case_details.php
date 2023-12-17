<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?=$page_title?></title>
	<style type="text/css">
		.priview-body{font-size: 16px;color:#000;margin: 25px;}
		.priview-header{margin-bottom: 10px;text-align:center;}
		.priview-header div{font-size: 18px;}
		.priview-memorandum, .priview-from, .priview-to, .priview-subject, .priview-message, .priview-office, .priview-demand, .priview-signature{padding-bottom: 20px;}
		.priview-office{text-align: center;}
		.priview-imitation ul{list-style: none;}
		.priview-imitation ul li{display: block;}
		.date-name{width: 20%;float: left;padding-top: 23px;text-align: right;}
		.date-value{width: 70%;float:left;}
		.date-value ul{list-style: none;}
		.date-value ul li{text-align: center;}
		.date-value ul li.underline{border-bottom: 1px solid black;}
		.subject-content{text-decoration: underline;}
		.headding{border-top:1px solid #000;border-bottom:1px solid #000;}

		.col-1{width:8.33%;float:left;}
		.col-2{width:16.66%;float:left;}
		.col-3{width:25%;float:left;}
		.col-4{width:33.33%;float:left;}
		.col-5{width:41.66%;float:left;}
		.col-6{width:50%;float:left;}
		.col-7{width:58.33%;float:left;}
		.col-8{width:66.66%;float:left;}
		.col-9{width:75%;float:left;}
		.col-10{width:83.33%;float:left;}
		.col-11{width:91.66%;float:left;}
		.col-12{width:100%;float:left;}

		.table{width:100%;border-collapse: collapse;}
		.table td, .table th{border:1px solid #ddd;}
		.table tr.bottom-separate td,
		.table tr.bottom-separate td .table td{border-bottom:1px solid #ddd;}
		.borner-none td{border:0px solid #ddd;}
		.headding td, .total td{border-top:1px solid #ddd;border-bottom:1px solid #ddd;}
		.table td{padding:5px;}
		.text-center{text-align:center;}
		.text-right{text-align:right;}
		.text-left{text-align:left;}
		.float-left{float: left;}
		.float-right{float: right;}
		b{font-weight:500;}
	</style>
</head>
<body>
	<div class="priview-body">

		<div class="priview-demand">
        <div class="col-md-12">
            <p>বাদীর বিবরণ</p>
                    <table cellspacing="0" cellpadding="0" border="1" width="980px">
                        <thead>
                            <th class="h3" scope="col" colspan="4">বাদীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row" width="200">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k = 1; 
                            foreach ($applicantCitizen as $badi)
                            {
                                ?>
                                <tr>
                                    <td><?= en2bn($k) ?></td>
                                    <td><?= $badi->citizen_name ?? '-' ?></td>
                                    <td><?= $badi->father ?? '-' ?></td>
                                    <td><?= $badi->present_address ?? '-' ?></td>
                                </tr>
                                <?php
                            }
                                 $k++; ?>
                            
                        </tbody>
                    </table>

                    <br>
                    <?php 
                    if(!empty($victimCitizen))
                    {
                        ?>
                          <p>ভিক্টিমের বিবরণ</p>
                        <table class="cellspacing="0" cellpadding="0" border="1" width="980px"">
                        <thead>
                            <th class="h3" scope="col" colspan="4">ভিক্টিমের বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row" width="200">পিতা/স্বামীর নাম</th>
                                <th scope="row" >ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k = 1; 
                            foreach ($victimCitizen as $victim)
                            {
                               ?>
                                <tr>
                                    <td><?= en2bn($k) ?></td>
                                    <td><?= $victim->citizen_name ?? '-'?></td>
                                    <td><?= $victim->father ?? '-'?></td>
                                    <td><?= $victim->present_address ?? '-' ?></td>
                                </tr>
                                <?php
                                $k++; 
                            }

                             ?>
                            
                        </tbody>
                    </table><?php
                    }
                    ?>    
                    
                    <br>
                    <p>বিবাদীর বিবরণ</p>
                    <table cellspacing="0" cellpadding="0" border="1" width="980px">
                        <thead>
                            <th class="h3" scope="col" colspan="4">বিবাদীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row" width="200">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $k = 1; 
                            foreach ($defaulterCitizen as $bibadi)
                            {
                                 ?>
                                <tr>
                                    <td><?= en2bn($k) ?></td>
                                    <td><?= $bibadi->citizen_name ?? '-' ?></td>
                                    <td><?= $bibadi->father ?? '-' ?></td>
                                    <td><?= $bibadi->present_address ?? '-' ?></td>
                                </tr>
                                 <?php
                                 $k++; 
                            }
                               
                              ?>
                            

                        </tbody>
                    </table>
                    <br>
                    <p>সাক্ষীর বিবরণ</p>
                    <table cellspacing="0" cellpadding="0" border="1" width="980px">
                        <thead>
                            <th class="h3" scope="col" colspan="4">সাক্ষীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row" width="200">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $k = 1; 
                            foreach ($witnessCitizen as $witness)
                            {
                                 ?>
                                <tr>
                                    <td><?= en2bn($k) ?></td>
                                    <td><?= $witness->citizen_name ?? '-' ?></td>
                                    <td><?= $witness->father ?? '-' ?></td>
                                    <td><?= $witness->present_address ?? '-' ?></td>
                                </tr>
                                 <?php
                                 $k++;
                            }
                               
                              ?>
                        </tbody>
                    </table>
                    <br>
                    <?php 
                    if (!empty($lawerCitizen))
                     {
                        ?>
                        <p>আইনজীবীর বিবরণ</p>
               <table cellspacing="0" cellpadding="0" border="1" width="980px">
                            <thead>
                                <th class="h3" scope="col" colspan="3">আইনজীবীর বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="row" width="10">ক্রম</th>
                                    <th scope="row" width="200">নাম</th>
                                    <th scope="row" width="200">পিতা/স্বামীর নাম</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= en2bn('1') ?></td>
                                    <td><?= $lawerCitizen->citizen_name ?? '-' ?></td>
                                    <td><?= $lawerCitizen->father ?? '-' ?></td>
                                    <td><?= $lawerCitizen->present_address ?? '-' ?></td>
                                </tr>

                            </tbody>
                        </table>
                        <?php
                     }
                     ?>
                        
                    
                  
                </div>
                </br>
                </br>
                </br>
                <div style="margin-top: 100px;">

                </div>
                <p>ঘটনার তারিখ সময় ও স্থান</p>
                <div class="col-md-12">
                    
                            
                                বিগত ইং <?=en2bn($appeal->case_date) ?> তারিখ মোতাবেক বাংলা
                                    <?= BnSal($appeal->case_date, 'Asia/Dhaka', 'j F Y') ?> সময়:
                                        <?php 
                                          if(date('a', strtotime($appeal->created_at)) == 'pm')
                                          {
                                               echo 'বিকাল';
                                          }
                                          else
                                          {
                                            echo 'সকাল';
                                          }
                                        ?>
                                    
                                    <?= en2bn(date('h:i:s', strtotime($appeal->created_at))) ?>
                                    । <?= $appeal->division->division_name_bn ?? '-' ?> বিভাগের
                                    <?= $appeal->district->district_name_bn ?? '-' ?> জেলার
                                    <?= $appeal->upazila->upazila_name_bn ?? '-' ?> উপজেলায়।
                                
                            

                    <p style="margin-top: 50px">ঘটনার বিবরণ</p>
                
                   

                     <?= str_replace('&nbsp;', '', strip_tags($appeal->case_details)) ?>  
                              
                </div>
				
		</div>

	</div>

</body>
</html>
