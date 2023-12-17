@extends('layouts.landing')

@section('style')
    
@endsection

@section('landing')
    <div style="background-image: url('{{ asset('images/cover.jpg') }}'); background-size: cover;">
        <!--begin::Landing hero-->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div style="margin-top:65px"
                        class="d-flex flex-column flex-center w-100 min-h-350px min-h-lg-500px px-9">
                        <!--begin::Heading-->
                        <div class="text-center mb-5 mb-lg-10 py-10 py-lg-20">
                            <!--begin::Title-->
                            <h1 class="font-weight-bolder display-2 text-white lh-base fw-bolder fs-2x fs-lg-3x mb-15">
                                <span {{-- style="background: linear-gradient(to right, #12CE5D 0%, #FFD80C 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"> --}}
                                    style="background: linear-gradient(to right, #ffffff 0%, #ff8283 100%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;">
                                    <span id="kt_landing_hero_text">এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টে</span>
                                </span>
                                <br>
                                আপনাকে স্বাগতম
                            </h1>
                            <!--end::Title-->
                            <!--begin::Action-->
                            <a href="#startSection" class="h2 btn btn-info">শুরু করুন </a>
                            <!--end::Action-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Clients-->
    </div>
    <div class="py-10 py-lg-20 " id="startSection">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Heading-->
            <div class="text-center mb-17">
                <!--begin::Title-->
                <h3 class="h1 fs-2hx text-info mb-5" id="clients" data-kt-scroll-offset="{default: 125, lg: 150}">
                    এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট!</h3>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="fs-5 h5 fw-bold">গণপ্রজাতন্ত্রী বাংলাদেশ সরকারের এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট ব্যবস্থার অনলাইন প্ল্যাটফর্মে
                    আপনাকে
                    স্বাগতম।
                    সিস্টেমটির মাধ্যমে নাগরিক অভিযোগ দায়ের  করতে পারবে, আপীল করতে পারবে এবং আপীলের
                    সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।
                    পাশাপাশি নাগরিক মামলা দাখিল করার পর মামলার সর্বশেষ অবস্থা সিস্টেম কর্তৃক স্বয়ংক্রিয়ভাবে
                    SMS ও ই-মেইলের মাধ্যমে সম্পর্কে জানানো হবে।
                    <!-- জেনারেল  কোর্ট পরিচালনার সাথে সম্পৃক্ত জেনারেল  অফিসারের কর্মদক্ষতা
                    বৃদ্ধি,
                    একটি সিস্টেমের মাধ্যমে প্রশিক্ষণ প্রদানে সহায়তাসহ তাৎক্ষণিকভাবে জেনারেল  অফিসারকে
                    আইনী তথ্য সরবরাহ,
                    ঊর্ধ্বতন কর্তৃপক্ষের মাধ্যমে জেনারেল  অফিসারের কার্যক্রম পরিবীক্ষণ, দ্রুততার সাথে
                    কার্যক্রম সম্পাদন, -->
                    জনগণের হয়রানি লাঘবকল্পে একটি ইলেক্ট্রনিক সিস্টেমের মাধ্যমে তাদেরকে মামলার নকল সরবরাহ ও সেবা
                    প্রদানের বিষয়ে গুরুত্বপূর্ণ ভূমিকা রাখবে।
                </div>
                <!--end::Description-->
            </div>
            <!--end::Heading-->
            <!--begin::Row-->
            <div class="row g-lg-10 mb-5">
                <!--begin::Col-->
                <div class="col-lg-4">
                    <div class="card card-custom wave wave-animate-slow wave-info mb-8 mb-lg-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-info svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path
                                                    d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z M10.875,15.75 C11.1145833,15.75 11.3541667,15.6541667 11.5458333,15.4625 L15.3791667,11.6291667 C15.7625,11.2458333 15.7625,10.6708333 15.3791667,10.2875 C14.9958333,9.90416667 14.4208333,9.90416667 14.0375,10.2875 L10.875,13.45 L9.62916667,12.2041667 C9.29375,11.8208333 8.67083333,11.8208333 8.2875,12.2041667 C7.90416667,12.5875 7.90416667,13.1625 8.2875,13.5458333 L10.2041667,15.4625 C10.3958333,15.6541667 10.6354167,15.75 10.875,15.75 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path
                                                    d="M10.875,15.75 C10.6354167,15.75 10.3958333,15.6541667 10.2041667,15.4625 L8.2875,13.5458333 C7.90416667,13.1625 7.90416667,12.5875 8.2875,12.2041667 C8.67083333,11.8208333 9.29375,11.8208333 9.62916667,12.2041667 L10.875,13.45 L14.0375,10.2875 C14.4208333,9.90416667 14.9958333,9.90416667 15.3791667,10.2875 C15.7625,10.6708333 15.7625,11.2458333 15.3791667,11.6291667 L11.5458333,15.4625 C11.3541667,15.6541667 11.1145833,15.75 10.875,15.75 Z"
                                                    fill="#000000" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('investigation.report') }}" class="h2 text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        তদন্ত প্রতিবেদন </a>
                                    <div class="h6 text-dark-75">সিস্টেমটির মাধ্যমে তদন্তকারী এক্সিকিউটিভ ম্যাজিস্ট্রেটের নিকট মামলার তদন্ত প্রতিবেদন প্রদান  করতে পারবে।</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-4">
                    <div class="card card-custom wave wave-animate-fast wave-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-info svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Search.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                <path
                                                    d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                    fill="#000000" fill-rule="nonzero" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('citizen.appeal.cause_list') }}" class="h2 text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        মামলার কার্যতালিকা
                                    </a>
                                    <div class="h6 text-dark-75">সিস্টেমটির মাধ্যমে আবেদনকারী  অভিযোগ দায়ের  করতে
                                        পারবে, আপীল করতে পারবে এবং আপীলের সর্বশেষ অবস্থা সম্পর্কে জানতে পারবে।</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-lg-4">
                    <div class="card card-custom wave wave-animate wave-info mb-8 mb-lg-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-info svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Question-circle.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
                                                <path
                                                    d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z"
                                                    fill="#000000" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="#" class="h2 text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                         কোর্ট সম্পর্কিত প্রশ্নোত্তর
                                    </a>
                                    <div class="h6 text-dark-75"> কোর্ট সম্পর্কিত প্রশ্নোত্তর  কোর্ট
                                        সম্পর্কিত প্রশ্নোত্তর</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-lg-10 mb-10">
                <div class="col-lg-4">
                    <div class="card card-custom wave wave-animate wave-info mb-8 mb-lg-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-info svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Home\Library.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                                    fill="#000000" />
                                                <rect fill="#000000" opacity="0.3"
                                                    transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519) "
                                                    x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="#" class="h2 text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        কোড অফ ক্রিমিনাল প্রসিডউর (CrPC) ১৮৯৮ 
                                    </a>
                                    <div class="h6 text-dark-75">বাংলাদেশ সিভিল সার্ভিস (প্রশাসন) এর সদস্যগণ, যারা সহকারী কমিশনার, উপজেলা নির্বাহী অফিসার ও অতিরিক্ত ডেপুটি কমিশনার, তারা এক্সিকিউটিভ ম্যাজিস্ট্রেট হতে পারবেন।</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-custom wave wave-animate-slow wave-info mb-8 mb-lg-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-info svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Tools\Hummer2.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                                    fill="#000000" />
                                                <path
                                                    d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="#" class="h2 text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        কোড অফ ক্রিমিনাল প্রসিডিউর (১৮৯৮),(ধারা ৬৪)
                                    </a>
                                    <div class="h6 text-dark-75">ম্যাজিস্ট্রেটের সম্মুখে অপরাধ করলে অপরাধীকে গ্রেপ্তার করার ক্ষমতা অথবা হাজতে প্রেরণের নির্দেশ দেওয়ার ক্ষমতা</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-custom wave wave-animate-slow wave-info mb-8 mb-lg-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center p-5">
                                <div class="mr-6">
                                    <span class="svg-icon svg-icon-info svg-icon-4x">
                                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Tools\Hummer2.svg--><svg
                                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path
                                                    d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                                    fill="#000000" opacity="0.3" />
                                                <path
                                                    d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                                    fill="#000000" />
                                                <path
                                                    d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                                    fill="#000000" opacity="0.3" />
                                            </g>
                                        </svg>
                                    </span>
                                </div>
                                <div class="d-flex flex-column">
                                    <a href="#" class="h2 text-dark text-hover-primary font-weight-bold font-size-h4 mb-3">
                                        কোড অফ ক্রিমিনাল প্রসিডিউর (১৮৯৮),(ধারা ১০৫)
                                    </a>
                                    <div class="h6 text-dark-75">সরাসরি তল্লাসির ক্ষমতা, তার উপস্থিতিতে যে কোন স্থানে তল্লাসির পরোয়ানা জারির ক্ষমতা।</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Col-->
            {{-- </div> --}}
            <!--end::Row-->
            <div class="card card-custom gutter-b bg-diagonal bg-diagonal-info">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-4 flex-lg-wrap flex-xl-nowrap">
                        <div class="d-flex flex-column mr-5">
                            <a href="#" class="h2 text-light text-hover-primary mb-5">
                                সাপোর্ট
                            </a>
                            <p class="h6 text-light">
                                সিস্টেম ব্যবহারে কোনো সমস্যার সম্মুখীন হলে যোগাযোগ করুন।
                            </p>
                        </div>
                        <div class="ml-6 ml-lg-0 ml-xxl-6 flex-shrink-0">
                            <a href="#" target="_blank" class="btn h4 text-uppercase btn-info py-4 px-6">
                                কল করুন
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
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
        });
    </script>
@endsection
