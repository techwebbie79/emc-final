@extends('layouts.landing')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
@if(!empty(globalUserInfo()->doptor_user_flag) &&  globalUserInfo()->doptor_user_flag == 1)
           <div class="row mb-5">
            <div class="col-md-9"></div>
            <div class="col-md-3">
                 <?=dorptor_widget()?> 
            </div>
           </div>
           <br>
@endif
  @if(globalUserInfo()->role_id != 37)
  
    @include('dashboard.inc.icon_card')
  @endif

    <style type="text/css">
        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }

        .list-group-flush>.list-group-item {
            padding-left: 0;
        }
    </style>

  
    {{-- @if (globalUserInfo()->role_id == 37)
        @include('dashboard.citizen.cause_list')
    @endif --}}
    <div class="card card-custom mb-5 shadow mx-5">
        <div class="card-header bg-primary-o-50">
            <div class="card-title">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="applicant-tab" data-toggle="tab" href="#applicant" aria-controls="applicant">
                            <span class="nav-icon">
                                <i class="fas fa-solid fa-list"></i>
                            </span>
                            <span class="nav-text text-dark h6 mt-2">কজলিস্ট</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="victim-tab" data-toggle="tab" href="#victim" aria-controls="victim">
                            <span class="nav-icon">
                                <i class="fas fa-solid fa-chart-pie"></i>
                            </span>
                            <span class="nav-text text-dark h6 mt-2">গ্রাফ চার্ট</span>
                        </a>
                    </li>

                         
                    <li class="nav-item">
                        <a class="nav-link" id="deafulter-tab" data-toggle="tab" href="#deafulter" aria-controls="deafulter">
                            <span class="nav-icon">
                                <i class="fas fa-solid fa-table"></i>
                            </span>
                            <span class="nav-text text-dark h6 mt-2">মামলার পরিসংখ্যান</span>
                        </a>
                    </li>
                    
                  
                </ul>
            </div>
        </div>
        <div class="card-body" id="CaseDetails">
            <div class="tab-content mt-5" id="myTabContent">
                {{-- <div class="tab-pane fade active show" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @include('dashboard.inc.calendar')
                </div> --}}
                <div class="tab-pane fade  active show" id="applicant" role="tabpanel" aria-labelledby="applicant-tab">
                    @include('dashboard.citizen.cause_list')
                </div>
                <div class="tab-pane fade" id="victim" role="tabpanel" aria-labelledby="victim-tab">
                    <form action="javascript:void(0)" class="form" method="POST">
                        @csrf
                        <!-- <div class="card-body"> -->
                        {{-- <fieldset class="mb-6">
                            <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                
                            <div class="row">
                                <div class="col-lg-2 mb-5">
                                    <!-- <label>উপজেলা </label> -->
                                    <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                        <option value="">-উপজেলা নির্বাচন করুন-</option>
                                        @foreach ($upazilas as $value)
                                            <option value="{{ $value->id }}"> {{ $value->upazila_name_bn }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 mb-5">
                                    <input type="text" name="date_from" id="date_from"
                                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                                </div>
                                <div class="col-lg-2 mb-5">
                                    <input type="text" name="date_to" id="date_to"
                                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ পর্যন্ত"
                                        autocomplete="off">
                                </div>
                            </div>
                        </fieldset> --}}
                        <!-- </div> -->
                
                
                         <!-- /row -->
                
                
                    </form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title ">
                                        <h3 class="card-label font-weight-bolder text-dark h3">অভিযোগের ধরণভিত্তিক  মামলার পরিসংখ্যান</h3>
                                    </div>
                                    {{-- <div class="card-toolbar">
                                        <button class="report-crpc btn btn-success spinner spinner-darker-white spinner-left"
                                            onclick="crpc_statistic()">অনুসন্ধান করুন</button>
                                    </div> --}}
                                </div>
                                <div class="card-body" style="padding-top: 75px">
                                    <!-- <div class="spinner spinner-danger spinner-lg"></div> -->
                                    <!-- <div class="loadersmall" style="display: none;">dfds</div> -->
                                    {{-- <p class="font-weight-boldest text-center h5 text-success" id="crpcMsg"></p>  --}}
                                    <div class="chart-container">
                                        <div class="pie-chart-container" style="height: 380px !important; width:380px !important">
                                            <canvas id="pie-chartcanvas-1" ></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="col-lg-6">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title ">
                                        <h3 class="card-label font-weight-bolder text-dark h3">আদালত ভিত্তিক মামলার পরিসংখ্যান</h3>
                                    </div>
                                    {{-- <div class="card-toolbar">
                                        <button class="report-case-status btn btn-success spinner spinner-darker-white spinner-left"
                                            onclick="case_status_statistic()">অনুসন্ধান করুন</button>
                                    </div> --}}
                                </div>
                                <div class="card-body">
                                    {{-- <p class="font-weight-boldest text-center h5 text-success" id="caseStatusMsg"></p> --}}
                                  
                                    <div class="chart-container">
                                        <div class="pie-chart-container" style="height: 400px !important; width:400px !important">
                                            <canvas id="pie-chartcanvas-2"></canvas>
                                        </div>
                                    </div>
                                </div>
            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="deafulter" role="tabpanel" aria-labelledby="deafulter-tab">
                    <form action="javascript:void(0)" class="form" method="POST">
                        @csrf
                        <!-- <div class="card-body"> -->
                        <fieldset class="mb-6">
                            <legend>ফিল্টারিং ফিল্ড সমূহ</legend>
                
                            <div class="row">
                                <div class="col-lg-2 mb-5">
                                    <!-- <label>উপজেলা </label> -->
                                    <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                        <option value="">-উপজেলা নির্বাচন করুন-</option>
                                        @foreach ($upazilas as $value)
                                            <option value="{{ $value->id }}"> {{ $value->upazila_name_bn }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 mb-5">
                                    <input type="text" name="date_from" id="date_from"
                                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ হতে" autocomplete="off">
                                </div>
                                <div class="col-lg-2 mb-5">
                                    <input type="text" name="date_to" id="date_to"
                                        class="form-control form-control-sm common_datepicker" placeholder="তারিখ পর্যন্ত"
                                        autocomplete="off">
                                </div>
                            </div>
                        </fieldset>
                        <!-- </div> -->
                
                
                         <!-- /row -->
                
                
                    </form>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title ">
                                        <h3 class="card-label font-weight-bolder text-dark h3">ফৌজদারি কার্যবিধি ১৮৯৮ এর ধারা ভিত্তিক মামলার পরিসংখ্যান</h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <button class="report-crpc btn btn-success spinner spinner-darker-white spinner-left"
                                            onclick="crpc_statistic()">অনুসন্ধান করুন</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- <div class="spinner spinner-danger spinner-lg"></div> -->
                                    <!-- <div class="loadersmall" style="display: none;">dfds</div> -->
                                    <p class="font-weight-boldest text-center h5 text-success" id="crpcMsg"></p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item font-weight-bolder h6"> <i class="fas fa-folder-open icon-lg text-danger mr-2"></i> বেআইনীভাবে আটক 
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="crpc100">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-folder-open icon-lg text-danger mr-2"></i> শান্তি ভঙ্গ
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="crpc107">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-folder-open icon-lg text-danger mr-2"></i> রাষ্ট্রদ্রোহিতামূলক বিষয় প্রচার
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="crpc108">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-folder-open icon-lg text-danger mr-2"></i> ভবঘুরে ও সন্দেহভাজন ব্যক্তি কর্তৃক উপস্থিতি গোপন ও অপরাধ
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="crpc109">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-folder-open icon-lg text-danger mr-2"></i> অভ্যাসগত অপরাধী কর্তৃক অপরাধ সংঘটন
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="crpc110">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-folder-open icon-lg text-danger mr-2"></i> মানুষের জীবন ,স্বাস্থ্য বা নিরাপত্তার প্রতি বিপদ বা দাঙ্গা-হাঙ্গামার সম্ভাবনা সৃষ্টিকারী অপরাধ সংঘটন
                                            <span class="label label-inline label-danger font-weight-bold float-right h5" id="crpc144">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-folder-open icon-lg text-danger mr-2"></i> স্থাবর সম্পত্তি বিষয়ক বিরোধের ফলে শান্তি ভঙ্গ
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="crpc145">0</span>
                                        </li>
                                    </ul>  
            
            
                                    {{-- <div class="chart-container">
                                        <div class="pie-chart-container">
                                            <canvas id="pie-chartcanvas-1"></canvas>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
            
                        <div class="col-lg-6">
                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title ">
                                        <h3 class="card-label font-weight-bolder text-dark h3">আদালত ভিত্তিক মামলার পরিসংখ্যান</h3>
                                    </div>
                                    <div class="card-toolbar">
                                        <button class="report-case-status btn btn-success spinner spinner-darker-white spinner-left"
                                            onclick="case_status_statistic()">অনুসন্ধান করুন</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="font-weight-boldest text-center h5 text-success" id="caseStatusMsg"></p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item font-weight-bolder h6"> <i class="fas fa-gavel icon-lg text-danger mr-3"></i> এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে বিচারাধীন 
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="ON_TRIAL">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে বিচারাধীন
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="ON_TRIAL_DM">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-gavel icon-lg text-danger mr-3"></i> গ্রহণের জন্য অপেক্ষমান (ইএম)
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="SEND_TO_EM">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-gavel icon-lg text-danger mr-3"></i> গ্রহণের জন্য অপেক্ষমান (এ ডি এম)
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="SEND_TO_ADM">0</span>
                                        </li>
                                        <li class="list-group-item font-weight-bolder h6"><i class="fas fa-gavel icon-lg text-danger mr-3"></i>নিষ্পত্তিকৃত মামলা
                                            <span class="label label-inline label-danger font-weight-bold float-right h6" id="CLOSED">0</span>
                                        </li>
                                       
                                    </ul> 
                                    {{-- <div class="chart-container">
                                        <div class="pie-chart-container">
                                            <canvas id="pie-chartcanvas-2"></canvas>
                                        </div>
                                    </div> --}}
                                </div>
            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="witness" role="tabpanel" aria-labelledby="witness-tab">
                    
                       
                </div>
                
    
                <div class="tab-pane fade" id="lawyer" role="tabpanel" aria-labelledby="lawyer-tab">
                  
                </div>
               
            </div>
        </div>
    </div>

    <style>
        .chart-container {
            width: 100%;
            height: 700px;

        }

        .pie-chart-container {
            height: 500px;
            width: 500px;

        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script type="text/javascript">
        // CRPC Statistics 
        function crpc_statistic() {
            // console.log('submitted!');
            // Variable
            let division = {{ user_division(); }}
            let district = {{ user_district(); }}
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            // console.log(division);
             
            // Loader
            $('.report-crpc').addClass('spinner');

            // AJAX Request
            $.ajax({
                url: "{{ route('dashboard.crpc-report') }}",
                type: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                success: function(response) {
                    // console.log(response);


                    if (response) {

                        $('#crpc100').html(response.data[100]);
                        $('#crpc107').html(response.data[107]);
                        $('#crpc108').html(response.data[108]);
                        $('#crpc109').html(response.data[109]);
                        $('#crpc110').html(response.data[110]);
                        $('#crpc144').html(response.data[144]);
                        $('#crpc145').html(response.data[145]);

                        $('#crpcMsg').text(response.msg).show();
                        // $("#ajaxform")[0].reset();
                        // $('.spinner').hide();
                        $('.report-crpc').removeClass('spinner');

                        makeChart1();

                    }
                },
                error: function(error) {
                    console.log(error);
                    //$('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }


        function makeChart1() {
            var options = {
                responsive: true,
                title: {
                    display: true,
                    position: "top",
                    text: "Pie Chart",
                    fontSize: 18,
                    fontColor: "#111"
                },
                legend: {
                    display: true,
                    position: "bottom",
                    labels: {
                        fontColor: "#333",
                        fontSize: 16
                    }
                }
            };
            var mydata = [];
            var ctx1 = $("#pie-chartcanvas-1");
            mydata.push($('#crpc100').html());
            mydata.push($('#crpc107').html());
            mydata.push($('#crpc108').html());
            mydata.push($('#crpc109').html());
            mydata.push($('#crpc110').html());
            mydata.push($('#crpc144').html());
            mydata.push($('#crpc145').html());

            //pie chart data
           
            var data1 = {
                labels: [
                    "১০০",
                    "১০৭", 
                    "১০৮",
                    "১০৯",
                    "১১০", 
                    "১৪৪",
                    "১৪৫"
                ],
                datasets: [{
                    label: "TeamA Score",

                    data: mydata,
                    backgroundColor: [
                        "#DEB887",
                        "#A9A9A9",
                        "#DC143C",
                        "#F4A460",
                        "#2E8B57"
                    ],
                    borderColor: [
                        "#CDA776",
                        "#989898",
                        "#CB252B",
                        "#E39371",
                        "#1D7A46"
                    ],
                    borderWidth: [1, 1, 1, 1, 1]
                }]
            };

            var chart1 = new Chart(ctx1, {
                type: "pie",
                data: data1,
                options: options
            });
        }
         
        function makeChart2()
        {
            var ctx2 = $("#pie-chartcanvas-2");
            var mydata = [];
            mydata.push($('#ON_TRIAL').html());
            mydata.push($('#ON_TRIAL_DM').html());
            mydata.push($('#SEND_TO_EM').html());
            mydata.push($('#SEND_TO_ADM').html()); 
            mydata.push($('#CLOSED').html());
            mydata.push($('#REJECTED').html());

            //pie chart data
            var data2 = {
                labels: ["এক্সিকিউটিভ ম্যাজিস্ট্রেট আদালতে বিচারাধীন", "অতিরিক্ত জেলা ম্যাজিস্ট্রেট আদালতে বিচারাধীন", "গ্রহণের জন্য অপেক্ষমান (ইএম)",
                    "গ্রহণের জন্য অপেক্ষমান (এ ডি এম)",
                    "নিষ্পত্তিকৃত মামলা",
                ],
                datasets: [{
                    label: "TeamB Score",
                    data: mydata,
                    backgroundColor: [
                        "#FAEBD7",
                        "#DCDCDC",
                        "#E9967A",
                        "#F5DEB3",
                        "#9ACD32"
                    ],
                    borderColor: [
                        "#E9DAC6",
                        "#CBCBCB",
                        "#D88569",
                        "#E4CDA2",
                        "#89BC21"
                    ],
                    borderWidth: [1, 1, 1, 1, 1]
                }]
            };

            //options
            var options = {
                responsive: true,
                title: {
                    display: true,
                    position: "top",
                    text: "Pie Chart",
                    fontSize: 16,
                    fontColor: "#111"
                },
                legend: {
                    display: true,
                    position: "bottom",
                    labels: {
                        fontColor: "#333",
                        fontSize: 16
                    }
                }
            };

            //create Chart class object
           

            //create Chart class object
            var chart2 = new Chart(ctx2, {
                type: "pie",
                data: data2,
                options: options
            });
        }
        // Case Status Statistics 
        function case_status_statistic() {
            // console.log('submitted!');
            // Variable
            let division = {{ user_division() }};
            let district = {{ user_district() }};
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            // console.log(division);

            // Loader
            $('.report-case-status').addClass('spinner');

            // AJAX Request
            $.ajax({
                url: "{{ route('dashboard.case-status-report') }}",
                type: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $('#ON_TRIAL').html(response.data['ON_TRIAL']);
                        $('#ON_TRIAL_DM').html(response.data['ON_TRIAL_DM']);
                        $('#SEND_TO_EM').html(response.data['SEND_TO_EM']);
                        $('#SEND_TO_ADM').html(response.data['SEND_TO_ADM']);
                        $('#CLOSED').html(response.data['CLOSED']);
                        $('#REJECTED').html(response.data['REJECTED']);

                        $('#caseStatusMsg').text(response.msg).show();
                        // $("#ajaxform")[0].reset();
                        // $('.spinner').hide();
                        $('.report-case-status').removeClass('spinner');
                        makeChart2();
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }


        // JQuery
        jQuery(document).ready(function() {
            // Load Function
            crpc_statistic();
            case_status_statistic();
            /*case_statistics_area();
            case_pie_chart();*/


            // Upazila Dropdown
            jQuery('select[name="district"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#upazila_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                /*if(dataID)
                {*/
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                        dataID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="upazila"]').html(
                            '<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="upazila"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="upazila"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
                //}

                // Load Court
                var courtID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                jQuery("#court_id").after('<div class="loadersmall"></div>');
                // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
                // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
                // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
                // jQuery('.loadersmall').remove();
                // if(courtID)
                // {
                jQuery.ajax({
                    url: '{{ url('/') }}/court/dropdownlist/getdependentcourt/' + courtID,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        jQuery('select[name="court"]').html('<div class="loadersmall"></div>');
                        //console.log(data);
                        // jQuery('#mouja_id').removeAttr('disabled');
                        // jQuery('#mouja_id option').remove();

                        jQuery('select[name="court"]').html(
                            '<option value="">-- নির্বাচন করুন --</option>');
                        jQuery.each(data, function(key, value) {
                            jQuery('select[name="court"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                        jQuery('.loadersmall').remove();
                        // $('select[name="mouja"] .overlay').remove();
                        // $("#loading").hide();
                    }
                });
                //}
                /*else
                 {
                    $('select[name="upazila"]').empty();
                    $('select[name="court"]').empty();
                }*/
            });

        });

        // common datepicker
        // var mydata = [];
        //             $('.crpcMsg').each(function() {
        //                 //alert($(this).val());
        //                 mydata.push($(this).val());
        //             });

        //             $('#graphData').val(mydata);
    </script>


    <script>
        $(function() {

            //get the pie chart canvas
            
        });
    </script>
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/widgets.js') }}"></script>
    <script>
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>
@endsection
