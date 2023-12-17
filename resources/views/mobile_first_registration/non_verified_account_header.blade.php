<div class="container align-items-stretch justify-content-between">
    <!--begin::Topbar-->
    <div class="topbar_wrapper">
        <div class="topbar">
            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-offset="10px,0px" data-menu-toggle="click" data-toggle="tooltip"
                    data-placement="right" title data-original-title="" aria-haspopup="true">
                    <a href="{{ route('dashboard') }}"
                        class="navi-link {{ request()->is('dashboard') ? 'menu-item-active' : '' }}">
                        <div class="btn-dropdown mr-2 pulse pulse-primary" style="padding-left: 0 !important;">
                            <span class="svg-icon auth-svg-icon-bar svg-icon-xl svg-icon-primary">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                    viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24">
                                        </rect>
                                        <rect fill="#000000" x="4" y="4" width="7"
                                            height="7" rx="1.5"></rect>
                                        <path
                                            d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z"
                                            fill="#000000" opacity="0.3"></path>
                                    </g>
                                </svg>
                                <p class="navi-text">ড্যাশবোর্ড</p>
                            </span>
                            <span class="pulse-ring"></span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="topbar-item">
                <div class="btn  -mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle"
                    style="margin: -12px">
                    <span class="text-muted font-size-base d-none d-md-inline mr-1">
                        @if (Auth::user()->profile_pic != null)
                            @if (Auth::user()->doptor_user_flag == 1)
                                <img src="{{ Auth::user()->profile_pic }}">
                            @else
                                <img src="{{ url('/') }}/uploads/profile/{{ Auth::user()->profile_pic }}">
                            @endif
                        @else
                            <img src="{{ url('/') }}/uploads/profile/default.jpg">
                        @endif

                    </span>
                    <span class="text-dark font-size-base d-none d-md-inline mr-3 text-left">
                        <i style="float: right; padding-left: 20px; padding-top: 12px;" class="fas fa-chevron-down"></i>
                        <b>{{ auth()->user()->name }}</b><br>{{ Auth::user()->role->role_name }}
                    </span>
                    <!-- <span class="symbol symbol-lg-35 symbol-25 symbol-light-info bg-primary p-2 text-light rounded">
                                                                <span class="">{{ Auth::user()->role->role_name }}</span>
                                                            </span> -->
                </div>
            </div>

        </div>
    </div>
    <!--end::Topbar-->
</div>
