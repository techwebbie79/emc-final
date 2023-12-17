@extends('layouts.citizen.citizen')

@section('content')


<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
      </div>
      @if(Auth::user()->role_id == 5)
      <div class="card-toolbar">
         <a href="{{ url('case/add') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন মামলা এন্ট্রি
         </a>
      </div>
      @endif
   </div>
   <div class="card-body overflow-auto">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      @include('appeal.search')

      <table class="table table-hover mb-6 font-size-h5">
         <thead class="thead-light font-size-h6">
            <tr>
               <th scope="col" width="30">#</th>
               {{-- <th scope="col">ক্রমিক নং</th> --}}
               <th scope="col">সার্টিফিকেট অবস্থা</th>
               <th scope="col">মামলা নম্বর</th>
               <th scope="col">পূর্ববর্তী মামলার নং</th>
               <th scope="col">আবেদনকারীর নাম</th>
               <th scope="col">জেনারেল সার্টিফিকেট অফিসার</th>
               <th scope="col">পরবর্তী তারিখ</th>
               <!-- <th scope="col">অফিস হতে প্রেরণের তারিখ</th>
               <th scope="col">জবাব পাওয়ার তারিখ</th>
               <th scope="col">বিজ্ঞ জি.পি নিকট প্রেরণ</th> -->
               <!-- <th scope="col" width="100">স্ট্যাটাস</th> -->
               <th scope="col" width="70">অ্যাকশন</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($results as $key => $row)
                <tr>

                    <td scope="row" class="tg-bn">{{ en2bn($key+ $results->firstItem()) }}.</td>
                    <td> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                    <td>{{ $row->case_no }}</td>
                    <td>{{ $row->prev_case_no }}</td>
                    <td>
                        {{-- @dd($row->appealCitizensJoin); --}}
                        @php
                            $appName = null;
                        @endphp
                        @foreach ($row->appealCitizens as $key => $item)
                            @foreach ($item->citizenType as $i => $it)
                                @if ($it->citizen_type == 'applicant')
                                    @foreach ($item->citizensAppealJoin as $activeCheck)
                                        @if ($activeCheck->active == 1 && $appName == null && $row->id == $activeCheck->appeal_id)
                                            @php
                                                $appName = $item->citizen_name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                        {{  $appName }}
                    </td>
                    <td>{{ $row->gco_name }}</td>
                    <td>{{ en2bn($row->case_date) }}</td>
                    <td>
                        <div class="btn-group float-right">
                            <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">অ্যাকশন</button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('appeal.appealView', encrypt($row->id)) }}">বিস্তারিত তথ্য</a>
                                <a class="dropdown-item" href="{{ route('appeal.nothiView', encrypt($row->id)) }}">নথি দেখুন</a>
                                @if ($row->appeal_status != 'REJECTED')
                                    <a class="dropdown-item" href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন করুন</a>
                                @endif
                                @if(globalUserInfo()->role_id == 27)
                                    @if ($row->appeal_status == 'SEND_TO_GCO')
                                        {{-- <a class="dropdown-item" href="{{ route('appeal.status_change', encrypt($row->id)) }}?status=REJECTED">মামলা বর্জন  করুন</a> --}}
                                        <a class="dropdown-item" href="{{ route('appeal.trial', encrypt($row->id)) }}">মামলা গ্রহণ করুন</a>
                                    @elseif ($row->appeal_status == 'ON_TRIAL' || $row->appeal_status == 'SEND_TO_DC' || $row->appeal_status == 'SEND_TO_DIV_COM' || $row->appeal_status == 'SEND_TO_NBR_CM' )
                                        <a class="dropdown-item" href="{{ route('appeal.trial', encrypt($row->id)) }}">কার্যক্রম পরিচালনা করুন</a>
                                    @endif
                                    @if (Request::url() === route('appeal.collectPaymentList'))
                                        <a class="dropdown-item" href="{{ route('appeal.collectPayment', encrypt($row->id)) }}">অর্থ আদায়</a>
                                    @endif
                                @endif
                                
                                {{-- @if($row->is_lost_appeal == 0)
                                    <div class="dropdown-divider"></div>
                                        @if($row->status == 2)
                                        <a class="alert alert-success" href="javascript:void(0)">আপিল করা হয়েছে</a>
                                        @else
                                        <a class="dropdown-item" href="{{ route('case.create_appeal', $row->id) }}">মামলা আপিল করুন</a>
                                        @endif
                                    </div>
                                @endif --}}
                        </div>
                    </td>
                </tr>
            @endforeach
         </tbody>
      </table>

      <div class="d-flex justify-content-center">
         {!! $results->links() !!}
      </div>
   </div>
   <!--end::Card-->

   @endsection

   {{-- Includable CSS Related Page --}}
   @section('styles')
   <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
   <!--end::Page Vendors Styles-->
   @endsection

   {{-- Scripts Section Related Page--}}
   @section('scripts')
   <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
   <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
 -->


<!--end::Page Scripts-->
@endsection


