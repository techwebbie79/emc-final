@php
    if (!empty($defaulerLawyerCitizen)) {
        $readonly = 'readonly';
        $nid_data_pull_warning = '';
        $citizen_name=$defaulerLawyerCitizen[0]->citizen_name;
        $id=$defaulerLawyerCitizen[0]->id;
        $citizen_phone_no=$defaulerLawyerCitizen[0]->citizen_phone_no;
        $citizen_NID=$defaulerLawyerCitizen[0]->citizen_NID;
        $citizen_gender=$defaulerLawyerCitizen[0]->citizen_gender;
        $designation=$defaulerLawyerCitizen[0]->designation;
        $email=$defaulerLawyerCitizen[0]->email;
        $present_address=$defaulerLawyerCitizen[0]->present_address;
        $organization=$defaulerLawyerCitizen[0]->organization;
        $mother=$defaulerLawyerCitizen[0]->mother;
        $father=$defaulerLawyerCitizen[0]->father;
        $organization_id=$defaulerLawyerCitizen[0]->organization_id;
    } else {
        $readonly = '';
        $nid_data_pull_warning = 'nid_data_pull_warning';
        $citizen_name=null;
        $id=null;
        $citizen_phone_no=null;
        $citizen_NID=null;
        $citizen_gender=null;
        $designation=null;
        $email=null;
        $present_address=null;
        $organization=null;
        $mother=null;
        $father=null;
        $organization_id=null;
    }
@endphp

<div role="tabpanel" aria-labelledby="regTab8" class="tab-pane fade" id="defaulerLawyerCitizen">
    <div class="panel panel-info radius-none">
        <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
            <section class="panel panel-primary applicantInfo" id="applicantInfo">
                <div class="card-body">
                    <div class="clearfix">
                        @if (empty($defaulerLawyerCitizen))
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-dark font-weight-bold">
                                        <label for="">জাতীয় পরিচয়পত্র যাচাই :
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input required type="text" {{-- id="applicantCiNID_1" --}} class="form-control "
                                            data-row-index='0' placeholder="উদাহরণ- 19825624603112948"
                                            id="defaulerLawyer_nid_input_1">
                                        <span id="res_applicant_1"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input required type="text" id="defaulerLawyer_dob_input_1"
                                                placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                                                {{-- id="dob" --}}
                                                class="form-control common_datepicker_edit_nid edit_check_dob_number"
                                                autocomplete="off" data-row-index='0'>

                                            <input type="button" id="defaulerLawyer_btn_input_1" data-row-index='0'
                                                class="btn btn-primary check_nid_button"
                                                onclick="NIDCHECKdefaulerLawyer(this.id)" value="  যাচাই করুন">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif



                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>আইনজীবীর
                                        নাম</label>
                                    <input name="defaulerLawyer[name][]" id="defaulerLawyerName_1"
                                        class="form-control form-control-sm {{ $nid_data_pull_warning }}"
                                        value="{{ $citizen_name ?? '' }}" {{ $readonly }}>
                                    <input type="hidden" name="defaulerLawyer[type][]"
                                        class="form-control form-control-sm" value="4">
                                    <input type="hidden" name="defaulerLawyer[id]" id="defaulerLawyerId_1"
                                        class="form-control form-control-sm"
                                        value="{{ $id ?? '' }}" {{ $readonly }}>
                                    <input type="hidden" name="defaulerLawyer[thana][]" id="defaulerLawyerThana_1"
                                        class="form-control form-control-sm" value="">
                                    <input type="hidden" name="defaulerLawyer[upazilla][]" id="defaulerLawyerUpazilla_1"
                                        class="form-control form-control-sm" value="">
                                    <input type="hidden" name="defaulerLawyer[age][]" id="defaulerLawyerAge_1"
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
                                    <input name="defaulerLawyer[phn][]"
                                        class="form-control form-control-sm "
                                        value="{{ $citizen_phone_no ?? '' }}"
                                        {{ $readonly }}>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000">*
                                        </span>জাতীয় পরিচয় পত্র</label>
                                    <input name="defaulerLawyer[nid][]"
                                        class="form-control form-control-sm {{ $nid_data_pull_warning }}"
                                        id="defaulerLawyerNid_1"
                                        value="{{ $citizen_NID ?? '' }}" {{ $readonly }}>
                                </div>
                            </div>
                            {{-- @php 
                                dd($citizen_gender);
                      @endphp --}}
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                                    <select style="width: 100%;"
                                        class="selectDropdown form-control form-control-sm {{ $nid_data_pull_warning }}"
                                        name="defaulerLawyer[gender][]" id="defaulerLawyerGender_1">
                                           
                                        @if(!empty($defaulerLawyerCitizen))
                                        <option value="MALE"
                                            {{ $citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                            পুরুষ</option>
                                        <option value="FEMALE"
                                            {{ $citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                            নারী</option>
                                          @else
                                          <option value="MALE">পুরুষ</option>
                                      <option value="FEMALE">নারী</option>
                                        @endif
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label"> <span style="color:#FF0000"></span>প্রাতিষ্ঠানিক
                                        আইডি </label>
                                    <input name="defaulerLawyer[organization_id][]" class="form-control form-control-sm"
                                        value="{{ $organization_id ?? '' }}"
                                        {{ $readonly }}>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>পিতার নাম</label>
                                    <input name="defaulerLawyer[father][]"
                                        class="form-control form-control-sm {{ $nid_data_pull_warning }}"
                                        id="defaulerLawyerFather_1"
                                        value="{{ $father ?? '' }}" {{ $readonly }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>মাতার নাম</label>
                                    <input name="defaulerLawyer[mother][]"
                                        class="form-control form-control-sm {{ $nid_data_pull_warning }}"
                                        id="defaulerLawyerMother_1"
                                        value="{{ $mother ?? '' }}" {{ $readonly }}>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>পদবি</label>
                                    <input name="defaulerLawyer[designation][]" class="form-control form-control-sm"
                                        value="{{ $designation ?? '' }}"
                                        {{ $readonly }}>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>প্রতিষ্ঠানের
                                        নাম</label>
                                    <input name="defaulerLawyer[organization][]" class="form-control form-control-sm"
                                        value="{{ $organization ?? '' }}"
                                        {{ $readonly }}>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color:#FF0000"></span>ঠিকানা</label>
                                    <textarea name="defaulerLawyer[presentAddress][]" rows="5" id="defaulerLawyerPresentAddree_1"
                                        class="form-control element-block blank {{ $nid_data_pull_warning }}" {{ $readonly }}>{{ $present_address ?? '' }} </textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ইমেইল</label>
                                    <input type="email" name="defaulerLawyer[email][]"
                                        class="form-control form-control-sm"
                                        value="{{ $email ?? '' }}" {{ $readonly }}>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
