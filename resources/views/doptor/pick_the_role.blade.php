@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card">

        <div class="card-header flex-wrap py-5">
            <div class="card-title">
               <h2> এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্টের ইউজার ম্যানেজমেন্ট,  অফিসার নির্বাচন </h2>
            </div>
        </div>

        <div class="card-body">
            @if(globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38)
            <a href="{{ route('doptor.user.management.user_list',['office_id'=>encrypt(globalUserInfo()->doptor_office_id )]) }}" class="btn btn-success">অতিরিক্ত জেলা ম্যাজিস্ট্রেট নির্বাচন</a>
            @endif
            @if(globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38)
            <a href="{{ route('doptor.user.management.office_list')}}" class="btn btn-success">এক্সিকিউটিভ ম্যাজিস্ট্রেট নির্বাচন</a>
            @endif
            @if(globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38)

            <a href="{{ route('doptor.user.management.office_list.change.role')}}" class="btn btn-success">রোল পরিবর্তন</a>
            @endif
        <div>     
    </div>

    <!--end::Card-->
@endsection


{{-- Includable CSS Related Page --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
@endsection