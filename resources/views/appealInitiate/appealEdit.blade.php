@extends('layouts.landing')

@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link href="{{ asset('custom/style.bundle.css') }}" />
@endsection

@section('content')
    <style>
        .hide {
            display: none;
        }

        .show {
            display: block;
        }

        .waring-border-field {
            border: 2px solid tomato;
        }

        .warning-message-alert {
            color: red;
        }

        .waring-message-alert-success {
            color: aqua;
        }

        .waring-border-field-succes {
            border: 2px solid aqua;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                                        <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                        <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                                    </div> -->
                    </div>
                </div>

                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('FileError'))
                    <div class="alert alert-danger">
                        {{ Session::get('FileError') }}
                    </div>
                @endif

                <?php
                if ($appeal->law_section == 1) {
                    $display = 'display: block;';
                } else {
                    $display = 'display: none;';
                }
                ?>

                <!--begin::Form-->
                <form id="appealCase" action="" class="form" method="" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="appealId" value="{{ $appeal->id }}">
                    <input type="hidden" name="appealEntryType" value="edit">
                    <input type="hidden" name="defaulter_change" id="defaulter_change">
                    <input type="hidden" name="defaulter_withness_change" id="defaulter_withness_change">
                    <input type="hidden" name="defaulter_lawyer_change" id="defaulter_lawyer_change">

                    @if ($appeal->appeal_status == 'SEND_TO_ASST_EM')
                        <input type="hidden" name="status" id="" value="SEND_TO_EM">
                    @elseif($appeal->appeal_status == 'SEND_TO_ASST_DM')
                        <input type="hidden" name="status" id="" value="SEND_TO_DM">
                    @else
                        <input type="hidden" name="status" id="" value="{{ $appeal->appeal_status }}">
                    @endif

                    <div class="card-body">
                        @include('appealInitiate.inc.citizen_info')

                        @include('appealInitiate.inc.court_fee')
                        @if ($appeal->investigation_report_is_submitted == 1)
                            @if (count($em_investigation_report_before_accepted) > 0)
                                @include('appealTrial.inc._investigationReportSectionBeforeAccepted')
                            @endif

                            @if (count($em_investigation_report_after_accepted) > 0)
                                @include('appealTrial.inc._investigationReportSectionAfterAccepted')
                            @endif
                        @endif

                        @include('appealInitiate.inc.orders_list')
                        @include('appealInitiate.inc._voice_to_text')
                        @include('appealInitiate.inc.working_order_list')
                        
                        <table class="table table-striped border">
                            <thead>
                                <th class="h3" scope="col" colspan="2">সংযুক্তি</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @forelse ($attachmentList as $key => $row)
                                            <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button class="btn bg-success-o-75"
                                                            type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                    </div>
                                                    {{-- <input readonly type="text" class="form-control" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                                    <input readonly type="text" class="form-control"
                                                        value="{{ $row->file_category ?? '' }}" />
                                                    <div class="input-group-append">
                                                        <a href="{{ asset($row->file_path . $row->file_name) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-success font-size-h5 float-left">
                                                            <i class="fa fas fa-file-pdf"></i>
                                                            <b>দেখুন</b>
                                                            {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" />  --}}
                                                        </a>
                                                        {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                                    </div>
                                                    <div class="input-group-append">
                                                        {{-- <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }},{{ $appeal->id }} )" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                    <b>মুছুন</b>
                                                </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="pt-5">
                                                <p class="text-center font-weight-normal font-size-lg">কোনো সংযুক্তি খুঁজে
                                                    পাওয়া যায়নি</p>
                                            </div>
                                        @endforelse
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <fieldset class=" mb-8">
                            <div
                                class="rounded bg-success-o-75 d-flex align-items-center justify-content-between flex-wrap px-5 py-0">
                                <div class="d-flex align-items-center mr-2 py-2">
                                    <h3 class="mb-0 mr-8">সংযুক্তি (যদি থাকে)</h3>
                                </div>
                                <!--end::Info-->
                                <!--begin::Users-->
                                <div class="symbol-group symbol-hover py-2">
                                    <div class="symbol symbol-30 symbol-light-primary" data-toggle="tooltip"
                                        data-placement="top" title="" role="button" data-original-title="">
                                        <div id="addFileRow">
                                            <span class="symbol-label font-weight-bold bg-success">
                                                <i class="text-white fa flaticon2-plus font-size-sm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Users-->
                            </div>
                            <div class="mt-3 px-5">
                                <table width="100%" class="border-0 px-5" id="fileDiv"
                                    style="border:1px solid #dcd8d8;">
                                    <tr></tr>
                                </table>
                                <input type="hidden" id="other_attachment_count" value="1">
                            </div>
                        </fieldset>

                        <div class="row buttonsDiv">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{-- @if (globalUserInfo()->role_id != 37 && globalUserInfo()->role_id != 38)
                                        <input type="hidden" id="status" name="status" value="ON_TRIAL">
                                    @else
                                        <input type="hidden" id="status" name="status" value="ON_TRIAL_DM">
                                    @endif --}}
                                    <button id="orderPreviewBtn" type="button" class="btn btn-primary"
                                        data-toggle="modal" data-target="#exampleModal" disabled
                                        onclick="orderPreview()">
                                        প্রিভিউ ও সংরক্ষণ
                                    </button>
                                    <!-- <button type="button" class="btn btn-primary" onclick="myFunction()">
                                                    আদেশ সংরক্ষণ করুন
                                                </button> -->
                                    {{-- <button type="button" onclick="formSubmit()" class="btn btn-warning">
                                        প্রেরণ(সংশ্লিষ্ট আদালত)
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
    @include('appealInitiate.inc.__orderPreview')
@endsection
@section('styles')
@endsection

@section('scripts')
    <script src="{{ asset('js/number2banglaWord.js') }}"></script>
    <script>
        function deleteFile(id, appeal_id) {
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

                        var url = "{{ url('appeal/deleteAppealFile') }}/" + id + "/" + appeal_id;
                        // console.log(url);
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
    </script>

    @include('appealInitiate.inc._edit_scripts')
@endsection
