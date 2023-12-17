@extends('layouts.landing')

@section('content')
   @include('dashboard.inc.icon_card')
   <div class="card card-custom bg-primary-o-15 mb-5 shadow">
   	@include('dashboard.citizen.cause_list')
   </div>

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')

<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->
<script src="{{ asset('js/pages/widgets.js') }}"></script>
<!--end::Page Scripts-->
@if(in_array(globalUserInfo()->role_id,[36,20]) && globalUserInfo()->is_cdap_user == 1)
    <script>
        let token = '{{ Session::get('access_token_cdap') }}'
        let widgets_id = '{{ mygov_client_id()}}'
    </script>
    <script src="{{ mygov_endpoint() }}/js/mygov-widgets-plugin.js"></script>
@endif
@endsection
