@extends('layouts.landing')

@section('content')

<!--begin::Card-->
<div class="row">
   <div class="card card-custom col-12">
      <div class="card-header flex-wrap py-5">
         <div class="card-title">
            <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
         </div>
         
   
       <div class="row">
         <div class="col-md-12">
           <div class="card p-10">
            <div class="card-header flex-wrap py-5">
               <div class="card-title">
                   <h3 class="card-label"> 
                     
                     @if(globalUserInfo()->role_id == 28)
                     আপনি একজন পেশকার ইম ইউজার , আপনার তথ্য সংশোধন করতে চাইলে অনুগ্রহ করে
                     আপনার আদালতের ইম মহোদয় কে আনুরোধ করুন
                     @else
                     আপনি একজন পেশকার এডিএম ইউজার , আপনার তথ্য সংশোধন করতে চাইলে অনুগ্রহ করে
                     আপনার আদালতের এডিএম মহোদয় কে আনুরোধ করুন
                     @endif
                     
                     
                     </h3>
               </div>
           </div>
            <h1>
               
            </h1>
           </div>
         </div>
       </div>
     
   </div>
</div>
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection     

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
<!--end::Page Scripts-->
@endsection


