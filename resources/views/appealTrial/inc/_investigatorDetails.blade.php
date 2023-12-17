<div class="radio">
    <label class="mr-5">
        <input type="radio" onclick="investigatorHideShow(1);" class="mr-2" value="1" checked name="investigatorType">নথি ব্যবহারকারী
    </label>
    <label>
        <input type="radio" onclick="investigatorHideShow(2);" class="mr-2" value="2" name="investigatorType">আইনশৃঙ্খলা রক্ষাকারী কর্মকর্তা 
    </label>
    <label>
        <input type="radio" onclick="investigatorHideShow(3);" class="mr-3 ml-3" value="2" name="investigatorType">অন্যান্য কর্মকর্তা
    </label>
</div>


<div class="form-group">
    <div class="form-group" id="officer">
        <fieldset>
            <legend></legend>
            <h3 id="ofiicerInvestigator">নথি ব্যবহারকারী</h3>
            <h3 id="defenceInvestigator" style="display: none;">আইনশৃঙ্খলা রক্ষাকারী কর্মকর্তা</h3>
            <h3 id="OtherInvestigator" style="display: none;">অন্যান্য কর্মকর্তা</h3>
            
            <div class="row" id="nothiCheck">
                <div class="col-md-12">
                    <div class="text-dark font-weight-bold h4">
                    <label for="">নথি যাচাই : </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input required type="text" id="nothiID" class="form-control" placeholder="নথি আইডি দিন , উদাহরণ- 100000006515" name="nothiID">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="button" id="investigatorCheck" name="investigatorCheck" onclick="checkInvestigator()" class="btn btn-danger" value="সন্ধান করুন"> <span class="ml-5" id="res_applicant_1"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="investigatorName"class="control-label"><span
                            style="color:#FF0000">*</span>নাম</label>
                        <input name="investigatorName"id="investigatorName" class="form-control form-control-sm" value="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="investigatorInstituteName"
                            class="control-label"><span
                                style="color:#FF0000">*</span>প্রতিষ্ঠানের নাম</label>
                        <input name="investigatorInstituteName"id="investigatorInstituteName" class="form-control form-control-sm" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="investigatorMobile"class="control-label"><span
                            style="color:#FF0000">*</span>মোবাইল</label>
                        <input name="investigatorMobile" id="investigatorMobile"class="form-control form-control-sm" value="" placeholder="01741315099">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="investigatorEmail"class="control-label">ইমেইল</label>
                        <input name="investigatorEmail" id="investigatorEmail"class="form-control form-control-sm" value="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="investigatorDesignation"
                            class="control-label">পদবী </label>
                        <input name="investigatorDesignation" id="investigatorDesignation" class="form-control form-control-sm" value="">
                    </div>
                </div>
            </div>
            
        </fieldset>
         
    </div>
</div>
