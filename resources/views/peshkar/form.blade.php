@extends('layouts.landing')


@if (globalUserInfo()->doptor_user_flag == 1)

    @section('content')
        <!--begin::Card-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

        <div class="card">


            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                    <h2> {{ $page_title }} </h2>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('peshkar.create.manual.form') }}" class="btn btn-sm btn-primary font-weight-bolder">
                        <i class="la la-plus"></i>নতুন পেশকার এন্ট্রি ম্যানুয়াল
                    </a>
                </div>
            </div>

            <div class="card-body">
                @php
                   
                    if (isset($_GET['search_key'])) {
                        $case_no = $_GET['search_key'];
                    } else {
                        $case_no = null;
                    }
                @endphp

                <form class="form-inline" method="GET" action="{{ route('peshkar.create.form.search') }}">
                    <div class="container mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <input type="text" class="form-control " name="search_key"
                                    placeholder="নাম, নথি আইডি, পদবী" value="{{ $case_no }}" required>
                            </div>
                            <div class="col-md-2 mt-1">
                                <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান
                                    করুন</button>
                            </div>
                        </div>
                    </div>
                </form>


                <table class="table table-striped table-hover" id="example" width="100%">
                    <thead>

                        <tr>
                            <td>ক্রম</td>
                            <td>নাম</td>
                            <td>পদবী</td>
                            <td>পদবী ইংরেজি</td>
                            <td>রোল</td>
                            <td>আদালত নির্বাচন</td>
                            <td>স্ট্যাটাস</td>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $increment = 1;
                            $list_of_others = array_reverse($list_of_others);
                            
                            if(globalUserInfo()->role_id == 27)
                            {

                                
                                    $peshkar_role = 28;
                                    $peshkar_designation = 'পেশকার (ইএম)';
                               
                            }
                            elseif (globalUserInfo()->role_id == 37) {
                                $peshkar_role = 39;
                                $peshkar_designation = 'পেশকার (এ ডি এম)';
                            }
                            elseif (globalUserInfo()->role_id == 38) {
                                $peshkar_role = 39;
                                $peshkar_designation = 'পেশকার (এ ডি এম)';
                            }

                        @endphp
                        @foreach ($list_of_others as $value)
                            @php
                                $is_adc = false;
                                $is_em = false;
                                $is_dc = false;
                                $is_adm_peskar = false;
                                $is_em_peskar = false;

                                if ($value['role_id'] == 27) {
                                    $is_em = true;
                                } elseif ($value['role_id'] == 38) {
                                    $is_adc = true;
                                } elseif ($value['role_id'] == 37) {
                                    $is_dc = true;
                                }
                                elseif ($value['role_id'] == 28) {
                                    $is_em_peskar = true;
                                }
                                elseif ($value['role_id'] == 39) {
                                    $is_adm_peskar = true;
                                }
                              
                            @endphp


                            <tr>
                                <input type="hidden" name="" id="office_name_bn_{{ $increment }}"
                                    value="{{ $value['office_name_bn'] }}">
                                <input type="hidden" name="" id="office_name_en_{{ $increment }}"
                                    value="{{ $value['office_name_en'] }}">
                                <input type="hidden" name="" id="unit_name_bn_{{ $increment }}"
                                    value="{{ $value['unit_name_bn'] }}">
                                <input type="hidden" name="" id="unit_name_en_{{ $increment }}"
                                    value="{{ $value['unit_name_en'] }}">
                                <input type="hidden" name="" id="designation_bng_{{ $increment }}"
                                    value="{{ $value['designation_bng'] }}">
                                <input type="hidden" name="" id="office_id_{{ $increment }}"
                                    value="{{ $value['office_id'] }}">
                                <input type="hidden" name="" id="username_{{ $increment }}"
                                    value="{{ $value['username'] }}">
                                <input type="hidden" name="" id="employee_name_bng_{{ $increment }}"
                                    value="{{ $value['employee_name_bng'] }}">

                                <td>{{ $increment }}</td>

                                <td><input type="text" class="form-control" value="{{ $value['employee_name_bng'] }}"
                                        readonly>
                                </td>
                                <td><input type="text" class="form-control" value="{{ $value['designation_bng'] }}"
                                        readonly>
                                </td>
                                <td><input type="text" class="form-control" value="{{ $value['designation_eng'] }}"
                                        readonly>
                                </td>
                                <td>


                                    @if ($is_em)
                                        <input type="text" class="form-control" value=" এক্সিকিউটিভ ম্যাজিস্ট্রেট" readonly>
                                    @elseif($is_adc)
                                        <input type="text" class="form-control" value="অতিরিক্ত জেলা ম্যাজিস্ট্রেট"
                                            readonly>
                                    @elseif($is_dc)
                                        <input type="text" class="form-control" value="জেলা ম্যাজিস্ট্রেট" readonly>
                                    @elseif($is_em_peskar)
                                        <input type="text" class="form-control" value="পেশকার (ইএম)" readonly>
                                    @elseif($is_adm_peskar)
                                        <input type="text" class="form-control" value="পেশকার (এ ডি এম)" readonly>
                                    @else
                                        <input type="hidden" class="form-control" value="{{ $peshkar_role }}"
                                            id="role_id_{{ $increment }}">

                                        <input type="text" class="form-control" value="{{ $peshkar_designation }}"
                                            readonly>
                                    @endif

                                </td>
                                <td>
                                    @php
                                        if ($is_adc) {
                                            $disabled='disabled';
                                        } elseif ($is_em) {
                                            $disabled='disabled';
                                        } elseif ($is_dc) {
                                            $disabled='disabled';
                                        } 
                                        elseif ($is_adm_peskar) {
                                            $disabled='disabled';
                                        }
                                        elseif ($is_em_peskar) {
                                            $disabled='disabled';
                                        }
                                        else {
                                            $disabled=' ';
                                        }
                                    @endphp

                                    <select name="court_select" class="court_select form-control form-control-sm"
                                        class="form-control form-control-sm" id="{{ $increment }}">

                                        <option value="0" {{ $disabled }} selected>কোন আদালত দেওয়া হয় নাই</option>

                                        @if ($disabled == 'disabled')
                                        @foreach ($courtlist_distrcit_all as $available_court_single)
                                            @php
                                                $selected=' ';
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_court_single->id }}" {{ $selected }}
                                                {{ $disabled }}>
                                                {{ $available_court_single->court_name }}</option>
                                        @endforeach
                                    @else
                                        @foreach ($available_court_picker as $available_court_single)
                                            @php
                                                $selected=' ';
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $selected='selected';
                                                }
                                            @endphp
                                            <option value="{{ $available_court_single->id }}" {{ $selected }}
                                                {{ $disabled }}>
                                                {{ $available_court_single->court_name }}</option>
                                        @endforeach
                                    @endif
                                    </select>
                                </td>
                                <td>
                                    @php $court_ids=[]; @endphp
                                    @foreach ($courtlist_distrcit_all as $available_court_single)
                                        @php  array_push($court_ids,$available_court_single->id); @endphp
                                    @endforeach

                                    @if (in_array($value['court_id'], $court_ids))
                                        @php
                                            $court_name_showing='';
                                            foreach ($courtlist_distrcit_all as $available_court_single) {
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $court_name_showing = $available_court_single->court_name;
                                                }
                                            }
                                        @endphp
                                        <button
                                            class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $court_name_showing }}
                                            এনাবেল</button>
                                    @else
                                        <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত
                                            দেয়া হয় নাই ডিজেবেল</button>
                                    @endif

                                </td>
                            </tr>
                            @php $increment++; @endphp
                        @endforeach

                    </tbody>
                </table>

                <div>
                </div>
            </div>
        </div>
        <!--end::Card-->


        @if (globalUserInfo()->role_id == 27)
            @if ($level == 4)
                @include('peshkar.inc._peshkar_create_em_uno_js')
            @endif
            @if ($level == 3)
                @include('peshkar.inc._peshkar_create_em_dc_js')
            @endif
        @endif
        @if (globalUserInfo()->role_id == 37)
            @include('peshkar.inc._peshkar_create_adm_js')
        @elseif(globalUserInfo()->role_id == 38)
            @include('peshkar.inc._peshkar_create_adm_js')
        @endif
    @endsection


@endif


{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <script>
        $(document).ready(function() {



            var myTable = $('#example').DataTable({
                searching: false,
                ordering: false,
            });

        });
    </script>
@endsection
