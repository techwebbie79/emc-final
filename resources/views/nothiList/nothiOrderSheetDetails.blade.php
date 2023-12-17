@extends('layouts.landing')
@auth
    @section('content')
        <div class="card card-custom">
            <div class="card-header flex-wrap py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-10">
                            <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                        </div>

                        <div class="col-2">
                            {{-- <a href="{{ route('appeal.pdfOrderSheet', $nothi_id) }}"
                            class="btn btn-danger btn-link" style="float: right;" target="_blank">জেনারেট পিডিএফ</a> --}}
                            {{-- <a href="{{ route('appeal.view.citizen.pdf.create',['appeal_id'=>$nothi_id]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a> --}}
                            <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                        </div>

                        {{-- <div class="col-2">
                    @if (Auth::user()->role_id == 2)
                    <a href="{{ route('messages_group') }}?c={{ $appeal->id }}" class="btn btn-primary float-right">বার্তা</a>
                        @endif
                </div> --}}

                    </div>
                </div>
            </div>

            <div class="card-body" id="element-to-print">
                <div class="contentForm" style="font-size: medium;">
                    <div class="contentForm" style="font-size: medium;">
                        <div class="contentForm" style="font-size: medium;">
                            <div class="contentForm" style="font-size: medium;">
                                <div id="head">
                                    <p class="form-bd" style="text-align: left;">বাংলাদেশ ফরম নম্বর - ৩৮৯০ <span
                                            style="float: right">ফৌঃ কাঃ বিঃ - ১০৭/১১৪/১১৭ (সি) ধারা</span><br></p>
                                    <p class="form-bd" style="text-align: left;">
                                        <sm>সুপ্রিম কোর্ট(হাইকোর্ট বিভাগ) ক্রিমিনাল ফরম নং(এম)১০৬ </sm>
                                    </p>
                                    <h2 style="text-align: center;"> ম্যাজিস্ট্রেটের রেকর্ডের জন্য আদেশনামা</h2>
                                    <p style="text-align: center;">(১৮৮৮ সালের ১১ই জুলাই এর ১ নম্বর পরিপক্ক যাহা ১৯০১ সালের ১৮ই
                                        নভেম্বর ৬ নম্বর পরিপক্ষ দ্বারা পুনঃ প্রবর্তিত ) ;<br><span>আদেশপত্র, তারিখ
                                            {{ en2bn($appealOrderLists['ordershit_start_date']) }}
                                            হইতে {{ en2bn($appealOrderLists['ordershit_end_date']) }} পর্যন্ত ।</span>
                                        <br><span> জেলা/ উপজেলা : {{ $appealOrderLists['case_Upzilla'] }}
                                            {{ $appealOrderLists['case_District'] }}, পি.আর
                                            ...../{{ en2bn(explode('-', $appealOrderLists['ordershit_end_date'])[2]) }}ইং<br>
                                            {{ en2bn($appealOrderLists['ordershit_end_date']) }} এর আদালত ।</span>
                                        <br><br><span style="float: right">
                                            সন:
                                            {{ en2bn(explode('-', $appealOrderLists['case_info']['case_date'])[0]) }}</span><span
                                            style="float: left;"> মামলা নম্বর:
                                            {{ en2bn($appealOrderLists['case_info']['case_no']) }}</span></p>
                                    <div id="dependent"></div><br><br><span style="float: left;"> বাদী:-
                                        {{ $appealOrderLists['case_info']['applicant_name'] }}
                                    </span> <span style="text-align: center;padding-left: 382px;">বনাম </span><span
                                        style="float: right;"> বিবাদী:-
                                        {{ $appealOrderLists['case_info']['defaulter_name'] }}</span>
                                    <p></p>
                                    <div id="dependent"></div><br>
                                </div>

                                <div id="body" style="overflow: hidden;">
                                    <table width="100%" cellspacing="0" cellpadding="0" border="1">
                                        <thead>
                                            <tr>
                                                <td width="5%" valign="middle" align="center"> আদেশের ক্রমিক নং </td>
                                                <td width="10%" valign="middle" align="center"> তারিখ</td>
                                                <td width="80%" valign="middle" align="center"> আদেশ </td>
                                                <td width="5%" valign="middle" align="center"> স্বাক্ষর</td>
                                            </tr>
                                        </thead>
                                        @if (!empty($appealOrderLists['shortoder_array_date']))
                                            @foreach ($appealOrderLists['shortoder_array_date'] as $index => $singleorder)
                                                <tr>
                                                    <td width="5%" valign="middle" align="center">{{ en2bn(++$index) }}
                                                    </td>
                                                    <td width="10%" valign="middle" align="center">
                                                        {{ en2bn($singleorder['order_date']) }}</td>
                                                    <td width="80%" valign="middle" align="left">
                                                        <p style="text-align: justify;margin-left:10px;margin-right:10px">{{ $singleorder['peshkar_order'] }}</p>
                                                        <br>
                                                        <p style="text-align: justify;margin-left:10px;margin-right:10px">{{ $singleorder['em_order'] }}</p>
                                                    </td>
                                                    <td width="5%" valign="middle" align="center">
                                                        <img src="{{ $singleorder['em_adm_signature'] }}" alt="">
                                                        <p style="color: blueviolet;">{{ $singleorder['em_adm_name'] }}</p>
                                                        <p style="color: blueviolet;">{{ $singleorder['designation'] }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                                <h3 id="rayNamaHeading" style="text-align: center;"></h3>
                                <div id="rayHeadAppealNama" class="ray-head"></div>
                                <div id="rayBodyAppealNama" class="ray-body"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-4">
                                    <p class="ml-5" style="margin-bottom: -2px;margin-top: 20px;">স্ক্যান করুন</p>
                                    <div id="qr_code_show">
                                        <img src="{{ $data_image_path }}" alt="">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>
        {{-- <div id="appealNamaTemplate" style="display: none; ">
        @include('reports.appealNama')
    </div>
    <div id="appealRayTemplate" style="display: none; ">
        @include('reports.rayNama')
    </div>

    <div id="appealShortOrderTemplate" style="display: none; ">
        @include('ShortOrderTemplate.shortOrderTemplateView')
    </div> --}}
    @endsection
@else
    @section('landing')
        <div class="container" style="margin-top:70px">
            <div class="card card-custom">
                <div class="card-header flex-wrap py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-10">
                                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                            </div>

                            <div class="col-2">
                                {{-- <a href="{{ route('appeal.pdfOrderSheet', $nothi_id) }}"
                            class="btn btn-danger btn-link" style="float: right;" target="_blank">জেনারেট পিডিএফ</a> --}}
                                {{-- <a href="{{ route('appeal.view.citizen.pdf.create',['appeal_id'=>$nothi_id]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a> --}}
                                <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                            </div>

                            {{-- <div class="col-2">
                    @if (Auth::user()->role_id == 2)
                    <a href="{{ route('messages_group') }}?c={{ $appeal->id }}" class="btn btn-primary float-right">বার্তা</a>
                        @endif
                </div> --}}

                        </div>
                    </div>
                </div>

                <div class="card-body" id="element-to-print">
                    <div class="contentForm" style="font-size: medium;">
                        <div class="contentForm" style="font-size: medium;">
                            <div class="contentForm" style="font-size: medium;">
                                <div class="contentForm" style="font-size: medium;">
                                    <div id="head">
                                        <p class="form-bd" style="text-align: left;">বাংলাদেশ ফরম নম্বর - ৩৮৯০ <span
                                                style="float: right">ফৌঃ কাঃ বিঃ - ১০৭/১১৪/১১৭ (সি) ধারা</span><br></p>
                                        <p class="form-bd" style="text-align: left;">
                                            <sm>সুপ্রিম কোর্ট(হাইকোর্ট বিভাগ) ক্রিমিনাল ফরম নং(এম)১০৬ </sm>
                                        </p>
                                        <h2 style="text-align: center;"> ম্যাজিস্ট্রেটের রেকর্ডের জন্য আদেশনামা</h2>
                                        <p style="text-align: center;">(১৮৮৮ সালের ১১ই জুলাই এর ১ নম্বর পরিপক্ক যাহা ১৯০১ সালের
                                            ১৮ই
                                            নভেম্বর ৬ নম্বর পরিপক্ষ দ্বারা পুনঃ প্রবর্তিত ) ;<br><span>আদেশপত্র, তারিখ
                                                {{ en2bn($appealOrderLists['ordershit_start_date']) }}
                                                হইতে {{ en2bn($appealOrderLists['ordershit_end_date']) }} পর্যন্ত ।</span>
                                            <br><span> জেলা/ উপজেলা : {{ $appealOrderLists['case_Upzilla'] }}
                                                {{ $appealOrderLists['case_District'] }}, পি.আর
                                                ...../{{ en2bn(explode('-', $appealOrderLists['ordershit_end_date'])[2]) }}ইং<br>
                                                {{ en2bn($appealOrderLists['ordershit_end_date']) }} এর আদালত ।</span>
                                            <br><br><span style="float: right">
                                                সন:
                                                {{ en2bn(explode('-', $appealOrderLists['case_info']['case_date'])[0]) }}</span><span
                                                style="float: left;"> মামলা নম্বর:
                                                {{ en2bn($appealOrderLists['case_info']['case_no']) }}</span></p>
                                        <div id="dependent"></div><br><br><span style="float: left;"> বাদী:-
                                            {{ $appealOrderLists['case_info']['applicant_name'] }}
                                        </span> <span style="text-align: center;padding-left: 382px;">বনাম </span><span
                                            style="float: right;"> বিবাদী:-
                                            {{ $appealOrderLists['case_info']['defaulter_name'] }}</span>
                                        <p></p>
                                        <div id="dependent"></div><br>
                                    </div>

                                    <div id="body" style="overflow: hidden;">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="1">
                                            <thead>
                                                <tr>
                                                    <td width="5%" valign="middle" align="center"> আদেশের ক্রমিক নং </td>
                                                    <td width="10%" valign="middle" align="center"> তারিখ</td>
                                                    <td width="80%" valign="middle" align="center"> আদেশ </td>
                                                    <td width="5%" valign="middle" align="center"> স্বাক্ষর</td>
                                                </tr>
                                            </thead>
                                            @if (!empty($appealOrderLists['shortoder_array_date']))
                                                @foreach ($appealOrderLists['shortoder_array_date'] as $index => $singleorder)
                                                    <tr>
                                                        <td width="5%" valign="middle" align="center">
                                                            {{ en2bn(++$index) }}</td>
                                                        <td width="10%" valign="middle" align="center">
                                                            {{ en2bn($singleorder['order_date']) }}</td>
                                                        <td width="80%" valign="middle" align="left">
                                                            <p style="text-align: justify;margin-left:10px;margin-right:10px">{{ $singleorder['peshkar_order'] }}</p>
                                                            <br>
                                                            <p style="text-align: justify;margin-left:10px;margin-right:10px">{{ $singleorder['em_order'] }}</p>
                                                        </td>
                                                        <td width="5%" valign="middle" align="center">
                                                            <img src="{{ $singleorder['em_adm_signature'] }}" alt="">
                                                            <p style="color: blueviolet;">{{ $singleorder['em_adm_name'] }}
                                                            </p>
                                                            <p style="color: blueviolet;">{{ $singleorder['designation'] }}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <h3 id="rayNamaHeading" style="text-align: center;"></h3>
                                    <div id="rayHeadAppealNama" class="ray-head"></div>
                                    <div id="rayBodyAppealNama" class="ray-body"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>আমাকে স্ক্যান করুন</p>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="qr_code_show">
                                            <img src="{{ $data_image_path }}" alt="">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- <div id="appealNamaTemplate" style="display: none; ">
        @include('reports.appealNama')
    </div>
    <div id="appealRayTemplate" style="display: none; ">
        @include('reports.rayNama')
    </div>

    <div id="appealShortOrderTemplate" style="display: none; ">
        @include('ShortOrderTemplate.shortOrderTemplateView')
    </div> --}}
    @endsection
@endauth
@section('scripts')
    {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
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

            var data = "TOUHIDUL";
            var img = '<img style="margin: 0 auto" src="https://chart.googleapis.com/chart?chs=' + 300 + 'x' + 300 +
                '&cht=qr&chl=' + data + '">';
            console.log(img);
        })



        function generatePDF() {
            var element = document.getElementById('element-to-print');
            var opt = {
                margin: 1,
                filename: 'myfile.pdf',
                pagebreak: {
                    avoid: ['tr', 'td']
                },
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
@endsection

@section('jsComponent')
    <script src="{{ asset('js/appeal/appeal-ui-utils.js') }}"></script>
    <script src="{{ asset('js/appeal/appealPopulate.js') }}"></script>
    {{-- <script src="{{ asset('js/initiate/ .js') }}"></script> --}}
    <script src="{{ asset('js/reports/appealNama.js') }}"></script>
    <script src="{{ asset('js/reports/rayNama.js') }}"></script>
    <script src="{{ asset('js/shortOrderTemplate/shortOrderTemplate.js') }}"></script>
    <script src="{{ asset('js/englishToBangla/convertEngToBangla.js') }}"></script>
    <script>
        appealNama = module.exports = {
            getAppealOrderListsInfo: function(appealId) {
                return $.ajax({
                    headers: {
                        'X-CSRF-Token': appealPopulate.token
                    },
                    url: '/appeal/get/appealnama',
                    method: "post",
                    data: {
                        appealId: appealId
                    },
                    dataType: 'json'
                });
            },
            printAppealNama: function() {
                var appealNamaContent = '',
                    rayNamaContent = '',
                    rayHead = '',
                    rayBody = '';
                var appealId = $('#appealId').val();
                appealNama.getAppealOrderListsInfo(appealId).done(function(response, textStatus, jqXHR) {

                    if (response.appealOrderLists.length > 0) {

                        appealNamaContent = appealNama.getAppealNamaReport(response);

                        $('#head').empty();
                        $('#body').empty();

                        $('#head').append(appealNamaContent.header);
                        $('#body').append(appealNamaContent.body);


                        //-------------------------------------------------------------------//

                        var newwindow = window.open();
                        newdocument = newwindow.document;
                        newdocument.write($('#appealNamaTemplate').html());
                        newdocument.close();
                        setTimeout(function() {
                            newwindow.print();
                        }, 500);
                        return false;
                    } else {
                        $.alert('আদেশ প্রদান করা হয় নি', 'অবহিতকরণ বার্তা');
                    }

                })

            },
            getAppealNamaReport: function(appealInfo) {
                var header = '',
                    body = '',
                    th = '',
                    tableClose = '';
                header = appealNama.prepareAppealNamaHeader(appealInfo);
                th = appealInfo.appealOrderLists[0].order_detail_table_th;
                tableClose = appealInfo.appealOrderLists[0].order_detail_table_close;
                body = th + appealNama.prepareAppealNamaBody(appealInfo) + tableClose;

                return {
                    header: header,
                    body: body
                };
            },
            prepareAppealNamaHeader: function(appealInfo) {
                var length = appealInfo.appealOrderLists.length;
                var header = appealInfo.appealOrderLists[length - 1].order_header;

                return header;

            },
            prepareAppealNamaBody: function(appealInfo) {

                var body = "";
                $.each(appealInfo.appealOrderLists, function(index, orderList) {
                    body += orderList.order_detail_table_body;
                });

                return body;

            }
        };
    </script>
@endsection
