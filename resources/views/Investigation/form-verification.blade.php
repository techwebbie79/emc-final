@extends('layouts.landing')

@section('landing')
    <style type="text/css">
        .invertigation_report {
            background-color: #3699ff;
            color: #ffff;
            border-radius: 10px;
            margin-top: 10px;
        }

        fieldset {
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;
            position: relative;
            border-radius: 4px;
            background-color: #d5f7d5;
            padding-left: 10px !important;
        }

        fieldset .form-label {
            color: black;
        }

        legend {
            font-size: 14px;
            font-weight: bold;
            width: 45%;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px 5px 5px 10px;
            background-color: #5cb85c;
        }
    </style>
    <!--begin::Card-->
    <div class="container">
        <div class="row">
           <div class="col-md-12" style="margin-top: 85px">

               <div class="card card-custom">
                   <div class="mx-auto">
                       <h3 class="mt-5"><span class="p-3 invertigation_report">তদন্ত প্রতিবেদন</span></h3>
                   </div>
           
                   <div class="p-5 m-5">
                       @if(Session::has('message'))
                       <div class="alert alert-danger" role="alert">
                           {{ Session::get('message') }}
                       </div>
                         @endif
           
                         @if(Session::has('success_report'))
                       <div class="alert alert-success" role="alert">
                           {{ Session::get('success_report') }}
                       </div>
                         @endif
           
                       <form method="post" action="{{ route('investigator.verify.form') }}">
                        @csrf
                           <div class="mb-2 pb-2">
                               <div class="mb-3 row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">মামলা নম্বর*</label>
                                   <div class="col-sm-10">
                                       <input type="text" class="form-control" id="case_no" name="case_no" value="{{old('case_no')}}" required>
                                     
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">মোবাইল নম্বর *</label>
                                   <div class="col-sm-10">
                                       <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{old('mobile_number')}}" required>
                                   </div>
                               </div>
                               <div class="mb-3 row">
                                   <label for="inputPassword" class="col-sm-2 col-form-label">গোপন নম্বর *</label>
                                   <div class="col-sm-10">
                                       <input type="text" class="form-control" id="investigation_tracking_code" name="investigation_tracking_code" required>
                                   </div>
                               </div>
                           </div>
                           <div class="text-center">

                               <button type="submit" class="btn btn-primary ps-5 me-5">পরবর্তী ধাপ</button>
                           </div>
                       </form>
                   </div>
           
           
           
               </div>
           </div>
        </div>
    </div>
    <!--end::Card-->
   
    @include('appealInitiate.appealCreate_Js')
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}

@section('scripts')
    @include('appealInitiate.appealCreate_Js')
@endsection
