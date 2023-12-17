@extends('layouts.landing')

@section('content')
    <style type="text/css">
        .invertigation_report {
            background-color: #3699ff;
            color: #ffff;
            border-radius: 10px;
            margin-top: 10px;
        }

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
    </style>
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="mx-auto py-5">
            <h3 class="mt-3"><span class="p-3 invertigation_report">তদন্ত প্রতিবেদন বিস্তারিত</span></h3>
        </div>

        <div class="p-5 mx-auto">


            <table class="table table-striped">
                <tr>
                    <td>নাম</td>
                    <td>{{ $investigation_single_report->investigator_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>অফিসের নাম</td>
                    <td>{{ $investigation_single_report->investigator_organization ?? '-' }}</td>
                </tr>
                <tr>
                    <td>নথি আইডি</td>
                    <td>{{ $investigator_details->nothi_id ?? '-'  }}</td>
                </tr>
                <tr>
                    <td>পদবী</td>
                    <td>{{ $investigator_details->designation ?? '-' }}</td>
                </tr>
                <tr>
                    <td>মোবাইল</td>
                    <td>{{ $investigator_details->mobile ?? '-' }}</td>
                </tr>
                <tr>
                    <td>ইমেইল</td>
                    <td>{{ $investigator_details->email ?? '-' }}</td>
                </tr>
                <tr>
                    <td>বিয়য় </td>
                    <td>{{ $investigation_single_report->investigation_subject ?? '-' }}</td>
                </tr>
                <tr>
                    <td>কেস নং</td>
                    <td>{{ en2bn($investigation_single_report->case_no) }}</td>
                </tr>
                <tr>
                    <td>তারিখ</td>
                    @php
                        $investigation_date = explode('/', $investigation_single_report->investigation_date);
                        $investigation_date_final = $investigation_date[2] . '-' . $investigation_date[0] . '-' . $investigation_date[1];
                    @endphp
                    <td>{{ en2bn($investigation_date_final) }}</td>
                </tr>
                <tr>
                    <td>স্মারক নং</td>
                    <td>{{ en2bn($investigation_single_report->memorial_no) }}</td>
                </tr>
                <tr>
                    <td>মন্তব্য</td>
                    <td>{{ $investigation_single_report->investigation_comments }}</td>
                </tr>
                <tr>
                    <td>সংযুক্তি তদন্ত সংযুক্তি (প্রধান)</td>
                    <td>
                        @php
                            if (!empty($investigation_single_report->investigation_attachment_main)) {
                                $files = json_decode($investigation_single_report->investigation_attachment_main);
                                foreach ($files as $file) {
                                    echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3 btn-block">
                      <i class="fa fas fa-file-pdf"></i>
                      <b>' .
                                        $file->file_category .
                                        '</b></a>';
                                }
                            }
                        @endphp
                    </td>
                </tr>
                <tr>
                    <td>সংযুক্তি তদন্ত</td>
                    <td>

                        @php
                            if (!empty($investigation_single_report->investigation_attachment)) {
                                $files = json_decode($investigation_single_report->investigation_attachment);
                                foreach ($files as $file) {
                                    echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3 btn-block">
                      <i class="fa fas fa-file-pdf"></i>
                      <b>' .
                                        $file->file_category .
                                        '</b></a>';
                                }
                            }
                        @endphp

                    </td>
                </tr>
            </table>

        </div>



    </div>
    <!--end::Card-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}

@section('scripts')
    @include('appealInitiate.appealCreate_Js')
@endsection
