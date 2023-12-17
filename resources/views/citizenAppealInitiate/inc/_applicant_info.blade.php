<fieldset class="pb-5" data-wizard-type="step-content">
    <legend class="font-weight-bold text-dark"><strong
            style="font-size: 20px !important">১ম পক্ষ</strong></legend>
    <input type="hidden" id="ApplicantCount" value="1">

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="applicantName_1" class="control-label">আভিযোগকারীর নাম</label>
                <input name="applicant[name]" id="applicantName_1"
                    class="form-control   name-group"
                    value="{{ globalUserInfo()->name }}" readonly>
                <input type="hidden" name="applicant[type]" class="form-control "
                    value="1">
                <input type="hidden" name="applicant[id]" id="applicantId_1"
                    class="form-control " value="">
                <input type="hidden" name="applicant[thana]" id="applicantThana_1"
                    class="form-control " value="">
                <input type="hidden" name="applicant[upazilla]" id="applicantUpazilla_1"
                    class="form-control " value="">
                <input type="hidden" name="applicant[age]" id="applicantAge_1"
                    class="form-control " value="">
                <input type="hidden" name="applicant[organization_id]"
                    id="applicantOrganizationId_1" class="form-control " value="">
                <input type="hidden" name="applicant[organization]"
                    id="applicantOrganization_1" class="form-control " value="">
                <input type="hidden" name="applicant[designation]"
                    id="applicantDesignation_1" class="form-control " value="">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label"><span
                        style="color:#FF0000"></span>লিঙ্গ</label><br>
                <select class="form-control" name="applicant[gender]">

                    <option value="MALE"
                        {{ $data['citizen_gender'] == 'MALE' ? ' selected' : 'disabled' }}>
                        পুরুষ </option>
                    <option value="FEMALE"
                        {{ $data['citizen_gender'] == 'FEMALE' ? ' selected' : 'disabled' }}>
                        নারী </option>
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
                    class="form-control " value="{{ $data['father'] }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="applicantMother_1" class="control-label"><span
                        style="color:#FF0000"></span>মাতার নাম</label>
                <input name="applicant[mother]" id="applicantMother_1"
                    class="form-control " value="{{ $data['mother'] }}" readonly>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="applicantNid_1" class="control-label"><span
                        style="color:#FF0000">* </span>জাতীয় পরিচয়পত্র</label>
                <input name="applicant[nid]" type="number" id="applicantNid_1"
                    class="form-control nid_important"
                    value="{{ globalUserInfo()->citizen_nid }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <div class="form-group">
                    <label for="applicantPhn_1" class="control-label"><span
                            style="color:#FF0000">* </span>মোবাইল</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"
                                style="padding-bottom: 0px !important;">+88</span></div>
                        <input name="applicant[phn]" class="form-control "
                            value="{{ $data['mobile_number_reshaped'] }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="applicantPresentAddree_1"><span style="color:#FF0000">*
                    </span>ঠিকানা</label>
                <textarea id="" name="applicant[presentAddress]" rows="5" class="form-control" readonly>{{ $data['present_address'] }} </textarea>


            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="applicantEmail_1">ইমেইল</label>
                <input type="email" name="applicant[email]" id="applicantEmail_1"
                    class="form-control" value="{{ globalUserInfo()->email }}">
            </div>
        </div>
    </div>
</fieldset>