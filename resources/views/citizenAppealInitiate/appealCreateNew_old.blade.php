@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                            <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                        </div> -->
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

                <!--begin::Form-->
                <form id="appealCase" action="{{ route('citizen.appeal.store') }}" class="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="appealId" value="">
                    <div class="card-body">
                        <div class="row mb-8 ">
                            <div class="col-md-12">
                                <div class="example-preview">
                                    <ul class="nav nav-pills nav-fill">
                                        <li class="nav-item">
                                            <a class="nav-link px-0 active" id="regTab0" data-toggle="tab" href="#regTab_0">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">অভিযোগের তথ্য</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" id="prevCaseDiv">
                                            <a class="nav-link px-0" id="regTab1" data-toggle="tab" href="#regTab_1">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">১ম পক্ষ </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab2" data-toggle="tab" href="#regTab_2">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">২য় পক্ষ  </span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link px-0" id="regTab3" data-toggle="tab" href="#regTab_3">
                                                <span class="nav-icon">
                                                    <i class="flaticon2-chat-1"></i>
                                                </span>
                                                <span class="nav-text">সাক্ষীর তথ্য   </span>
                                            </a>
                                        </li>

                                    </ul>
                                    <hr>
                                    <div class="tab-content mt-5" id="myTabContent4">
                                        <div role="tabpanel" aria-labelledby="regTab0" class="tab-pane fade show active"
                                            id="regTab_0">
                                            <div class="panel panel-info radius-none">
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <input type="hidden" id="new" class="caseEntryType mr-2" value="others" name="caseEntryType">

                                                        <!-- <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="caseEntryType" class="control-label"> মামলার ধরন </label>
                                                                    <div class="radio">
                                                                        <label class="mr-5">
                                                                            <input type="radio" id="oldCaseRadio" class="caseEntryType  mr-2"
                                                                                value="others" checked name="caseEntryType">অন্যের মামলা
                                                                        </label>
                                                                        <label>
                                                                            <input type="radio" id="new" class="caseEntryType mr-2" value="own"
                                                                                name="caseEntryType">নিজের মামলা
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div> -->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="caseNo" class="control-label">মামলা নম্বর</label>
                                                                    <div name="caseNo" id="caseNo" class="form-control form-control-sm">সিস্টেম কর্তৃক পূরণকৃত </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                                                                    <input type="text" name="caseDate" id="case_date" class="form-control form-control-sm common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">অভিযোগের ধরণ  <span class="text-danger">*</span><span id="link"></span></label>
                                                                    <select class="form-control select2" id="kt_select2_1" name="lawSection" data-placeholder="-- নির্বাচন করুন --">
                                                                        <option value=""> -- নির্বাচন করুন --</option>
                                                                        @foreach ($data['lawSections'] as $value)
                                                                        <option law_section="{{ $value->crpc_id }}" value="{{ $value->id }}" {{ old('lawSection') == $value->crpc_id ? 'selected' : '' }}> {{ $value->crpc_name }} </option>
                                                                        @endforeach
                                                                    </select>

                                                                    {{-- <select class="form-control select2" id="kt_select2_1" name="lawSection">
                                                                        <option value=""> -- নির্বাচন করুন --</option>
                                                                        @foreach ($data['lawSections'] as $value)
                                                                        <option law_section="{{ $value->crpc_id }}" value="{{ $value->id }}" {{ old('lawSection') == $value->crpc_id ? 'selected' : '' }}> {{ $value->crpc_name }} </option>
                                                                        @endforeach
                                                                    </select> --}}
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">অভিযোগের ধরণ  <span class="text-danger">*</span><span id="link"></span></label>
                                                                    <select class="form-control select2" id="kt_select2_1" name="param">
                                                                        <option value="AK">Alaska</option>
                                                                        <option value="HI">Hawaii</option>
                                                                    </select>
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">বিভাগ </label>
                                                                    <!-- <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                                        value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                                                    <select name="division" id="division_id" class="form-control form-control-sm" >
                                                                        <option value="">-- নির্বাচন করুন --</option>
                                                                         @foreach ($data['divisionId'] as $value)
                                                                        <option value="{{ $value->id }}" {{ old('division') == $value->id ? 'selected' : '' }}> {{ $value->division_name_bn }} </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">জেলা</label>

                                                                    <select name="district" id="district_id" class="form-control form-control-sm">
                                                                        <!-- <span id="loading"></span> -->
                                                                        <option value="">-- নির্বাচন করুন --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="lawSection" class="control-label">উপজেলা</label>
                                                                    <!-- <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                                        value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                                                    <select name="upazila" id="upazila_id" class="form-control form-control-sm">
                                                                        <!-- <span id="loading"></span> -->
                                                                        <option value="">-- নির্বাচন করুন --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12 mb-5">
                                                                <label for="case_details" class="control-label">অভিযোগের বিবরণ</label>
                                                                <textarea name="case_details" id="kt-ckeditor-5"></textarea>
                                                                {{-- <textarea name="case_details" class="form-control" id="case_details" rows="3" spellcheck="true"></textarea> --}}
                                                            </div>
                                                        </div>
                                                        {{-- <div class="row">
                                                            <div class="col-lg-12 mb-5">
                                                                <label for="case_details" class="control-label">অভিযোগের বিবরণ</label>
                                                                <div class="card card-custom">
                                                                    <div class="card-header">
                                                                        <div class="card-title">
                                                                            <h3 class="card-title">
                                                                                Large Classic Demo
                                                                            </h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <textarea name="kt-ckeditor-5" id="kt-ckeditor-5"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab1" class="tab-pane fade"
                                            id="regTab_1">
                                            <div class="panel panel-info radius-none">
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                                        <div class="card-body">
                                                            <div class="clearfix">

                                                                {{-- <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="text-dark font-weight-bold h4">
                                                                        <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input required type="text" id="applicantCiNID_1" class="form-control" placeholder="উদাহরণ- 19825624603112948" name="applicant[ciNID]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input required type="text" id="applicantDob_1" name="applicant[dob]" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী)" id="dob" class="form-control common_datepicker" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input type="button" id="applicantCCheck_1" name="applicant[cCheck]" onclick="checkNomineeCitizen('applicant', 1)" class="btn btn-danger" value="সন্ধান করুন"> <span class="ml-5" id="res_applicant_1"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group" id="applicant_nidPic_1"></div>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantName_1"
                                                                                class="control-label">ভিক্টিমের নাম</label>
                                                                            <input name="applicant[name]" id="applicantName_1"
                                                                                class="form-control form-control-sm name-group">
                                                                            <input type="hidden" name="applicant[type]"
                                                                                class="form-control form-control-sm" value="1">
                                                                            <input type="hidden" name="applicant[id]"
                                                                                id="applicantId_1" class="form-control form-control-sm" value="">
                                                                            <input type="hidden" name="applicant[thana]"
                                                                                id="applicantThana_1" class="form-control form-control-sm"
                                                                                value="">
                                                                            <input type="hidden" name="applicant[upazilla]"
                                                                                id="applicantUpazilla_1" class="form-control form-control-sm"
                                                                                value="">
                                                                            <input type="hidden" name="applicant[age]"
                                                                                id="applicantAge_1" class="form-control form-control-sm"
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantGender_1"
                                                                                class="control-label">লিঙ্গ</label>
                                                                            <select style="width: 100%;"
                                                                                class="selectDropdown form-control form-control-sm"
                                                                                name="applicant[gender]" id="applicantGender_1">
                                                                                <option value="">বাছাই করুন</option>
                                                                                <option value="MALE">পুরুষ</option>
                                                                                <option value="FEMALE">নারী</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantFather_1"
                                                                                class="control-label"><span
                                                                                    style="color:#FF0000"></span>পিতার নাম</label>
                                                                            <input name="applicant[father]"
                                                                                id="applicantFather_1" class="form-control form-control-sm"
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantMother_1"
                                                                                class="control-label"><span
                                                                                    style="color:#FF0000"></span>মাতার নাম</label>
                                                                            <input name="applicant[mother]"
                                                                                id="applicantMother_1" class="form-control form-control-sm"
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantNid_1"
                                                                                class="control-label"><span
                                                                                    style="color:#FF0000">*</span>জাতীয় পরিচয়
                                                                                পত্র</label>
                                                                            <input name="applicant[nid]" id="applicantNid_1" class="form-control form-control-sm" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantPhn_1"
                                                                                class="control-label"><span
                                                                                    style="color:#FF0000">*
                                                                                </span>মোবাইল</label>
                                                                            <input name="applicant[phn]" id="applicantPhn_1"
                                                                                class="form-control form-control-sm" value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantPresentAddree_1"><span
                                                                                    style="color:#FF0000">*
                                                                                </span>ঠিকানা</label>
                                                                            <textarea id="applicantPresentAddree_1"
                                                                                name="applicant[presentAddress]" rows="1"
                                                                                class="form-control element-block blank"
                                                                                aria-describedby="note-error"
                                                                                aria-invalid="false"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="applicantEmail_1">ইমেইল</label>
                                                                                <input type="email" name="applicant[email]"
                                                                                id="applicantEmail_1" class="form-control form-control-sm"
                                                                                value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab2" class="tab-pane fade"
                                            id="regTab_2">
                                            <div class="panel panel-info radius-none">
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary DefaulterInfo" id="DefaulterInfo">

                                                        <div class="accordion accordion-solid accordion-toggle-plus"
                                                            id="accordionExample3">
                                                            <div id="cloneDefaulter" class="card">
                                                                <input type="hidden" id="DefaulterCount" value="1">
                                                                <div class="card-header" id="headingOne3">
                                                                    <div class="card-title h4" data-toggle="collapse"
                                                                        data-target="#collapseOne3">
                                                                        ২য় পক্ষের তথ্য &nbsp; <span
                                                                            id="spannCount">(1)</span>
                                                                    </div>
                                                                </div>
                                                                <div id="collapseOne3" class="collapse show"
                                                                    data-parent="#accordionExample3">
                                                                    <div class="card-body">
                                                                        <div class="clearfix">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterName_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>অপরাধীর নাম</label>
                                                                                        <input name="defaulter[name][]" id="defaulterName_1"
                                                                                            class="form-control form-control-sm" value=""
                                                                                            onchange="appealUiUtils.changeInitialNote()">
                                                                                        <input type="hidden" name="defaulter[type][]"
                                                                                            class="form-control form-control-sm" value="2">
                                                                                        <input type="hidden" name="defaulter[id][]"
                                                                                            id="defaulterId_1" class="form-control form-control-sm" value="">
                                                                                        <input type="hidden" name="defaulter[thana][]"
                                                                                            id="defaulterThana_1" class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden" name="defaulter[upazilla][]"
                                                                                            id="defaulterUpazilla_1" class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden" name="defaulter[age][]"
                                                                                            id="defaulterAge_1" class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterPhn_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>মোবাইল</label>
                                                                                        <input name="defaulter[phn][]" id="defaulterPhn_1"
                                                                                            class="form-control form-control-sm" value="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterNid_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000">*</span>জাতীয় পরিচয়
                                                                                            পত্র</label>
                                                                                        <input name="defaulter[nid][]" id="defaulterNid_1"
                                                                                            class="form-control form-control-sm" value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterGender_1"
                                                                                            class="control-label">লিঙ্গ</label>
                                                                                        <select style="width: 100%;"
                                                                                            class="selectDropdown form-control form-control-sm"
                                                                                            name="defaulter[gender][]" id="defaulterGender_1">
                                                                                            <option value="">বাছাই করুন</option>
                                                                                            <option value="MALE">পুরুষ</option>
                                                                                            <option value="FEMALE">নারী</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- <input name="defaulter[organization_id][]" id="defaulterOrganizationID_1" type="hidden"> -->

                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterFather_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>পিতার নাম</label>
                                                                                        <input name="defaulter[father][]"
                                                                                            id="defaulterFather_1" class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterMother_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>মাতার নাম</label>
                                                                                        <input name="defaulter[mother][]"
                                                                                            id="defaulterMother_1" class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterPresentAddree_1"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>ঠিকানা</label>
                                                                                        <textarea id="defaulterPresentAddree_1"
                                                                                            name="defaulter[presentAddress][]" rows="1"
                                                                                            class="form-control element-block blank"
                                                                                            aria-describedby="note-error"
                                                                                            aria-invalid="false"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="defaulterEmail_1">ইমেইল</label>
                                                                                            <input type="email" name="defaulter[email][]"
                                                                                            id="defaulterEmail_1" class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>

                                                <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="RemoveDefaulter" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddDefaulter" type="button" class="btn btn-primary">
                                                        ২য় পক্ষ যোগ করুন
                                                    </button>
                                                </div>
                                            </div>
                                            {{-- <div class="panel panel-info radius-none">
                                                <div class="panel-body">
                                                    <div class="clearfix">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterName_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>অপরাধীর নাম</label>
                                                                    <input name="defaulter[name][]" id="defaulterName_1"
                                                                        class="form-control form-control-sm" value=""
                                                                        onchange="appealUiUtils.changeInitialNote()">
                                                                    <input type="hidden" name="defaulter[type][]"
                                                                        class="form-control form-control-sm" value="2">
                                                                    <input type="hidden" name="defaulter[id][]"
                                                                        id="defaulterId_1" class="form-control form-control-sm" value="">
                                                                    <input type="hidden" name="defaulter[thana][]"
                                                                        id="defaulterThana_1" class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden" name="defaulter[upazilla][]"
                                                                        id="defaulterUpazilla_1" class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden" name="defaulter[age][]"
                                                                        id="defaulterAge_1" class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPhn_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>মোবাইল</label>
                                                                    <input name="defaulter[phn][]" id="defaulterPhn_1"
                                                                        class="form-control form-control-sm" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterNid_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000">*</span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="defaulter[nid][]" id="defaulterNid_1"
                                                                        class="form-control form-control-sm" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterGender_1"
                                                                        class="control-label">লিঙ্গ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm"
                                                                        name="defaulter[gender][]" id="defaulterGender_1">
                                                                        <option value="">বাছাই করুন</option>
                                                                        <option value="MALE">পুরুষ</option>
                                                                        <option value="FEMALE">নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- <input name="defaulter[organization_id][]" id="defaulterOrganizationID_1" type="hidden"> -->

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="defaulter[father][]"
                                                                        id="defaulterFather_1" class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterMother_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>মাতার নাম</label>
                                                                    <input name="defaulter[mother][]"
                                                                        id="defaulterMother_1" class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterPresentAddree_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঠিকানা</label>
                                                                    <textarea id="defaulterPresentAddree_1"
                                                                        name="defaulter[presentAddress][]" rows="1"
                                                                        class="form-control element-block blank"
                                                                        aria-describedby="note-error"
                                                                        aria-invalid="false"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="defaulterEmail_1">ইমেইল</label>
                                                                        <input type="email" name="defaulter[email][]"
                                                                        id="defaulterEmail_1" class="form-control form-control-sm"
                                                                        value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div role="tabpanel" aria-labelledby="regTab3" class="tab-pane fade"
                                            id="regTab_3">
                                            <div class="panel panel-info radius-none ">
                                                <div style="margin: 10px" id="accordion" role="tablist"
                                                    aria-multiselectable="true" class="panel-group notesDiv">
                                                    <section class="panel panel-primary witnessInfo" id="witnessInfo">

                                                        <div class="accordion accordion-solid accordion-toggle-plus"
                                                            id="accordionExample3">
                                                            <div id="cloneNomenee" class="card">
                                                                <input type="hidden" id="WitnessCount" value="1">
                                                                <div class="card-header" id="headingOne3">
                                                                    <div class="card-title h4" data-toggle="collapse"
                                                                        data-target="#collapseOne3">
                                                                        সাক্ষীর তথ্য  &nbsp; <span
                                                                            id="spannCount">(1)</span>
                                                                    </div>
                                                                </div>
                                                                <div id="collapseOne3" class="collapse show"
                                                                    data-parent="#accordionExample3">
                                                                    <div class="card-body">
                                                                        <div class="clearfix">
                                                                            <div class="row">

                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessName_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>সাক্ষীর
                                                                                            নাম</label>
                                                                                        <input name="witness[name][]"
                                                                                            id="witnessName_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="witness[type][]"
                                                                                            class="form-control form-control-sm"
                                                                                            value="5">
                                                                                        <input type="hidden"
                                                                                            name="witness[id][]"
                                                                                            id="witnessId_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="witness[thana][]"
                                                                                            id="witnessThana_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="witness[upazilla][]"
                                                                                            id="witnessUpazilla_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="witness[designation][]"
                                                                                            id="witnessDesignation_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                        <input type="hidden"
                                                                                            name="witness[organization][]"
                                                                                            id="witnessOrganization_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessPhn_1"
                                                                                            class="control-label">মোবাইল</label>
                                                                                        <input name="witness[phn][]"
                                                                                            id="witnessPhn_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessNid_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>জাতীয়
                                                                                            পরিচয় পত্র</label>
                                                                                        <input name="witness[nid][]"
                                                                                            id="witnessNid_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessGender_1"
                                                                                            class="control-label">নারী /
                                                                                            পুরুষ</label>
                                                                                        <select style="width: 100%;"
                                                                                            class="selectDropdown form-control"
                                                                                            name="witness[gender][]"
                                                                                            id="witnessGender_1">
                                                                                            <option value="">
                                                                                                বাছাই করুন</option>
                                                                                            <option value="MALE">
                                                                                                পুরুষ</option>
                                                                                            <option value="FEMALE">
                                                                                                নারী</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <input name="witness[organization_id][]" id="witnessOrganizationID_1" type="hidden">

                                                                            </div>

                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessFather_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>পিতার নাম</label>
                                                                                        <input name="witness[father][]"
                                                                                            id="witnessFather_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessPresentAddree_1"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>ঠিকানা</label>
                                                                                        <textarea id="witnessPresentAddree_1"
                                                                                            name="witness[presentAddress][]" rows="1"
                                                                                            class="form-control element-block blank"
                                                                                            aria-describedby="note-error"
                                                                                            aria-invalid="false"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                               <!--  <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessMother_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>মাতার
                                                                                            নাম</label>
                                                                                        <input name="witness[mother][]"
                                                                                            id="witnessMother_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div> -->
                                                                            </div>
                                                                            <!-- <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessAge_1"
                                                                                            class="control-label"><span
                                                                                                style="color:#FF0000"></span>বয়স</label>
                                                                                        <input name="witness[age][]"
                                                                                            id="witnessAge_1"
                                                                                            class="form-control form-control-sm"
                                                                                            value="">
                                                                                    </div>
                                                                                </div>
                                                                                {{-- <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="witnessPresentAddree_1">ঠিকানা</label>
                                                                                        <textarea
                                                                                            id="witnessPresentAddree_1"
                                                                                            name="witness[presentAddress][]"
                                                                                            rows="1"
                                                                                            class="form-control form-control-sm element-block blank"
                                                                                            aria-describedby="note-error"
                                                                                            aria-invalid="false"></textarea>
                                                                                    </div>
                                                                                </div> --}}
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="witnessEmail_1"><span
                                                                                                style="color:#FF0000">*
                                                                                            </span>ইমেইল</label>
                                                                                            <input type="email" name="witness[email][]" id="witnessEmail_1" class="form-control form-control-sm" value="">
                                                                                    </div>
                                                                                </div>
                                                                            </div> -->
                                                                            <div class="row">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </div>
                                                <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="Removewitness" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddWitness" type="button" class="btn btn-primary">
                                                        সাক্ষী যোগ করুন
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <fieldset class=" mb-8">
                            <div
                                class="rounded bg-success-o-75 d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে) dfsdf</h3>
                                </div>
                                <!--end::Info-->
                                <!--begin::Users-->
                                <div class="symbol-group symbol-hover py-2">
                                    <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                        data-placement="top" title="" role="button" data-original-title="New user">
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
                                <table width="100%" class="border-0 px-5" id="fileDiv" style="border:1px solid #dcd8d8;">
                                    <tr></tr>
                                </table>
                                <input type="hidden" id="other_attachment_count" value="1">
                            </div>
                        </fieldset>
                        <div class="row buttonsDiv">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" id="status" name="status" value="DRAFT">
                                    <button type="button" class="btn btn-primary" onclick="myFunction()">
                                        সংরক্ষণ করুন
                                    </button>
                                    <button type="button" onclick="formSubmit()" class="btn btn-warning">
                                        প্রেরণ(সংশ্লিষ্ট আদালত)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-body-->
                                        <!-- Modal-->
                    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
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
                                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">বন্ধ করুন </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
    <script src="{{ asset('js/pages/crud/forms/widgets/select2.js')}}"></script>
    <script src="{{ asset('plugins/custom/ckeditor/ckeditor-classic.bundle.js')}}"></script>
	<script src="{{ asset('js/pages/crud/forms/editors/ckeditor-classic.js')}}"></script>
    <script>
        $(document).ready(function() {
            // Add smooth scrolling to all links
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
        var KTCkeditor = function () {
            // Private functions
            var demos = function () {
                ClassicEditor
                    .create( document.querySelector( '#kt-ckeditor-5' ) )
                    .then( editor => {
                        console.log( editor );
                    } )
                    .catch( error => {
                        console.error( error );
                    } );
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
