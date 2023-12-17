<div role="tabpanel" aria-labelledby="regTab7" class="tab-pane fade" id="regTab_7">
    <div class="panel panel-info radius-none ">

        {{-- <div class="panel-heading radius-none"> --}}
        {{-- <h4 class="panel-title">@lang('message.lawyerBlockHeading')</h4> --}}
        {{-- </div> --}}
        <div style="margin: 10px" id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
            <section class="panel panel-primary defaulerWithnessInfo" id="defaulerWithnessInfo">
                <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                    <input type="hidden" id="defaulerWithnessCount" value="{{ count($defaulerWithnessCitizen) }}">
                    @forelse ($defaulerWithnessCitizen as $key => $item)
                        @php
                            $count = ++$key;
                        @endphp
                        <div id="cloneNomenee" class="card">
                            <div class="card-header" id="headingOne3">
                                <div class="card-title h4 {{ $count == 1 ? '' : 'collapsed' }}" data-toggle="collapse"
                                    data-target="#collapseOne3{{ $count }}">
                                    ২য় পক্ষের সাক্ষীর তথ্য &nbsp; <span id="spannCount">({{ $count }})</span>
                                </div>
                            </div>
                            <div id="collapseOne3{{ $count }}" class="collapse {{ $count == 1 ? 'show' : '' }} "
                                data-parent="#accordionExample3">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessName_1" class="control-label"><span
                                                            style="color:#FF0000">*</span>২য় পক্ষের সাক্ষীর
                                                        নাম</label>
                                                    <input name="defaulerWithness[name][]" id="defaulerWithnessName_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->citizen_name }}" readonly>
                                                    <input type="hidden" name="defaulerWithness[type][]"
                                                        class="form-control form-control-sm" value="6">
                                                    <input type="hidden" name="defaulerWithness[id][]"
                                                        id="defaulerWithnessId_1" class="form-control form-control-sm"
                                                        value="{{ $item->id }}">

                                                    <input type="hidden" name="defaulerWithness[thana][]"
                                                        id="defaulerWithnessThana_1"
                                                        class="form-control form-control-sm" value="">
                                                    <input type="hidden" name="defaulerWithness[upazilla][]"
                                                        id="defaulerWithnessUpazilla_1"
                                                        class="form-control form-control-sm" value="">
                                                    <input type="hidden" name="defaulerWithness[designation][]"
                                                        id="defaulerWithnessDesignation_1"
                                                        class="form-control form-control-sm" value="">
                                                    <input type="hidden" name="defaulerWithness[organization][]"
                                                        id="defaulerWithnessOrganization_1"
                                                        class="form-control form-control-sm" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessPhn_1" class="control-label"><span
                                                            style="color:#FF0000">*</span>মোবাইল</label>
                                                    <input name="defaulerWithness[phn][]" id="defaulerWithnessPhn_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->citizen_phone_no }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessNid_1" class="control-label"><span
                                                            style="color:#FF0000">*</span>জাতীয়
                                                        পরিচয় পত্র</label>
                                                    <input name="defaulerWithness[nid][]" id="defaulerWithnessNid_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->citizen_NID }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessGender_1" class="control-label">নারী /
                                                        পুরুষ</label>
                                                    <select style="width: 100%;"
                                                        class="selectDropdown form-control form-control-sm"
                                                        name="defaulerWithness[gender][]" id="defaulerWithnessGender_1">

                                                        <option value="MALE"
                                                            {{ $item->citizen_gender == 'MALE' ? 'selected' : 'disabled' }}>
                                                            পুরুষ</option>
                                                        <option value="FEMALE"
                                                            {{ $item->citizen_gender == 'FEMALE' ? 'selected' : 'disabled' }}>
                                                            নারী</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input name="defaulerWithness[organization_id][]"
                                                id="defaulerWithnessOrganizationID_1" type="hidden">
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessFather_1" class="control-label"><span
                                                            style="color:#FF0000"></span>পিতার
                                                        নাম</label>
                                                    <input name="defaulerWithness[father][]"
                                                        id="defaulerWithnessFather_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->father }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessMother_1" class="control-label"><span
                                                            style="color:#FF0000"></span>মাতার
                                                        নাম</label>
                                                    <input name="defaulerWithness[mother][]"
                                                        id="defaulerWithnessMother_1"
                                                        class="form-control form-control-sm"
                                                        value="{{ $item->mother }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessPresentAddree_1"><span
                                                            style="color:#FF0000">*</span>ঠিকানা</label>
                                                    <textarea id="defaulerWithnessPresentAddree_1" name="defaulerWithness[presentAddress][]" rows="3"
                                                        class="form-control form-control-sm element-block blank" aria-describedby="note-error" aria-invalid="false"
                                                        readonly>{{ $item->present_address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="cloneNomenee" class="card">
                            <input type="hidden" id="defaulerWithnessCount" value="1">
                            <div class="card-header" id="headingOne3">
                                <div class="card-title h4" data-toggle="collapse" data-target="#collapseOne3">
                                    ২য় পক্ষের সাক্ষীর তথ্য &nbsp; <span id="spannCount">(1)</span>
                                </div>
                            </div>
                            <div id="collapseOne3" class="collapse show" data-parent="#accordionExample3">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-dark font-weight-bold">
                                                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input required type="text" {{-- id="applicantCiNID_1" --}}
                                                        class="form-control check_nid_number_0" data-defaulerwithnessrowindex='1'
                                                        placeholder="উদাহরণ- 19825624603112948" id="defaulerWithness_nid_input_1"
                                                        onclick="addDatePicker(this.id)">
                                                    <span id="res_applicant_1"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input required type="text" id="defaulerWithness_dob_input_1"
                                                            placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                                                            {{-- id="dob" --}} class="form-control common_datepicker_1"
                                                            autocomplete="off" >

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="button" id="defaulerWithness_nid_1" data-defaulerwithnessrowindex='1'
                                                        class="btn btn-primary check_nid_button"
                                                        onclick="NIDCHECKdefaulerWithness(this.id)" value="  যাচাই করুন">
                                                </div>
                                            </div>



                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessName_1" class="control-label"><span
                                                            style="color:#FF0000">*</span>২য় পক্ষের সাক্ষীর
                                                        নাম</label>
                                                    <input name="defaulerWithness[name][]" id="defaulerWithnessName_1"
                                                        class="form-control form-control-sm validation "
                                                        value="" >
                                                    <div class="required_message hide">This Field is required</div>
                                                    <input type="hidden" name="defaulerWithness[type][]"
                                                        class="form-control form-control-sm" value="6">
                                                    <input type="hidden" name="defaulerWithness[id][]"
                                                        id="defaulerWithnessId_1" class="form-control form-control-sm"
                                                        value="">
                                                    <input type="hidden" name="defaulerWithness[thana][]"
                                                        id="defaulerWithnessThana_1"
                                                        class="form-control form-control-sm" value="">
                                                    <input type="hidden" name="defaulerWithness[upazilla][]"
                                                        id="defaulerWithnessUpazilla_1"
                                                        class="form-control form-control-sm" value="">
                                                    <input type="hidden" name="defaulerWithness[designation][]"
                                                        id="defaulerWithnessDesignation_1"
                                                        class="form-control form-control-sm" value="">
                                                    <input type="hidden" name="defaulerWithness[organization][]"
                                                        id="defaulerWithnessOrganization_1"
                                                        class="form-control form-control-sm" value="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="defaulerWithnessPhn_1" class="control-label"><span
                                                            style="color:#FF0000">*</span>মোবাইল</label>
                                                    <input name="defaulerWithness[phn][]" id="defaulerWithnessPhn_1"
                                                        class="form-control form-control-sm phone validation"
                                                        value="" placeholder="ইংরেজিতে দিতে হবে" required>
                                                    <div class="required_message hide">This Field is required</div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="defaulerWithnessNid_1" class="control-label"><span
                                                        style="color:#FF0000"></span>জাতীয়
                                                    পরিচয় পত্র</label>
                                                <input type="text" name="defaulerWithness[nid][]" id="defaulerWithnessNid_1"
                                                    class="form-control form-control-sm validation "
                                                    value="" required >
                                                <div class="required_message hide">This Field is required</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="defaulerWithnessGender_1"
                                                    class="control-label">লিঙ্গ</label>
                                                <select style="width: 100%;" class="selectDropdown form-control"
                                                    name="defaulerWithness[gender][]" id="defaulerWithnessGender_1">

                                                    <option value="MALE">
                                                        পুরুষ</option>
                                                    <option value="FEMALE">
                                                        নারী</option>
                                                </select>
                                            </div>
                                        </div>

                                        <input name="defaulerWithness[organization_id][]"
                                            id="defaulerWithnessOrganizationID_1" type="hidden">

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="defaulerWithnessFather_1" class="control-label"><span
                                                        style="color:#FF0000">*</span>পিতার নাম</label>
                                                <input name="defaulerWithness[father][]" id="defaulerWithnessFather_1"
                                                    class="form-control form-control-sm "
                                                    value="" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="defaulerWithnessMother_1" class="control-label"><span
                                                        style="color:#FF0000">*</span>মাতার
                                                    নাম</label>
                                                <input name="defaulerWithness[mother][]" id="defaulerWithnessMother_1"
                                                    class="form-control form-control-sm "
                                                    value="" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="defaulerWithnessPresentAddree_1"><span
                                                        style="color:#FF0000">*
                                                    </span>ঠিকানা</label>
                                                <textarea id="defaulerWithnessPresentAddree_1" name="defaulerWithness[presentAddress][]" rows="3"
                                                    class="form-control element-block blank validation " aria-describedby="note-error"
                                                    aria-invalid="false" ></textarea>
                                                <div class="required_message hide">This Field is required</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div style="text-align: right;margin: 10px;">
                    <button type="button" id="RemovedefaulerWithness" class="btn btn-danger">
                        বাতিল
                    </button>
                    <button id="AdddefaulerWithness" type="button" class="btn btn-primary">
                        ২য় পক্ষের সাক্ষী যোগ করুন
                    </button>
                </div>
                @endforelse

            </section>
        </div>

    </div>


</div>
