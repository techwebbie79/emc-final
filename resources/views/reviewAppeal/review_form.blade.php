<div class="wizard wizard-1" id="appealWizard" data-wizard-state="step-first" data-wizard-clickable="true">
    <!--begin::Wizard Nav-->
    <div class="wizard-nav border-bottom">
        <div class="wizard-steps p-8 p-lg-10">
          
          
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
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
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
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
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
            <form id="appealCase" action="{{ route('citizen.appeal.store') }}" class="form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="appealId" value="">
                <input type="hidden" name="appealEntryType" value="create">
                <input type="hidden" id="new" class="caseEntryType mr-2" value="others" name="caseEntryType">

                <!--begin::Step 1-->
              
                <!--end::Step 1-->

                <!--begin::Step 2-->
            
                <!--end::Step 2-->

                <!--begin::Step 3 victim-->
                
                <!--end::Step 3 victim-->

                <!--begin::Step 4-->
                
                <!--end::Step 4-->

                <!--begin::Step 5-->
                <div class="pb-5" data-wizard-type="step-content" id="withness_content_smdn">
                    <fieldset>
                        <legend class="font-weight-bold text-dark"><strong style="font-size: 20px !important">সাক্ষীর তথ্য (১)</strong></legend>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-dark font-weight-bold">
                                <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input required type="text" {{-- id="applicantCiNID_1" --}} class="form-control check_nid_number_0" data-rownew-index='0' placeholder="উদাহরণ- 19825624603112948" id="witness_nid_input_0" onclick="addDatePicker(this.id)">
                                    <span id="res_applicant_1"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input required type="text" id="witness_dob_input_0" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী)" {{-- id="dob" --}} class="form-control common_datepicker_1" autocomplete="off" data-rownew-index='0'>
                                        <input type="button" id="witness_nid_0" data-rownew-index='0' class="btn btn-primary check_nid_button" onclick="NIDCHECKwitness(this.id)" value="সন্ধান করুন">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="witnessCount" value="1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="applicantName_1" class="control-label">সাক্ষীর নাম</label>
                                    <input name="witness[name][0]" id="witnessName_1" class="form-control   name-group">
                                    <input type="hidden" name="witness[type][]" class="form-control " value="5">
                                    <input type="hidden" name="witness[id][]" id="witnessId_1"  class="form-control " value="">
                                    <input type="hidden" name="witness[thana][]" id="witnessThana_1" class="form-control " value="">
                                    <input type="hidden" name="witness[upazilla][]" id="witnessUpazilla_1" class="form-control " value="">
                                    <input type="hidden" name="witness[organization_id][]" id="witnessOrganizationId_1" class="form-control " value="">
                                    <input type="hidden" name="witness[organization]" id="witnessOrganization_1" class="form-control " value="">
                                    <input type="hidden" name="witness[designation]" id="witnessDesignation_1" class="form-control " value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessPhn_1" class="control-label"><span style="color:#FF0000">* </span>মোবাইল</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text" style="padding-bottom: 0px !important;">+88</span></div>
                                        <input name="witness[phn][0]" id="witnessPhn_1" class="form-control " value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessNid_1" class="control-label"><span style="color:#FF0000">*</span>জাতীয় পরিচয়পত্র</label>
                                    <input name="witness[nid][0]"  type="number"  id="witnessNid_1" class="form-control " value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                                    <select class="form-control" name="witness[gender][0]">
                                        <option value=""> -- নির্বাচন করুন --</option>
                                        <option value="MALE"> পুরুষ </option>
                                        <option value="FEMALE"> নারী </option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessFather_1" class="control-label"><span style="color:#FF0000"></span>পিতার নাম</label>
                                    <input name="witness[father][0]" id="witnessFather_1" class="form-control " value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessPresentAddree_1"><span style="color:#FF0000">*</span>ঠিকানা</label>
                                    <textarea id="witnessPresentAddree_1" name="witness[presentAddress][0]" rows="5" class="form-control element-block blank" aria-describedby="note-error" aria-invalid="false"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Template -->
                    <fieldset id="witnessTemplate" style="display: none; margin-top: 30px;" >
                        <legend class="font-weight-bold text-dark"><strong style="font-size: 20px !important" data-name="witness.info">সাক্ষীর তথ্য (১)</strong></legend>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-dark font-weight-bold">
                                <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input required type="text" {{-- id="applicantCiNID_1" --}} class="form-control" placeholder="উদাহরণ- 19825624603112948" data-name="witness.NIDNumber" onclick="addDatePicker(this.id)">
                                    <span id="res_applicant_1"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input required type="text" id="applicantDob_1" data-name="witness.DOBNumber" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী)" {{-- id="dob" --}} class="form-control common_datepicker_1" autocomplete="off">

                                        <input type="button" data-name="witness.NIDCheckButton" class="btn btn-primary check_nid_button" value="সন্ধান করুন" onclick="NIDCHECKwitness(this.id)">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span> সাক্ষীর নাম</label>
                                    <input type="text" data-name="witness.name" class="form-control ">

                                    <input type="hidden" data-name="witness.type"  value="5">
                                    <input type="hidden" data-name="witness.id">
                                    <input type="hidden" data-name="witness.thana">
                                    <input type="hidden" data-name="witness.upazilla">
                                    <input type="hidden" data-name="witness.designation">
                                    <input type="hidden" data-name="witness.organization">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessPhn_1" class="control-label"><span style="color:#FF0000">* </span>মোবাইল</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text" style="padding-bottom: 0px !important;">+88</span></div>
                                        <input data-name="witness.phn" class="input-reset form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessFather_1" class="control-label"><span style="color:#FF0000"></span>পিতার নাম</label>
                                    <input data-name="witness.father" class="input-reset form-control ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                                    <select class="form-control" data-name="witness.gender">
                                        <option value=""> -- নির্বাচন করুন --</option>
                                        <option value="MALE"> পুরুষ </option>
                                        <option value="FEMALE"> নারী </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="witnessNid_1" class="control-label"><span style="color:#FF0000">*</span>জাতীয় পরিচয় পত্র</label>
                                    <input data-name="witness.nid" type="number" class="input-reset form-control ">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span style="color:#FF0000">*</span>ঠিকানা</label>
                                    <textarea data-name="witness.presentAddress" rows="5"
                                        class="input-reset form-control element-block blank"></textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <div>
                        <div class="col-md-12" style="float: right; margin-bottom: 25px;">
                            <button id="witnessRemove" type="button" class="btn btn-danger" value="0" style="float: right;">বাতিল</button>
                            <button id="witnessAdd" type="button" class="btn btn-success" value="0" style="float: right; margin-right: 10px;">সাক্ষী যোগ করুন </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--end::Step 5-->

                <!--begin::Step 6-->
                <fieldset class="pb-5" data-wizard-type="step-content" id="">
                    <legend class="font-weight-bold text-dark"><strong style="font-size: 20px !important">আইনজীবীর তথ্য</strong></legend>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-dark font-weight-bold">
                            <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input required type="text" id="lawyer_nid_checking_smdn" class="form-control" placeholder="উদাহরণ- 19825624603112948" name="lawyer[ciNID]">
                                <span id="res_lawyer"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <input required type="text" id="lawyer_dob_checking_smdn" name="lawyer[dob]" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী)"  class="form-control common_datepicker" autocomplete="off">
                                    {{-- <input type="button" id="applicantCCheck_1" class="btn btn-primary" value="সন্ধান করুন"> --}}

                                    <input type="button" name="lawyer[cCheck]" onclick="NIDCHECKLaywer()" class="btn btn-primary" value="সন্ধান করুন">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span>আইনজীবীর
                                    নাম</label>
                                <input name="lawyer[name]" id="lawyerName_1" class="form-control " value="">
                                <input type="hidden" name="lawyer[type]" class="form-control " value="4">
                                <input type="hidden" name="lawyer[id]" id="lawyerId_1" class="form-control " value="">
                                <input type="hidden" name="lawyer[thana]" id="lawyerThana_1" class="form-control " value="">
                                <input type="hidden" name="lawyer[upazilla]" id="lawyerUpazilla_1"  class="form-control " value="">
                                <input type="hidden" name="lawyer[age]" id="lawyerAge_1" class="form-control " value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000">*</span>মোবাইল</label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text">+88</span></div>
                                    <input name="lawyer[phn]" class="form-control ">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000">*</span>জাতীয় পরিচয় পত্র</label>
                                <input name="lawyer[nid]" type="number" class="form-control " value="">
                            </div>
                        </div>

                        <div class="col-md-3">
                            
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                                <select class="form-control" name="lawyer[gender]">
                                    <option value=""> -- নির্বাচন করুন --</option>
                                    <option value="MALE"> পুরুষ </option>
                                    <option value="FEMALE"> নারী </option>
                                </select>
                            </div>
                        </div>
                        

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label"> <span style="color:#FF0000"></span>প্রাতিষ্ঠানিক আইডি </label>
                                <input name="lawyer[organization_id]" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span>পিতার নাম</label>
                                <input name="lawyer[father]" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span>মাতার নাম</label>
                                <input name="lawyer[mother]" class="form-control ">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span>পদবি</label>
                                <input name="lawyer[designation]" class="form-control ">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label"><span style="color:#FF0000"></span>প্রতিষ্ঠানের নাম</label>
                                <input name="lawyer[organization]" class="form-control ">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><span style="color:#FF0000"></span>ঠিকানা</label>
                                <textarea name="lawyer[presentAddress]" rows="5" class="form-control element-block blank"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>ইমেইল</label>
                                    <input type="email" name="lawyer[email]" class="form-control ">
                            </div>
                        </div>
                    </div>
                </fieldset>
                <!--end::Step 6-->

                <!--begin::Actions-->
                <div class="d-flex justify-content-between {{-- mt-5 pt-10 --}}">
                    <div class="mr-2">
                        <button type="button" style="background-color: #008841" class="btn btn-primary mt-3 font-weight-bolder text-uppercase px-9 py-4" id="wizardBack" data-wizard-type="action-prev">পূর্ববর্তী</button>
                    </div>
                    <div>
                        <input type="hidden" id="status" name="status" value="">

                        <button type="button" style="background-color: #008841" class="btn btn-success mt-3 font-weight-bolder text-uppercase px-9 py-4" id="previous_step_smdn" data-wizard-type="action-submit">সংরক্ষণ করুন</button>
                        <button type="button" style="background-color: #008841" class="btn mt-3 btn-primary font-weight-bolder text-uppercase px-9 py-4" id="next_step_smdn"  data-wizard-type="action-next">পরবর্তী পদক্ষেপ</button>
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