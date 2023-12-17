@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="row">
        <div class="card card-custom col-12">
            <div class="card-header flex-wrap py-5">
                <div class="card-title">
                   <h2 > ইউজার ম্যানেজমেন্ট পেশকার </h2>
                </div>
                <div class="card-toolbar">
                   <a href="{{ route('peshkar.create.adm.dm.form') }}" class="btn btn-sm btn-primary font-weight-bolder">
                      <i class="la la-plus"></i>নতুন পেশকার এন্ট্রি
                   </a> 
                </div>
             </div>
            {{-- @php 
             dd($peshkar_users)
             
            @endphp --}}

            @if(Session::has('message'))
            <div class="alert-success p-5">
                {{ Session::get('message') }}
            </div>
            @endif
      <table class="table table-striped border">
        <thead>
            <tr>
                <th class="font-weight-bolder text-center">নাম</th>
                <th class="font-weight-bolder text-center">ইউজারনেম</th>
                <th class="font-weight-bolder text-center">মোবাইল</th>
                <th class="font-weight-bolder text-center">ইমেইল এড্রেস</th>
                <th class="font-weight-bolder text-center">নথি/সাধারন</th>
                <th class="font-weight-bolder text-center">পদক্ষেপ</th>
                <th class="font-weight-bolder text-center">অবস্থা</th>
                <th class="font-weight-bolder text-center">অ্যাক্টিভ/ইন অ্যাক্টিভ</th>
            </tr>
        </thead>
        @foreach($peshkar_users as $value)
        <tr>
           <td class="text-center">{{ $value->name }}</td>
           <td class="text-center">{{ $value->username }}</td>
           <td class="text-center">{{ $value->mobile_no }}</td>
           <td class="text-center">{{ isset($value->email) ? $value->email : '--' }}</td>
           <td class="text-center">
            @php 
            if($value->doptor_user_flag==1)
            {

                echo 'নথি ইউজার';
            }
            else {
                echo 'সাধারন ইউজার';
            }
            @endphp
           </td>
           <td class="text-center">
            @if($value->doptor_user_flag==0)
          
            <a href="{{ route('peshkar.update.form',['id'=>$value->id]) }}" class="btn btn-primary">সংশোধন</a>
            @else
            <p>দপ্তর ইউজারকে সংশোধন করা যাবে না </p>
            @endif
           
            </td>
           <td class="text-center">
            @if($value->peshkar_active==1)
              <button class="btn btn-success font-weight-bolder status" style="font-size: 15px">অ্যাক্টিভ</button>
            @else
              <button class="btn btn-danger font-weight-bolder status" style="font-size: 15px">ইন অ্যাক্টিভ</button>
            @endif
            
        
           </td>
           <td class="text-center">
            @php 
             if($value->peshkar_active==1)
             {
                echo '<button class="btn btn-danger active" data-user='.$value->id.'>ইন অ্যাক্টিভ</button>';
             }
             else 
             {
               echo '<button class="btn btn-primary active" data-user='.$value->id.'>অ্যাক্টিভ</button>';
             }
            @endphp
            
        
           </td>
        </tr>

        @endforeach
      </table>     
        </div>
    </div>

    <!--end::Card-->
    @include('peshkar._peshkar_create_js')




    <script></script>
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
