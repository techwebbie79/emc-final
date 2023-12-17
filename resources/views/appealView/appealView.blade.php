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
                        {{-- @if ($appeal->appeal_status == 'SEND_TO_EM' || $appeal->appeal_status == 'SEND_TO_ADM')
                            <a href="{{ route('appeal.edit', encrypt($appeal->id)) }}" class="btn btn-primary btn-link font-weight-bolder">
                                <i class="la la-edit"></i>সংশোধন 
                            </a>
                        @endif --}}
                        {{-- <a href="{{ route('appeal.new.view.citizen.pdf.create',['appeal_id'=>encrypt($appeal_id)]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a> --}}

                        <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
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
            <div class="row" id="element-to-print">

                <div class="col-md-12 py-5">
                    <table class="table table-striped border">
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
                                    <th scope="row" width="200">পিতা/স্বামীর নাম</th>
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
                                <th scope="row" width="200">পিতা/স্বামীর নাম</th>
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
                                <th scope="row" width="200">পিতা/স্বামীর নাম</th>
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
                    @if (!empty($lawerCitizen))
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="4">আইনজীবীর বিবরণ</th>
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
                                    <td>{{ en2bn('1') }}.</td>
                                    <td>{{ $lawerCitizen->citizen_name ?? '-' }}</td>
                                    <td>{{ $lawerCitizen->father ?? '-' }}</td>
                                    <td>{{ $lawerCitizen->present_address ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>
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

                @if ($guarantorCitizen)
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

                                    <td>{{ $guarantorCitizen->citizen_name ?? '-' }}</td>
                                    <td>{{ $guarantorCitizen->father ?? '-' }}</td>
                                    <td>{{ $guarantorCitizen->present_address ?? '-' }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
            <br>
            <table class="table table-striped border">
                <thead>
                    <th class="h3" scope="col" colspan="2">সংযুক্তি</th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @forelse ($attachmentList as $key => $row)
                                <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn bg-success-o-75"
                                                type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                        </div>
                                        {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                        <input readonly type="text" class="form-control"
                                            value="{{ $row->file_category ?? '' }}" />
                                        <div class="input-group-append">
                                            <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank"
                                                class="btn btn-sm btn-success font-size-h5 float-left">
                                                <i class="fa fas fa-file-pdf"></i>
                                                <b>দেখুন</b>
                                                {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                            </a>
                                            {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                        </div>
                                        <!-- <div class="input-group-append">
                                              <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }} )" class="btn btn-danger">
                                                  <i class="fas fa-trash-alt"></i>
                                                  <b>মুছুন</b>
                                              </a>
                                          </div> -->
                                    </div>
                                </div>
                            @empty
                                <div class="pt-5">
                                    <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে পাওয়া যায়নি
                                    </p>
                                </div>
                            @endforelse
                        </td>
                    </tr>
                </tbody>
            </table>



        </div>
        <!--end::Card-->
    @endsection

    @section('scripts')
        {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
            integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function generatePDF() {
                var element = document.getElementById('element-to-print');
                var opt = {
                    margin: 1,
                    filename: 'myfile.pdf',
                    pagebreak: {
                        avoid: ['tr', 'td']
                    },
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save();
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
