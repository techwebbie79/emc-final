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
                            <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                            {{-- <a href="{{ route('appeal.view.citizen.pdf.create.shortOrder',['appeal_id'=>$nothi_id]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a> --}}
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
                <div id="body" style="overflow: hidden; padding: 40px;">
                    <?php foreach($appealShortOrderLists as $key=>$row){?>
                    <?php echo $row->template_full; ?>

                    <?php }?>
                </div>
                <div class="row" style="margin-top:-100px ">
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
    @endsection
@else
    @section('landing')
        <div class="container"  style="margin-top:70px">
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
                                <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                                {{-- <a href="{{ route('appeal.view.citizen.pdf.create.shortOrder',['appeal_id'=>$nothi_id]) }}" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a> --}}
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
                    <div id="body" style="overflow: hidden; padding: 40px;">
                        <?php foreach($appealShortOrderLists as $key=>$row){?>
                        <?php echo $row->template_full; ?>

                        <?php }?>
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
    @endsection
@endauth
@section('scripts')
    {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
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
