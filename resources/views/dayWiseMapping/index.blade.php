@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>

        </div>
        {{-- @foreach ($all_em_court_with_district as $count)
         @php var_dump($count->court_name); @endphp
        @endforeach --}}
        @php

            function checkFunction($days_active_string, $day_string)
            {
                if (!empty($days_active_string)) {
                    $days_array = explode(',', $days_active_string);
                    if (is_array($days_array)) {
                        if (in_array($day_string,$days_array)) {
                            return 'checked';
                        } else {
                            return '';
                        }
                    }else {
                        return '';
                    }
                    
                } else {
                    return '';
                }
            }

        @endphp
        <div class="card-body overflow-auto">
            <form action="{{ route('day-wise-case-mapping.store') }}" method="post">
                @csrf
                <table class="table table-hover mb-6 font-size-h5">
                    <thead class="thead-customStyle font-size-h6">
                        <tr>
                            <th scope="col">ক্রমিক নং</th>
                            <th scope="col">নির্বাহী ম্যাজিস্ট্রেট</th>
                            <th scope="col">আদালত</th>
                            <th scope="col">বার</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $i=0; @endphp
                        @foreach ($all_em_with_district as $key => $value)
                            @php $i++; @endphp
                            <tr>
                                <input type="hidden" name="user_id[]" value="{{ $value->id }}">
                                <td>{{ $i }}</td>
                                <th>{{ $value->name }}</th>
                                <td>
                                    <select name="court[]" class="form-control">

                                        @foreach ($all_em_court_with_district as $k => $court)
                                            @php
                                                if ($court->id == $value->court_id) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                            @endphp
                                            <option value="{{ $court->id }}" {{ $selected }}>{{ $court->court_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>

                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" name="day_check[{{ $key }}][]"
                                                    type="checkbox" value="SUN" id="flexCheckChecked"
                                                    {{ checkFunction($value->days_active, 'SUN') }}>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Sun
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" name="day_check[{{ $key }}][]"
                                                    type="checkbox" value="MON" id="flexCheckChecked"
                                                    {{ checkFunction($value->days_active, 'MON') }}>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Mon
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" name="day_check[{{ $key }}][]"
                                                    type="checkbox" value="TUE" id="flexCheckChecked"
                                                    {{ checkFunction($value->days_active, 'TUE') }}>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Tue
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" name="day_check[{{ $key }}][]"
                                                    type="checkbox" value="WED" id="flexCheckChecked"
                                                    {{ checkFunction($value->days_active, 'WED') }}>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Wed
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input class="form-check-input" name="day_check[{{ $key }}][]"
                                                    type="checkbox" value="THU" id="flexCheckChecked"
                                                    {{ checkFunction($value->days_active, 'THU') }}>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Trus
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <button class="btn btn-primary text-center">Submit</button>
            </form>
        </div>
    </div>
    <!--end::Card-->


    <script>
        $(document).ready(function() {
            $.fn.select2.defaults.set("theme", "bootstrap4");
            $('.js-example-basic-multiple').select2();
        });
    </script>
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    -->


    <!--end::Page Scripts-->
@endsection
