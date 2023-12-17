<script src="{{ asset('js/number2banglaWord.js') }}"></script>

<script>
    var globalNote = '';
    var Payable = '';
    var year = '';
    var complain = '';
    var global_order_id = '';
    var before_year_str=' ';
    var after_year_str=' ';

    $('#note').empty();
    $('.modal_close').on('click', function() {
        $('#exampleModal22').modal('hide');
    })

    function deleteFile(id) {
        Swal.fire({
                title: "আপনি কি মুছে ফেলতে চান?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "হ্যাঁ",
                cancelButtonText: "না",
            })
            .then(function(result) {
                if (result.value) {
                    KTApp.blockPage({
                        // overlayColor: '#1bc5bd',
                        overlayColor: 'black',
                        opacity: 0.2,
                        // size: 'sm',
                        message: 'Please wait...',
                        state: 'danger' // a bootstrap color
                    });

                    var url = "{{ url('appeal/deleteFile') }}/" + id;
                    console.log(url);
                    // return;
                    $.ajax({
                        url: url,
                        dataType: "json",
                        type: "Post",
                        async: true,
                        data: {},
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                position: "top-right",
                                icon: "success",
                                title: "সফলভাবে মুছে ফেলা হয়েছে!",
                                showConfirmButton: false,
                                timer: 1500,
                            });
                            KTApp.unblockPage();
                            $('#deleteFile' + id).hide();
                        },
                        error: function(xhr, exception) {
                            var msg = "";
                            if (xhr.status === 0) {
                                msg = "Not connect.\n Verify Network." + xhr.responseText;
                            } else if (xhr.status == 404) {
                                msg = "Requested page not found. [404]" + xhr.responseText;
                            } else if (xhr.status == 500) {
                                msg = "Internal Server Error [500]." + xhr.responseText;
                            } else if (exception === "parsererror") {
                                msg = "Requested JSON parse failed.";
                            } else if (exception === "timeout") {
                                msg = "Time out error." + xhr.responseText;
                            } else if (exception === "abort") {
                                msg = "Ajax request aborted.";
                            } else {
                                msg = "Error:" + xhr.status + " " + xhr.responseText;
                            }
                            console.log(msg);
                            KTApp.unblockPage();
                        }
                    })
                    // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
                }
            });
    }

    // function getval(sel) {
    //     var status = sel.value
    //     if (status == 'CLOSED') {
    //         $("#orderPublish").show();
    //         $("#nextDatePublish").hide();
    //         $("#note").val('');
    //         $('.shortOrderCheckBox').each(function(index) {
    //         if ($(this).is(":checked")) {

    //             var data = $(this).attr('desc');
    //             $("#note").val(data)
    //         }
    //      });

    //     } else {
    //         $("#nextDatePublish").show();
    //         $("#orderPublish").hide();
    //     }
    // }

    function orderPublishDate(sel) {
        var status = sel.value
        if (status == '1') {
            // alert(status);
            $("#finalOrderPublishDate").show();
        }
        if (status == '0') {
            // alert(status);
            $("#finalOrderPublishDate").hide();
        }
    }

    $('#status').on('change', function() {
        if ($(this).val() == "CLOSED") {
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'none');
            $('#appeal_date_time_status #neworderPublish').css('display', 'block');
        } else if ($(this).val() == "REJECTED") {
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'none');
            $('#appeal_date_time_status #neworderPublish').css('display', 'none');
        } else {
            $('#appeal_date_time_status #newnextDatePublish').css('display', 'block');
            $('#appeal_date_time_status #neworderPublish').css('display', 'none');
        }
    })

    function neworderPublishDate(opt) {
        var status = opt.value

        if (status == 1) {

            $("#finalOrderPublishDateNow").show();
        }
        if (status == 0) {

            $("#finalOrderPublishDateNow").hide();
        }

    }

    function sdfsdf(id) {

        var url = "{{ url('appeal/deleteFile') }}/" + id;
        console.log(url);
        $.ajax({
            url: url,
            dataType: "json",
            type: "Post",
            async: true,
            data: {},
            success: function(data) {
                console.log(data);
                $('#deleteFile' + id).hide();
            },
            error: function(xhr, exception) {
                var msg = "";
                if (xhr.status === 0) {
                    msg = "Not connect.\n Verify Network." + xhr.responseText;
                } else if (xhr.status == 404) {
                    msg = "Requested page not found. [404]" + xhr.responseText;
                } else if (xhr.status == 500) {
                    msg = "Internal Server Error [500]." + xhr.responseText;
                } else if (exception === "parsererror") {
                    msg = "Requested JSON parse failed.";
                } else if (exception === "timeout") {
                    msg = "Time out error." + xhr.responseText;
                } else if (exception === "abort") {
                    msg = "Ajax request aborted.";
                } else {
                    msg = "Error:" + xhr.status + " " + xhr.responseText;
                }
                console.log(msg);
            }
        })
    }

    function updateNote(a) {
        var law_sec_id = $('input[name="law_sec_id"]').val();

        var order_id = $(a).val();
        global_order_id = order_id;
        if (order_id == 2 || order_id == 5 || order_id == 21) {
            // alert(order_id);
            $("#investigatorDetails").show();

        } else {
            $("#investigatorDetails").hide();
        }
        if (order_id == 19) {
            // alert(order_id);
            $("#warrantExecutorDetails").show();
        } else {
            $("#warrantExecutorDetails").hide();
        }

        if (order_id == 16) {
            // alert(order_id);
            $("#warrantExecutorZellSuperDetails").show();
        } else {
            $("#warrantExecutorZellSuperDetails").hide();
        }

        if (order_id == 7 || order_id == 16 || order_id == 26 || order_id == 29 || order_id == 23) {
            // alert(order_id);
            $("#law_enforcement_forces_Details").show();
        } else {
            $("#law_enforcement_forces_Details").hide();
        }

        if (order_id == 28 || order_id == 29) {
            // alert(order_id);
            $("#receiver_land_details").show();
        } else {
            $("#receiver_land_details").hide();
        }

        if (order_id == 10 || order_id == 11 || order_id == 5) {
            // alert(order_id);
            $("#complain_details").show();
        } else {
            $("#complain_details").hide();
        }

        if (law_sec_id != 144 || law_sec_id != 100 || law_sec_id != 145) {
            if (order_id == 9 || order_id == 3 || order_id == 33 || order_id == 22) {
                // alert(order_id);
                $("#bond_amount_bond_details").show();
            } else {
                $("#bond_amount_bond_details").hide();
            }
        }
        if (order_id == 18 || order_id == 15 || order_id == 4) {

            $('#status  option[value="CLOSED"]').prop("selected", true);

        } else {
            $('#status  option[value="CLOSED"]').prop("selected", false);
        }

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
        //var data = $('#shortOrder_' + order_id).attr("desc");
        //$("#note").val(data)
    }

    function updateNoteWithData(a) {
        var date = $(a).val();
        globalNote = document.getElementById("note").value;
        if (date == "") {
            if (globalNote.includes("পরবর্তী তারিখ: ")) {
                globalNote = removeLastLine(globalNote);
                globalNote = $.trim(globalNote);
            }
        }

        $('.shortOrderCheckBox').each(function(index) {
            if ($(this).is(":checked")) {
                if (globalNote.includes("পরবর্তী তারিখ: ")) {
                    globalNote = removeLastLine(globalNote);
                    globalNote = $.trim(globalNote);
                }

                var data = globalNote + "\n\n\nপরবর্তী তারিখ: " + date;
                $("#note").val(data)
            }
        });
    }

    function removeLastLine(x) {
        if (x.lastIndexOf("\n") > 0) {
            return x.substring(0, x.lastIndexOf("\n"));
        } else {
            return x;
        }
    }

    function orderPreview() {
        // console.log($("#note").val());
        var description = $("#note").val();
        $("#orderContaint").html(description);
    }

    function saveAsOnTrial(a) {
        // if($request->userRoleCode){

        // }
        // if ($("#appealForm").valid()) {
        var n = $("#appealForm"),
            t = new FormData(n[0]),
            l = $("#userRoleCode").val();
        if ("GCO_" == l) {
            var p = t.get("note").replace(/\r\n|\r|\n/g, "<br />");
            t.append("note", p)
        }
        if ("GCO_" != l & "Peshkar_" != l)
            "ON_TRIAL" === a ? t.append("status", "ON_TRIAL") : t.append("status", "ON_DC_TRIAL");
        else if (3 == $("#appealDecision").val()) t.append("status", "CLOSED");
        else if (4 == $("#appealDecision").val()) {
            var i = $("#getUserRole").val();
            "DM" == i ? t.append("status", "RESEND_TO_PESHKAR") : "ADM" == i && t.append("status", "RESEND_TO_DM")
        } else 2 == $("#appealDecision").val() ? t.append("status", "POSTPONED") : t.append("status", "ON_TRIAL");
        t.append(
                "appealId",
                $("#appealId").val()),
            $("#oldCaseFlag").is(":checked") ?
            t.append("oldCaseFlag", $("#oldCaseFlag").val()) :
            t.append("oldCaseFlag", "0"),
            $.confirm({
                resizable: !1,
                height: 250,
                width: 400,
                modal: !0,
                title: "বিচারকার্যক্রম তথ্য",
                titleClass: "modal-header",
                content: "বিচারকার্যক্রম সংরক্ষণ করতে চান ?",
                buttons: {
                    "না": function() {},
                    "হ্যাঁ": function() {
                        $("#loadingModal").show(),
                            appeal.appealSave(e, "/appeal/store/ontrial", t).done(function(a, e, n) {
                                $("#loadingModal").hide(), "true" == a.flag ? ($.alert(
                                        " বিচারকার্যক্রম  সম্পন্ন  হয়েছে", "অবহিতকরণ বার্তা"),
                                    setTimeout(function() {
                                        window.location = "/appeal/list"
                                    }, 3e3)) : $.alert("ত্রুটি", "অবহিতকরণ বার্তা")
                            }).fail(function() {
                                $("#loadingModal").hide(), $.alert("ত্রুটি", "অবহিতকরণ বার্তা")
                            })
                    }
                }
            })
        // }
    }
</script>
@include('appealInitiate.appealCreate_Js')
<script>
    $(document).ready(function() {
        $('#CaseDetails input').prop('disabled', true);
        $('#CaseDetails select').prop('disabled', true);
        $('#CaseDetails textarea').prop('disabled', true);
    });
</script>
<script>
    $('#trialDate,#finalOrderPublishDateTime, #finalOrderPublishDateNow').datepicker({
        startDate: new Date(),
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "bottom left"
    });

    /*$("#trialDate").on('click',function() {
        $(function(){
            var dtToday = new Date();
            
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;

            // or instead:
            // var maxDate = dtToday.toISOString().substr(0, 10);

            alert(maxDate);
            $('#trialDate').attr('min', maxDate);
        });
    });*/
</script>




@include('components.Ajax')
<script>
    $("#ReportForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: "{{ route('appeal.trial.report_add') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            // beforeSubmit: function() {
            //     $(".progress-bar").width('0%');
            //     $("#uploadStatus").html('Uploading FILE');
            // },
            // success: (data) => {
            //     // this.reset();
            //     // toastr.success(data.success, "Success");
            //     console.log(data);
            //     // console.log(data.html);
            //     // $('.ajax').remove();
            //     // $('#caseHearingList').empty();
            //     // $('#caseHearingList').append('<label class="ajax" style="display:block !important;">' + data.html + '</label>')
            //     // $('#hearing_add_button_close').click()
            //     // $('#hearingNoticelod').removeClass('spinner spinner-white spinner-right disabled');

            // },
            // error: function(data) {
            //     console.log(data);
            //     // $('#hearingNoticelod').removeClass('spinner spinner-white spinner-right disabled');

            // }
        });
    });

    function ReportFormSubmit(formId) {
        console.log('check');
        $("#" + formId + " #submit").addClass('spinner spinner-dark spinner-left disabled');
        var form = $("#" + formId);

        var formData = new FormData(form[0]);
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: "{{ route('appeal.trial.report_add') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSubmit: function() {
                $(".progress-bar").width('0%');
                $("#uploadStatus").html('Uploading FILE');
            },
            success: (data) => {
                // form[0].reset();
                toastr.success(data.success, "Success");
                console.log(data);
                // console.log(data.html);
                // $('.ajax').remove();
                $('#legalReportSection').empty();
                $('#legalReportSection').append(data.data)
                // $('#hearing_add_button_close').click()
                $("#" + formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');
                $('.modal').modal('hide');
                form[0].reset();


            },
            error: function(data) {
                console.log(data);
                $("#" + formId + " #submit").removeClass('spinner spinner-white spinner-right disabled');

            }
        });
    }

    $(document).ready(function() {
        $("#formSubmit").click(function() {
            $("#caseRivisionForm").submit(); // Submit the form
        });
    });

    function AttPrintHideShow(type) {
        var att = $('input[name="citizenAttendance[' + type + '][attendance]"]:checked').val();
        if (att == 'ABSENT') {
            $("#attVic" + type).addClass("d-none");
        } else {
            $("#attVic" + type).removeClass("d-none");
        }
        // console.log(att);
    }

    function investigatorHideShow(typeID) {
        // var typeID = $('input[name="investigatorType"]').val();
        // alert(typeID);
        if (typeID == 1) {
            $("#nothiCheck").show();
            $("#ofiicerInvestigator").show();
            $("#defenceInvestigator").hide();
            $('#OtherInvestigator').hide();
        } else if (typeID == 2) {
            $("#nothiCheck").hide();
            $("#ofiicerInvestigator").hide();
            $("#defenceInvestigator").show();
            $('#OtherInvestigator').hide();
        } else {
            $("#nothiCheck").hide();
            $("#ofiicerInvestigator").hide();
            $("#defenceInvestigator").hide();
            $('#OtherInvestigator').show();
        }
        // console.log(att);
    }

    function goToURL() {
        var date = $('#conductDate').val();
        window.open("{{ route('appeal.trial.attendance_print', $appeal->id) }}?conductDate=" + date, "_blank");
    }
</script>
<script>
    function checkInvestigator() {
        Swal.showLoading();
        $.ajax({
            method: "GET",
            url: "{{ route('investigator_doptor_check') }}",
            data: {

                nothiID: $('#nothiID').val(),
                _token: '{{ csrf_token() }}'

            },
            success: (result) => {
                if (result.success == 'success') {
                    let text = document.getElementById("note").value;
                    Swal.close();
                    $('#investigatorName').val(result.investigatorName);
                    $('#investigatorInstituteName').val(result.investigatorInstituteName);
                    $('#investigatorMobile').val(result.investigatorMobile);
                    $('#investigatorEmail').val(result.investigatorEmail);
                    $('#investigatorDesignation').val(result.investigatorDesignation);
                    document.getElementById("note").value = text.replace("{#investigator}", result
                        .investigatorName);
                    investigator = result.investigatorName;

                }
                if (result.error == 'error') {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'কোন তথ্য পাওয়া যায় নি!',

                    })
                }
            },
            error: (error) => {
                // console.log(error);

            }
        });
    }


    function investigatorType() {

        if (document.getElementById('defenceInvestigator').checked) {
            document.getElementById('defence').style.display = 'block';
        } else {
            document.getElementById('officer').style.display = 'block';
        }


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

    $('#bond_amount').on('change', function() {
        if ($(this).val() == "" || $(this).val() <= 0) {
            return;
        }
        let text = document.getElementById("note").value;
        if (text.includes("{#Payable}")) {
            document.getElementById("note").value = text.replace("{#Payable}", NumToBangla.replaceNumbers($(
                this).val()));
            Payable = $(this).val();
        } else {

            document.getElementById("note").value = text.replace(NumToBangla.replaceNumbers(Payable),
                NumToBangla.replaceNumbers($(this).val()));
            Payable = $(this).val();
        }
        globalNote = text;
    })

    $('#bond_period').on('change', function() {
        if ($(this).val() == "" || $(this).val() <= 0) {
            return;
        }
        let text = document.getElementById("note").value;
        if (text.includes("{#year}")) {
            
            var word_array=document.getElementById("note").value.split(' ');

            for(var index=0;index<word_array.length;index++)
                {
                    if(word_array[index]=="{#year}")
                    {
                        //alert(word_array[index+1]);
                        before_year_str=word_array[index-1];
                        after_year_str=word_array[index+1];       
                    }
                }
                
            document.getElementById("note").value = text.replace("{#year}", NumToBangla.replaceNumbers($(this)
                .val()));
                    
            year = $(this).val();
        } else {
            // var array_word=document.getElementById("note").value.split(' ').reverse().join(' ');
            
            // document.getElementById("note").value=array_word.replace(NumToBangla.replaceNumbers(year), NumToBangla
            //     .replaceNumbers($(this).val())).split(' ').reverse().join(' '); 
                
                var word_array=document.getElementById("note").value.split(' ');
                //console.log(word_array);
                for(var index=0;index<word_array.length;index++)
                {
                    if(word_array[index]==before_year_str && word_array[index+2]==after_year_str)
                    {
                        //alert(word_array[index+1]);
                        word_array[index+1]=NumToBangla.replaceNumbers($(this).val());
                                
                    }
                }
                //console.log(word_array.join(' '));
                document.getElementById("note").value=word_array.join(' ');
            year = $(this).val();
        }
        globalNote = text;
    })

    $('#investigatorName').on('change', function() {

        if ($(this).val() == "") {
            return;
        }
        let text = document.getElementById("note").value;
        if (text.includes("{#investigator}")) {
            document.getElementById("note").value = text.replace("{#investigator}", $(this).val());
            investigator = $(this).val();
        } else {

            document.getElementById("note").value = text.replace(investigator, $(this).val());
            investigator = $(this).val();
        }
        globalNote = text;
    })

    $('#complain_detail').on('change', function() {

        if ($(this).val() == "") {
            return;
        }
        let text = document.getElementById("note").value;
        if (text.includes("{#complain}")) {
            document.getElementById("note").value = text.replace("{#complain}", $(this).val());
            complain = $(this).val();
        } else {

            if (global_order_id == 10 || global_order_id == 11) {
                document.getElementById("note").value = text.replace(complain, ($(this).val()));
                complain = $(this).val();

            }

        }
        globalNote = text;
    })

    $('#note').on('change', function() {
        globalNote = document.getElementById("note").value;
    })
</script>
