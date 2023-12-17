@extends('layouts.landing')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
    {{-- @include('dashboard.inc.icon_card') --}}

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

    <form action="javascript:void(0)" class="form" method="POST">
        @csrf
        <!-- <div class="card-body"> -->
        <fieldset class="mb-6">
            <legend>ফিল্টারিং ফিল্ড সমূহ</legend>

            <div class="row">
                <div class="col-lg-2 mb-5">
                    <select name="division" id="division_id" class="form-control form-control-sm">
                        <option value="">-বিভাগ নির্বাচন করুন-</option>
                        @foreach ($divisions as $value)
                            <option value="{{ $value->id }}"> {{ $value->division_name_bn }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <!-- <label>জেলা <span class="text-danger">*</span></label> -->
                    <select name="district" id="district_id" class="form-control form-control-sm">
                        <option value="">-জেলা নির্বাচন করুন-</option>
                    </select>
                </div>
                <div class="col-lg-2 mb-5">
                    <!-- <label>উপজেলা </label> -->
                    <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                        <option value="">-উপজেলা নির্বাচন করুন-</option>
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

        <div class="row">
            <div class="col-lg-6">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title ">
                            <h3 class="card-label font-weight-bolder text-dark h3">অভিযোগের ধরণভিত্তিক মামলার পরিসংখ্যান
                            </h3>
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
                            <li class="list-group-item font-weight-bolder h6"> <i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> বেআইনীভাবে আটক
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="crpc100">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> শান্তি ভঙ্গ
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="crpc107">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> রাষ্ট্রদ্রোহিতামূলক বিষয় প্রচার
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="crpc108">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> ভবঘুরে ও সন্দেহভাজন ব্যক্তি
                                কর্তৃক উপস্থিতি গোপন ও অপরাধ
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="crpc109">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> অভ্যাসগত অপরাধী কর্তৃক অপরাধ
                                সংঘটন
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="crpc110">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> মানুষের জীবন ,স্বাস্থ্য বা
                                নিরাপত্তার প্রতি বিপদ বা দাঙ্গা-হাঙ্গামার সম্ভাবনা সৃষ্টিকারী অপরাধ সংঘটন
                                <span class="label label-inline label-danger font-weight-bold float-right h5"
                                    id="crpc144">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-folder-open icon-lg text-danger mr-2"></i> স্থাবর সম্পত্তি বিষয়ক বিরোধের
                                ফলে শান্তি ভঙ্গ
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="crpc145">0</span>
                            </li>
                        </ul>
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
                            <li class="list-group-item font-weight-bolder h6"> <i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i> এক্সিকিউটিভ ম্যাজিস্ট্রেটের আদালতে
                                বিচারাধীন
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="ON_TRIAL">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>অতিরিক্ত জেলা ম্যাজিস্ট্রেটের আদালতে
                                বিচারাধীন
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="ON_TRIAL_DM">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i> গ্রহণের জন্য অপেক্ষমান (ইএম)
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_EM">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i> গ্রহণের জন্য অপেক্ষমান (এ ডি এম)
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="SEND_TO_ADM">0</span>
                            </li>
                            <li class="list-group-item font-weight-bolder h6"><i
                                    class="fas fa-gavel icon-lg text-danger mr-3"></i>নিষ্পত্তিকৃত মামলা
                                <span class="label label-inline label-danger font-weight-bold float-right h6"
                                    id="CLOSED">0</span>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div> <!-- /row -->

        <br><br>

        <div class="row">

            <div class="col-lg-6 mb-12">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title ">
                            <h3 class="card-label font-weight-bolder text-dark h3">সিআরপিসি পাই চার্ট</h3>
                        </div>
                        <div class="card-toolbar">
                            <button class="case-piechart btn btn-success spinner spinner-darker-white spinner-left"
                                onclick="case_pie_chart()">অনুসন্ধান করুন</button>
                        </div>
                    </div>
                    <div class="card-body" style="margin-top: 245px;">
                        <div id="piechart_3d" style="width: 400px; height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <figure class="highcharts-figure">
                            <div id="containerDrilldown"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <br><br>

        <div class="row" style="display: none;">
            <div class="col-lg-6">
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title ">
                            <h3 class="card-label font-weight-bolder text-dark h3">আদালত ভিত্তিক মামলার পরিসংখ্যান</h3>
                        </div>
                        <div class="card-toolbar">
                            <button class="case-statistics-area btn btn-success spinner spinner-darker-white spinner-left"
                                onclick="case_statistics_area()">অনুসন্ধান করুন</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="case_type_div"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card card-custom">
                    <div class="card-body">
                        <figure class="highcharts-figure" style="width: 100%">
                            <div id="containerSectionStatistics"></div>
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <!-- <button class="btn btn-success save-data">Test Ajax</button> -->
    </form>


    <style type="text/css">
        /*highchart css*/

        .highcharts-figure,
        .highcharts-data-table table {
            /*min-width: 310px; */
            /*max-width: 1000px;*/
            /*margin: 1em auto;*/
        }

        #container {
            /*height: 400px;*/
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            /*max-width: 500px;*/
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


        /*Pie chart*/
        .highcharts-figure,
        .highcharts-data-table table {
            min-width: 320px;
            max-width: 1030px;
            margin: 1em auto;
        }

        .highcharts-data-table table {
            font-family: Verdana, sans-serif;
            border-collapse: collapse;
            border: 1px solid #EBEBEB;
            margin: 10px auto;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .highcharts-data-table caption {
            padding: 1em 0;
            font-size: 1.2em;
            color: #555;
        }

        .highcharts-data-table th {
            font-weight: 600;
            padding: 0.5em;
        }

        .highcharts-data-table td,
        .highcharts-data-table th,
        .highcharts-data-table caption {
            padding: 0.5em;
        }

        .highcharts-data-table thead tr,
        .highcharts-data-table tr:nth-child(even) {
            background: #f8f8f8;
        }

        .highcharts-data-table tr:hover {
            background: #f1f7ff;
        }


        input[type="number"] {
            min-width: 50px;
        }
    </style>

    <?php
    // $divisiondata=array();
    // $districtdata=array();
    
    // $result = array_merge($districtdata, $upazilatdata);
    ?>

    <!--end::Subheader-->

    {{-- -------------calendar start---------- --}}
    {{-- @if (Auth::user()->role_id == 2)
    @include('dashboard.calendar.calender_need')
    @endif --}}
    {{-- -------------calendar end---------- --}}

    <div class="row" style="display: none;">
        <div class="col-xl-6">
            <div class="card card-custom card-stretch gutter-b">
                {{-- <figure class="highcharts-figure" style="width: 100%">
                    <div id="containerDrilldown"></div>
                </figure> --}}
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card card-custom card-stretch gutter-b">
                {{-- <figure class="highcharts-figure" style="width: 100%">
                    <div id="containerSectionStatistics"></div>
                </figure> --}}
            </div>
        </div>
    </div>
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/widgets.js') }}"></script>
    <script>
        $('.Count').each(function() {
            var en2bnnumbers = {
                0: '০',
                1: '১',
                2: '২',
                3: '৩',
                4: '৪',
                5: '৫',
                6: '৬',
                7: '৭',
                8: '৮',
                9: '৯'
            };
            var bn2ennumbers = {
                '০': 0,
                '১': 1,
                '২': 2,
                '৩': 3,
                '৪': 4,
                '৫': 5,
                '৬': 6,
                '৭': 7,
                '৮': 8,
                '৯': 9
            };

            function replaceEn2BnNumbers(input) {
                var output = [];
                for (var i = 0; i < input.length; ++i) {
                    if (en2bnnumbers.hasOwnProperty(input[i])) {
                        output.push(en2bnnumbers[input[i]]);
                    } else {
                        output.push(input[i]);
                    }
                }
                return output.join('');
            }

            function replaceBn2EnNumbers(input) {
                var output = [];
                for (var i = 0; i < input.length; ++i) {
                    if (bn2ennumbers.hasOwnProperty(input[i])) {
                        output.push(bn2ennumbers[input[i]]);
                    } else {
                        output.push(input[i]);
                    }
                }
                return output.join('');
            }
            var $this = $(this);
            var nubmer = replaceBn2EnNumbers($this.text());
            jQuery({
                Counter: 0
            }).animate({
                Counter: nubmer
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    var nn = Math.ceil(this.Counter).toString();
                    // console.log(replaceEn2BnNumbers(nn));
                    $this.text(replaceEn2BnNumbers(nn));
                }
            });
        });
    </script>
    {{-- @if (Auth::user()->role_id == 2)
        @include('dashboard.calendar.calender_need_js')
    @endif --}}

    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('containerDrilldown', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'বিভাগ ও জেলা ভিত্তিক মামলা'
            },
            subtitle: {
                text: 'মামলা'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Number of Case'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:red">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: "Division",
                colorByPoint: true,
                data: <?= json_encode($divisiondata) ?>
            }],

            drilldown: {
                series: <?= json_encode($dis_upa_data) ?>
            }
        });
    </script>

    <script type="text/javascript">
        // Create the chart
        Highcharts.chart('containerSectionStatistics', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'ধারা ভিত্তিক মামলা'
            },
            subtitle: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'মামলার সংখ্যা'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:red">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },

            series: [{
                name: "Case",
                colorByPoint: true,
                data: <?= json_encode($crpcdata) ?>
            }]
        });
    </script>


    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <script>
        // common datepicker
        $('.common_datepicker').datepicker({
            format: "dd/mm/yyyy",
            todayHighlight: true,
            orientation: "bottom left"
        });
    </script>

    <script type="text/javascript">
        // CRPC Statistics 
        function crpc_statistic() {
            // console.log('submitted!');
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
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

                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }


        // Case Status Statistics 
        function case_status_statistic() {
            // console.log('submitted!');
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
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

                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        }

        // Test AJAX Code
        $(".save-data").click(function(event) {
            event.preventDefault();
            console.log('submitted!');

            let division = $("input[name=division]").val();
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('dashboard.test-report') }}",
                type: "POST",
                data: {
                    division: division,
                    _token: _token
                },
                success: function(response) {
                    console.log(response);
                    if (response) {
                        $('.success').text(response.success);
                        // $("#ajaxform")[0].reset();
                    }
                },
                error: function(error) {
                    console.log(error);
                    $('#nameError').text(response.responseJSON.errors.division);
                }
            });
        });


        // Google Chart
        google.charts.load('current', {
            'packages': ['bar', 'corechart']
        });
        google.charts.setOnLoadCallback();

        // Case Pie Chart
        function case_pie_chart() {
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            
            
            
            // if (division == null || division === undefined) {
            //     division = null;
            // } 

            // if (district == null || district === undefined) {
            //     district = null;
            // } 
            // if (upazila == null || upazila === undefined) {
            //     upazila = null;
            // } 

            // if (dateFrom == null || dateFrom === undefined) {
            //     dateFrom = null;
            // } 
            // if (dateTo == null || dateTo === undefined) {
            //     dateTo = null;
            // } 


            var title = "hello";
            var year = "2022";
            var temp_title = title + ' ' + year + '';

            // Loader
            $('.case-piechart').addClass('spinner');

            // Reqpuest
            $.ajax({
                url: "{{ route('dashboard.crpc-pie-chart') }}",
                method: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                dataType: "JSON",
                success: function(response) {
                    if (!response.data) {
                        document.getElementById('piechart_3d').innerHTML =
                            '<p style="margin-left: 178px;margin-top: 134px;font-size: 30px;"> কোন অভিযোগের তথ্য পাওয়া যায় নাই</p>';
                    } else {
                        var data = google.visualization.arrayToDataTable([
                            ['CRPC', 'Case Count'],
                            ['CRPC 100', response.data[100]],
                            ['CRPC 107', response.data[107]],
                            ['CRPC 108', response.data[108]],
                            ['CRPC 109', response.data[109]],
                            ['CRPC 110', response.data[110]],
                            ['CRPC 144', response.data[144]],
                            ['CRPC 145', response.data[145]]
                        ]);

                        var options = {
                            // title: 'My Daily Activities',
                            is3D: true,
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                        chart.draw(data, options);
                    }


                    $('.case-piechart').removeClass('spinner');
                }
            });
        }

        /*function drawStuff() {

            // Variable
            let division = $("#division_id").val();        
            let district = $("#district_id").val();        
            let upazila  = $("#upazila_id").val();        
            let dateFrom = $("#date_from").val();        
            let dateTo   = $("#date_to").val();        
            let _token   = $('meta[name="csrf-token"]').attr('content');

            var chartData = $.ajax({
                url: "{{ route('dashboard.crpc-report') }}",
                type:"POST",
                data:{
                    division:division,
                    district:district,
                    upazila:upazila,
                    dateFrom:dateFrom,
                    dateTo:dateTo,
                    _token: _token
                },
                dataType:"JSON",
                success:function(data)
                {
                    drawMonthwiseChart(data, temp_title);
                }
            }).responseText;

            var data = new google.visualization.arrayToDataTable(chartData);

            var options = {
                title: 'মামলার ধরন',
                // width: 900,
                height: 300,
                legend: { position: 'none' },
                bars: 'veriticle', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: { side: 'bottom', label: 'মামলার ধরন'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('case_type_div'));
            chart.draw(data, options);
        };*/


        // Statistics 3
        function case_statistics_area() {
            // Variable
            let division = $("#division_id").val();
            let district = $("#district_id").val();
            let upazila = $("#upazila_id").val();
            let dateFrom = $("#date_from").val();
            let dateTo = $("#date_to").val();
            let _token = $('meta[name="csrf-token"]').attr('content');

            var title = "hello";
            var year = "2022";
            var temp_title = title + ' ' + year + '';

            // Loader
            $('.case-statistics-area').addClass('spinner');

            // Reqpuest
            $.ajax({
                url: "{{ route('dashboard.ajax-case-statistics') }}",
                method: "POST",
                data: {
                    division: division,
                    district: district,
                    upazila: upazila,
                    dateFrom: dateFrom,
                    dateTo: dateTo,
                    _token: _token
                },
                success: function(res) {
                    // console.log(data);
                    var data = [
                        ['Opening Move', 'মামলা'],
                        ["বরিশাল", res.data['বরিশাল']],
                        ["চট্টগ্রাম", res.data['চট্টগ্রাম']],
                        ["ঢাকা", res.data['ঢাকা']],
                        ["খুলনা", res.data['খুলনা']],
                        ["রাজশাহী", res.data['রাজশাহী']],
                        ['রংপুর', res.data['রংপুর']],
                        ["সিলেট", res.data['সিলেট']],
                        ["ময়মনসিংহ", res.data['ময়মনসিংহ']],
                    ];

                    drawMonthwiseChart(data, temp_title);
                    $('.case-statistics-area').removeClass('spinner');
                }
            });
        }


        function drawMonthwiseChart(chart_data, chart_main_title) {
            var data = new google.visualization.arrayToDataTable(chart_data);

            var options = {
                title: 'মামলার ধরন',
                // width: 900,
                height: 300,
                legend: {
                    position: 'none'
                },
                bars: 'veriticle', // Required for Material Bar Charts.
                axes: {
                    x: {
                        0: {
                            side: 'bottom',
                            label: 'মামলার ধরন'
                        } // Top x-axis.
                    }
                },
                bar: {
                    groupWidth: "90%"
                }
            };

            var chart = new google.charts.Bar(document.getElementById('case_type_div'));
            chart.draw(data, options);


            /*var jsonData = chart_data;
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Month');
            data.addColumn('number', 'Profit');
            $.each(jsonData, function(i, jsonData){
                var month = jsonData.month;
                var profit = parseFloat($.trim(jsonData.profit));
                data.addRows([[month, profit]]);
            });
            var options = {
                title:chart_main_title,
                hAxis: {
                    title: "Months"
                },
                vAxis: {
                    title: 'Profit'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_area'));
            chart.draw(data, options);*/
        }






        jQuery(document).ready(function() {
            // Load Function
            crpc_statistic();
            case_status_statistic();
            case_statistics_area();
            case_pie_chart();
            

            // District Dropdown
            jQuery('select[name="division"]').on('change', function() {
                var dataID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                if (dataID) {

                    jQuery("#district_id").after('<div class="loadersmall"></div>');
                }
                
                if (dataID) {
                    jQuery.ajax({
                        url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentdistrict/' +
                            dataID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');
                            //console.log(data);
                            // jQuery('#mouja_id').removeAttr('disabled');
                            // jQuery('#mouja_id option').remove();

                            jQuery('select[name="district"]').html(
                                '<option value="">-- নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                            jQuery('.loadersmall').remove();
                            // $('select[name="mouja"] .overlay').remove();
                            // $("#loading").hide();
                        }
                    });
                } else {
                    
                    jQuery('select[name="district"]').html(
                                '<option value="">-- জেলা নির্বাচন করুন --</option>');
                }
            });

            // Upazila Dropdown
            jQuery('select[name="district"]').on('change', function() {
                var dataUpzillaID = jQuery(this).val();
                // var category_id = jQuery('#category_id option:selected').val();
                
                if (dataUpzillaID) {
                    
                    jQuery("#upazila_id").after('<div class="loadersmall"></div>');                    
                }

                if(dataUpzillaID)
                {
                jQuery.ajax({
                    url: '{{ url('/') }}/generalCertificate/case/dropdownlist/getdependentupazila/' +
                    dataUpzillaID,
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
                    }
                });
                }
                else
                {
                    jQuery('select[name="upazila"]').html(
                                '<option value="">-- উপজেলা নির্বাচন করুন --</option>');
                }

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
    </script>
@endsection
