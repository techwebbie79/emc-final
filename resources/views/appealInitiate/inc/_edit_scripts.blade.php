<script>
    $("#note").val('');

    function addDatePicker(id) {


        $(".common_datepicker_1").datepicker({
            format: 'yyyy/mm/dd'

        });


    }

    function NIDCHECKdefaulerWithness(id) {
        var Id = '#' + id;
        //alert(id);
        var element = document.getElementById(id);
        var row_index_defaulerWithness = element.dataset.defaulerwithnessrowindex;


        var nid_number = document.getElementById('defaulerWithness_nid_input_' + row_index_defaulerWithness).value;
        var dob_number = document.getElementById('defaulerWithness_dob_input_' + row_index_defaulerWithness).value;


        //swal.showLoading();

        var formdata = new FormData();

        $.ajax({
            url: '{{ route('new.nid.verify.mobile.reg.first') }}',
            method: 'post',
            data: {
                nid_number: nid_number,
                dob_number: dob_number,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success == 'error') {
                    Swal.fire({
                        text: response.message,

                    })

                    let gender = '';
                    let remove_alert = 100000;


                    $("#defaulerWithnessName_" + row_index_defaulerWithness).val('');
                    $("#defaulerWithnessName_" + row_index_defaulerWithness).removeClass(
                        'nid_data_pull_warning');
                    $("#defaulerWithnessName_" + row_index_defaulerWithness).prop('readonly', false);

                    $("#defaulerWithnessFather_" + row_index_defaulerWithness).val('');
                    $("#defaulerWithnessFather_" + row_index_defaulerWithness).prop('readonly', false);
                    $("#defaulerWithnessFather_" + row_index_defaulerWithness).removeClass(
                        'nid_data_pull_warning');

                    $("#defaulerWithnessMother_" + row_index_defaulerWithness).val('');
                    $("#defaulerWithnessMother_" + row_index_defaulerWithness).prop('readonly', false);
                    $("#defaulerWithnessMother_" + row_index_defaulerWithness).removeClass(
                        'nid_data_pull_warning');

                    $("#defaulerWithnessPresentAddree_" + row_index_defaulerWithness).text('');
                    $("#defaulerWithnessPresentAddree_" + row_index_defaulerWithness).prop('readonly',
                        false);
                    $("#defaulerWithnessPresentAddree_" + row_index_defaulerWithness).removeClass(
                        'nid_data_pull_warning');

                    $("#defaulerWithnessGender_" + row_index_defaulerWithness).find(':selected').removeAttr(
                        'selected');
                    $("#defaulerWithnessGender_" + row_index_defaulerWithness).find(':disabled').removeAttr(
                        'disabled');


                    $("#defaulerWithnessNid_" + row_index_defaulerWithness).val('');
                    $("#defaulerWithnessNid_" + row_index_defaulerWithness).prop(
                        'readonly', false);
                    $("#defaulerWithnessNid_" + row_index_defaulerWithness)
                        .removeClass('nid_data_pull_warning');
                    $("#edit_defaulter_email_" + row_index_defaulerWithness).val('');

                } else if (response.success == 'success') {

                    Swal.fire({
                        icon: 'success',
                        text: response.message,

                    });

                    let opposite_gender = ' ';

                    if (response.gender == 'MALE') {
                        opposite_gender = 'FEMALE';
                    } else {
                        opposite_gender = 'MALE';
                    }

                    $("#defaulerWithnessName_" + row_index_defaulerWithness).val(response.name_bn);

                    $("#defaulerWithnessName_" + row_index_defaulerWithness).addClass(
                        "nid_data_pull_warning")

                    $("#defaulerWithnessName_" + row_index_defaulerWithness).prop('readonly', true);

                    $("#defaulerWithnessGender_" + row_index_defaulerWithness).find('option[value="' +
                        response.gender + '"]').attr('selected', 'selected');

                    $("#defaulerWithnessGender_" + row_index_defaulerWithness).find('option[value="' +
                        opposite_gender + '"]').attr('disabled', 'disabled');

                    $("#defaulerWithnessFather_" + row_index_defaulerWithness).val(response.father);
                    $("#defaulerWithnessFather_" + row_index_defaulerWithness).prop('readonly', true);
                    $("#defaulerWithnessFather_" + row_index_defaulerWithness).addClass(
                        'nid_data_pull_warning');

                    $("#defaulerWithnessMother_" + row_index_defaulerWithness).val(response.mother);
                    $("#defaulerWithnessMother_" + row_index_defaulerWithness).prop('readonly', true);
                    $("#defaulerWithnessMother_" + row_index_defaulerWithness).addClass(
                        'nid_data_pull_warning');

                    $("#defaulerWithnessNid_" + row_index_defaulerWithness).val(response.national_id);
                    $("#defaulerWithnessNid_" + row_index_defaulerWithness).prop(
                        'readonly', true);
                    $("#defaulerWithnessNid_" + row_index_defaulerWithness)
                        .addClass('nid_data_pull_warning');

                    $("#defaulerWithnessPresentAddree_" + row_index_defaulerWithness).text(response
                        .present_address);
                    $("#defaulerWithnessPresentAddree_" + row_index_defaulerWithness).prop('readonly',
                        true);
                    $("#defaulerWithnessPresentAddree_" + row_index_defaulerWithness).addClass(
                        'nid_data_pull_warning');
                    $("#edit_defaulter_email_" + row_index_defaulerWithness).val(response.email);

                    $('#defaulter_withness_change').val('has_changed');

                }
            }
        });

    }

    function NIDCHECKdefaulerLawyer(id) {
        var Id = '#' + id;
        //alert(id);


        var nid_number = document.getElementById('defaulerLawyer_nid_input_1').value;
        var dob_number = document.getElementById('defaulerLawyer_dob_input_1').value;


        //swal.showLoading();

        var formdata = new FormData();

        $.ajax({
            url: '{{ route('new.nid.verify.mobile.reg.first') }}',
            method: 'post',
            data: {
                nid_number: nid_number,
                dob_number: dob_number,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success == 'error') {
                    Swal.fire({
                        text: response.message,

                    })

                    let gender = '';
                    let remove_alert = 100000;


                    $("#defaulerLawyerName_" + 1).val('');
                    $("#defaulerLawyerName_" + 1).removeClass(
                        'nid_data_pull_warning');
                    $("#defaulerLawyerName_" + 1).prop('readonly', false);

                    $("#defaulerLawyerFather_" + 1).val('');
                    $("#defaulerLawyerFather_" + 1).prop('readonly', false);
                    $("#defaulerLawyerFather_" + 1).removeClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyerMother_" + 1).val('');
                    $("#defaulerLawyerMother_" + 1).prop('readonly', false);
                    $("#defaulerLawyerMother_" + 1).removeClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyerPresentAddree_" + 1).text('');
                    $("#defaulerLawyerPresentAddree_" + 1).prop('readonly',
                        false);
                    $("#defaulerLawyerPresentAddree_" + 1).removeClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyerGender_1").find(':selected').removeAttr(
                        'selected');
                    $("#defaulerLawyerGender_1").find(':disabled').removeAttr(
                        'disabled');


                    $("#defaulerLawyerNid_" + 1).val('');
                    $("#defaulerLawyerNid_" + 1).prop('readonly', false);
                    $("#defaulerLawyerNid_" + 1).removeClass(
                        'nid_data_pull_warning');
                    $("#defaulerLawyeremail_1").val('');
                    $("#defaulerLawyerorganization_1").val('');
                    $("#defaulerLawyerdesignation_1").val('');
                    $("#defaulerLawyerorganization_id_1").val('');

                } else if (response.success == 'success') {

                    Swal.fire({
                        icon: 'success',
                        text: response.message,

                    });

                    let opposite_gender = ' ';

                    if (response.gender == 'MALE') {
                        opposite_gender = 'FEMALE';
                    } else {
                        opposite_gender = 'MALE';
                    }

                    $("#defaulerLawyerName_" + 1).val(response.name_bn);

                    $("#defaulerLawyerName_" + 1).addClass(
                        "nid_data_pull_warning")

                    $("#defaulerLawyerName_" + 1).prop('readonly', true);

                    $("#defaulerLawyerGender_" + 1).find('option[value="' +
                        response.gender + '"]').attr('selected', 'selected');

                    $("#defaulerLawyerGender_" + 1).find('option[value="' +
                        opposite_gender + '"]').attr('disabled', 'disabled');

                    $("#defaulerLawyerFather_" + 1).val(response.father);
                    $("#defaulerLawyerFather_" + 1).prop('readonly', true);
                    $("#defaulerLawyerFather_" + 1).addClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyerMother_" + 1).val(response.mother);
                    $("#defaulerLawyerMother_" + 1).prop('readonly', true);
                    $("#defaulerLawyerMother_" + 1).addClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyerNid_" + 1).val(response.national_id);
                    $("#defaulerLawyerNid_" + 1).prop('readonly', true);
                    $("#defaulerLawyerNid_" + 1).addClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyerPresentAddree_" + 1).text(response
                        .present_address);
                    $("#defaulerLawyerPresentAddree_" + 1).prop('readonly',
                        true);
                    $("#defaulerLawyerPresentAddree_" + 1).addClass(
                        'nid_data_pull_warning');

                    $("#defaulerLawyeremail_1").val(response.email);
                    $("#defaulerLawyerorganization_1").val(response.organization);
                    $("#defaulerLawyerdesignation_1").val(response.designation);
                    $("#defaulerLawyerorganization_id_1").val(response.organization_id);

                    $('#defaulter_lawyer_change').val('has_changed');

                }
            }
        });

    }




    function updateNote(a) {
        var order_id = $(a).val();

        if (1 == $(a).is(":checked")) {
            var description = $(a).attr("desc");
            var className = $(a).attr("name");
            // var data = $("#note").val() + "<p class='"+className+"'>" + description +"</p>";
            var data = $("#note").val() + "\n" + description;
            $("#note").val(data);
            $("#orderPreviewBtn").attr('disabled', false);

        }
        // 19 == $(a).val() &&
        // $("#paymentStatus").val("PAYMENT_REGULAR"),
        // 16 == $(a).val() &&
        // $("#paymentStatus").val("PAYMENT_AUCTION"),
        // 15 == $(a).val() &&
        // $("#paymentStatus").val("PAYMENT_INSTALLMENT")
        makeOrderWithClean(order_id);

    }

    function makeOrderWithClean(order_id) {

        $("#note").val('');
        $.ajax({
            url: '{{ route('appeal.get.dynamic.name.defulter.applicant') }}',
            method: 'post',
            data: {

                appeal_id: $("input[name='appealId']").val(),
                law_sec_id: $("input[name='law_sec_id']").val(),
                details: $('#shortOrder_' + order_id).attr("desc"),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {

                if (response.success == 'success') {
                    $("#note").val('');
                    var data = response.message;
                    $("#note").val(data)
                    globalNote = data;
                }
            }
        });
        // var data = $('#shortOrder_' + order_id).attr("desc");
        // $("#note").val(data)
    }

    function updateNoteWithData(a) {
        var date = $(a).val();

        $("#note").val(' ');
        $('.shortOrderCheckBox').each(function(index) {
            if ($(this).is(":checked")) {

                var data = $(this).attr('desc') + "\n\n\nপরবর্তী তারিখ: " + date;
                $("#note").val(data)
            }
        });
    }

    function orderPreview() {
        // console.log($("#note").val());
        var description = $("#note").val();
        $("#orderContaint").html(description);
    }

    $('#trialDate').datepicker({
        startDate: new Date(),
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "bottom left"
    });
    $('.common_datepicker_edit_nid').datepicker({
        format: "yyyy/mm/dd",
    });

    function myFunction() {

        // let permission = true;
        // let defaulter_lawyer_change = $('#defaulter_lawyer_change').val();
        // let defaulter_withness_change = $('#defaulter_withness_change').val();
        // if (defaulter_lawyer_change == "has_changed" || defaulter_withness_change == "has_changed") {
        //     $('.').each(function() {

        //         if ($(this).val() == '') {
        //             $(this).addClass('waring-border-field');
        //             $(this).next('.required_message').removeClass('hide');
        //             $(this).next('.required_message').addClass('show warning-message-alert');
        //             permission = false;
        //         } else {
        //             $(this).removeClass('waring-border-field');
        //             $(this).next('.required_message').addClass('hide');
        //             $(this).next('.required_message').removeClass('show warning-message-alert');
        //         }


        //         $(this).on('keyup', function() {
        //             if ($(this).val() == '') {
        //                 $(this).addClass('waring-border-field');
        //                 $(this).next('.required_message').removeClass('hide');
        //                 $(this).next('.required_message').addClass(
        //                     'show warning-message-alert');
        //                 permission = false;
        //             } else if ($(this).hasClass("phone")) {
        //                 if (!isPhone($(this).val())) {
        //                     permission = false;
        //                     $(this).addClass('waring-border-field');
        //                     $(this).next('.required_message').removeClass('hide');
        //                     $(this).next('.required_message').addClass(
        //                         'show warning-message-alert');
        //                     $(this).next('.required_message').text(
        //                         'Invalid phone number');
        //                 } else {
        //                     $(this).removeClass('waring-border-field');
        //                     $(this).next('.required_message').addClass('hide');
        //                     $(this).next('.required_message').removeClass(
        //                         'show warning-message-alert');

        //                 }
        //             } else {
        //                 $(this).removeClass('waring-border-field');
        //                 $(this).next('.required_message').addClass('hide');
        //                 $(this).next('.required_message').removeClass(
        //                     'show warning-message-alert');
        //             }
        //         })



        //     });
        // }




        //if (permission) {
        $('form#appealCase').submit();
        //} else {
        //Swal.fire('২য় পক্ষের সাক্ষী এবং আইনজীবীর তথ্য সঠিক ভাবে পূরণ করুন ')
        //}

    }


    $("form#appealCase").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        swal.showLoading();
        $.ajax({
            url: '{{ route('appeal.store') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'error') {
                    $('#exampleModal').modal('hide');
                    Swal.fire(response.message);
                    toastr.error(response.error);
                    swal.fire({
                        text: response.message,

                    });
                    //scrollCreate(response.div_id);

                } else {

                    $('#exampleModal').modal('hide');
                    swal.close();
                    toastr.success(response.success);
                    window.location.replace('/dashboard');
                }
            }
        });
    });

    // function scrollCreate(div_id) {
    //     var target = $('#' + div_id);
    //     if (target.length) {
    //         $('html,body').animate({
    //             scrollTop: target.offset().top
    //         }, 1000);
    //         return false;
    //     }

    // }

    // ============= Add Attachment Row ========= start =========
    $("#addFileRow").click(function(e) {
        addFileRowFunc();
    });
    //add row function
    function addFileRowFunc() {
        var count = parseInt($('#other_attachment_count').val());
        $('#other_attachment_count').val(count + 1);
        var items = '';
        items += '<tr>';
        items +=
            '<td><input type="text" name="file_type[]" class="form-control form-control-sm" placeholder="ফাইলের নাম দিন" id="file_name_important' +
            count + '" ></td>';
        items += '<td><div class="custom-file"><input type="file" name="file_name[]" onChange="attachmentTitle(' +
            count + ',this)" class="custom-file-input" id="customFile' + count +
            '" /><label class="custom-file-label custom-input' + count + '" for="customFile' + count +
            '">ফাইল নির্বাচন করুন </label></div></td>';
        items +=
            '<td width="40"><a href="javascript:void();" class="btn btn-sm btn-danger font-weight-bolder pr-2" onclick="removeBibadiRow(this)"> <i class="fas fa-minus-circle"></i></a></td>';
        items += '</tr>';
        $('#fileDiv tr:last').after(items);
    }
    //Attachment Title Change
    function attachmentTitle(id, obj) {
        // var value = $('#customFile' + id).val();
        var value = $('#customFile' + id)[0].files[0];

        const fsize = $('#customFile' + id)[0].files[0].size;
        const file_size = Math.round((fsize / 1024));

        var file_extension = value['name'].split('.').pop().toLowerCase();

        if ($.inArray(file_extension, ['pdf', 'docx', 'doc']) == -1) {
            Swal.fire(

                'ফাইল ফরম্যাট PDF, docx, doc হতে হবে ',

            )
            $(obj).closest("tr").remove();
        }
        if (file_size > 30720) {
            Swal.fire(

                'ফাইল সাইজ অনেক বড় , ফাইল সাইজ ১৫ মেগাবাইটের কম হতে হবে',

            )
            $(obj).closest("tr").remove();
        }

        var custom_file_name = $('#file_name_important' + id).val();
        if (custom_file_name == "") {
            Swal.fire(

                'ফাইল এর প্রথমে যে নাম দেয়ার field আছে সেখানে ফাইল এর নাম দিন ',

            )
            $(obj).closest("tr").remove();
        }



        // console.log(value['name']);
        $('.custom-input' + id).text(value['name']);
    }
    //remove Attachment
    function removeBibadiRow(id) {
        $(id).closest("tr").remove();
    }


    function english2bangla(input) {
        var finalEnlishToBanglaNumber = {
            '0': '০',
            '1': '১',
            '2': '২',
            '3': '৩',
            '4': '৪',
            '5': '৫',
            '6': '৬',
            '7': '৭',
            '8': '৮',
            '9': '৯'
        };

        String.prototype.getDigitBanglaFromEnglish = function() {
            var retStr = this;
            for (var x in finalEnlishToBanglaNumber) {
                retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
            }
            return retStr;
        };


        return input.getDigitBanglaFromEnglish();
    }


    $(document).on('keyup', '#court_fee_amount', function(e) {
        $(this).val(english2bangla($(this).val()));
    })
    $(document).on('keyup', '#court_fee_amount', function(e) {
        var field_value = $(this).val();
        let csrf = '{{ csrf_token() }}';
        $.ajax({
            url: '{{ route('number.field.check') }}',
            method: 'post',
            data: JSON.stringify({
                court_fee_amount: field_value,
                _token: csrf
            }),
            cache: false,
            contentType: 'application/json',
            processData: false,
            dataType: 'json',
            success: function(res) {

                if (!res.is_numeric) {
                    alert('শুধুমাত্র সংখ্যা দিন');
                    $('#court_fee_amount').val('');
                }
            }
        });

    })



    function NIDCHECKEDITDEFAULTER(ID) {
        //var row_index=$('#'+id).data('row-index');

        var nid_number = $('#edit_check_nid_number_' + ID).val();
        var dob_number = $('#edit_check_dob_number_' + ID).val();




        swal.showLoading();

        var formdata = new FormData();

        $.ajax({
            url: '{{ route('new.nid.verify.mobile.reg.first') }}',
            method: 'post',
            data: {
                nid_number: nid_number,
                dob_number: dob_number,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success == 'error') {
                    Swal.fire({
                        text: response.message,

                    })

                    let gender = '';
                    let remove_alert = 100000;


                    $("#edit_defaulter_name_" + ID).val('');
                    $("#edit_defaulter_name_" + ID).removeClass('nid_data_pull_warning');
                    $("#edit_defaulter_name_" + ID).prop('readonly', false);

                    $("#edit_defaulter_father_" + ID).val('');
                    $("#edit_defaulter_father_" + ID).prop('readonly', false);
                    $("#edit_defaulter_father_" + ID).removeClass('nid_data_pull_warning');

                    $("#edit_defaulter_mother_" + ID).val('');
                    $("#edit_defaulter_mother_" + ID).prop('readonly', false);
                    $("#edit_defaulter_mother_" + ID).removeClass('nid_data_pull_warning');

                    $("#edit_defaulter_present_address_" + ID).text('');
                    $("#edit_defaulter_present_address_" + ID).prop('readonly',
                        false);
                    $("#edit_defaulter_present_address_" + ID).removeClass('nid_data_pull_warning');

                    $("#edit_defaulter_gender_" + ID).find(':selected').removeAttr(
                        'selected');
                    $("#edit_defaulter_gender_" + ID).find(':disabled').removeAttr(
                        'disabled');

                    $("select[name='defaulter[gender][]'] option:selected").removeAttr(
                        'selected');
                    $("select[name='defaulter[gender][]'] option:disabled").removeAttr(
                        'disabled');

                    $("#edit_defaulter_nid_" + ID).val('');
                    $("#edit_defaulter_nid_" + ID).prop('readonly', false);
                    $("#edit_defaulter_nid_" + ID).removeClass('nid_data_pull_warning');
                    $("#edit_defaulter_email_" + ID).val('');

                } else if (response.success == 'success') {

                    Swal.fire({
                        icon: 'success',
                        text: response.message,

                    });

                    let opposite_gender = ' ';

                    if (response.gender == 'MALE') {
                        opposite_gender = 'FEMALE';
                    } else {
                        opposite_gender = 'MALE';
                    }

                    $("#edit_defaulter_name_" + ID).val(response.name_bn);

                    $("#edit_defaulter_name_" + ID).addClass("nid_data_pull_warning")

                    $("#edit_defaulter_name_" + ID).prop('readonly', true);

                    $("#edit_defaulter_gender_" + ID).find('option[value="' +
                        response.gender + '"]').attr('selected', 'selected');

                    $("#edit_defaulter_gender_" + ID).find('option[value="' +
                        opposite_gender + '"]').attr('disabled', 'disabled');

                    $("#edit_defaulter_father_" + ID).val(response.father);
                    $("#edit_defaulter_father_" + ID).prop('readonly', true);
                    $("#edit_defaulter_father_" + ID).addClass('nid_data_pull_warning');

                    $("#edit_defaulter_mother_" + ID).val(response.mother);
                    $("#edit_defaulter_mother_" + ID).prop('readonly', true);
                    $("#edit_defaulter_mother_" + ID).addClass('nid_data_pull_warning');

                    $("#edit_defaulter_nid_" + ID).val(response.national_id);
                    $("#edit_defaulter_nid_" + ID).prop('readonly', true);
                    $("#edit_defaulter_nid_" + ID).addClass('nid_data_pull_warning');

                    $("#edit_defaulter_present_address_" + ID).text(response
                        .present_address);
                    $("#edit_defaulter_present_address_" + ID).prop('readonly',
                        true);
                    $("#edit_defaulter_present_address_" + ID).addClass('nid_data_pull_warning');
                    $("#edit_defaulter_email_" + ID).val(response.email);
                    $('#defaulter_change').val("has_changed");

                }
            }

        });
    }




    //add defaulerWithness
   @include('appealInitiate.inc._defaulter_withness_create_js')

    $("#RemovedefaulerWithness").on('click', function() {
        var elements = $("#defaulerWithnessInfo #accordionExample3 .card").length;
        if (elements != 1) {
            var citizen_id = $("#defaulerWithnessInfo #accordionExample3 .card:last #defaulerWithnessId_1")
                .val();
            if (citizen_id) {
                Swal.fire({
                        title: "আপনি কি মুছে ফেলতে চান?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "হ্যাঁ",
                        cancelButtonText: "না",
                    })
                    .then(function(result) {
                        if (result.value) {

                            $("#defaulerWithnessInfo #accordionExample3 .card:last").remove();
                        }
                    });
            } else {
                $("#defaulerWithnessInfo #accordionExample3 .card:last").remove();
            }
        } else {
            console.log('fasle');
            Swal.fire({
                position: "top-right",
                icon: "error",
                title: 'আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে',
                showConfirmButton: false,
                timer: 1500,
            });
        }
    });

    $(document).on('click', '.nid_data_pull_warning', function() {

        Swal.fire(
            '',
            'অনুগ্রহ পূর্বক সংশ্লিষ্ট ব্যাক্তির জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করুন ( ফর্ম এর উপরের দিকে দেখুন )। জাতীয় পরিচয়পত্র থেকে পিতার নাম, মাতার নাম, লিঙ্গ, ঠিকানা পেয়ে যাবেন যা পরিবর্তনযোগ্য নয় । তবে জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করার পরেও যদি আপনার তথ্য না আসে সেক্ষেত্রে আপনি তথ্য গুলো টাইপ করে দিতে পারবেন',
            'question'


        )

    });

    function nid_data_pull_warning_function(id) {
        if (id == 100000) {
            return;
        } else {
            Swal.fire(
                '',
                'অনুগ্রহ পূর্বক সংশ্লিষ্ট ব্যাক্তির জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করুন ( ফর্ম এর উপরের দিকে দেখুন )। জাতীয় পরিচয়পত্র থেকে পিতার নাম, মাতার নাম, লিঙ্গ, ঠিকানা পেয়ে যাবেন যা পরিবর্তনযোগ্য নয় । তবে জাতীয় পরিচয়পত্র নম্বর এবং জন্ম তারিখ প্রদান করার পরেও যদি আপনার তথ্য না আসে সেক্ষেত্রে আপনি তথ্য গুলো টাইপ করে দিতে পারবেন',
                'question'
            )
        }


    }


    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    function isPhone(phone) {
        var regex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
        return regex.test(phone);
    }
    $('#search_short_order_important').on('keyup', function() {
        $.each($(".case_short_decision_data"), function(key, value) {
            if ($(this).data('string').indexOf($('#search_short_order_important').val()) >= 0) {
                $('.radio_id_' + $(this).data('row_id_index')).show();
            } else {
                $('.radio_id_' + $(this).data('row_id_index')).hide();
            }

        });
    })
</script>
