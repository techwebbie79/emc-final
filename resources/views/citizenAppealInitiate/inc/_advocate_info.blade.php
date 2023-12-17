 <fieldset class="pb-5" data-wizard-type="step-content" id="">
     <legend class="font-weight-bold text-dark"><strong style="font-size: 20px !important">আইনজীবীর তথ্য</strong></legend>

     <div class="row">
         <div class="col-md-12">
             <div class="text-dark font-weight-bold">
                 <label for="">জাতীয় পরিচয়পত্র যাচাই : </label>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <input required type="text" id="lawyer_nid_checking_smdn" class="form-control"
                     placeholder="উদাহরণ- 19825624603112948" name="lawyer[ciNID]">
                 <span id="res_lawyer"></span>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <div class="input-group">
                     <input required type="text" id="lawyer_dob_checking_smdn" name="lawyer[dob]"
                         placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী , বছর/মাস/দিন ) "
                         class="form-control common_datepicker" autocomplete="off">
                 </div>
             </div>
         </div>
         <div class="col-md-4">
             <div class="form-group">
                 <div class="input-group">
                     <input type="button" name="lawyer[cCheck]" onclick="NIDCHECKLaywer()" class="btn btn-primary"
                         value="  যাচাই করুন">
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label"><span style="color:#FF0000">*</span>আইনজীবীর
                     নাম</label>
                 <input name="lawyer[name]" id="lawyerName_1" class="form-control " value=""
                     >
                 <input type="hidden" name="lawyer[type]" class="form-control " value="4">
                 <input type="hidden" name="lawyer[id]" id="lawyerId_1" class="form-control " value="">
                 <input type="hidden" name="lawyer[thana]" id="lawyerThana_1" class="form-control " value="">
                 <input type="hidden" name="lawyer[upazilla]" id="lawyerUpazilla_1" class="form-control "
                     value="">
                 <input type="hidden" name="lawyer[age]" id="lawyerAge_1" class="form-control " value="">
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label"><span style="color:#FF0000">*</span>মোবাইল</label>
                 <div class="input-group">
                     <div class="input-group-prepend"><span class="input-group-text">+88</span></div>
                     <input name="lawyer[phn]" class="form-control " placeholder="ইংরেজিতে দিতে হবে">
                 </div>
             </div>
         </div>
     </div>

     <div class="row">
         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label"><span style="color:#FF0000">*</span>জাতীয়
                     পরিচয় পত্র</label>
                 <input name="lawyer[nid]" type="text" class="form-control  nid_important"
                     value="" >
             </div>
         </div>

         <div class="col-md-3">

             <div class="form-group">
                 <label class="control-label"><span style="color:#FF0000"></span>লিঙ্গ</label><br>
                 <select class="form-control" name="lawyer[gender]">

                     <option value="MALE"> পুরুষ </option>
                     <option value="FEMALE"> নারী </option>
                 </select>
             </div>
         </div>


         <div class="col-md-3">
             <div class="form-group">
                 <label class="control-label"> <span style="color:#FF0000"></span>বার
                     কাউন্সিল আইডি </label>
                 <input name="lawyer[organization_id]" class="form-control ">
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label"><span style="color:#FF0000">*</span>পিতার
                     নাম</label>
                 <input name="lawyer[father]" class="form-control ">
             </div>
         </div>
         <div class="col-md-6">
             <div class="form-group">
                 <label class="control-label"><span style="color:#FF0000">*</span>মাতার
                     নাম</label>
                 <input name="lawyer[mother]" class="form-control " >
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
                 <label><span style="color:#FF0000">*</span>ঠিকানা</label>
                 <textarea name="lawyer[presentAddress]" rows="5" class="form-control element-block blank "
                     ></textarea>
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
