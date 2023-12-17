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

                 {{-- @if (!empty($victimCitizen)) --}}
                 <li class="nav-item" id="tab_victim" style="<?php echo $display; ?>">
                     <a class="nav-link px-0" id="regTab4" data-toggle="tab" href="#regTab_4">
                         <span class="nav-icon">
                             <i class="flaticon2-chat-1"></i>
                         </span>
                         <span class="nav-text">ভিক্টিমের তথ্য</span>
                     </a>
                 </li>
                 {{-- @endif --}}
                 <li class="nav-item">
                     <a class="nav-link px-0" id="regTab2" data-toggle="tab" href="#regTab_2">
                         <span class="nav-icon">
                             <i class="flaticon2-chat-1"></i>
                         </span>
                         <span class="nav-text">২য় পক্ষ </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link px-0" id="regTab3" data-toggle="tab" href="#regTab_3">
                         <span class="nav-icon">
                             <i class="flaticon2-chat-1"></i>
                         </span>
                         <span class="nav-text">সাক্ষীর তথ্য </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link px-0" id="regTab5" data-toggle="tab" href="#regTab_5">
                         <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                         <span class="nav-text">আইনজীবীর তথ্য </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link px-0" id="regTab5" data-toggle="tab" href="#regTab_7">
                         <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                         <span class="nav-text">২য় পক্ষের সাক্ষীর তথ্য </span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link px-0" id="regTab5" data-toggle="tab" href="#regTab_8">
                         <span class="nav-icon"><i class="flaticon2-chat-1"></i></span>
                         <span class="nav-text">২য় পক্ষের আইনজীবীর তথ্য </span>
                     </a>
                 </li>
             </ul>
             <hr>
             <div class="tab-content mt-5" id="myTabContent4">
                 <div role="tabpanel" aria-labelledby="regTab0" class="tab-pane fade show active" id="regTab_0">
                     <div class="panel panel-info radius-none">
                         <div class="panel-body">
                             <div class="clearfix">
                                 <input type="hidden" id="new" class="caseEntryType mr-2" value="others"
                                     name="caseEntryType">


                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label for="caseNo" class="control-label">মামলা
                                                 নম্বর</label>
                                             <input name="caseNo" id="caseNo" class="form-control form-control-sm"
                                                 value="{{ $appeal->case_no ?? '' }}" readonly />
                                         </div>
                                     </div>

                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label>আবেদনের তারিখ <span class="text-danger">*</span></label>
                                             <input type="text" name="caseDate" id="case_date"
                                                 value="{{ date('d-m-Y', strtotime($appeal->case_date)) ?? '' }}"
                                                 class="form-control form-control-sm " placeholder="দিন/মাস/তারিখ"
                                                 autocomplete="off" readonly>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label for="lawSection" class="control-label">অভিযোগের
                                                 ধরণ <span class="text-danger">*</span><span
                                                     id="link"></span></label>
                                             <select class="form-control"" name="lawSection">

                                                 @foreach ($laws as $value)
                                                     <option value="{{ $value->id }}"
                                                         {{ $value->id == $appeal->law_section ? 'selected' : 'disabled' }}>
                                                         {{ $value->crpc_name }} </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label for="lawSection" class="control-label">বিভাগ
                                             </label>
                                             <!-- <input name="lawSection" id="lawSection" class="form-control form-control-sm"
                                                                                value="সরকারি পাওনা আদায় আইন, ১৯১৩ এর ৫ ধারা"> -->
                                             <select name="division" id="division_id"
                                                 class="form-control form-control-sm">

                                                 @foreach ($divisionId as $value)
                                                     <option value="{{ $value->id }}"
                                                         {{ $value->id == $appeal->division_id ? 'selected' : 'disabled' }}>
                                                         {{ $value->division_name_bn }} </option>
                                                 @endforeach
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
                                                 <!-- <span id="loading"></span> -->

                                                 @foreach ($districtId as $value)
                                                     <option value="{{ $value->id }}"
                                                         {{ $value->id == $appeal->district_id ? 'selected' : 'disabled' }}>
                                                         {{ $value->district_name_bn }} </option>
                                                 @endforeach
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
                                                 <!-- <span id="loading"></span> -->

                                                 @foreach ($upazilaId as $value)
                                                     <option value="{{ $value->id }}"
                                                         {{ $value->id == $appeal->upazila_id ? 'selected' : 'disabled' }}>
                                                         {{ $value->upazila_name_bn }} </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="row">
                                     <div class="col-lg-12 mb-5">
                                         <label for="case_details" class="control-label">অভিযোগের
                                             বিবরণ</label>
                                         <textarea class="form-control" name="case_details" id="exampleFormControlTextarea1" rows="5" readonly>{{ str_replace('&nbsp;', '', strip_tags($appeal->case_details)) }}</textarea>

                                     </div>
                                 </div>


                             </div>
                         </div>
                     </div>
                 </div>
                 <div role="tabpanel" aria-labelledby="regTab1" class="tab-pane fade" id="regTab_1">
                     <div class="panel panel-info radius-none">
                         <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true"
                             class="panel-group notesDiv">
                             <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                 <div class="card-body">
                                     <div class="clearfix">

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="applicantName_1" class="control-label">আবেদনকারীর
                                                         নাম</label>
                                                     <input name="applicant[name]" id="applicantName_1"
                                                         class="form-control form-control-sm name-group"
                                                         value="{{ $applicantCitizen[0]->citizen_name ?? '' }}"
                                                         readonly>
                                                     <input type="hidden" name="applicant[type]"
                                                         class="form-control form-control-sm" value="1">
                                                     <input type="hidden" name="applicant[id]" id="applicantId_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $applicantCitizen[0]->id ?? '' }}" readonly>
                                                     <input type="hidden" name="applicant[thana]"
                                                         id="applicantThana_1" class="form-control form-control-sm"
                                                         value="">
                                                     <input type="hidden" name="applicant[upazilla]"
                                                         id="applicantUpazilla_1" class="form-control form-control-sm"
                                                         value="">
                                                     <input type="hidden" name="applicant[age]" id="applicantAge_1"
                                                         class="form-control form-control-sm" value="">
                                                     <input type="hidden" name="applicant[organization_id]"
                                                         id="applicantOrganizationId_1" class="form-control "
                                                         value="">
                                                     <input type="hidden" name="applicant[organization]"
                                                         id="applicantOrganization_1" class="form-control "
                                                         value="">
                                                     <input type="hidden" name="applicant[designation]"
                                                         id="applicantDesignation_1" class="form-control "
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

                                                         <option value="MALE"
                                                             {{ $applicantCitizen[0]->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                             পুরুষ</option>
                                                         <option value="FEMALE"
                                                             {{ $applicantCitizen[0]->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
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
                                                     <input name="applicant[father]" id="applicantFather_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $applicantCitizen[0]->father ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="applicantMother_1" class="control-label"><span
                                                             style="color:#FF0000"></span>মাতার নাম</label>
                                                     <input name="applicant[mother]" id="applicantMother_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $applicantCitizen[0]->mother ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="applicantNid_1" class="control-label"><span
                                                             style="color:#FF0000">* </span>জাতীয় পরিচয়
                                                         পত্র</label>
                                                     <input name="applicant[nid]" id="applicantNid_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $applicantCitizen[0]->citizen_NID ?? '' }}"
                                                         readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="applicantPhn_1" class="control-label"><span
                                                             style="color:#FF0000">*
                                                         </span>মোবাইল</label>
                                                     <input name="applicant[phn]" id="applicantPhn_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $applicantCitizen[0]->citizen_phone_no ?? '' }}"
                                                         readonly>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="applicantPresentAddree_1"><span
                                                             style="color:#FF0000">*
                                                         </span>ঠিকানা</label>
                                                     <textarea id="applicantPresentAddree_1" name="applicant[presentAddress]" rows="5"
                                                         class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false" readonly>{{ $applicantCitizen[0]->present_address ?? '' }}</textarea>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="applicantEmail_1"><span style="color:#ff0000d8">
                                                         </span>ইমেইল</label>
                                                     <input type="email" name="applicant[email]"
                                                         id="applicantEmail_1" class="form-control form-control-sm"
                                                         value="{{ $applicantCitizen[0]->email ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </section>
                         </div>
                     </div>
                 </div>
                 <div role="tabpanel" aria-labelledby="regTab2" class="tab-pane fade" id="regTab_2">
                     <div class="panel panel-info radius-none">
                         <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true"
                             class="panel-group notesDiv">

                             <section class="panel panel-primary defaulterInfo" id="defaulterInfo">
                                 <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                     @forelse ($defaulterCitizen as $key => $item)
                                         @php
                                             $count = ++$key;
                                         @endphp
                                         <div id="clonedefaulter" class="card">
                                             <input type="hidden" id="defaulterCount" value="1">
                                             <div class="card-header" id="headingOne3">
                                                 <div class="card-title h4" data-toggle="collapse"
                                                     data-target="#collapseOne3{{ $count }}">
                                                     ২য় পক্ষের তথ্য &nbsp; <span
                                                         id="spannCount">({{ $count }})</span>
                                                 </div>
                                             </div>
                                             <div id="collapseOne3{{ $count }}"
                                                 class="collapse {{ $count == 1 ? 'show' : '' }}"
                                                 data-parent="#accordionExample3">
                                                 <div class="card-body">
                                                     <div class="clearfix">

                                                         @if (empty($item->citizen_NID))
                                                             @php
                                                                 $readonly = '';
                                                             @endphp
                                                             <div class="row">
                                                                 <div class="col-md-12">
                                                                     <div class="text-dark font-weight-bold">
                                                                         <label for="">জাতীয় পরিচয়পত্র যাচাই :
                                                                         </label>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-md-3">
                                                                     <div class="form-group">
                                                                         <input required type="text"
                                                                             {{-- id="applicantCiNID_1" --}}
                                                                             class="form-control edit_check_nid_number_{{ $count }} "
                                                                             data-row-index='0'
                                                                             placeholder="উদাহরণ- 19825624603112948"
                                                                             id="edit_check_nid_number_{{ $count }}">
                                                                         <span id="res_applicant_1"></span>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-md-3">
                                                                     <div class="form-group">
                                                                         <div class="input-group">
                                                                             <input required type="text"
                                                                                 id="edit_check_dob_number_{{ $count }}"
                                                                                 placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                                                                                 {{-- id="dob" --}}
                                                                                 class="form-control common_datepicker_edit_nid edit_check_dob_number_{{ $count }}"
                                                                                 autocomplete="off"
                                                                                 data-row-index='0'>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                                 
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="button"
                                                                                 id="{{ $count }}"
                                                                                 data-row-index='0'
                                                                                 class="btn btn-primary check_nid_button"
                                                                                 onclick="NIDCHECKEDITDEFAULTER(this.id)"
                                                                                 value="  যাচাই করুন">
                                                                    </div>
                                                                </div>
                                                             </div>
                                                         @else
                                                             @php
                                                                 $readonly = 'readonly';
                                                             @endphp
                                                         @endif

                                                         <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="defaulterName_1"
                                                                         class="control-label">নাম</label>
                                                                     <input name="defaulter[name][]"
                                                                         class="form-control form-control-sm name-group nid_data_pull_warning_old"
                                                                         value="{{ $item->citizen_name ?? '' }}"
                                                                         id="edit_defaulter_name_{{ $count }}"
                                                                         readonly>
                                                                     <input type="hidden" name="defaulter[type][]"
                                                                         class="form-control form-control-sm"
                                                                         value="2">
                                                                     <input type="hidden" name="defaulter[id][]"
                                                                         id="defaulterId_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->id ?? '' }}" readonly>
                                                                     <input type="hidden" name="defaulter[thana][]"
                                                                         id="defaulterThana_1"
                                                                         class="form-control form-control-sm"
                                                                         value="">
                                                                     <input type="hidden"
                                                                         name="defaulter[upazilla][]"
                                                                         id="defaulterUpazilla_1"
                                                                         class="form-control form-control-sm"
                                                                         value="">
                                                                     <input type="hidden" name="defaulter[age][]"
                                                                         id="defaulterAge_1"
                                                                         class="form-control form-control-sm"
                                                                         value="">
                                                                     <input type="hidden"
                                                                         name="defaulter[organization_id][]"
                                                                         id="defaulterOrganizationId_1"
                                                                         class="form-control " value="">
                                                                     <input type="hidden"
                                                                         name="defaulter[organization]"
                                                                         id="defaulterOrganization_1"
                                                                         class="form-control " value="">
                                                                     <input type="hidden"
                                                                         name="defaulter[designation]"
                                                                         id="defaulterDesignation_1"
                                                                         class="form-control " value="">
                                                                 </div>
                                                             </div>

                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="defaulterGender_1"
                                                                         class="control-label">লিঙ্গ</label>
                                                                     <select style="width: 100%;"
                                                                         class="selectDropdown form-control form-control-sm nid_data_pull_warning_old"
                                                                         name="defaulter[gender][]"
                                                                         id="edit_defaulter_gender_{{ $count }}">

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
                                                                     <label for="defaulterFather_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000"></span>পিতার
                                                                         নাম</label>
                                                                     <input name="defaulter[father][]"
                                                                         class="form-control form-control-sm nid_data_pull_warning_old"
                                                                         value="{{ $item->father ?? '' }}"
                                                                         id="edit_defaulter_father_{{ $count }}"
                                                                         readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="defaulterMother_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000"></span>মাতার
                                                                         নাম</label>
                                                                     <input name="defaulter[mother][]"
                                                                         class="form-control form-control-sm nid_data_pull_warning_old"
                                                                         value="{{ $item->mother ?? '' }}"
                                                                         id="edit_defaulter_mother_{{ $count }}"
                                                                         readonly>
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
                                                                     <input name="defaulter[nid][]"
                                                                         class="form-control form-control-sm nid_data_pull_warning_old"
                                                                         value="{{ $item->citizen_NID ?? '' }}"
                                                                         id="edit_defaulter_nid_{{ $count }}"
                                                                         readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="defaulterPhn_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000">*
                                                                         </span>মোবাইল</label>
                                                                     <input name="defaulter[phn][]"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->citizen_phone_no ?? '' }}"
                                                                         id="edit_defaulter_mobile_{{ $count }}"
                                                                         {{ $readonly }}>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="defaulterPresentAddree_1"><span
                                                                             style="color:#FF0000">*
                                                                         </span>ঠিকানা</label>
                                                                     <textarea name="defaulter[presentAddress][]" rows="5"
                                                                         class="form-control element-block blank nid_data_pull_warning_old" aria-describedby="note-error" aria-invalid="false"
                                                                         readonly id="edit_defaulter_present_address_{{ $count }}">{{ $item->present_address ?? '' }}</textarea>
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="defaulterEmail_1"><span
                                                                             style="color:#ff0000d8">
                                                                         </span>ইমেইল</label>
                                                                     <input id="edit_defaulter_email_{{ $count }}" type="email" name="defaulter[email][]"
                                                                       
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->email ?? '' }}"
                                                                         {{ $readonly }}
                                                                         >
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

                         {{-- <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="RemoveDefaulter" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddDefaulter" type="button" class="btn btn-primary">
                                                        ২য় পক্ষ যোগ করুন
                                                    </button>
                                                </div> --}}
                     </div>
                 </div>
                 <div role="tabpanel" aria-labelledby="regTab3" class="tab-pane fade" id="regTab_3">
                     <div class="panel panel-info radius-none ">
                         <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true"
                             class="panel-group notesDiv">
                             <section class="panel panel-primary witnessInfo" id="witnessInfo">
                                 <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                     @forelse ($witnessCitizen as $key => $item)
                                         @php
                                             $count = ++$key;
                                         @endphp
                                         <div id="clonewitness" class="card">
                                             <input type="hidden" id="WitnessCount" value="1">
                                             <div class="card-header" id="headingOne3">
                                                 <div class="card-title h4" data-toggle="collapse"
                                                     data-target="#collapseOne4{{ $count }}">
                                                     সাক্ষীর তথ্য &nbsp; <span
                                                         id="spannCount">({{ $count }})</span>
                                                 </div>
                                             </div>

                                             <div id="collapseOne4{{ $count }}"
                                                 class="collapse {{ $count == 1 ? 'show' : '' }}"
                                                 data-parent="#accordionExample3">
                                                 <div class="card-body">
                                                     <div class="clearfix">

                                                         <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="witnessName_1"
                                                                         class="control-label">সাক্ষীর নাম</label>
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
                                                                     <input type="hidden"
                                                                         name="witness[organization]"
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
                                                                         name="witness[gender][]"
                                                                         id="witnessGender_1">

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
                             </section>
                         </div>
                         {{-- <div style="text-align: right;margin: 10px;">
                                                    <button type="button" id="Removewitness" class="btn btn-danger">
                                                        বাতিল
                                                    </button>
                                                    <button id="AddWitness" type="button" class="btn btn-primary">
                                                        সাক্ষী যোগ করুন
                                                    </button>
                                                </div> --}}

                     </div>
                 </div>

                 <div role="tabpanel" aria-labelledby="regTab5" class="tab-pane fade" id="regTab_5">
                     <div class="panel panel-info radius-none">
                         <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true"
                             class="panel-group notesDiv">
                             <section class="panel panel-primary applicantInfo" id="applicantInfo">
                                 <div class="card-body">
                                     <div class="clearfix">

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label"><span
                                                             style="color:#FF0000"></span>আইনজীবীর
                                                         নাম</label>
                                                     <input name="lawyer[name]" id="lawyerName_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->citizen_name ?? '' }}" readonly>
                                                     <input type="hidden" name="lawyer[type]"
                                                         class="form-control form-control-sm" value="4">
                                                     <input type="hidden" name="lawyer[id]" id="lawyerId_1"
                                                         class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->id ?? '' }}" readonly>
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
                                                     <label class="control-label"><span style="color:#FF0000">
                                                         </span>মোবাইল</label>
                                                     {{-- <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text">+8801</span></div>
                                                </div> --}}
                                                     <input name="lawyer[phn]" class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->citizen_phone_no ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label"><span style="color:#FF0000">*
                                                         </span>জাতীয় পরিচয় পত্র</label>
                                                     <input name="lawyer[nid]" class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->citizen_NID ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                             {{-- @php 
                                                 dd($lawerCitizen->citizen_gender);
                                       @endphp --}}
                                             <div class="col-md-3">
                                                 <div class="form-group">
                                                     <label class="control-label"><span
                                                             style="color:#FF0000"></span>লিঙ্গ</label><br>
                                                     <select style="width: 100%;"
                                                         class="selectDropdown form-control form-control-sm"
                                                         name="lawyer[gender]">

                                                         <option value="MALE"
                                                             {{ $lawerCitizen->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                             পুরুষ</option>
                                                         <option value="FEMALE"
                                                             {{ $lawerCitizen->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                             নারী</option>
                                                     </select>

                                                 </div>
                                             </div>

                                             <div class="col-md-3">
                                                 <div class="form-group">
                                                     <label class="control-label"> <span
                                                             style="color:#FF0000"></span>প্রাতিষ্ঠানিক আইডি </label>
                                                     <input name="lawyer[organization_id]"
                                                         class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->organization_id ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label"><span
                                                             style="color:#FF0000"></span>পিতার নাম</label>
                                                     <input name="lawyer[father]" class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->father ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label"><span
                                                             style="color:#FF0000"></span>মাতার নাম</label>
                                                     <input name="lawyer[mother]" class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->mother ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>

                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label"><span
                                                             style="color:#FF0000"></span>পদবি</label>
                                                     <input name="lawyer[designation]"
                                                         class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->designation ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label class="control-label"><span
                                                             style="color:#FF0000"></span>প্রতিষ্ঠানের নাম</label>
                                                     <input name="lawyer[organization]"
                                                         class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->organization ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label><span style="color:#FF0000"></span>ঠিকানা</label>
                                                     <textarea name="lawyer[presentAddress]" rows="5" class="form-control element-block blank" readonly>{{ $lawerCitizen->present_address ?? '' }}</textarea>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label>ইমেইল</label>
                                                     <input type="email" name="lawyer[email]"
                                                         class="form-control form-control-sm"
                                                         value="{{ $lawerCitizen->email ?? '' }}" readonly>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </section>
                         </div>
                     </div>
                 </div>

                 <div role="tabpanel" aria-labelledby="regTab4" class="tab-pane fade" id="regTab_4">
                     <div class="panel panel-info radius-none">
                         <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true"
                             class="panel-group notesDiv">
                             <section class="panel panel-primary victimInfo" id="victimInfo">
                                 <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                     @forelse ($victimCitizen as $key => $item)
                                         @php
                                             $count = ++$key;
                                         @endphp
                                         <div id="clonevictim" class="card">
                                             <input type="hidden" id="victimCount" value="1">
                                             <div id="collapseOne3{{ $count }}"
                                                 class="collapse {{ $count == 1 ? 'show' : '' }}"
                                                 data-parent="#accordionExample3">
                                                 <div class="card-body">
                                                     <div class="clearfix">

                                                         <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimName_1"
                                                                         class="control-label">ভিক্টিমের নাম</label>
                                                                     <input name="victim[name]" id="victimName_1"
                                                                         class="form-control form-control-sm name-group"
                                                                         value="{{ $item->citizen_name ?? '' }}"
                                                                         readonly>
                                                                     <input type="hidden" name="victim[type]"
                                                                         class="form-control form-control-sm"
                                                                         value="8">
                                                                     <input type="hidden" name="victim[id]"
                                                                         id="victimId_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->id ?? '' }}" readonly>
                                                                     <input type="hidden" name="victim[thana]"
                                                                         id="victimThana_1"
                                                                         class="form-control form-control-sm"
                                                                         value="">
                                                                     <input type="hidden" name="victim[upazilla]"
                                                                         id="victimUpazilla_1"
                                                                         class="form-control form-control-sm"
                                                                         value="">
                                                                     <input type="hidden" name="victim[age]"
                                                                         id="victimAge_1"
                                                                         class="form-control form-control-sm"
                                                                         value="">
                                                                     <input type="hidden"
                                                                         name="victim[organization_id]"
                                                                         id="victimOrganizationId_1"
                                                                         class="form-control " value="">
                                                                     <input type="hidden" name="victim[organization]"
                                                                         id="victimOrganization_1"
                                                                         class="form-control " value="">
                                                                     <input type="hidden" name="victim[designation]"
                                                                         id="victimDesignation_1"
                                                                         class="form-control " value="">
                                                                 </div>
                                                             </div>

                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimGender_1"
                                                                         class="control-label">লিঙ্গ</label>
                                                                     <select style="width: 100%;"
                                                                         class="selectDropdown form-control form-control-sm"
                                                                         name="victim[gender]" id="victimGender_1">

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
                                                                     <label for="victimFather_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000"></span>পিতার
                                                                         নাম</label>
                                                                     <input name="victim[father]" id="victimFather_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->father ?? '' }}">
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimMother_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000"></span>মাতার
                                                                         নাম</label>
                                                                     <input name="victim[mother]" id="victimMother_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->mother ?? '' }}" readonly>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimNid_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000"></span>জাতীয় পরিচয়
                                                                         পত্র</label>
                                                                     <input name="victim[nid]" id="victimNid_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->citizen_NID ?? '' }}"
                                                                         readonly>
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimPhn_1"
                                                                         class="control-label"><span
                                                                             style="color:#FF0000">*
                                                                         </span>মোবাইল</label>
                                                                     <input name="victim[phn]" id="victimPhn_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->citizen_phone_no ?? '' }}"
                                                                         readonly>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimPresentAddree_1"><span
                                                                             style="color:#FF0000">*
                                                                         </span>ঠিকানা</label>
                                                                     <textarea id="victimPresentAddree_1" name="victim[presentAddress]" rows="5"
                                                                         class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false" readonly>{{ $item->present_address ?? '' }}</textarea>
                                                                 </div>
                                                             </div>
                                                             <div class="col-md-6">
                                                                 <div class="form-group">
                                                                     <label for="victimEmail_1"><span
                                                                             style="color:#ff0000d8">
                                                                         </span>ইমেইল</label>
                                                                     <input type="email" name="victim[email]"
                                                                         id="victimEmail_1"
                                                                         class="form-control form-control-sm"
                                                                         value="{{ $item->email ?? '' }}" readonly>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @empty
                                         <div class="clearfix">

                                             {{-- <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="text-dark font-weight-bold h4">
                                                                        <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input required type="text" id="victimCiNID_1" class="form-control" placeholder="উদাহরণ- 19825624603112948" name="victim[ciNID]">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input required type="text" id="victimDob_1" name="victim[dob]" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী)" id="dob" class="form-control common_datepicker" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input type="button" id="victimCCheck_1" name="victim[cCheck]" onclick="checkNomineeCitizen('victim', 1)" class="btn btn-danger" value="সন্ধান করুন"> <span class="ml-5" id="res_victim_1"></span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group" id="victim_nidPic_1"></div>
                                                                    </div>
                                                                </div> --}}
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimName_1" class="control-label">ভিক্টিমের
                                                             নাম</label>
                                                         <input name="victim[name]" id="victimName_1"
                                                             class="form-control form-control-sm name-group">
                                                         <input type="hidden" name="victim[type]"
                                                             class="form-control form-control-sm" value="8">
                                                         <input type="hidden" name="victim[id]" id="victimId_1"
                                                             class="form-control form-control-sm" value="">
                                                         <input type="hidden" name="victim[thana]"
                                                             id="victimThana_1" class="form-control form-control-sm"
                                                             value="">
                                                         <input type="hidden" name="victim[upazilla]"
                                                             id="victimUpazilla_1"
                                                             class="form-control form-control-sm" value="">
                                                         <input type="hidden" name="victim[age]" id="victimAge_1"
                                                             class="form-control form-control-sm" value="">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimGender_1"
                                                             class="control-label">লিঙ্গ</label>
                                                         <select style="width: 100%;"
                                                             class="selectDropdown form-control form-control-sm"
                                                             name="victim[gender]" id="victimGender_1">

                                                             <option value="MALE">পুরুষ</option>
                                                             <option value="FEMALE">নারী</option>
                                                         </select>
                                                     </div>
                                                 </div>

                                             </div>

                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimFather_1" class="control-label"><span
                                                                 style="color:#FF0000"></span>পিতার
                                                             নাম</label>
                                                         <input name="victim[father]" id="victimFather_1"
                                                             class="form-control form-control-sm" value="">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimMother_1" class="control-label"><span
                                                                 style="color:#FF0000"></span>মাতার
                                                             নাম</label>
                                                         <input name="victim[mother]" id="victimMother_1"
                                                             class="form-control form-control-sm" value="">
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimNid_1" class="control-label">জাতীয়
                                                             পরিচয়পত্র</label>
                                                         <input name="victim[nid]" id="victimNid_1"
                                                             class="form-control form-control-sm" value="">
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimPhn_1" class="control-label"><span
                                                                 style="color:#FF0000">*
                                                             </span>মোবাইল</label>
                                                         <input name="victim[phn]" id="victimPhn_1"
                                                             class="form-control form-control-sm" value="">
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="row">
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimPresentAddree_1"><span
                                                                 style="color:#FF0000">*
                                                             </span>ঠিকানা</label>
                                                         <textarea id="victimPresentAddree_1" name="victim[presentAddress]" rows="5"
                                                             class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                                     </div>
                                                 </div>
                                                 <div class="col-md-6">
                                                     <div class="form-group">
                                                         <label for="victimEmail_1">ইমেইল</label>
                                                         <input type="email" name="victim[email]"
                                                             id="victimEmail_1" class="form-control form-control-sm"
                                                             value="">
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     @endforelse
                                 </div>
                             </section>
                         </div>
                     </div>
                 </div>
                 @include('appealInitiate.inc.defaulter_withness')
                 @include('appealInitiate.inc.defaulter_lawyer')
             </div>
         </div>
     </div>
 </div>
