<fieldset id="victim_content" class="pb-5" data-wizard-type="step-content">
                                    <legend class="font-weight-bold text-dark"><strong
                                            style="font-size: 20px !important">ভিক্টিমের তথ্য</strong></legend>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="text-dark font-weight-bold">
                                                <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input required type="text" id="victim_nid_checking_smdn" class="form-control"
                                                    placeholder="উদাহরণ- 19825624603112948" name="lawyer[ciNID]">
                                                <span id="res_lawyer"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input required type="text" id="victim_dob_checking_smdn" name="lawyer[dob]"
                                                        placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                                                        class="form-control common_datepicker" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="button" name="lawyer[cCheck]" onclick="NIDCHECKVictim()" class="btn btn-primary"
                                                        value="  যাচাই করুন">
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="victimName_1" class="control-label"><span
                                                        style="color:#FF0000">* </span>ভিক্টিমের নাম</label>
                                                <input name="victim[name]" class="form-control   name-group">
                                                <input type="hidden" name="victim[type]" class="form-control "
                                                    value="8">
                                                <input type="hidden" name="victim[id]" id="victimId_1"
                                                    class="form-control " value="">
                                                <input type="hidden" name="victim[thana]" id="victimThana_1"
                                                    class="form-control " value="">
                                                <input type="hidden" name="victim[upazilla]" id="victimUpazilla_1"
                                                    class="form-control " value="">
                                                <input type="hidden" name="victim[age]" id="victimAge_1"
                                                    class="form-control " value="">
                                                <input type="hidden" name="victim[organization_id]"
                                                    id="victimOrganizationId_1" class="form-control " value="">
                                                <input type="hidden" name="victim[organization]"
                                                    id="victimOrganization_1" class="form-control " value="">
                                                <input type="hidden" name="victim[designation]" id="victimDesignation_1"
                                                    class="form-control " value="">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span
                                                        style="color:#FF0000"></span>লিঙ্গ</label><br>
                                                <select class="form-control" name="victim[gender]">

                                                    <option value="MALE"> পুরুষ </option>
                                                    <option value="FEMALE"> নারী </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span style="color:#FF0000"></span>পিতার
                                                    নাম</label>
                                                <input name="victim[father]" class="form-control " value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span style="color:#FF0000"></span>মাতার
                                                    নাম</label>
                                                <input name="victim[mother]" class="form-control " value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label"><span style="color:#FF0000"></span>জাতীয়
                                                    পরিচয়পত্র</label>
                                                <input name="victim[nid]" type="number"
                                                    class="form-control nid_important nid_data_pull_warning"
                                                    value="" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label class="control-label"><span
                                                            style="color:#FF0000"></span>মোবাইল</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend"><span
                                                                class="input-group-text">+88</span></div>
                                                        <input name="victim[phn]" class="form-control " value=""
                                                            placeholder="ইংরেজিতে দিতে হবে">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><span style="color:#FF0000">* </span>ঠিকানা</label>
                                                <textarea id="victimPresentAddree_1" name="victim[presentAddress]" rows="5"
                                                    class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>ইমেইল</label>
                                                <input type="email" name="victim[email]" class="form-control "
                                                    value="">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>