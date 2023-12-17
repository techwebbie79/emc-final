 $("#AdddefaulerWithness").on('click', function() {
        // var count = parseInt($('#defaulerWithnessCount').val());
        var count = $("#defaulerWithnessInfo #accordionExample3 .card").length;
        $('#defaulerWithnessCount').val(count + 1);
        var adddefaulerWithness = '';
        adddefaulerWithness += '<div id="cloneNomenee" class="card">';
        adddefaulerWithness += '<div class="card-header" id="headingOne3">';
        adddefaulerWithness +=
            '    <div class="card-title collapsed h4" data-toggle="collapse" data-target="#collapseOne' +
            count + '">';
        adddefaulerWithness += '        ২য় পক্ষের সাক্ষীর তথ্য &nbsp; <span id="spannCount">(' + (count +
                1) +
            ')</span>';
        adddefaulerWithness += '    </div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '<div id="collapseOne' + count +
            '" class="collapse" data-parent="#accordionExample3">';
        adddefaulerWithness += '    <div class="card-body">';
        adddefaulerWithness += '        <div class="clearfix">';


        adddefaulerWithness += ' <div class="row">';
        adddefaulerWithness += '<div class="col-md-12">';
        adddefaulerWithness += '<div class="text-dark font-weight-bold">';
        adddefaulerWithness += '<label for="">জাতীয় পরিচয়পত্র যাচাই : </label>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '<div class="col-md-4">';
        adddefaulerWithness += '<div class="form-group">';
        adddefaulerWithness +=
            '<input required type="text"  class="form-control check_nid_number_0" data-defaulerwithnessrowindex="' +
            (
                count + 1) + '" placeholder="উদাহরণ- 19825624603112948" id="defaulerWithness_nid_input_' + (
                count + 1) +
            '" onclick="addDatePicker(this.id)">';

        adddefaulerWithness += '<span id="res_applicant_1"></span>';

        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '<div class="col-md-4">';
        adddefaulerWithness += '<div class="form-group">';
        adddefaulerWithness += '<div class="input-group">';


        adddefaulerWithness += '<input required type="text" id="defaulerWithness_dob_input_' + (count + 1) +
            '" placeholder="জন্ম তারিখ (জাতীয় পরিচয়পত্র অনুযায়ী) বছর/মাস/তারিখ" {{-- id="dob" --}} class="form-control common_datepicker_1" autocomplete="off" data-defaulerwithnessrowindex="' +
            (count + 1) + '" >';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '<div class="col-md-4">';
        adddefaulerWithness += '<div class="form-group">';
        adddefaulerWithness += '<div class="input-group">';

        adddefaulerWithness += '<input type="button" id="defaulerWithness_nid_' + (count + 1) +
            '" data-defaulerwithnessrowindex="' + (
                count + 1) +
            '" class="btn btn-primary check_nid_button" onclick="NIDCHECKdefaulerWithness(this.id)" value="সন্ধান করুন">';


        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';
        adddefaulerWithness += '</div>';


        adddefaulerWithness += '     <div class="row">';
        adddefaulerWithness += '                <div class="col-md-6">';
        adddefaulerWithness += '                    <div class="form-group">';
        adddefaulerWithness += '                        <label for="defaulerWithnessName_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="control-label"><span';
        adddefaulerWithness +=
            '                                style="color:#FF0000">*</span>২য় পক্ষের সাক্ষীর';
        adddefaulerWithness += '                            নাম</label>';
        adddefaulerWithness += '                        <input name="defaulerWithness[name][]"';
        adddefaulerWithness += '                            id="defaulerWithnessName_' + (count + 1) + '"';
        adddefaulerWithness +=
            '                            class="form-control form-control-sm "';
        adddefaulerWithness +=
            '                            value=""  >';
        adddefaulerWithness += ' <div class="required_message hide">This Field is required</div>';
        adddefaulerWithness += '                        <input type="hidden"';
        adddefaulerWithness += '                            name="defaulerWithness[type][]"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness += '                            value="6">';
        adddefaulerWithness += '                        <input type="hidden"';
        adddefaulerWithness += '                            name="defaulerWithness[id][]"';
        adddefaulerWithness += '                            id="defaulerWithnessId_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness += '                            value="">';
        adddefaulerWithness += '                        <input type="hidden"';
        adddefaulerWithness += '                            name="defaulerWithness[thana][]"';
        adddefaulerWithness += '                            id="defaulerWithnessThana_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness += '                            value="">';
        adddefaulerWithness += '                        <input type="hidden"';
        adddefaulerWithness += '                            name="defaulerWithness[upazilla][]"';
        adddefaulerWithness += '                            id="defaulerWithnessUpazilla_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness += '                            value="">';
        adddefaulerWithness += '                        <input type="hidden"';
        adddefaulerWithness += '                            name="defaulerWithness[designation][]"';
        adddefaulerWithness += '                            id="defaulerWithnessDesignation_' + (count + 1) +
            '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness += '                            value="">';
        adddefaulerWithness += '                        <input type="hidden"';
        adddefaulerWithness += '                            name="defaulerWithness[organization][]"';
        adddefaulerWithness += '                            id="defaulerWithnessOrganization_' + (count + 1) +
            '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness += '                            value="">';
        adddefaulerWithness += '                    </div>';
        adddefaulerWithness += '                </div>';
        adddefaulerWithness += '                <div class="col-md-6">';
        adddefaulerWithness += '                    <div class="form-group">';
        adddefaulerWithness += '                        <label for="defaulerWithnessPhn_' + (count + 1) + '"';
        adddefaulerWithness +=
            '                            class="control-label"><span style="color:#FF0000">*</span>মোবাইল</label>';
        adddefaulerWithness += '                        <input name="defaulerWithness[phn][]"';
        adddefaulerWithness += '                            id="defaulerWithnessPhn_' + (count + 1) + '"';
        adddefaulerWithness +=
            '                            class="form-control form-control-sm phone "';
        adddefaulerWithness += '                            value="" placeholder="ইংরেজিতে দিতে হবে">';
        adddefaulerWithness += ' <div class="required_message hide">This Field is required</div>';
        adddefaulerWithness += '                    </div>';
        adddefaulerWithness += '                </div>';
        adddefaulerWithness += '            </div>';
        adddefaulerWithness += '            </div>';

        adddefaulerWithness += '            <div class="row">';
        adddefaulerWithness += '                <div class="col-md-6">';
        adddefaulerWithness += '                    <div class="form-group">';
        adddefaulerWithness += '                        <label for="defaulerWithnessNid_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="control-label"><span';
        adddefaulerWithness += '                                style="color:#FF0000"></span>জাতীয়';
        adddefaulerWithness += '                            পরিচয় পত্র</label>';
        adddefaulerWithness += '                        <input type="text" name="defaulerWithness[nid][]"';
        adddefaulerWithness += '                            id="defaulerWithnessNid_' + (count + 1) + '"';
        adddefaulerWithness +=
            '                            class="form-control form-control-sm  email"';
        adddefaulerWithness +=
            '                            value=""  >';
        adddefaulerWithness += ' <div class="required_message hide">This Field is required</div>';
        adddefaulerWithness += '                    </div>';
        adddefaulerWithness += '                </div>';
        adddefaulerWithness += '                <div class="col-md-6">';
        adddefaulerWithness += '                    <div class="form-group">';
        adddefaulerWithness += '                        <label for="defaulerWithnessGender_' + (count + 1) +
            '"';
        adddefaulerWithness += '                            class="control-label">লিঙ্গ</label>';

        adddefaulerWithness += '                        <select style="width: 100%;"';
        adddefaulerWithness += '                            class="selectDropdown form-control"';
        adddefaulerWithness += '                            name="defaulerWithness[gender][]"';
        adddefaulerWithness += '                            id="defaulerWithnessGender_' + (count + 1) + '">';

        adddefaulerWithness += '                            <option value="MALE">';
        adddefaulerWithness += '                                পুরুষ</option>';
        adddefaulerWithness += '                            <option value="FEMALE">';
        adddefaulerWithness += '                                নারী</option>';
        adddefaulerWithness += '                        </select>';
        adddefaulerWithness += '                    </div>';
        adddefaulerWithness += '                </div>';
        adddefaulerWithness += '            </div>';
        adddefaulerWithness += '            <div class="row">';
        adddefaulerWithness += '                <div class="col-md-6">';
        adddefaulerWithness += '                    <div class="form-group">';
        adddefaulerWithness += '                        <label for="defaulerWithnessFather_' + (count + 1) +
            '"';
        adddefaulerWithness += '                            class="control-label"><span';
        adddefaulerWithness += '                                style="color:#FF0000">*</span>পিতার';
        adddefaulerWithness += '                            নাম</label>';
        adddefaulerWithness += '                        <input name="defaulerWithness[father][]"';
        adddefaulerWithness += '                            id="defaulerWithnessFather_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness +=
            '                            value=""  >';
        adddefaulerWithness += '                    </div>';
        adddefaulerWithness += '                </div>';
        adddefaulerWithness += '                <div class="col-md-6">';
        adddefaulerWithness += '                    <div class="form-group">';
        adddefaulerWithness += '                        <label for="defaulerWithnessMother_' + (count + 1) +
            '"';
        adddefaulerWithness += '                            class="control-label"><span';
        adddefaulerWithness += '                                style="color:#FF0000">*</span>মাতার';
        adddefaulerWithness += '                            নাম</label>';
        adddefaulerWithness += '                        <input name="defaulerWithness[mother][]"';
        adddefaulerWithness += '                            id="defaulerWithnessMother_' + (count + 1) + '"';
        adddefaulerWithness += '                            class="form-control form-control-sm"';
        adddefaulerWithness +=
            '                            value=""  >';
        adddefaulerWithness += '                    </div>';
        adddefaulerWithness += '                </div>';
        adddefaulerWithness += '            </div>';


        adddefaulerWithness += '         <div class="row">';

        adddefaulerWithness += '         </div>';
        adddefaulerWithness += '         <div class="col-md-12">';
        adddefaulerWithness += '          <div class="form-group">';
        adddefaulerWithness += '          <label for="defaulerWithnessPresentAddree_' + (count + 1) + '"><span';
        adddefaulerWithness += '                                style="color:#FF0000">*';
        adddefaulerWithness += '                            </span>ঠিকানা</label>';
        adddefaulerWithness += '                        <textarea id="defaulerWithnessPresentAddree_' + (count +
            1) + '"';
        adddefaulerWithness += '                            name="defaulerWithness[presentAddress][]" rows="3"';
        adddefaulerWithness +=
            '                            class="form-control element-block blank "';
        adddefaulerWithness += '                            aria-describedby="note-error"';
        adddefaulerWithness +=
            '                            aria-invalid="false"  ></textarea>';
        adddefaulerWithness += ' <div class="required_message hide">This Field is required</div>';
        adddefaulerWithness += '         </div>';
        adddefaulerWithness += '         </div>';
        adddefaulerWithness += '</div></div></div></div>';






        // console.log(adddefaulerWithness);
        $('#defaulerWithnessInfo #accordionExample3').append(adddefaulerWithness);

    })