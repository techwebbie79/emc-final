<div class="pb-5" data-wizard-type="step-content" id="withness_content_smdn">
    <fieldset>
        <legend class="font-weight-bold text-dark"><strong style="font-size: 20px !important">সাক্ষীর তথ্য (১)</strong>
        </legend>

        <div class="row">
            <div class="col-md-12">
                <div class="text-dark font-weight-bold">
                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input required type="text" {{-- id="applicantCiNID_1" --}} class="form-control check_nid_number_0"
                        data-rownew-index='0' placeholder="উদাহরণ- 19825624603112948" id="witness_nid_input_0"
                        onclick="addDatePicker(this.id)">
                    <span id="res_applicant_1"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <input required type="text" id="witness_dob_input_0"
                            placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) " {{-- id="dob" --}}
                            class="form-control common_datepicker_1" autocomplete="off" data-rownew-index='0'>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <input type="button" id="witness_nid_0" data-rownew-index='0'
                            class="btn btn-primary check_nid_button" onclick="NIDCHECKwitness(this.id)"
                            value="  যাচাই করুন">
                    </div>
                </div>
            </div>

        </div>

        <input type="hidden" id="witnessCount" value="1">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="applicantName_1" class="control-label"><span style="color:#FF0000">* </span>সাক্ষীর
                        নাম</label>
                    <input name="witness[name][0]" id="witnessName_1"
                        class="form-control   name-group " >
                    <input type="hidden" name="witness[type][]" class="form-control " value="5">
                    <input type="hidden" name="witness[id][]" id="witnessId_1" class="form-control " value="">
                    <input type="hidden" name="witness[thana][]" id="witnessThana_1" class="form-control "
                        value="">
                    <input type="hidden" name="witness[upazilla][]" id="witnessUpazilla_1" class="form-control "
                        value="">
                    <input type="hidden" name="witness[organization_id][]" id="witnessOrganizationId_1"
                        class="form-control " value="">
                    <input type="hidden" name="witness[organization]" id="witnessOrganization_1" class="form-control "
                        value="">
                    <input type="hidden" name="witness[designation]" id="witnessDesignation_1" class="form-control "
                        value="">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessPhn_1" class="control-label"><span style="color:#FF0000">* </span>মোবাইল</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"
                                style="padding-bottom: 0px !important;">+88</span></div>
                        <input name="witness[phn][0]" id="witnessPhn_1" class="form-control " value=""
                            placeholder="ইংরেজিতে দিতে হবে">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessNid_1" class="control-label">জাতীয়
                        পরিচয়পত্র</label>
                    <input name="witness[nid][0]" type="text" id="witnessNid_1"
                        class="form-control  nid_important" value="" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                    <select class="form-control" name="witness[gender][0]">

                        <option value="MALE"> পুরুষ </option>
                        <option value="FEMALE"> নারী </option>
                    </select>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessFather_1" class="control-label"><span style="color:#FF0000">*</span>পিতার
                        নাম</label>
                    <input name="witness[father][0]" id="witnessFather_1" class="form-control "
                        value="" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessFather_1" class="control-label"><span style="color:#FF0000">*</span>মাতার
                        নাম</label>
                    <input name="witness[mother][0]" id="witnessFather_1" class="form-control "
                        value="" >
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessPresentAddree_1"><span style="color:#FF0000">*</span>ঠিকানা</label>
                    <textarea id="witnessPresentAddree_1" name="witness[presentAddress][0]" rows="5"
                        class="form-control element-block blank " aria-describedby="note-error"
                        aria-invalid="false"></textarea>
                </div>
            </div>
        </div>
    </fieldset>

    <!-- Template -->
    <fieldset id="witnessTemplate" style="display: none; margin-top: 30px;">
        <legend class="font-weight-bold text-dark"><strong style="font-size: 20px !important"
                data-name="witness.info">সাক্ষীর তথ্য
                (১)</strong></legend>
        
        
        <div class="row">
            <div class="col-md-12">
                <div class="text-dark font-weight-bold">
                    <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input required type="text" {{-- id="applicantCiNID_1" --}}
                        class="form-control" placeholder="উদাহরণ- 19825624603112948"
                        data-name="witness.NIDNumber" onclick="addDatePicker(this.id)">
                    <span id="res_applicant_1"></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <input required type="text" id="applicantDob_1"
                            data-name="witness.DOBNumber"
                            placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                            {{-- id="dob" --}} class="form-control common_datepicker_1"
                            autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <input type="button" data-name="witness.NIDCheckButton"
                            class="btn btn-primary check_nid_button" value="  যাচাই করুন"
                            onclick="NIDCHECKwitness(this.id)">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000">*</span>
                        সাক্ষীর নাম</label>
                    <input type="text" data-name="witness.name" class="form-control " >

                    <input type="hidden" data-name="witness.type" value="5">
                    <input type="hidden" data-name="witness.id">
                    <input type="hidden" data-name="witness.thana">
                    <input type="hidden" data-name="witness.upazilla">
                    <input type="hidden" data-name="witness.designation">
                    <input type="hidden" data-name="witness.organization">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessPhn_1" class="control-label"><span style="color:#FF0000">*
                        </span>মোবাইল</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"
                                style="padding-bottom: 0px !important;">+88</span></div>
                        <input data-name="witness.phn" class="input-reset form-control"
                            placeholder="ইংরেজিতে দিতে হবে">
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessFather_1" class="control-label"><span style="color:#FF0000">*</span>পিতার
                        নাম</label>
                    <input data-name="witness.father" class="input-reset form-control " >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessFather_1" class="control-label"><span style="color:#FF0000">*</span>মাতার
                        নাম</label>
                    <input data-name="witness.mother" class="input-reset form-control " >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="witnessNid_1" class="control-label"></span>জাতীয় পরিচয়
                        পত্র</label>
                    <input data-name="witness.nid" type="number"
                        class="input-reset form-control  nid_important" >
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                    <select class="form-control" data-name="witness.gender">

                        <option value="MALE"> পুরুষ </option>
                        <option value="FEMALE"> নারী </option>
                    </select>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label><span style="color:#FF0000">*</span>ঠিকানা</label>
                    <textarea data-name="witness.presentAddress" rows="5"
                        class="input-reset form-control element-block blank " ></textarea>
                </div>
            </div>
        </div>
    </fieldset>

    <div>
        <div class="col-md-12" style="float: right; margin-bottom: 25px;">
            <button id="witnessRemove" type="button" class="btn btn-danger" value="0"
                style="float: right;">বাতিল</button>
            <button id="witnessAdd" type="button" class="btn btn-success" value="0"
                style="float: right; margin-right: 10px;">সাক্ষী যোগ করুন
            </button>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
