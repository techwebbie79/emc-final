@extends('layouts.landing')



@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection

<!-- begin::Styles the pages -->
@push('head')
    <link href="{{ asset('assets/css/pages/wizard/wizard-1.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/tachyons.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
<!-- end::Styles the pages -->

@section('content')
    <style type="text/css">
        .nav .nav-link .nav-text {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label {
            margin-left: 3rem;
            margin-right: 3rem;
        }

        .wizard.wizard-1 .wizard-nav .wizard-steps .wizard-step .wizard-label .wizard-title {
            color: #7e8299;
            font-size: 1.25rem !important;
            font-weight: 700;
        }

        .ck-file-dialog-button button.ck {
            display: none;
        }
    </style>
    @if (Session::has('Errormassage'))
        <div class="alert alert-danger text-center">
            {{ Session::get('Errormassage') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                    </div>
                </div>

                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('FileError'))
                    <div class="alert alert-danger">
                        {{ Session::get('FileError') }}
                    </div>
                @endif
                <!--begin::Form-->
                <!--begin::Entry-->
                <div class="progress">

                    <div class="progress-bar" id="progressbar_appeal_create" role="progressbar" style="width: 0%"
                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>

                </div>

                <div class="wizard wizard-1" id="appealWizard" data-wizard-state="step-first" data-wizard-clickable="true">
                    <!--begin::Wizard Nav-->
                    <div class="wizard-nav border-bottom">
                        <div class="wizard-steps p-8 p-lg-10">
                            <div class="wizard-step" id="appeal_info_smdn" data-wizard-type="step"
                                data-wizard-state="current">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                        <i class="fas fa-chalkboard-teacher"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">অভিযোগের তথ্য</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14"
                                                rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" id="applicant_info_smdn" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
                                        <i class="fas fa-user"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">১ম পক্ষ</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14"
                                                rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>

                            <div class="wizard-step" data-wizard-type="step" id="victim_wizard" style="display: none">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
                                        {{-- <i class="fas fa-mail-bulk"></i> --}}
                                        <i class="fas fa-users"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">ভিক্টিমের তথ্য</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14"
                                                rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>



                            <div class="wizard-step" id="defaulter_info_smdn" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Globe.svg-->
                                        <i class="fas fa-people-arrows"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">২য় পক্ষ</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14"
                                                rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" id="withness_content_smdn" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Devices/Display1.svg-->
                                        <i class="fas fa-hand-paper"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">সাক্ষীর তথ্য</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14"
                                                rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" id="laywer_content_smdn" data-wizard-type="step">
                                <div class="wizard-label">
                                    <span class="svg-icon svg-icon-4x wizard-icon">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                        <i class="fas fa-file-alt"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <h3 class="wizard-title">আইনজীবীর তথ্য</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow last">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                x="11" y="5" width="2" height="14"
                                                rx="1" />
                                            <path
                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Wizard Nav-->
                    <!--begin::Wizard Body-->
                    <div class="row justify-content-center mt-5 mb-10 px-8 mb-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-12">
                            <!--begin::Form Wizard-->
                            <form id="appealCase" action="{{ route('citizen.appeal.store') }}" class="form"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" id="citizen_appeal_check"
                                    value="{{ route('citizen.appeal.nid.check') }}">

                                <input type="hidden" name="appealId" value="">
                                <input type="hidden" name="appealEntryType" value="create">
                                <input type="hidden" id="new" class="caseEntryType mr-2" value="others"
                                    name="caseEntryType">

                                <!--begin::Step 1-->
                                <fieldset class="pb-5 create_cause" data-wizard-type="step-content"
                                    data-wizard-state="current">
                                    <legend class="font-weight-bold text-dark"><strong
                                            style="font-size: 20px !important">অভিযোগের তথ্য</strong></legend>
                                    <div class="row" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="is_own_case" class="control-label">
                                                </label>
                                                <div class="radio">
                                                    <label class="mr-5">
                                                        <input type="radio" id="oldCaseRadio" class="is_own_case  mr-2"
                                                            value="0" checked name="is_own_case">অন্যের মামলা
                                                    </label>
                                                    <label>
                                                        <input type="radio" id="new" class="is_own_case mr-2"
                                                            value="1" name="is_own_case">নিজের মামলা
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="caseNo" class="control-label">মামলা নম্বর</label>
                                                <div name="caseNo" id="caseNo" class="form-control ">সিস্টেম কর্তৃক
                                                    পূরণীয় </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                                                <input type="text" name="caseDate" id="case_date"
                                                    class="form-control" placeholder="দিন/মাস/তারিখ" autocomplete="off"
                                                    value="{{ en2bn(date('Y-m-d', strtotime(now()))) }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" id="victim">
                                                <label for="lawSection" class="control-label">অভিযোগের ধরণ <span
                                                        class="text-danger">*</span><span id="link"></span></label>
                                                <select class="form-control crpc_select_law_section_adm_em" id="kt"
                                                    name="lawSection" data-placeholder="-- নির্বাচন করুন --">
                                                    <option value=""> -- নির্বাচন করুন --</option>
                                                    @foreach ($data['lawSections'] as $value)
                                                        <option law_section="{{ $value->crpc_id }}"
                                                            value="{{ $value->id }}"
                                                            {{ old('lawSection') == $value->crpc_id ? 'selected' : '' }}>
                                                            {{ $value->crpc_name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label"><span
                                                        class="text-danger">*</span> বিভাগ</label>
                                                <!-- <input name="lawSection" id="lawSection" class="form-control "
                                                                        value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                                <select name="division" id="division_id" class="form-control ">
                                                    <option value=""> -- নির্বাচন করুন --</option>
                                                    @foreach ($data['divisionId'] as $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ old('division') == $value->id ? 'selected' : '' }}>
                                                            {{ $value->division_name_bn }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label"><span
                                                        class="text-danger">*</span> জেলা</label>

                                                <select name="district" id="district_id" class="form-control ">
                                                    <!-- <span id="loading"></span> -->
                                                    <option value="">-- নির্বাচন করুন --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label"><span
                                                        class="text-danger">*</span> উপজেলা /
                                                    থানা</label>
                                                <!-- <input name="lawSection" id="lawSection" class="form-control "
                                                                        value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                                <select name="upazila" id="upazila_id" class="form-control ">
                                                    <!-- <span id="loading"></span> -->
                                                    <option value="">-- নির্বাচন করুন --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-lg-12 mb-5">
                                            <label for="case" class="control-label">
                                                <h4><b> Voice To Text</b></h4>
                                            </label>
                                            @include('appealTrial.inc._voice_to_text')
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12 mb-5">
                                            <label for="case details" class="control-label">
                                                <h4><b><span class="text-danger">*</span> অভিযোগের বিবরণ</b></h4>
                                            </label>
                                            {{-- <textarea name="case_details" id="kt-ckeditor-5"></textarea> --}}

                                            <textarea name="case_details" class="form-control" id="case_details" rows="10" spellcheck="true"></textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <div
                                        class="rounded d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                        <input type="hidden" name="note" id="note" class="form-control "
                                            value="">
                                        <div class="d-flex align-items-center mr-2 py-2">
                                            <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে)</h3>
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::Users-->
                                        <div class="symbol-group symbol-hover py-2">
                                            <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                                data-placement="top" title="" role="button"
                                                data-original-title="Add New File">
                                                <div id="addFileRow">
                                                    <span class="symbol-label font-weight-bold bg-success">
                                                        <i class="text-white fa flaticon2-plus font-size-sm"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Users-->
                                    </div>
                                    <div class="mt-3 px-5">
                                        <table width="100%" class="border-0 px-5" id="fileDiv"
                                            style="border:1px solid #dcd8d8;">
                                            <tr></tr>
                                        </table>
                                        <input type="hidden" id="other_attachment_count" value="1">
                                    </div>
                                    <br>






                                    <!-- Template -->
                                    <div id="template" style="display: none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" data-name="file.type" class="form-control ">
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" data-name="file.name"
                                                                class="custom-file-input">
                                                            <label class="custom-file-label custom-input2"
                                                                for="customFile2">ফাইল নির্বাচন করুন</label>
                                                        </div>
                                                        <button type="button"
                                                            class="fas fa-minus-circle btn btn-sm btn-danger font-weight-bolder removeRow"></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!--end::Step 1-->

                                <!--begin::Step 2-->
                                @include('citizenAppealInitiate.inc._applicant_info')
                                <!--end::Step 2-->

                                <!--begin::Step 3 victim-->
                                @include('citizenAppealInitiate.inc._victim_info')
                                <!--end::Step 3 victim-->

                                <!--begin::Step 4-->
                                @include('citizenAppealInitiate.inc._defaulter_info')
                                <!--end::Step 4-->

                                <!--begin::Step 5-->
                                @include('citizenAppealInitiate.inc._witness_info')
                                <!--end::Step 5-->

                                <!--begin::Step 6-->
                                @include('citizenAppealInitiate.inc._advocate_info')
                                <!--end::Step 6-->

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-between {{-- mt-5 pt-10 --}}">
                                    <div class="mr-2">
                                        <button type="button" style="background-color: #008841"
                                            class="btn btn-primary mt-3 font-weight-bolder text-uppercase px-9 py-4"
                                            id="wizardBack" data-wizard-type="action-prev">পূর্ববর্তী</button>
                                    </div>
                                    <div>
                                        <input type="hidden" id="status" name="status" value="">

                                        <button type="button" style="background-color: #008841"
                                            class="btn btn-success mt-3 font-weight-bolder text-uppercase px-9 py-4"
                                            id="previous_step_smdn" data-wizard-type="action-submit">সংরক্ষণ
                                            করুন</button>
                                        <button type="button" style="background-color: #008841"
                                            class="btn mt-3 btn-primary font-weight-bolder text-uppercase px-9 py-4"
                                            id="next_step_smdn" data-wizard-type="action-next">পরবর্তী পদক্ষেপ</button>
                                    </div>
                                </div>
                                <!--end::Users-->
                        </div>

                        </fieldset>
                    </div>
                    <!--end::Card-body-->
                    <!-- Modal-->
                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
                        aria-labelledby="staticBackdrop" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">ফৌজদারি ধারার বিবরণ </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body" style="height: 300px;">
                                    <div id="lawdetails"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-primary font-weight-bold"
                                        data-dismiss="modal">বন্ধ করুন </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Wizard Body-->
                </div>
                <!--end::Entry-->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/number2banglaWord.js') }}"></script>
    @include('citizenAppealInitiate.appealCreate_Js')
    <script src="{{ asset('js/initiate/init.js') }}"></script>
    <script src="{{ asset('js/location/location.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/select2.js') }}"></script>
    <script src="{{ asset('plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/forms/editors/ckeditor-classic.js') }}"></script>
    <script src="{{ asset('js/appeal/Tachyons.min.js') }}"></script>
    <script src="{{ asset('js/appeal/appealCreateValidate.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Add smooth scrolling to all links

            //$('textarea').val($('textarea').val().trim())


            $("a.h2.btn.btn-info").on('click', function(event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
        });


        // Text Editor
        var KTCkeditor = function() {
            // Private functions
            var demos = function() {
                ClassicEditor
                    .create(document.querySelector('#kt-ckeditor-5'))
                    .then(editor => {
                        // console.log(editor);
                    })
                    .catch(error => {
                        // console.error(error);
                    });
            }

            return {
                // public functions
                init: function() {
                    demos();
                }
            };
        }();

        // Initialization
        jQuery(document).ready(function() {
            // KTCkeditor.init();
        });
    </script>
@endsection
