@extends('layouts.landing')

@section('style')
@endsection

@section('landing')
    <!--begin::Landing hero-->
    <link rel="stylesheet" type="text/css" href="http://parsleyjs.org/src/parsley.css" />
    @auth
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-4"style="margin-top:100px;text-align:center;">
                            <img src="{{ asset('images/book.png') }}" alt="Girl in a jacket" width="100%" height="250">
                        </div>
                        <div class="col-md-8">
                            <div style="margin-top: 165px; margin-left: 55px;">
                                <h1 class="phome_h1_text">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট</h1>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট ব্যবস্থার অনলাইন প্ল্যাটফর্মে
                            আপনাকে
                            স্বাগতম।
                            সিস্টেমটির মাধ্যমে নাগরিক অভিযোগ দায়ের  করতে পারবে, আপীল করতে পারবে এবং আপীলের
                            সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।
                            পাশাপাশি নাগরিক মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে
                            SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                            জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                            প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                        </div>
                        <div class="col-md-6 mt-5">
                            <a href=""><button type="button" class="px-15 btn btn-success">বিস্তারিত</button></a>
                            <a href="#!" class="svg-home-play">
                                <span class="svg-icon  svg-icon-primary svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path
                                                d="M9.82866499,18.2771971 L16.5693679,12.3976203 C16.7774696,12.2161036 16.7990211,11.9002555 16.6175044,11.6921539 C16.6029128,11.6754252 16.5872233,11.6596867 16.5705402,11.6450431 L9.82983723,5.72838979 C9.62230202,5.54622572 9.30638833,5.56679309 9.12422426,5.7743283 C9.04415337,5.86555116 9,5.98278612 9,6.10416552 L9,17.9003957 C9,18.1765381 9.22385763,18.4003957 9.5,18.4003957 C9.62084305,18.4003957 9.73759731,18.3566309 9.82866499,18.2771971 Z"
                                                fill="#000000"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                                <strong>Watch Video</strong>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12 mt-10" style="background-color:#f0f1ef ;">
                <div class="row">    
                    <div class="col-md-1 mt-5">
                        <p type="text">খবরঃ</p>
                    </div>
                    <div class="col-md-11 mt-5">
                        <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                            onmouseout="this.start()">
                            @foreach ($short_news as $row)
                                {{ $row->news_details }}
                            @endforeach
                        </marquee>
                    </div>
                </div>    
            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-lg-12 phomebuttons">

                    @if(Session::has('nid_error'))
                    <div class="alert alert-danger">
                       {{ Session::get('nid_error')  }} 
                    </div>
                    @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <div class="card " style="background: #f6f6f7 !important">
                        <div class="card-body mt-15">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <a class="btn btn-success btn-block" href="https://cdap.mygov.bd/registration" target="_blank"><i class="fas fa-users"></i> CDAP Registration</a>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <button class="btn btn-success btn-block"><i class="fas fa-users"></i> CDAP দিয়ে লগইন</button>
                                </div>
                            </div>
                            <br>
                            <form id="nidVerifyForm" action="{{ route('cdap.user.verify.login') }}" class="form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nid_no"
                                                class="control-label"><span
                                                    style="color:#FF0000">*
                                                </span> ইমেইল, মোবাইল নং, এন আইডি, বি আর এন  অথবা পাসপোর্ট </label>
                                            <input type="text" name="email" id="email" class="form-control form-control name-group" placeholder="উদাহরণ- 19825624603112948">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dob"
                                                class="control-label"><span
                                                    style="color:#FF0000">*
                                                </span> পাসওয়ার্ড </label>
                                                <br>
                                                <input type="password" name="password" id="password" class="form-control " placeholder="পাসওয়ার্ড" autocomplete="off" >
                                            
                                        </div>
                                    </div>
                                    <!-- <textarea id="message" class="form-control" name="message" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.." data-parsley-validation-threshold="10"></textarea> -->
                                </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>

                                    <div class="row buttonsDiv text-center">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary"  value="validate">
                                                    সংরক্ষণ করুন
                                                </button>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-10" style="background-color:#f0f1ef ;">
                <div class="row">    
                    <div class="col-md-1 mt-5">
                        <p type="text">খবরঃ</p>
                    </div>
                    <div class="col-md-11 mt-5">
                        <marquee style="font-size: 18px" direction="left" scrollamount="3" onmouseover="this.stop()"
                            onmouseout="this.start()">
                            @foreach ($short_news as $row)
                                {{ $row->news_details }}
                            @endforeach
                        </marquee>
                    </div>
                </div>    
            </div>
        </div>
    @endauth


    <div class="py-10 py-lg-20 " id="startSection">
        <!--begin::Container-->
        <div class="container">
            <h2 style="color: green;">সহায়ক তথ্য ও সেবা</h2>
            <!--end::Heading-->
            <!--begin::Row-->
            <div class="row mt-5 g-lg-10 mb-5">
                <!--begin::Col-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom bg-dark-o-10 card_home mb-lg-0">
                        <div class="card-body text-center py-15">
                            <img src="{{ asset('images/report.png') }}" alt="Girl in a jacket" width="60"
                                height="70">
                            <div class="align-items-center p-5">
                                <div class="flex-column icon-card-hm">
                                    <strong>কজব <span>লিস্ট</span></strong>
                                    <a href="{{ route('citizen.appeal.cause_list') }}"
                                        class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        অভিযোগের তথ্য জানুন
                                        <button class="bistarito-btn-hm">বিস্তারিত</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Col-->

                <!--begin::Col-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom bg-dark-o-10 card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/causelist.png') }}"
                                alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center p-5">
                                <div class="flex-column icon-card-hm">
                                    <a href="#!"
                                        class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        মামলার নির্দেশিতা
                                    </a>
                                    <button class="bistarito-btn-hm">বিস্তারিত</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom bg-dark-o-10 card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/support.png') }}"
                                alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center p-5">
                                <div class="flex-column icon-card-hm">
                                    <a href="#"
                                        class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        সাপোর্ট সেন্টার </a>
                                    <button class="bistarito-btn-hm">বিস্তারিত</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--begin::Col-->
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-custom bg-dark-o-10 card_home card_home mb-lg-0">
                        <div class="card-body text-center py-15"><img src="{{ asset('images/bangladesh.png') }}"
                                alt="Girl in a jacket" width="60" height="70">
                            <div class="align-items-center p-5">
                                <div class="flex-column icon-card-hm">
                                    <a href="#"
                                        class="h4 text-center text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        ল’জ অব বাংলাদেশ </a>
                                    <button class="bistarito-btn-hm">বিস্তারিত</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>

        <div class="container">
            <h2 class="mb-6" style="color: green;">জনপ্রিয় খবর</h2>
            @include('_sliders')
        </div>

    </div>
    <style type="text/css">
        label.error{color:red;}
    </style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.js"></script>

@endsection
@section('scripts')




    <script>
        $(document).ready(function() {
            $("a.h2.btn.btn-info").on('click', function(event) {
                if (this.hash !== "") {
                    event.preventDefault();
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {
                        window.location.hash = hash;
                    });
                }
            });

                    // common datepicker =============== start
            $('.common_datepicker').datepicker({
                format: "yyyy/mm/dd",
                todayHighlight: true,
                mindate: new Date(),
                orientation: "bottom left"
            });
            // common datepicker =============== end
            

        });
    </script>
@endsection
