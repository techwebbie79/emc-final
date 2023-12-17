@extends('layouts.landing')

@section('landing')
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

        #main_file_input {}
    </style>
    <!--begin::Card-->
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="margin-top: 85px">
                <div class="card card-custom">
                    <div class="mx-auto py-5">
                        <h3 class="mt-3"><span class="p-3 invertigation_report">তদন্ত প্রতিবেদন</span></h3>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('withError'))
                        <div class="alert alert-danger">
                            {{ Session::get('withError') }}
                        </div>
                    @endif


                    <div class="card-title">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home">
                                    <span class="nav-icon">
                                        <i class="flaticon2-chat-1 text-primary"></i>
                                    </span>
                                    <span class="nav-text text-dark h6 mt-2"> অভিযোগের তথ্য</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="applicant-tab" data-toggle="tab" href="#applicant"
                                    aria-controls="applicant">
                                    <span class="nav-icon">
                                        <i class="flaticon2-chat-1 text-primary"></i>
                                    </span>
                                    <span class="nav-text text-dark h6 mt-2">বাদীর তথ্য</span>
                                </a>
                            </li>
                            @if (!empty($victimCitizen))
                                <li class="nav-item">
                                    <a class="nav-link" id="victim-tab" data-toggle="tab" href="#victim"
                                        aria-controls="victim">
                                        <span class="nav-icon">
                                            <i class="flaticon2-chat-1 text-primary"></i>
                                        </span>
                                        <span class="nav-text text-dark h6 mt-2">ভিক্টিমের তথ্য</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" id="deafulter-tab" data-toggle="tab" href="#deafulter"
                                    aria-controls="deafulter">
                                    <span class="nav-icon">
                                        <i class="flaticon2-chat-1 text-primary"></i>
                                    </span>
                                    <span class="nav-text text-dark h6 mt-2">বিবাদীর তথ্য</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="witness-tab" data-toggle="tab" href="#witness"
                                    aria-controls="witness">
                                    <span class="nav-icon">
                                        <i class="flaticon2-chat-1 text-primary"></i>
                                    </span>
                                    <span class="nav-text text-dark h6 mt-2">সাক্ষীর তথ্য</span>
                                </a>
                            </li>
                            @if (isset($lawerCitizen->citizen_name) > 0)
                                <li class="nav-item">
                                    <a class="nav-link" id="lawyer-tab" data-toggle="tab" href="#lawyer"
                                        aria-controls="lawyer">
                                        <span class="nav-icon">
                                            <i class="flaticon2-chat-1 text-primary"></i>
                                        </span>
                                        <span class="nav-text text-dark h6 mt-2">আইনজীবীর তথ্য</span>
                                    </a>
                                </li>
                            @endif
                            @if (!empty($defaulerWithnessCitizen))
                                <li class="nav-item">
                                    <a class="nav-link" id="defaulerWithnessCitizen-tab" data-toggle="tab"
                                        href="#defaulerWithnessCitizen" aria-controls="witness">
                                        <span class="nav-icon">
                                            <i class="flaticon2-chat-1 text-primary"></i>
                                        </span>
                                        <span class="nav-text text-dark h6 mt-2">বিবাদী পক্ষের সাক্ষীর তথ্য</span>
                                    </a>
                                </li>
                            @endif
                            @if (isset($defaulerLawyerCitizen[0]->citizen_name) )
                                <li class="nav-item">
                                    <a class="nav-link" id="defaulerLawyerCitizen-tab" data-toggle="tab"
                                        href="#defaulerLawyerCitizen" aria-controls="witness">
                                        <span class="nav-icon">
                                            <i class="flaticon2-chat-1 text-primary"></i>
                                        </span>
                                        <span class="nav-text text-dark h6 mt-2">বিবাদী পক্ষের আইনজীবীর তথ্য</span>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link active" id="lawyer-tab" data-toggle="tab" href="#reportInvestigation"
                                    aria-controls="lawyer">
                                    <span class="nav-icon">
                                        <i class="flaticon2-chat-1 text-primary"></i>
                                    </span>
                                    <span class="nav-text text-dark h6 mt-2">তদন্ত প্রতিবেদন জমা দেওয়ার ফর্ম</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body" id="CaseDetails">
                        <div class="tab-content mt-5" id="myTabContent">
                            <div class="tab-pane fade " id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="clearfix">
                                    <div class="row">
                                        <!--  <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="caseEntryType" class="control-label"> মামলার ধরন </label>
                                                <div class="radio">
                                                    <label class="mr-5">
                                                        <input {{ $appeal->case_entry_type == 'others' ? 'checked' : '' }} type="radio" id="oldCaseRadio" class="caseEntryType  mr-2"
                                                            value="others" checked name="caseEntryType">অন্যের মামলা
                                                    </label>
                                                    <label>
                                                        <input {{ $appeal->case_entry_type == 'own' ? 'checked' : '' }} type="radio" id="new" class="caseEntryType mr-2" value="own"
                                                            name="caseEntryType">নিজের মামলা
                                                    </label>
                                                </div>
                                            </div>
                                        </div> -->

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="caseNo" class="control-label">মামলা নম্বর</label>
                                                <div name="caseNo" id="caseNo" class="form-control form-control-sm">
                                                    {{ $appeal->case_no }}</div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                                                <input value="{{ date('d-m-Y', strtotime($appeal->case_date)) ?? '' }}"
                                                    type="text" name="caseDate" id="case_date"
                                                    class="form-control form-control-sm common_datepicker"
                                                    placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label">অভিযোগের ধরণ </label>
                                                <input name="lawSection" id="lawSection"
                                                    class="form-control form-control-md"
                                                    value="{{ $appeal->crpcSection->crpc_name ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label">বিভাগ </label>
                                                <!-- <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                    value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                                <select name="division" id="division_id"
                                                    class="form-control form-control-sm">
                                                    <option>{{ $appeal->division->division_name_bn ?? '' }}</option>
                                                    {{-- @foreach ($data['divisionId'] as $value)
                                            <option value="{{ $value->id }}" {{ old('division') == $value->id ? 'selected' : '' }}> {{ $value->division_name_bn ?? '' }} </option>
                                            @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label">জেলা</label>

                                                <select name="district" id="district_id"
                                                    class="form-control form-control-sm">
                                                    <option>{{ $appeal->district->district_name_bn ?? '' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lawSection" class="control-label">উপজেলা</label>
                                                <!-- <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                    value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                                <select name="upazila" id="upazila_id"
                                                    class="form-control form-control-sm">
                                                    <option>{{ $appeal->upazila->upazila_name_bn ?? '' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 mb-5">
                                            <div class="form-group">
                                                <label for="case_details" class="control-label"><b>অভিযোগের
                                                        বিবরণ</b></label>
                                                <div class="border p-5" style="height: 200px; overflow-y: scroll;">

                                                    {!! $appeal->case_details ?? '' !!}
                                                </div>
                                            </div>
                                            {{-- <textarea name="case_details" class="form-control" id="case_details" rows="3" spellcheck="true">{!! $appeal->case_details ?? '' !!}</textarea> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="applicant" role="tabpanel" aria-labelledby="applicant-tab">
                                <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                        @forelse ($applicantCitizen as $key => $item)
                                            @php
                                                $count = ++$key;
                                            @endphp
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantName_1" class="control-label"> বাদীর
                                                                নাম</label>
                                                            <input name="applicant[name][]" id="applicantName_1"
                                                                class="form-control form-control-md name-group"
                                                                value="{{ $item->citizen_name ?? '' }}">
                                                            <input type="hidden" name="applicant[type][]"
                                                                class="form-control form-control-md" value="1">
                                                            <input type="hidden" name="applicant[id][]"
                                                                id="applicantId_1" class="form-control form-control-md"
                                                                value="{{ $item->id ?? '' }}">
                                                            <input type="hidden" name="applicant[thana][]"
                                                                id="applicantThana_1" class="form-control form-control-md"
                                                                value="">
                                                            <input type="hidden" name="applicant[upazilla][]"
                                                                id="applicantUpazilla_1"
                                                                class="form-control form-control-md" value="">
                                                            <input type="hidden" name="applicant[age][]"
                                                                id="applicantAge_1" class="form-control form-control-md"
                                                                value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantGender_1"
                                                                class="control-label">লিঙ্গ</label>
                                                            <select style="width: 100%;"
                                                                class="selectDropdown form-control form-control-md"
                                                                name="applicant[gender][]" id="applicantGender_1">
                                                                <option value="">বাছাই করুন</option>
                                                                <option value="MALE"
                                                                    {{ $item->citizen_gender == 'MALE' ? 'selected' : '' }}>
                                                                    পুরুষ</option>
                                                                <option value="FEMALE"
                                                                    {{ $item->citizen_gender == 'FEMALE' ? 'selected' : '' }}>
                                                                    নারী</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantFather_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>পিতার নাম</label>
                                                            <input name="applicant[father][]" id="applicantFather_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->father ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantMother_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>মাতার নাম</label>
                                                            <input name="applicant[mother][]" id="applicantMother_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->mother ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantNid_1" class="control-label"><span
                                                                    style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                                পত্র</label>
                                                            <input name="applicant[nid][]" id="applicantNid_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->citizen_NID ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantPhn_1" class="control-label"><span
                                                                    style="color:#FF0000">*
                                                                </span>মোবাইল</label>
                                                            <input name="applicant[phn][]" id="applicantPhn_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->citizen_phone_no ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantPresentAddree_1"><span
                                                                    style="color:#FF0000">*
                                                                </span>প্রতিষ্ঠানের ঠিকানা</label>
                                                            <textarea id="applicantPresentAddree_1" name="applicant[presentAddress][]" rows="5"
                                                                class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false">{{ $item->present_address ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="applicantEmail_1"><span style="color:#ff0000d8">
                                                                </span>ইমেইল</label>
                                                            <input type="email" name="applicant[email][]"
                                                                id="applicantEmail_1" class="form-control form-control-md"
                                                                value="{{ $item->email ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="victim" role="tabpanel" aria-labelledby="victim-tab">
                                <section class="panel panel-primary victimInfo" id="victimInfo">
                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                        @forelse ($victimCitizen as $key => $item)
                                            @php
                                                $count = ++$key;
                                            @endphp
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimName_1" class="control-label"> ভিক্টিমের
                                                                নাম</label>
                                                            <input name="victim[name][]" id="victimName_1"
                                                                class="form-control form-control-md name-group"
                                                                value="{{ $item->citizen_name ?? '' }}">
                                                            <input type="hidden" name="victim[type][]"
                                                                class="form-control form-control-md" value="1">
                                                            <input type="hidden" name="victim[id][]" id="victimId_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->id ?? '' }}">
                                                            <input type="hidden" name="victim[thana][]"
                                                                id="victimThana_1" class="form-control form-control-md"
                                                                value="">
                                                            <input type="hidden" name="victim[upazilla][]"
                                                                id="victimUpazilla_1" class="form-control form-control-md"
                                                                value="">
                                                            <input type="hidden" name="victim[age][]" id="victimAge_1"
                                                                class="form-control form-control-md" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimGender_1"
                                                                class="control-label">লিঙ্গ</label>
                                                            <select style="width: 100%;"
                                                                class="selectDropdown form-control form-control-md"
                                                                name="victim[gender][]" id="victimGender_1">
                                                                <option value="">বাছাই করুন</option>
                                                                <option value="MALE"
                                                                    {{ $item->citizen_gender == 'MALE' ? 'selected' : '' }}>
                                                                    পুরুষ</option>
                                                                <option value="FEMALE"
                                                                    {{ $item->citizen_gender == 'FEMALE' ? 'selected' : '' }}>
                                                                    নারী</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimFather_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>পিতার নাম</label>
                                                            <input name="victim[father][]" id="victimFather_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->father ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimMother_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>মাতার নাম</label>
                                                            <input name="victim[mother][]" id="victimMother_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->mother ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimNid_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                পত্র</label>
                                                            <input name="victim[nid][]" id="victimNid_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->citizen_NID ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimPhn_1" class="control-label"><span
                                                                    style="color:#FF0000">*
                                                                </span>মোবাইল</label>
                                                            <input name="victim[phn][]" id="victimPhn_1"
                                                                class="form-control form-control-md"
                                                                value="{{ $item->citizen_phone_no ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimPresentAddree_1"><span
                                                                    style="color:#FF0000">*
                                                                </span>প্রতিষ্ঠানের ঠিকানা</label>
                                                            <textarea id="victimPresentAddree_1" name="victim[presentAddress][]" rows="5"
                                                                class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false">{{ $item->present_address ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="victimEmail_1"><span style="color:#ff0000d8">
                                                                </span>ইমেইল</label>
                                                            <input type="email" name="victim[email][]"
                                                                id="victimEmail_1" class="form-control form-control-md"
                                                                value="{{ $item->email ?? '' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="deafulter" role="tabpanel" aria-labelledby="deafulter-tab">
                                <section class="panel panel-primary deafulterInfo" id="deafulterInfo">
                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                        @forelse ($defaulterCitizen as $key => $item)
                                            @php
                                                $count = ++$key;
                                            @endphp
                                            <div id="cloneNomenee" class="card">
                                                <div class="card-header" id="headingOne3">
                                                    <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}"
                                                        data-toggle="collapse"
                                                        data-target="#collapseOne3{{ $count }}">
                                                        বিবাদীর তথ্য &nbsp; <span
                                                            id="spannCount">({{ $count }})</span>
                                                    </div>
                                                </div>
                                                <div id="collapseOne3{{ $count }}"
                                                    class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                    data-parent="#accordionExample3">
                                                    <div class="card-body">
                                                        <div class="clearfix">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterName_1"
                                                                            class="control-label">
                                                                            বিবাদীর নাম</label>
                                                                        <input name="defaulter[name][]"
                                                                            id="defaulterName_1"
                                                                            class="form-control form-control-md name-group"
                                                                            value="{{ $item->citizen_name ?? '' }}">
                                                                        <input type="hidden" name="defaulter[type][]"
                                                                            class="form-control form-control-md"
                                                                            value="1">
                                                                        <input type="hidden" name="defaulter[id][]"
                                                                            id="defaulterId_1"
                                                                            class="form-control form-control-md"
                                                                            value="{{ $item->id ?? '' }}">
                                                                        <input type="hidden" name="defaulter[thana][]"
                                                                            id="defaulterThana_1"
                                                                            class="form-control form-control-md"
                                                                            value="">
                                                                        <input type="hidden" name="defaulter[upazilla][]"
                                                                            id="defaulterUpazilla_1"
                                                                            class="form-control form-control-md"
                                                                            value="">
                                                                        <input type="hidden" name="defaulter[age][]"
                                                                            id="defaulterAge_1"
                                                                            class="form-control form-control-md"
                                                                            value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterGender_1"
                                                                            class="control-label">লিঙ্গ</label>
                                                                        <select style="width: 100%;"
                                                                            class="selectDropdown form-control form-control-md"
                                                                            name="defaulter[gender][]"
                                                                            id="defaulterGender_1">
                                                                            <option value="">বাছাই করুন</option>
                                                                            <option value="MALE"
                                                                                {{ $item->citizen_gender == 'MALE' ? 'selected' : '' }}>
                                                                                পুরুষ</option>
                                                                            <option value="FEMALE"
                                                                                {{ $item->citizen_gender == 'FEMALE' ? 'selected' : '' }}>
                                                                                নারী</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterFather_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000"></span>পিতার
                                                                            নাম</label>
                                                                        <input name="defaulter[father][]"
                                                                            id="defaulterFather_1"
                                                                            class="form-control form-control-md"
                                                                            value="{{ $item->father ?? '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterMother_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000"></span>মাতার
                                                                            নাম</label>
                                                                        <input name="defaulter[mother][]"
                                                                            id="defaulterMother_1"
                                                                            class="form-control form-control-md"
                                                                            value="{{ $item->mother ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterNid_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                                            পত্র</label>
                                                                        <input name="defaulter[nid][]" id="defaulterNid_1"
                                                                            class="form-control form-control-md"
                                                                            value="{{ $item->citizen_NID ?? '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterPhn_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000">*
                                                                            </span>মোবাইল</label>
                                                                        <input name="defaulter[phn][]" id="defaulterPhn_1"
                                                                            class="form-control form-control-md"
                                                                            value="{{ $item->citizen_phone_no ?? '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterPresentAddree_1"><span
                                                                                style="color:#FF0000">*
                                                                            </span>প্রতিষ্ঠানের ঠিকানা</label>
                                                                        <textarea id="defaulterPresentAddree_1" name="defaulter[presentAddress][]" rows="5"
                                                                            class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false">{{ $item->present_address ?? '' }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="defaulterEmail_1"><span
                                                                                style="color:#ff0000d8">
                                                                            </span>ইমেইল</label>
                                                                        <input type="email" name="defaulter[email][]"
                                                                            id="defaulterEmail_1"
                                                                            class="form-control form-control-md"
                                                                            value="{{ isset($item->email) ? $item->email : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </section>
                            </div>
                            <div class="tab-pane fade" id="witness" role="tabpanel" aria-labelledby="witness-tab">

                                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                    @forelse ($witnessCitizen as $key => $item)
                                        @php
                                            $count = ++$key;
                                        @endphp
                                        <div id="cloneNomenee" class="card">
                                            <div class="card-header" id="headingOne3">
                                                <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}"
                                                    data-toggle="collapse"
                                                    data-target="#collapseOne3{{ $count }}">
                                                    সাক্ষীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                                </div>
                                            </div>
                                            <div id="collapseOne3{{ $count }}"
                                                class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                data-parent="#accordionExample3">
                                                <div class="card-body">
                                                    <div class="clearfix">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessName_1"
                                                                        class="control-label">সাক্ষীর
                                                                        নাম</label>
                                                                    <input name="witness[name][]" id="witnessName_1"
                                                                        class="form-control form-control-sm name-group"
                                                                        value="{{ $item->citizen_name ?? '' }}" readonly>
                                                                    <input type="hidden" name="witness[type][]"
                                                                        class="form-control form-control-sm"
                                                                        value="5">
                                                                    <input type="hidden" name="witness[id][]"
                                                                        id="witnessId_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $item->id ?? '' }}" readonly>
                                                                    <input type="hidden" name="witness[thana][]"
                                                                        id="witnessThana_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden" name="witness[upazilla][]"
                                                                        id="witnessUpazilla_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden" name="witness[age][]"
                                                                        id="witnessAge_1"
                                                                        class="form-control form-control-sm"
                                                                        value="">
                                                                    <input type="hidden"
                                                                        name="witness[organization_id][]"
                                                                        id="witnessOrganizationId_1" class="form-control "
                                                                        value="">
                                                                    <input type="hidden" name="witness[organization]"
                                                                        id="witnessOrganization_1" class="form-control "
                                                                        value="">
                                                                    <input type="hidden" name="witness[designation]"
                                                                        id="witnessDesignation_1" class="form-control "
                                                                        value="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessGender_1"
                                                                        class="control-label">লিঙ্গ</label>
                                                                    <select style="width: 100%;"
                                                                        class="selectDropdown form-control form-control-sm"
                                                                        name="witness[gender][]" id="witnessGender_1">

                                                                        <option value="MALE"
                                                                            {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                                            পুরুষ</option>
                                                                        <option value="FEMALE"
                                                                            {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                                            নারী</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessFather_1"
                                                                        class="control-label"><span
                                                                            style="color:#FF0000"></span>পিতার নাম</label>
                                                                    <input name="witness[father][]" id="witnessFather_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $item->father ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessPresentAddree_1"><span
                                                                            style="color:#FF0000">
                                                                        </span>মাতার নাম</label>
                                                                    <input name="witness[mother][]" id="witnessFather_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $item->mother ?? '' }}" readonly>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessPhn_1" class="control-label"><span
                                                                            style="color:#FF0000">*
                                                                        </span>মোবাইল</label>
                                                                    <input name="witness[phn][]" id="witnessPhn_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $item->citizen_phone_no ?? '' }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessNid_1" class="control-label"><span
                                                                            style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                                        পত্র</label>
                                                                    <input name="witness[nid][]" id="witnessNid_1"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $item->citizen_NID ?? '' }}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="witnessPresentAddree_1"><span
                                                                            style="color:#FF0000">*
                                                                        </span>ঠিকানা</label>
                                                                    <textarea id="witnessPresentAddree_1" name="witness[presentAddress][]" rows="5"
                                                                        class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false" readonly>{{ $item->present_address ?? '' }}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                </div>
                            </div>
                            @if (isset($lawerCitizen->citizen_name) > 0)
                                <div class="tab-pane fade" id="lawyer" role="tabpanel" aria-labelledby="lawyer-tab">
                                    <div class="panel panel-info radius-none ">
                                        {{-- <div class="panel-heading radius-none"> --}}
                                        {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                        {{-- </div> --}}
                                        <div class="panel-body">
                                            <div class="clearfix">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerName_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>আইনজীবীর
                                                                নাম</label>
                                                            <input name="lawyer[name]" id="lawyerName_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->citizen_name }}">
                                                            <input type="hidden" name="lawyer[type]"
                                                                class="form-control form-control-sm" value="4">
                                                            <input type="hidden" name="lawyer[id]" id="lawyerId_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->id }}">
                                                            <input type="hidden" name="lawyer[email]" id="lawyerEmail_1"
                                                                class="form-control form-control-sm" value="">
                                                            <input type="hidden" name="lawyer[thana]" id="lawyerThana_1"
                                                                class="form-control form-control-sm" value="">
                                                            <input type="hidden" name="lawyer[upazilla]"
                                                                id="lawyerUpazilla_1" class="form-control form-control-sm"
                                                                value="">
                                                            <input type="hidden" name="lawyer[age]" id="lawyerAge_1"
                                                                class="form-control form-control-sm" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerPhn_1" class="control-label">মোবাইল</label>
                                                            <input name="lawyer[phn]" id="lawyerPhn_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->citizen_phone_no }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerNid_1" class="control-label"><span
                                                                    style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                                পত্র</label>
                                                            <input name="lawyer[nid]" id="lawyerNid_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->citizen_NID }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerGender_1"
                                                                class="control-label">লিঙ্গ</label>
                                                            <select style="width: 100%;"
                                                                class="selectDropdown form-control form-control-sm form-control-sm"
                                                                name="lawyer[gender]" id="lawyerGender_1">
                                                                <option value="">বাছাই করুন</option>
                                                                <option value="MALE"
                                                                    {{ $lawerCitizen->citizen_gender == 'MALE' ? 'selected' : '' }}>
                                                                    পুরুষ</option>
                                                                <option value="FEMALE"
                                                                    {{ $lawerCitizen->citizen_gender == 'FEMALE' ? 'selected' : '' }}>
                                                                    নারী</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerFather_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>পিতার নাম</label>
                                                            <input name="lawyer[father]" id="lawyerFather_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->father }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerMother_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>মাতার নাম</label>
                                                            <input name="lawyer[mother]" id="lawyerMother_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->mother }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerDesignation_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>পদবি</label>
                                                            <input name="lawyer[designation]" id="lawyerDesignation_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->designation }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerOrganization_1" class="control-label"><span
                                                                    style="color:#FF0000"></span>প্রতিষ্ঠানের
                                                                নাম</label>
                                                            <input name="lawyer[organization]" id="lawyerOrganization_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->organization }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerPresentAddree_1"><span
                                                                    style="color:#FF0000">*
                                                                </span>ঠিকানা</label>
                                                            <textarea id="lawyerPresentAddree_1" name="lawyer[presentAddress]" rows="5"
                                                                class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false">{{ $lawerCitizen->present_address ?? '-' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="lawyerEmail_1"><span style="color:#FF0000">
                                                                </span>ইমেইল</label>
                                                            <input type="email" name="lawyer[email]" id="lawyerEmail_1"
                                                                class="form-control form-control-sm"
                                                                value="{{ $lawerCitizen->email ?? '-' }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($defaulerWithnessCitizen))
                                <div class="tab-pane fade" id="defaulerWithnessCitizen" role="tabpanel"
                                    aria-labelledby="defaulerWithnessCitizen-tab">

                                    <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                        @forelse ($defaulerWithnessCitizen as $key => $item)
                                            @php
                                                $count = ++$key;
                                            @endphp
                                            <div id="cloneNomenee" class="card">
                                                <div class="card-header" id="headingOne3">
                                                    <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}"
                                                        data-toggle="collapse"
                                                        data-target="#collapseOne3{{ $count }}">
                                                        বিবাদী পক্ষের সাক্ষীর তথ্য &nbsp; <span
                                                            id="spannCount">({{ $count }})</span>
                                                    </div>
                                                </div>
                                                <div id="collapseOne3{{ $count }}"
                                                    class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                    data-parent="#accordionExample3">
                                                    <div class="card-body">
                                                        <div class="clearfix">

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessName_1"
                                                                            class="control-label">সাক্ষীর
                                                                            নাম</label>
                                                                        <input name="witness[name][]" id="witnessName_1"
                                                                            class="form-control form-control-sm name-group"
                                                                            value="{{ $item->citizen_name ?? '' }}"
                                                                            readonly>
                                                                        <input type="hidden" name="witness[type][]"
                                                                            class="form-control form-control-sm"
                                                                            value="5">
                                                                        <input type="hidden" name="witness[id][]"
                                                                            id="witnessId_1"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $item->id ?? '' }}" readonly>
                                                                        <input type="hidden" name="witness[thana][]"
                                                                            id="witnessThana_1"
                                                                            class="form-control form-control-sm"
                                                                            value="">
                                                                        <input type="hidden" name="witness[upazilla][]"
                                                                            id="witnessUpazilla_1"
                                                                            class="form-control form-control-sm"
                                                                            value="">
                                                                        <input type="hidden" name="witness[age][]"
                                                                            id="witnessAge_1"
                                                                            class="form-control form-control-sm"
                                                                            value="">
                                                                        <input type="hidden"
                                                                            name="witness[organization_id][]"
                                                                            id="witnessOrganizationId_1"
                                                                            class="form-control " value="">
                                                                        <input type="hidden" name="witness[organization]"
                                                                            id="witnessOrganization_1"
                                                                            class="form-control " value="">
                                                                        <input type="hidden" name="witness[designation]"
                                                                            id="witnessDesignation_1"
                                                                            class="form-control " value="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessGender_1"
                                                                            class="control-label">লিঙ্গ</label>
                                                                        <select style="width: 100%;"
                                                                            class="selectDropdown form-control form-control-sm"
                                                                            name="witness[gender][]" id="witnessGender_1">

                                                                            <option value="MALE"
                                                                                {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                                                পুরুষ</option>
                                                                            <option value="FEMALE"
                                                                                {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                                                নারী</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessFather_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000"></span>পিতার
                                                                            নাম</label>
                                                                        <input name="witness[father][]"
                                                                            id="witnessFather_1"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $item->father ?? '' }}" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessPresentAddree_1"><span
                                                                                style="color:#FF0000">
                                                                            </span>মাতার নাম</label>
                                                                        <input name="witness[mother][]"
                                                                            id="witnessFather_1"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $item->mother ?? '' }}" readonly>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessPhn_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000">*
                                                                            </span>মোবাইল</label>
                                                                        <input name="witness[phn][]" id="witnessPhn_1"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $item->citizen_phone_no ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessNid_1"
                                                                            class="control-label"><span
                                                                                style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                                            পত্র</label>
                                                                        <input name="witness[nid][]" id="witnessNid_1"
                                                                            class="form-control form-control-sm"
                                                                            value="{{ $item->citizen_NID ?? '' }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="witnessPresentAddree_1"><span
                                                                                style="color:#FF0000">*
                                                                            </span>ঠিকানা</label>
                                                                        <textarea id="witnessPresentAddree_1" name="witness[presentAddress][]" rows="5"
                                                                            class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false" readonly>{{ $item->present_address ?? '' }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            @endif
                            @if (isset($defaulerLawyerCitizen[0]->citizen_name) )
                            <div class="tab-pane fade" id="defaulerLawyerCitizen" role="tabpanel" aria-labelledby="lawyer-tab">
                                <div class="panel panel-info radius-none ">
                                    {{-- <div class="panel-heading radius-none"> --}}
                                    {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
                                    {{-- </div> --}}
                                    <div class="panel-body">
                                        <div class="clearfix">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerName_1" class="control-label"><span
                                                                style="color:#FF0000"></span>বিবাদী পক্ষের আইনজীবীর
                                                            নাম</label>
                                                        <input name="lawyer[name]" id="lawyerName_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->citizen_name }}">
                                                        <input type="hidden" name="lawyer[type]"
                                                            class="form-control form-control-sm" value="4">
                                                        <input type="hidden" name="lawyer[id]" id="lawyerId_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->id }}">
                                                        <input type="hidden" name="lawyer[email]" id="lawyerEmail_1"
                                                            class="form-control form-control-sm" value="">
                                                        <input type="hidden" name="lawyer[thana]" id="lawyerThana_1"
                                                            class="form-control form-control-sm" value="">
                                                        <input type="hidden" name="lawyer[upazilla]"
                                                            id="lawyerUpazilla_1" class="form-control form-control-sm"
                                                            value="">
                                                        <input type="hidden" name="lawyer[age]" id="lawyerAge_1"
                                                            class="form-control form-control-sm" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerPhn_1" class="control-label">মোবাইল</label>
                                                        <input name="lawyer[phn]" id="lawyerPhn_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->citizen_phone_no }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerNid_1" class="control-label"><span
                                                                style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                            পত্র</label>
                                                        <input name="lawyer[nid]" id="lawyerNid_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->citizen_NID }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerGender_1"
                                                            class="control-label">লিঙ্গ</label>
                                                        <select style="width: 100%;"
                                                            class="selectDropdown form-control form-control-sm form-control-sm"
                                                            name="lawyer[gender]" id="lawyerGender_1">
                                                            <option value="">বাছাই করুন</option>
                                                            <option value="MALE"
                                                                {{ $defaulerLawyerCitizen[0]->citizen_gender == 'MALE' ? 'selected' : '' }}>
                                                                পুরুষ</option>
                                                            <option value="FEMALE"
                                                                {{ $defaulerLawyerCitizen[0]->citizen_gender == 'FEMALE' ? 'selected' : '' }}>
                                                                নারী</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerFather_1" class="control-label"><span
                                                                style="color:#FF0000"></span>পিতার নাম</label>
                                                        <input name="lawyer[father]" id="lawyerFather_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->father }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerMother_1" class="control-label"><span
                                                                style="color:#FF0000"></span>মাতার নাম</label>
                                                        <input name="lawyer[mother]" id="lawyerMother_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->mother }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerDesignation_1" class="control-label"><span
                                                                style="color:#FF0000"></span>পদবি</label>
                                                        <input name="lawyer[designation]" id="lawyerDesignation_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->designation }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerOrganization_1" class="control-label"><span
                                                                style="color:#FF0000"></span>প্রতিষ্ঠানের
                                                            নাম</label>
                                                        <input name="lawyer[organization]" id="lawyerOrganization_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->organization }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerPresentAddree_1"><span
                                                                style="color:#FF0000">*
                                                            </span>ঠিকানা</label>
                                                        <textarea id="lawyerPresentAddree_1" name="lawyer[presentAddress]" rows="5"
                                                            class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false">{{ $defaulerLawyerCitizen[0]->present_address ?? '-' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="lawyerEmail_1"><span style="color:#FF0000">
                                                            </span>ইমেইল</label>
                                                        <input type="email" name="lawyer[email]" id="lawyerEmail_1"
                                                            class="form-control form-control-sm"
                                                            value="{{ $defaulerLawyerCitizen[0]->email ?? '-' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                            <div class="tab-pane fade active show" id="reportInvestigation" role="tabpanel"
                                aria-labelledby="lawyer-tab">

                                {{-- <div class="mx-auto py-5">
                                <h3 class="mt-3"><span class="p-3 invertigation_report">তদন্ত প্রতিবেদন</span></h3>
                            </div> --}}

                                <div class="p-5 m-5">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (Session::has('withError'))
                                        <div class="alert alert-danger">
                                            {{ Session::get('withError') }}
                                        </div>
                                    @endif


                                    @php
                                        
                                        $investigator = DB::table('em_investigators')
                                            ->where('id', '=', decrypt($investigator_id))
                                            ->first();
                                        
                                        $case_no = DB::table('em_appeals')
                                            ->select('case_no')
                                            ->where('id', '=', decrypt($id))
                                            ->first();
                                        
                                    @endphp
                                    <form method="post" action="{{ route('investigator.form.submit') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" value="{{ decrypt($id) }}" name="appeal_id">
                                        <input type="hidden" value="{{ decrypt($investigator_id) }}"
                                            name="investigator_id">

                                        <div class="mb-2 pb-2">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">নাম <span
                                                        style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword"
                                                        name="full_name" value="{{ $investigator->name }}">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">অফিসের নাম
                                                    <span style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword"
                                                        name="office_name" value="{{ $investigator->organization }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2 pb-2">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">বিয়য় <span
                                                        style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword"
                                                        name="subject">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">কেস নং <span
                                                        style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword"
                                                        name="case_no" value="{{ $case_no->case_no }}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-2 pb-2">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">তারিখ</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control"
                                                        name="report_after_verification_date_show"
                                                        value="{{ date('d/m/Y', strtotime(now())) }}" readonly>

                                                    <input type="hidden" name="report_after_verification_date"
                                                        value="{{ date('m/d/Y', strtotime(now())) }}">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">স্মারক নং <span
                                                        style="color: red">*</span></label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="inputPassword"
                                                        name="memorial_no">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">

                                                <div class="col-md-12 mb-5">
                                                    <fieldset>
                                                        <legend>সংযুক্তি</legend>
                                                        <div class="form-group" id="step1Content">
                                                            <label>তদন্ত সংযুক্তি (মূল প্রতিবেদন) <span style="color: red">
                                                                    ***
                                                                </span> </label>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        placeholder="ফাইলের নাম দিন" id=""
                                                                        value="তদন্ত সংযুক্তি (মূল প্রতিবেদন)">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="custom-file"><input type="file"
                                                                            name="show_cause[]" class="custom-file-input"
                                                                            id="main_file_input"
                                                                            onChange="attachmentTitleMainReport()" /><label
                                                                            class="custom-file-label custom-input"
                                                                            for="">ফাইল নির্বাচন করুন </label>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="form-group">
                                                            <label>অন্যান্য সংযুক্তির </label>
                                                            <table class="table" width="100%" border="1"
                                                                id="fileDiv" style="border:1px solid #dcd8d8;">
                                                                <thead class="thead-light">
                                                                    <th scope="col">সংযুক্তির নাম <span
                                                                            class="text-danger">*</span></th>
                                                                    <th scope="col">সংযুক্তি যুক্ত করুন (যদি থাকে)
                                                                        পাশের
                                                                        (+) থেকে একাধিক ফাইল দিতে পারবেন</th>
                                                                    <th scope="col" width="50">
                                                                        <a href="javascript:void();" id="addFileRow"
                                                                            class="btn btn-sm btn-primary font-weight-bolder pr-2"><i
                                                                                class="fas fa-plus-circle"></i></a>
                                                                    </th>
                                                                </thead>
                                                                <tr></tr>
                                                            </table>
                                                        </div>
                                                        <input type="hidden" id="other_attachment_count"
                                                            value="1">
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-12 mb-5">
                                                    <fieldset>
                                                        <legend>মন্তব্য (যদি থাকে)</legend>
                                                        <div class="col-lg-12 mb-5">
                                                            <label></label>
                                                            <textarea name="investigation_comments" class="form-control" id="comments" rows="6" spellcheck="false"></textarea>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>

                                        </div>
                                        <table width="100%" class="border-0 p-5 " id="fileDiv"
                                            style="border:1px solid #dcd8d8;">
                                            <tr></tr>
                                        </table>
                                        <input type="hidden" id="other_attachment_count" value="1">
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary ps-5 me-5">প্রেরণ</button>
                                        </div>
                                    </form>
                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--end::Card-->
        @include('Investigation.InvestigatorCreate_Js')
    @endsection

    {{-- Includable CSS Related Page --}}
    @section('styles')
        <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
        <!--end::Page Vendors Styles-->
    @endsection

    {{-- Scripts Section Related Page --}}

    @section('scripts')
    @endsection
