@extends('layouts.landing')
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="container">
                <div class="row">
                    <div class="col-10">
                        <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    </div>

                    <div class="col-2">
                        <a href="javascript:generatePDF()" class="btn btn-danger btn-link">জেনারেট পিডিএফ</a>
                    </div>

                 

                </div>
            </div>
        </div>

        <div class="card-body" id="element-to-print">
            <div style="text-align: center;">
                                <h2>হাজিরা</h2>
            </div>
            <div id="body" style="overflow: hidden; padding-right: 20px; padding-left: 20px;">
                <div style="padding-bottom:1%;padding-top:5%">
                            <div style="text-align: left; padding-left: 10px;">
                                মোকাম {{ $district }}  এর <b><span style="text-decoration-line: underline;text-decoration-style: dotted;">  বিজ্ঞ {{ globalUserInfo()->role->role_name }}</span></b> এর আদালত
                            </div>
                            <!-- <div style="float: right;">
                                <b>আদালত</b>
                            </div> -->
                        </div>
                        <div style="padding-bottom: 1%;padding-top:5%">
                            
                            <div style="float: right;">
                                <b style="text-decoration-line: underline;text-decoration-style: dotted;"> {{ $applicant['citizen_name'] }} </b>বাদী/প্রার্থী/রাষ্ট্র/আপিলেন্ট 
                            </div>
                            
                        </div>
                        <div style="padding-bottom: 1%; padding-left: 10px;">
                            <div style="float: left;">
                                <b>মামলা নংঃ <span id="caseNumber">{{ $case_no }}</span></b>
                            </div>
                            <div style="text-align: center; padding-right: 15%;">
                                <b><h2>বনাম</h2></b>
                            </div>
                           
                        </div>
                        <div style="padding-bottom: 1%;">
                            
                            <div style="float: right;">
                                <b style="text-decoration-line: underline;text-decoration-style: dotted;">{{ $defaulter['citizen_name'] }} </b>বিবাদী/প্রতিপক্ষ/আসামী/রেস্পন্ডেন্ট  
                            </div>
                            
                        </div>
                        <div style="padding-top: 10%;padding-left: 30%;">
                            
                            <div style="float: left; width: 70px;">
                            </div>
                            <div style="float: right;">
                                অদ্য বিজ্ঞ আদালতে বাদী/ অভিযোগকারী/ প্রার্থী/আসামী/ বিবাদী/ প্রতিপক্ষ/সাক্ষীর/আপিলেন্ট/ রেসপন্ডেন্ট এর হাজিরা দাখিল করা গেল। 
                            </div>
                            
                        </div>
            </div>
            <h3 id="rayNamaHeading" style="text-align: center;"></h3>
            <div id="rayHeadAppealNama" class="ray-head"></div>
            <div id="rayBodyAppealNama" class="ray-body"></div>
        </div>

        </div>

    </div>
    
@endsection

@section('scripts')
    {{-- https://www.byteblogger.com/how-to-export-webpage-to-pdf-using-javascript-html2pdf-and-jspdf/
    https://ekoopmans.github.io/html2pdf.js/ --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function generatePDF() {
            var element = document.getElementById('element-to-print');
            html2pdf(element);
        }
    </script>
@endsection

