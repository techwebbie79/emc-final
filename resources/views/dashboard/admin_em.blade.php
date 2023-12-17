@extends('layouts.landing')
@yield('style')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

@section('content')
@include('dashboard.inc.icon_card')
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
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center p-50">

                            <div class="card card-custom">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="card-label font-weight-bolder text-dark h3"> ফৌজদারি কার্যবিধি ১৮৯৮ এর ধারা ভিত্তিক মামলার পরিসংখ্যান লিখাটা হবে</h3>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="font-weight-boldest text-center h5 text-success" id="crpcMsg"></p> 
                                    <div class="chart-container">
                                        <div class="pie-chart-container">
                                            <canvas id="pie-chartcanvas-1"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
{{-- @dd($crpcdata);  --}}



        


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script type="text/javascript">
  

    makeChart1();
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
       var crpc_100={{ $crpcdata[0]['y'] }};
       var crpc_107={{ $crpcdata[1]['y'] }};
       var crpc_108={{ $crpcdata[2]['y'] }};
       var crpc_109={{ $crpcdata[3]['y'] }};
       var crpc_110={{ $crpcdata[4]['y'] }};
       var crpc_144={{ $crpcdata[5]['y'] }};
       var crpc_145={{ $crpcdata[6]['y'] }};
        mydata.push(crpc_100);
        mydata.push(crpc_107);
        mydata.push(crpc_108);
        mydata.push(crpc_109);
        mydata.push(crpc_110);
        mydata.push(crpc_144);
        mydata.push(crpc_145);

        var ctx1 = $("#pie-chartcanvas-1");
       

        //pie chart data
        //alert(mydata);

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


@endsection