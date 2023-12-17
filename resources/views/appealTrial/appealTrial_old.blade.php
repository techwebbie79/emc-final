@extends('layouts.landing')

@section('content')
    <!--begin::Row-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        @include('appealTrial.inc._send_section')
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

                <!--begin::Form-->
                <form id="appealCase" action="{{ route('appeal.appealStoreOnTrial') }}" class="form"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="appealId" value="{{ $appeal->id }}">
                    {{-- <input type="hidden" name="causeListId" id="causeListId"  value=""> --}}
                    <input type="hidden" name="noteId" id="noteId" class="form-control" value="">
                    {{-- <input type="hidden" name="userRoleCode" id="userRoleCode"   value="GCO_"> --}}

                    <div class="card-body">

                        @include('appealTrial.inc._caseDetails')
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z" fill="#000000" opacity="0.3"/>
                                                <path d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z" fill="#000000"/>
                                                <path d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z" fill="#000000" opacity="0.3"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </span>
                                    <h3 class="card-label">আদেশের তালিকা
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="panel panel-info radius-none ">
                                    <div id="accordion" role="tablist" aria-multiselectable="true" class="panel-group notesDiv">
                                        <section class="panel panel-primary nomineeInfo" id="nomineeInfo">
                                            <div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
                                                @forelse ($approvedNoteCauseList as $key => $item)
                                                    @php
                                                        $count = ++$key;
                                                        // with('noteCauseList', 'attachments')
                                                    @endphp
                                                    <div id="cloneNomenee" class="card">
                                                        <div class="card-header" id="headingOne3">
                                                            <div class=" bg-gray-300 card-title h4 {{ $count == 1 ? '' : 'collapsed' }}"
                                                                data-toggle="collapse"
                                                                data-target="#collapseOne3{{ $count }}">
                                                                <span
                                                                    id="spannCount">{{ en2bn($item->noteCauseList->conduct_date ?? '') }}</span>&nbsp;
                                                                তারিখ এর আদেশ
                                                            </div>
                                                        </div>
                                                        <div id="collapseOne3{{ $count }}"
                                                            class="collapse {{ $count == 1 ? 'show' : '' }} "
                                                            data-parent="#accordionExample3">
                                                            <div class="card-body border-secondary">
                                                                <div class="clearfix ">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="bg-gray-100 rounded-md rounded-right-0">
                                                                                <div class="p-4 h5">
                                                                                    {!! nl2br($item->order_text) !!}</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <fieldset class="col-md-12 border-0 bg-white">
                                                                            @forelse ($item->attachments as $key => $row)
                                                                                <div class="form-group mb-2"
                                                                                    id="deleteFile{{ $row->id }}">
                                                                                    <div class="input-group">
                                                                                        <div class="input-group-prepend">
                                                                                            <button class="btn bg-success-o-75"
                                                                                                type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                                                                        </div>
                                                                                        <input readonly type="text"
                                                                                            class="form-control-md form-control "
                                                                                            value="{{ $row->file_category ?? '' }}" />
                                                                                        <div class="input-group-append">
                                                                                            <a href="{{ asset($row->file_path . $row->file_name) }}"
                                                                                                target="_blank"
                                                                                                class="btn btn-sm btn-success font-size-h5 float-left">
                                                                                                <i
                                                                                                    class="fa fas fa-file-pdf"></i>
                                                                                                <b>দেখুন</b>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @empty
                                                                            @endforelse
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                <div class="border">
                                                    <p class="h5 text-center mt-3"> <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"/>
                                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                                                        </g>
                                                    </svg><!--end::Svg Icon--></span>
                                                     তথ্য খুঁজে পাওয়া যায়নি... &nbsp;
                                                    </p>
                                                </div>
                                                @endforelse
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M8,7 C7.44771525,7 7,6.55228475 7,6 C7,5.44771525 7.44771525,5 8,5 L16,5 C18.209139,5 20,6.790861 20,9 C20,11.209139 18.209139,13 16,13 L8,13 C6.8954305,13 6,13.8954305 6,15 C6,16.1045695 6.8954305,17 8,17 L17,17 C17.5522847,17 18,17.4477153 18,18 C18,18.5522847 17.5522847,19 17,19 L8,19 C5.790861,19 4,17.209139 4,15 C4,12.790861 5.790861,11 8,11 L16,11 C17.1045695,11 18,10.1045695 18,9 C18,7.8954305 17.1045695,7 16,7 L8,7 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                <path d="M9.79289322,3.79289322 C10.1834175,3.40236893 10.8165825,3.40236893 11.2071068,3.79289322 C11.5976311,4.18341751 11.5976311,4.81658249 11.2071068,5.20710678 L8.20710678,8.20710678 C7.81658249,8.59763107 7.18341751,8.59763107 6.79289322,8.20710678 L3.79289322,5.20710678 C3.40236893,4.81658249 3.40236893,4.18341751 3.79289322,3.79289322 C4.18341751,3.40236893 4.81658249,3.40236893 5.20710678,3.79289322 L7.5,6.08578644 L9.79289322,3.79289322 Z" fill="#000000" fill-rule="nonzero" transform="translate(7.500000, 6.000000) rotate(-270.000000) translate(-7.500000, -6.000000) "/>
                                                <path d="M18.7928932,15.7928932 C19.1834175,15.4023689 19.8165825,15.4023689 20.2071068,15.7928932 C20.5976311,16.1834175 20.5976311,16.8165825 20.2071068,17.2071068 L17.2071068,20.2071068 C16.8165825,20.5976311 16.1834175,20.5976311 15.7928932,20.2071068 L12.7928932,17.2071068 C12.4023689,16.8165825 12.4023689,16.1834175 12.7928932,15.7928932 C13.1834175,15.4023689 13.8165825,15.4023689 14.2071068,15.7928932 L16.5,18.0857864 L18.7928932,15.7928932 Z" fill="#000000" fill-rule="nonzero" transform="translate(16.500000, 18.000000) scale(1, -1) rotate(270.000000) translate(-16.500000, -18.000000) "/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </span>
                                    <h3 class="card-label">কার্যক্রম
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="panel panel-info">
                                    {{-- <div class="panel-heading raiViewheading"><span class="panel-title">কার্যক্রম</span>
                                    </div> --}}
                                    <div class="panel-body">
                                        <div hidden="hidden" id="paymentInformation" class="row">
                                            <div class="col-md-3">
                                                <div class="form-group"><label for="totalLoan"
                                                        class="control-label btn-block">দাবিকৃত অর্থের পরিমাণ</label>
                                                    <div id="totalLoan" class="text-primary">0 টাকা</div>
                                                </div>
                                            </div>
                                            <div hidden="hidden" id="auctionBlock" class="col-md-3">
                                                <div class="form-group"><label for="auctionSale"
                                                        class="control-label btn-block">নিলামে বিক্রিত অর্থ</label>
                                                    <div id="auctionSale" class="text-primary">0 টাকা</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group"><label for="totalPaidAmount"
                                                        class="control-label btn-block">পরিশোধকৃত অর্থের পরিমাণ</label>
                                                    <div id="totalPaidAmount" class="text-primary">0 টাকা</div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group"><label for="dueAmount"
                                                        class="control-label btn-block">বকেয়া</label>
                                                    <div id="dueAmount" class="text-primary">0 টাকা</div> <input type="hidden"
                                                        value="" id="dueAmountValue">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group"><label>সংক্ষিপ্ত আদেশ</label>
                                                    <div class="form-control form-control-md"
                                                        style="height: 253px; overflow-y: scroll;">
                                                        @forelse ($shortOrderList as $row)
                                                            @php
                                                                $checked = '';
                                                                if (count($notApprovedShortOrderCauseList) > 0) {
                                                                    foreach ($notApprovedShortOrderCauseList as $key => $value) {
                                                                        // dd($notApprovedShortOrderCauseList);
                                                                        if ($value->case_shortdecision_id == $row->id) {
                                                                            $checked = 'checked';
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <label class="checkbox checkbox-outline checkbox-primary mb-3">
                                                                <input value="{{ $row->id ?? '' }}" type="checkbox"
                                                                    class="shortOrderCheckBox" onchange="updateNote(this)"
                                                                    name="shortOrder[{{ $row->id ?? '' }}]"
                                                                    id="shortOrder_{{ $row->id ?? '' }}"
                                                                    desc="{{ $row->delails ?? '' }}" {{ $checked }}>
                                                                <span class="mr-2"></span>
                                                                {{ $row->case_short_decision ?? '' }}
                                                            </label>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group"><label for="note">আদেশ</label>
                                                    {{-- <textarea id="note" name="note" rows="10" class="form-control">@forelse($notApprovedNoteCauseList as $row)
                                                    {{ $row->order_text ?? '' }}@empty সার্টিফিকেট ধারক উপস্থিত/অনুপস্থিত। সার্টিফিকেট খাতক উপস্থিত/অনুপস্থিত। ১০(ক) ধারার নোটিশ জারি হয়েছে/হয়নি। নোটিশ জারি অন্তে এস আর ফেরত পাওয়া গিয়েছে/যায়নি।
                                                        দেখলাম।
                                                    @endforelse</textarea> --}}
                                                    <textarea id="note" name="note" rows="10" class="form-control">{{ $appeal->initial_note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="applicantName" class="control-label">
                                                        ভিক্টিমের নাম
                                                    </label>
                                                    <span id="applicantName"
                                                        class="form-control form-control-md">{{ $applicantCitizen[0]->citizen_name ?? '' }}</span>
                                                    <input type="hidden" name="citizenAttendance[1][id]"
                                                        id="applicantCitizenAttendanceId" value="">
                                                    <input type="hidden" name="citizenAttendance[1][appealId]"
                                                        value="{{ $appeal->id }}">
                                                    <input type="hidden" name="citizenAttendance[1][citizenId]"
                                                        id="citizenAttendanceApplicantCitizenId"
                                                        value="{{ $applicantCitizen[0]->id ?? '' }}">
                                                    <input type="hidden" name="citizenAttendance[1][attendanceDate]"
                                                        value="{{ now() }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group"><label for="applicantDesignation"
                                                        class="control-label"><span style="color: rgb(255, 0, 0);"></span>
                                                        ইমেইল </label> <span id="applicantEmail_1"
                                                        class="form-control form-control-md">{{ $applicantCitizen[0]->email ?? '' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="applicantAttendance" class="control-label">
                                                        <span style="color: rgb(255, 0, 0);">* </span> হাজিরা
                                                    </label>
                                                    <div class="radio">
                                                        <label>
                                                            <input onchange="AttPrintHideShow('1')" id="applicantAttendancePresent" type="radio"
                                                                name="citizenAttendance[1][attendance]" value="PRESENT"
                                                                checked="checked" class="">
                                                            উপস্থিত
                                                        </label>
                                                        <label class="ml-2">
                                                            <input onchange="AttPrintHideShow('1')" id="applicantAttendanceAbsent" type="radio"
                                                                name="citizenAttendance[1][attendance]" value="ABSENT"
                                                                class="">
                                                            অনুপস্থিত
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group" id="attVic1">
                                                    <label for="attendance" class="control-label">
                                                        হাজিরা প্রিন্ট
                                                    </label>
                                                    <div>
                                                        {{-- <a target="_blank" class="btn btn-info" href="{{ route('appeal.trial.attendance_print', $appeal->id) }}">হাজিরা প্রিন্ট </a> --}}
                                                        <!-- <a href="javascript:void(0)" onclick="goToURL(); return false;" class="btn btn-info" >হাজিরা প্রিন্ট </a> -->
                                                        <a href="javascript:void(0)"  class="btn btn-info" >হাজিরা প্রিন্ট </a>
                                                        {{-- <a  class="btn btn-info" href="javascript:void(0)">হাজিরা প্রিন্ট </a> --}}

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="defaulterName" class="control-label">
                                                        <span style="color: rgb(255, 0, 0);"></span>অপরাধীর নাম
                                                    </label>
                                                    <span id="defaulterName"
                                                        class="form-control form-control-md">{{ $defaulterCitizen[0]->citizen_name ?? '' }}</span>
                                                    <input type="hidden" name="citizenAttendance[2][id]"
                                                        id="defaulterCitizenAttendanceId" value="">
                                                    <input type="hidden" name="citizenAttendance[2][appealId]"
                                                        value="{{ $appeal->id }}">
                                                    <input type="hidden" name="citizenAttendance[2][citizenId]"
                                                        id="citizenAttendanceDefaulterCitizenId"
                                                        value="{{ $defaulterCitizen->id ?? '' }}">
                                                    <input type="hidden" name="citizenAttendance[2][attendanceDate]"
                                                        value="{{ now() }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group"><label for="defaulterDesignation"
                                                        class="control-label"><span style="color: rgb(255, 0, 0);"></span>
                                                        ইমেইল </label> <span id="defaulterEmail_1"
                                                        class="form-control form-control-md">{{ $defaulterCitizen[0]->email }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group"><label for="defaulterAttendance"
                                                        class="control-label"><span style="color: rgb(255, 0, 0);">* </span>
                                                        হাজিরা</label>
                                                    <div class="radio">
                                                        <label>
                                                            <input onchange="AttPrintHideShow('2')" id="defaulterAttendancePresent" type="radio" name="citizenAttendance[2][attendance]"
                                                                value="PRESENT" checked="checked" class="defaulterAttendance">
                                                            উপস্থিত
                                                        </label>
                                                        <label class="ml-2">
                                                            <input onchange="AttPrintHideShow('2')"
                                                                id="defaulterAttendanceAbsent" type="radio"
                                                                name="citizenAttendance[2][attendance]" value="ABSENT"
                                                                class="defaulterAttendance"> অনুপস্থিত
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group" id="attVic2">
                                                    <label for="attendance" class="control-label">
                                                        হাজিরা প্রিন্ট</label>
                                                    <div>
                                                        <!-- <a href="javascript:void(0)" onclick="goToURL(); return false;" class="btn btn-info" >হাজিরা প্রিন্ট </a> -->
                                                        <a href="javascript:void(0)"  class="btn btn-info" >হাজিরা প্রিন্ট </a>

                                                    {{-- <a target="_blank" class="btn btn-info" href="{{ route('appeal.trial.attendance_print', $appeal->id) }}">হাজিরা প্রিন্ট </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="offenderGender" class="control-label"> অবস্থা</label>
                                                    <select name="appealDecision" id="appealDecision"
                                                        class=" form-control form-control-md">
                                                        <option value="1">চলমান</option>
                                                        <option value="2">মুলতবি</option>
                                                        <option value="3">নিষ্পতি হয়েছে</option>
                                                        <option value="5">বাতিল</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">

                                                <div class="form-group"><label for="offenderGender"
                                                        class="control-label">স্বাক্ষর</label>
                                                    <label class="checkbox checkbox-outline checkbox-primary mb-3"
                                                        style="font-size: 15px;">
                                                        <input value="1" type="checkbox" class="shortOrderCheckBox"
                                                            name="oldCaseFlag" id="oldCaseFlag">
                                                        <span class="mr-2"></span> কোন স্বাক্ষর নেই
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row form-group">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>আদেশের তারিখ</label>
                                                            {{-- <input readonly type="text" name="conductDate" id="conductDate" value="{{ date('d-m-Y', strtotime( $noteCauseList[0]->conduct_date )) ?? '' }}" class="form-control form-control-md common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off"> --}}
                                                            <input readonly type="text" name="conductDate" id="conductDate" value="{{ date('d-m-Y', strtotime( now() )) ?? '' }}" class="form-control form-control-md common_datepicker" placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                                        </div>
                                                        {{-- <label for="conductDate" class="control-label">আদেশের তারিখ</label>
                                                        <div class="input-group">
                                                            <input onchange="appealUiUtils.attendanceDateChange();" readonly="readonly" name="conductDate" id="conductDate" value="" type="text" class="conductDate form-control hasDatepicker form-control form-control-md">
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar"></i>
                                                            </span>
                                                        </div> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>পরবর্তী তারিখ</label>
                                                            <input type="text" onchange="updateNoteWithData(this)"
                                                                name="trialDate" id="trialDate"
                                                                class="form-control form-control-md common_datepicker"
                                                                placeholder="দিন/মাস/তারিখ" autocomplete="off">
                                                        </div>

                                                        {{-- <label for="trialDate" class="control-label">পরবর্তী তারিখ </label>
                                                        <div class="input-group">
                                                            <input readonly="readonly" onchange="appealUiUtils.trailDateAdd();" name="trialDate" id="trialDate" value="" type="text" class="date form-control hasDatepicker form-control form-control-md">
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-calendar text-primary"></i>
                                                            </span>
                                                        </div> --}}
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="trialTime" class="control-label">সময় </label>
                                                        <input class="form-control  form-control-md" type="time"
                                                            name="trialTime" id="trialTime" value="10:00:00"
                                                            id="example-time-input">

                                                        {{-- <div class="input-group">
                                                            <input name="trialTime" id="trialTime" value="" type="text" class="timepicker form-control form-control-md">
                                                            <span class="input-group-addon">
                                                                <i class="glyphicon glyphicon-time text-primary"></i>
                                                            </span>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="userRole" id="getUserRole" value="GCO">
                                        <input type="hidden" name="paymentStatus" id="paymentStatus" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M14,16 L12,16 L12,12.5 C12,11.6715729 11.3284271,11 10.5,11 C9.67157288,11 9,11.6715729 9,12.5 L9,17.5 C9,19.4329966 10.5670034,21 12.5,21 C14.4329966,21 16,19.4329966 16,17.5 L16,7.5 C16,5.56700338 14.4329966,4 12.5,4 L12,4 C10.3431458,4 9,5.34314575 9,7 L7,7 C7,4.23857625 9.23857625,2 12,2 L12.5,2 C15.5375661,2 18,4.46243388 18,7.5 L18,17.5 C18,20.5375661 15.5375661,23 12.5,23 C9.46243388,23 7,20.5375661 7,17.5 L7,12.5 C7,10.5670034 8.56700338,9 10.5,9 C12.4329966,9 14,10.5670034 14,12.5 L14,16 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.500000, 12.500000) rotate(-315.000000) translate(-12.500000, -12.500000) "/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </span>
                                    <h3 class="card-label">সংযুক্তি সমূহ
                                </div>
                            </div>
                            <div class="card-body">
                                @forelse ($attachmentList as $key => $row)
                                <div class="form-group mb-2" id="deleteFile{{ $row->id }}">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn bg-success-o-75"
                                                type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                        </div>
                                        {{-- <input readonly type="text" class="form-control form-control-md" value="{{ asset($row->file_path . $row->file_name) }}" /> --}}
                                        <input readonly type="text" class="form-control form-control-md"
                                            value="{{ $row->file_category ?? '' }}" />
                                        <div class="input-group-append">
                                            <a href="{{ asset($row->file_path . $row->file_name) }}" target="_blank"
                                                class="btn btn-sm btn-success font-size-h5 float-left">
                                                <i class="fa fas fa-file-pdf"></i>
                                                <b>দেখুন</b>
                                                {{-- <embed src="{{ asset('uploads/sf_report/'.$data[0]['case_register'][0]['sf_report']) }}" type="application/pdf" width="100%" height="600px" /> --}}
                                            </a>
                                            {{-- <a href="minarkhan.com" class="btn btn-success" type="button">দেখুন </a> --}}
                                        </div>
                                        {{-- <div class="input-group-append">
                                            <a href="javascript:void(0);" id="" onclick="deleteFile({{ $row->id }} )"
                                                class="btn btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                                <b>মুছুন</b>
                                            </a>
                                        </div> --}}
                                    </div>
                                </div>
                                @empty
                                <div class="border">
                                    <p class="h5 text-center mt-3"> <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Search.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg><!--end::Svg Icon--></span>
                                    কোনো সংযুক্তি খুঁজে পাওয়া যায়নি... &nbsp;
                                    </p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                <path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
                                                <path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-90.000000) translate(-11.959697, -18.661508) "/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </span>
                                    <h3 class="card-label">সংযুক্তি যুক্ত করুন (যদি থাকে)
                                </div>
                                <div class="card-toolbar">
                                    <a id="addFileRow" href="javascript:;" class="btn btn-md btn-icon btn-light-light mr-2" title="যুক্ত করুন" data-toggle="tooltip"
                                    data-placement="top" title="" role="button" data-original-title="Add New File">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Code\Plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                            </g>
                                        </svg><!--end::Svg Icon--></span>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table width="100%" class="border-0 px-5" id="fileDiv" style="border:1px solid #dcd8d8;">
                                    <tr></tr>
                                </table>
                            </div>
                        </div>
                        <div class="row buttonsDiv">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if(globalUserInfo()->role_id != 37 && globalUserInfo()->role_id != 38)
                                        <input type="hidden" id="status" name="status" value="ON_TRIAL">
                                    @else
                                        <input type="hidden" id="status" name="status" value="ON_TRIAL_DM">
                                    @endif
                                    <button type="button" class="btn btn-primary" onclick="myFunction()">
                                        আদেশ সংরক্ষণ করুন
                                    </button>
                                    {{-- <button type="button" onclick="formSubmit()" class="btn btn-warning">
                                        প্রেরণ(সংশ্লিষ্ট আদালত)
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Card-body-->
                </form>
            </div>
        </div>
        @include('appealTrial.inc.__modal')
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    @include('appealTrial.inc._script')
@endsection
