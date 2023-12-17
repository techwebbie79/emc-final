@php
$user = Auth::user();
$roleID = Auth::user()->role_id;
@endphp

@extends('layouts.landing')

@section('content')
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 6px 5px;
            word-break: normal;
        }

        .tg .tg-nluh {
            background-color: #dae8fc;
            border-color: #cbcefb;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-19u4 {
            background-color: #ecf4ff;
            border-color: #cbcefb;
            font-weight: bold;
            text-align: right;
            vertical-align: top
        }
    </style>

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('create_log_pdf',['id'=>$apepal_id]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="row text-center">
                <div class="col-md-6">


                    <h5><span class="font-weight-bolder">মামলা নং: </span>{{ en2bn($info->case_no) }}</h5>
                    <h5><span class="font-weight-bolder">আদালতের নাম: </span> {{ $info->court_name }}</h5>
                    <h5><span class="font-weight-bolder">জেলা: </span> {{ $info->district_name_bn }}</h5>


                </div>
                <div class="col-md-6">
                    <h5><span class="font-weight-bolder">উপজেলা: </span> {{ $info->upazila_name_bn }}</h5>
                    <h5><span class="font-weight-bolder">বিভাগ: </span> {{ $info->division_name_bn }}</h5>

                    <h5><span class="font-weight-bolder">মামলার ফলাফল: </span>
                        @php
                            
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
                        @endphp



                    </h5>
                </div>
            </div>

            <div class="row" id="element-to-print">
                <div class="col-md-12">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">বাদীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($applicantCitizen as $badi)
                                <tr>
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $badi->citizen_name ?? '-' }}</td>
                                    <td>{{ $badi->father ?? '-' }}</td>
                                    <td>{{ $badi->present_address ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach
                        </tbody>
                    </table>

                    <br>
                    @if (!empty($victimCitizen))
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">ভিক্টিমের বিবরণ</th>
                            </thead>
                            <thead>
                                <tr>
                                    <th scope="row" width="10">ক্রম</th>
                                    <th scope="row" width="200">নাম</th>
                                    <th scope="row">পিতা/স্বামীর নাম</th>
                                    <th scope="row">ঠিকানা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $k = 1; @endphp
                                @foreach ($victimCitizen as $victim)
                                    <tr>
                                        <td>{{ en2bn($k) }}.</td>
                                        <td>{{ $victim->citizen_name ?? '-' }}</td>
                                        <td>{{ $victim->father ?? '-' }}</td>
                                        <td>{{ $victim->present_address ?? '-' }}</td>
                                    </tr>
                                    @php $k++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <br>
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">বিবাদীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($defaulterCitizen as $bibadi)
                                <tr>
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $bibadi->citizen_name ?? '-' }}</td>
                                    <td>{{ $bibadi->father ?? '-' }}</td>
                                    <td>{{ $bibadi->present_address ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach

                        </tbody>
                    </table>
                    <br>
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="4">সাক্ষীর বিবরণ</th>
                        </thead>
                        <thead>
                            <tr>
                                <th scope="row" width="10">ক্রম</th>
                                <th scope="row" width="200">নাম</th>
                                <th scope="row">পিতা/স্বামীর নাম</th>
                                <th scope="row">ঠিকানা</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $k = 1; @endphp
                            @foreach ($witnessCitizen as $witness)
                                <tr>
                                    <td>{{ en2bn($k) }}.</td>
                                    <td>{{ $witness->citizen_name ?? '-' }}</td>
                                    <td>{{ $witness->father ?? '-' }}</td>
                                    <td>{{ $witness->present_address ?? '-' }}</td>
                                </tr>
                                @php $k++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <br>

                </div>
                <div class="col-md-12">
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">ঘটনার তারিখ সময় ও স্থান </th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>বিগত ইং {{ en2bn($appeal->case_date) }} তারিখ মোতাবেক বাংলা
                                    {{ BnSal($appeal->case_date, 'Asia/Dhaka', 'j F Y') }} সময়:
                                    @if (date('a', strtotime($appeal->created_at)) == 'pm')
                                        বিকাল
                                    @else
                                        সকাল
                                    @endif

                                    {{ en2bn(date('h:i:s', strtotime($appeal->created_at))) }}
                                    । {{ $appeal->division->division_name_bn ?? '-' }} বিভাগের
                                    {{ $appeal->district->district_name_bn ?? '-' }} জেলার
                                    {{ $appeal->upazila->upazila_name_bn ?? '-' }} উপজেলায়।
                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <table class="table table-striped border">
                        <thead>
                            <th class="h3" scope="col" colspan="2">ঘটনার বিবরণ</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>

                                    {{ str_replace('&nbsp;', '', strip_tags($appeal->case_details)) }}
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- <div class="col-md-12">
                                         <table class="table table-striped border">
                                             <thead>
                                                 <th class="h3 text-center" scope="col">রিকুইজিশন নোট </th>
                                             </thead>
                                             <tbody>
                                                   @foreach ($appeal->appealnotes as $notes)
    <tr>
                                                          <td>{{ $notes->order_text }}</td>
                                                       </tr>
    @endforeach

                                            </tbody>
                                         </table>
                                      </div> -->

                
                @if ($lawerCitizen)
                    <div class="col-md-12">

                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="3">আইনজীবীর বিবরণ</th>
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

                                    <td>{{ $lawerCitizen->citizen_name ?? '-' }}</td>
                                    <td>{{ $lawerCitizen->father ?? '-' }}</td>
                                    <td>{{ $lawerCitizen->present_address ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                @endif
                <br>
                @if(!empty($defaulerWithnessCitizen))
                <table class="table table-striped border">
                    <thead>
                        <th class="h3" scope="col" colspan="4">বিবাদীর পক্ষের সাক্ষীর বিবরণ</th>
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
                        @php $k = 1; @endphp
                        @foreach ($defaulerWithnessCitizen as $witness)
                            <tr>
                                <td>{{ en2bn($k) }}.</td>
                                <td>{{ $witness->citizen_name ?? '-' }}</td>
                                <td>{{ $witness->father ?? '-' }}</td>
                                <td>{{ $witness->present_address ?? '-' }}</td>
                            </tr>
                            @php $k++; @endphp
                        @endforeach
                    </tbody>
                </table>
                @endif
                @if(!empty($defaulerLawyerCitizen))
                <table class="table table-striped border">
                    <thead>
                        <th class="h3" scope="col" colspan="4">বিবাদীর পক্ষের আইনজীবীর বিবরণ</th>
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
                        @php $k = 1; @endphp
                        @foreach ($defaulerLawyerCitizen as $witness)
                            <tr>
                                <td>{{ en2bn($k) }}.</td>
                                <td>{{ $witness->citizen_name ?? '-' }}</td>
                                <td>{{ $witness->father ?? '-' }}</td>
                                <td>{{ $witness->present_address ?? '-' }}</td>
                            </tr>
                            @php $k++; @endphp
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            <br>

            <div class="col-md-12 ">
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
                        {{-- @php 
                          dd($case_details);
                        @endphp --}}
                        @foreach ($case_details as $case_details_single)
                            @php
                                if ($case_details_single->user_id != 0) {
                                    $user_name = DB::table('users')
                                        ->select('name')
                                        ->where('id', '=', $case_details_single->user_id)
                                        ->first();
                                    $name = $user_name->name;
                                    $designation = $case_details_single->designation;

                                
                                    // if (isset($case_details_single->investigation_report)) {
                                    //     $investigation_report = json_decode($case_details_single->investigation_report);
                                    //     //dd($investigation_report);
                                    //     $investigator_details = json_decode($case_details_single->investigator_details);
                                    //     $to_be_print = x($investigation_report, $investigator_details);
                                    //     $name = $investigation_report->investigator_name;
                                    //     $designation = $to_be_print['designation'];
                                    //     $show = $to_be_print['show'];
                                    // }
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
                                
                            @endphp
                            <tr>

                                <td>{{ en2bn($case_details_single->created_at) }}</td>
                                <td>{{ $name }}</td>
                                <td>{{ $designation }}</td>
                                <td>@php
                                    echo $case_details_single->activity;
                                    echo '<br>';
                                    if (!empty($case_details_single->files)) {
                                        $files = json_decode($case_details_single->files);
                                    
                                        if (!empty($files->file_path)) {
                                            echo '<a href="'. url('/').'/'.$files->file_path .'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3">
                                                              <i class="fa fas fa-file-pdf"></i>
                                                              <b>জারিকারের রিপোর্ট ফাইল</b></a>';
                                        } else {
                                            foreach ($files as $file) {
                                                echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3">
                                                                  <i class="fa fas fa-file-pdf"></i>
                                                                  <b>' .
                                                    $file->file_category .
                                                    '</b></a>';
                                            }
                                        }
                                    
                                    }
                                    if (!empty($case_details_single->details_url)) {
                                        $details_url = url('/') . $case_details_single->details_url . '/' . $case_details_single->id;
                                        echo '<a href="'.$details_url.'"  class="btn btn-sm btn-success font-size-h5 float-left">
                                                                          
                                                                          <b>বিস্তারিত দেখুন</b>
                                                                          
                                                                        </a>';
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
                                                    echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3  my-2">
                                          <i class="fa fas fa-file-pdf "></i>
                                          <b>' .
                                                        $file->file_category .
                                                        '</b></a>';
                                                        
                                                }
                                            } else {
                                                $files = json_decode($investigation_report->investigation_attachment_main);
                                                foreach ($files as $file) {
                                                    echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3  my-2">
                                          <i class="fa fas fa-file-pdf "></i>
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
                                                echo 'মুছে ফেলা প্রধান ফাইল নাম';
                                                                    
                                            echo '<br>';
                                            
                                            echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3  my-2">
                                          <i class="fa fas fa-file-pdf"></i>
                                          <b>' .
                                                        $file->file_category .
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
                                                    echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3  my-2">
                                          <i class="fa fas fa-file-pdf"></i>
                                          <b>' .
                                                        $file->file_category .
                                                        '</b></a>';
                                                        echo '<br>';   
                                                }
                                            } else {
                                                $files = json_decode($investigation_report->investigation_attachment);
                                                foreach ($files as $file) {
                                                    echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3  my-2">
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
                                            echo '</br>';
                                            foreach ($files as $file) {
                                                echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3  my-2">
                                          <i class="fa fas fa-file-pdf"></i>
                                          <b>' .
                                                        $file->file_category .
                                                        '</b></a>';
                                            }
                                        }
                                    }
                                    
                                @endphp</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>


        </div>
        <!--end::Card-->
    @endsection
    @php
        
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
    @endphp
    @section('scripts')
        {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function generatePDF() {
                var element = document.getElementById('element-to-print');
                html2pdf(element);
            }
        </script>
    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}
    @section('scripts')
        <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
        <!--end::Page Scripts-->
    @endsection
