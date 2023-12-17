@include('layouts.base.header-mobile')
@php
use Illuminate\Support\Facades\Auth;

if (Auth::check()) {
    global $menu;
    $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
    if (globalUserInfo()->role_id == 1) {
        $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
    } elseif (globalUserInfo()->role_id == 2) {
        $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16];
    } elseif (globalUserInfo()->role_id == 6) {
        $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 24) {
        $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 25) {
        $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 27) {
        // $menu = [1, 2, 3, 6, 7, 8, 9, 10, 11, 12, 13, 17, 18, 19];
        $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
    } elseif (globalUserInfo()->role_id == 28) {
        $menu = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 32) {
        $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 33) {
        $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 34) {
        $menu = [1, 2, 3, 5, 6, 11, 12, 13, 17, 18, 19];
    } elseif (globalUserInfo()->role_id == 35) {
        $menu = [1, 3, 4, 5, 6, 7, 8, 9, 12];
    } elseif (globalUserInfo()->role_id == 36) {
        $menu = [1, 3, 4, 5, 6, 7, 8, 9, 12];
    }
}

@endphp
<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Logo-->
            <div class="header-logo ">
                <a href="{{ url('/') }}">
                    <span class="pulse pulse-info">
                        <span class="pulse-ring"></span>
                    </span>
                    <img class="img-responsive py-3" src="{{ asset('images/logo.png') }}" alt="e-Court">
                </a>
            </div>
        </div>
        <!--end::Header Menu Wrapper-->
        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::Search-->

            @auth
                <div class="dropdown" id="kt_quick_search_toggle">
                    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                        <!--begin::Header Nav-->
                        <ul class="menu-nav">
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title="ড্যাশবোর্ড"
                                aria-haspopup="true">
                                <a href="{{ route('dashboard') }}" class="menu-link">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                    </span>
                                </a>
                            </li>


                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title=" সাপোর্ট "
                                aria-haspopup="true">
                                <a href="{{ route('calendar') }}" class="menu-link">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                            <path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000"/>
                                        </g>
                                    </svg>
                                    </span>
                                </a>
                            </li>
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title="রেজিস্টার "
                                aria-haspopup="true">
                                <a href="{{ url('register/list') }}" class="menu-link">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                        </g>
                                    </svg>
                                    </span>
                                </a>
                            </li>
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title="ক্যালেন্ডার"
                                aria-haspopup="true">
                                <a href="{{ route('calendar') }}" class="menu-link">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <i class="far fa-calendar-alt text-primary"></i>
                                    </span>
                                </a>
                            </li>
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title="কোর্ট পরিচালনা"
                                aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
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
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        @if(in_array(4, $menu))
                                        <li class="menu-item {{ request()->is('appeal/create') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('citizen.appeal.create') }}" class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> অভিযোগ দায়ের করুন </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(in_array(5, $menu))
                                        <li class="menu-item {{ request()->is('appeal/draft_list') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a href="{{ route('appeal.draft_list') }}" class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> খসড়া মামলা </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(in_array(6, $menu))
                                        <li class="menu-item {{ request()->is('appeal/list') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a style="pointer-events: block" href="{{ route('appeal.index') }}"
                                                class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M13.6855025,18.7082217 C15.9113859,17.8189707 18.682885,17.2495635 22,17 C22,16.9325178 22,13.1012863 22,5.50630526 L21.9999762,5.50630526 C21.9999762,5.23017604 21.7761292,5.00632908 21.5,5.00632908 C21.4957817,5.00632908 21.4915635,5.00638247 21.4873465,5.00648922 C18.658231,5.07811173 15.8291155,5.74261533 13,7 C13,7.04449645 13,10.79246 13,18.2438906 L12.9999854,18.2438906 C12.9999854,18.520041 13.2238496,18.7439052 13.5,18.7439052 C13.5635398,18.7439052 13.6264972,18.7317946 13.6855025,18.7082217 Z" fill="#000000"/>
                                                            <path d="M10.3144829,18.7082217 C8.08859955,17.8189707 5.31710038,17.2495635 1.99998542,17 C1.99998542,16.9325178 1.99998542,13.1012863 1.99998542,5.50630526 L2.00000925,5.50630526 C2.00000925,5.23017604 2.22385621,5.00632908 2.49998542,5.00632908 C2.50420375,5.00632908 2.5084219,5.00638247 2.51263888,5.00648922 C5.34175439,5.07811173 8.17086991,5.74261533 10.9999854,7 C10.9999854,7.04449645 10.9999854,10.79246 10.9999854,18.2438906 L11,18.2438906 C11,18.520041 10.7761358,18.7439052 10.4999854,18.7439052 C10.4364457,18.7439052 10.3734882,18.7317946 10.3144829,18.7082217 Z" fill="#000000" opacity="0.3"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> চলমান মামলা </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(in_array(7, $menu))
                                        <li class="menu-item {{ request()->is('appeal/closed_list') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a style="pointer-events: block" href="{{ route('appeal.closed_list') }}"
                                                class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path
                                                                d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z"
                                                                fill="#000000" opacity="0.3"></path>
                                                            <path
                                                                d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                fill="#000000"></path>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> নিষ্পত্তিকৃত মামলা </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(in_array(8, $menu))
                                        <li class="menu-item {{ request()->is('appeal/postponed_list') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a style="pointer-events: block" href="{{ route('appeal.postponed_list') }}"
                                                class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11.1750002,14.75 C10.9354169,14.75 10.6958335,14.6541667 10.5041669,14.4625 L8.58750019,12.5458333 C8.20416686,12.1625 8.20416686,11.5875 8.58750019,11.2041667 C8.97083352,10.8208333 9.59375019,10.8208333 9.92916686,11.2041667 L11.1750002,12.45 L14.3375002,9.2875 C14.7208335,8.90416667 15.2958335,8.90416667 15.6791669,9.2875 C16.0625002,9.67083333 16.0625002,10.2458333 15.6791669,10.6291667 L11.8458335,14.4625 C11.6541669,14.6541667 11.4145835,14.75 11.1750002,14.75 Z" fill="#000000"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> মুলতবি মামলা </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(in_array(9, $menu))
                                        <li class="menu-item {{ request()->is('appeal/rejected_list') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a style="pointer-events: block" href="{{ route('appeal.rejected_list') }}"
                                                class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M12,16 C14.209139,16 16,14.209139 16,12 C16,9.790861 14.209139,8 12,8 C9.790861,8 8,9.790861 8,12 C8,14.209139 9.790861,16 12,16 Z M12,20 C7.581722,20 4,16.418278 4,12 C4,7.581722 7.581722,4 12,4 C16.418278,4 20,7.581722 20,12 C20,16.418278 16.418278,20 12,20 Z" fill="#000000" fill-rule="nonzero"/>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> বাতিলকৃত মামলা </span>
                                            </a>
                                        </li>
                                        @endif
                                        @if(in_array(0, $menu))
                                        <li class="menu-item {{ request()->is('appeal/collectPaymentList') ? 'menu-item-active' : '' }}"
                                            aria-haspopup="true">
                                            <a style="pointer-events: pointer" href="{{ route('appeal.collectPaymentList') }}"
                                                class="menu-link">
                                                <span class="svg-icon menu-icon">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Safe-chat.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path
                                                                d="M8,17 C8.55228475,17 9,17.4477153 9,18 L9,21 C9,21.5522847 8.55228475,22 8,22 L3,22 C2.44771525,22 2,21.5522847 2,21 L2,18 C2,17.4477153 2.44771525,17 3,17 L3,16.5 C3,15.1192881 4.11928813,14 5.5,14 C6.88071187,14 8,15.1192881 8,16.5 L8,17 Z M5.5,15 C4.67157288,15 4,15.6715729 4,16.5 L4,17 L7,17 L7,16.5 C7,15.6715729 6.32842712,15 5.5,15 Z"
                                                                fill="#000000" opacity="0.3"></path>
                                                            <path
                                                                d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z"
                                                                fill="#000000"></path>
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span>
                                                <span class="menu-text font-weight-bolder"> অর্থ আদায় </span>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title="নোটিফিকেশন"
                                aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <path d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z" fill="#000000"/>
                                            <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
                                        </g>
                                    </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="{{ route('hearing_date') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M8,3 L8,3.5 C8,4.32842712 8.67157288,5 9.5,5 L14.5,5 C15.3284271,5 16,4.32842712 16,3.5 L16,3 L18,3 C19.1045695,3 20,3.8954305 20,5 L20,21 C20,22.1045695 19.1045695,23 18,23 L6,23 C4.8954305,23 4,22.1045695 4,21 L4,5 C4,3.8954305 4.8954305,3 6,3 L8,3 Z" fill="#000000" opacity="0.3"/>
                                                            <path d="M11,2 C11,1.44771525 11.4477153,1 12,1 C12.5522847,1 13,1.44771525 13,2 L14.5,2 C14.7761424,2 15,2.22385763 15,2.5 L15,3.5 C15,3.77614237 14.7761424,4 14.5,4 L9.5,4 C9.22385763,4 9,3.77614237 9,3.5 L9,2.5 C9,2.22385763 9.22385763,2 9.5,2 L11,2 Z" fill="#000000"/>
                                                            <rect fill="#000000" opacity="0.3" x="7" y="10" width="5" height="2" rx="1"/>
                                                            <rect fill="#000000" opacity="0.3" x="7" y="14" width="9" height="2" rx="1"/>
                                                        </g>
                                                    </svg>
                                                    </span>

                                                    <span class="menu-text font-weight-bolder">শুনানির তারিখ নির্ধারণ করা
                                                        হয়েছে</span>
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ $CaseHearingCount = 5 }}</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="{{ route('results_completed') }}" class="menu-link">
                                                    <span class="svg-icon menu-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                                            <path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002) "/>
                                                        </g>
                                                    </svg>
                                                    </span>

                                                    <span class="menu-text font-weight-bolder">ফলাফল সম্পন্ন</span>
                                                    <span class="menu-label">
                                                        <span
                                                            class="label label-rounded label-danger">{{ $CaseResultCount=2 }}</span>
                                                    </span>
                                                </a>
                                            </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click"
                                data-toggle="tooltip" data-placement="right" title data-original-title="বার্তা"
                                aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="svg-icon svg-icon-xl svg-icon-primary">
                                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000"/>
                                            <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3"/>
                                        </g>
                                    </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                            @php
                                            $NewMessagesCount = $msg_request_count = 0;
                                        @endphp
                                        @if(in_array(18, $menu))
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="{{ route('messages_recent') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                        <span class="menu-text font-weight-bolder">সাম্প্রতিক বার্তা</span>

                                                        @if ($NewMessagesCount != 0)
                                                            <span class="menu-label">
                                                                <span
                                                                    class="label label-rounded label-danger">{{ $NewMessagesCount =5 }}</span>
                                                            </span>
                                                        @endif
                                                    </a>
                                                </li>
                                        @endif
                                        @if(in_array(19, $menu))
                                                @if ($msg_request_count != 0)
                                                    <li class="menu-item" aria-haspopup="true">
                                                        <a href="{{ route('messages_request') }}" class="menu-link">
                                                            <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                            <span class="menu-text font-weight-bolder">নতুন বার্তা অনুরোধ</span>
                                                            <span class="menu-label">
                                                                <span
                                                                    class="label label-rounded label-danger">{{ $msg_request_count =2 }}</span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                @endif
                                        @endif
                                        @if(in_array(20, $menu))
                                                <li class="menu-item" aria-haspopup="true">
                                                    <a href="{{ route('messages') }}" class="menu-link">
                                                        <i class="menu-bullet menu-bullet-dot"><span></span></i>
                                                        <span class="menu-text font-weight-bolder">ব্যবহারকারীর তালিকা</span>
                                                    </a>
                                                </li>
                                        @endif

                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <!--end::Header Nav-->
                    </div>
                </div>
                <div class="dropdown">
                    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1">
                            @if (Auth::user()->profile_pic != null)
                                <img class="h-20px w-20px rounded-sm"
                                    src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}" alt="">
                            @else
                                <img class="h-20px w-20px rounded-sm"
                                    src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8M3x8dXNlcnxlbnwwfHwwfHw%3D&w=1000&q=80"
                                    alt="">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="topbar-item">
                    <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                        id="kt_quick_user_toggle">
                        <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                        <span
                            class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ auth()->user()->name }}</span>
                        <span class="symbol symbol-lg-35 symbol-25 symbol-light-info">
                            <span
                                class="symbol-label font-size-h5 font-weight-bolder">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </span>
                    </div>
                </div>
            @else
                <div class="topbar-item">
                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                        id="kt_quick_user_toggle">
                        <input type="button" id="loginID" class="btn btn-info" value="{{ __('লগইন') }}"
                            data-toggle="modal" data-target="#exampleModalLong">
                    </div>
                </div>
                <div class="topbar-item">
                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2"
                        id="kt_quick_user_toggle">

                        <a href="{{ url('/citizenRegister') }}" type="button" class="btn btn-info"
                            value="">{{ __('রেজিস্টার') }}</a>
                    </div>
                </div>
            @endauth
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
