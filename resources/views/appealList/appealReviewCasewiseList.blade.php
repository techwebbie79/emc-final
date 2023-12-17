@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            @if (Auth::user()->role_id == 5)
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
                <thead class="thead-customStyle font-size-h6">
                    <tr>
                        <th scope="col">ক্রমিক নং</th>
                        <th scope="col">মামলার অবস্থা</th>
                        <th scope="col">মামলা নম্বর</th>
                        <th scope="col">মামলা আবেদনকারীর নাম</th>
                        <th scope="col">রিভিউ আবেদনকারীর নাম</th>
                        <th scope="col">আবেদনকারীর ধরন </th>
                        @if(globalUserInfo()->role_id == 36)
                            <th scope="col">নিজের পক্ষ</th>
                        @endif
                        <th scope="col"> রিভিউ আবেদনের তারিখ</th>
                        <th scope="col" width="70">পদক্ষেপ </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $key => $row)
                        @if($row->appeal_status == 'CLOSED')
                            @php
                                $finalOrderDate = date_create($row->final_order_publish_date);
                                $today = date_create(date('Y-m-d',strtotime(now())));
                                $diff = date_diff($finalOrderDate, $today);
                                $difference = $diff->format("%a");
                            @endphp
                        @endif
                        <tr>

                            <td scope="row" class="tg-bn">{{ en2bn($key + $results->firstItem()) }}.</td>
                            <td> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                            <td>{{ $row->case_no }}</td>
                            <td>
                                {{ $row->caseCreator->name ?? ''}}
                            </td>
                            <td>
                                {{ $row->reviewCreator->name ?? ''}}
                            </td>
                            <td>
                                {{ $row->reviewCreator->role->role_name ?? ''}}
                            </td>
                            @if(globalUserInfo()->role_id == 36)
                                <td>
                                    @if($row->created_by == globalUserInfo()->id)
                                        বাদী
                                    @else
                                        বিবাদী
                                    @endif
                                </td>
                            @endif
                            <!-- <td>{{ $row->gco_name }}</td> -->
                            <td>{{ en2bn($row->review_applied_date) }}</td>
                            <td>
                                <div class="btn-group float-right">
                                    <button class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" type="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">পদক্ষেপ </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item"
                                            href="{{ route('appeal.appealView', encrypt($row->id)) }}">বিস্তারিত তথ্য</a>
                                            <a class="dropdown-item"
                                            href="{{ route('appeal.appealTraking', encrypt($row->id)) }}">মামলা ট্রাকিং</a>
                                        @if(globalUserInfo()->role_id != 36)
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.nothiView', encrypt($row->id)) }}">নথি দেখুন
                                            </a>
                                        @elseif(globalUserInfo()->role_id == 36 && $row->appeal_status == 'CLOSED' && $row->final_order_publish_status == 1)
                                            <a class="dropdown-item"
                                                href="{{ route('appeal.nothiView', encrypt($row->id)) }}">নথি দেখুন
                                            </a>
                                        @endif
                                        @if(globalUserInfo()->role_id == 36)
                                            @if ($row->appeal_status == 'SEND_ASST_TO_EM' || $row->appeal_status == 'SEND_ASST_TO_ADM')
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন করুন</a>
                                            @endif
                                        
                                        @endif
                                        @if(globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 37 || globalUserInfo()->role_id == 38)

                                            @if ($row->appeal_status == 'SEND_TO_EM' || $row->appeal_status == 'SEND_TO_DM' || $row->appeal_status == 'SEND_TO_ADM'  || $row->appeal_status == 'SEND_TO_DM_REVIEW' )
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.trial', encrypt($row->id)) }}">মামলা গ্রহণ
                                                    করুন
                                                </a>
                                            @elseif ($row->appeal_status == 'ON_TRIAL_DM' || $row->appeal_status == 'ON_TRIAL' || $row->appeal_status == 'SEND_TO_DC' || $row->appeal_status == 'SEND_TO_DIV_COM' || $row->appeal_status == 'SEND_TO_NBR_CM')
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.trial', encrypt($row->id)) }}">কার্যক্রম পরিচালনা
                                                    করুন</a>
                                            @endif

                                            @if (Request::url() === route('appeal.collectPaymentList'))
                                                <a class="dropdown-item"
                                                    href="{{ route('appeal.collectPayment', encrypt($row->id)) }}">অর্থ
                                                    আদায়</a>
                                            @endif
                                        @endif
                                        @if(globalUserInfo()->role_id == 37)
                                            @if($row->appeal_status == 'ON_TRIAL_DM')
                                                @if($row->is_assigned == 0)
                                                    <a class="dropdown-item" href="{{ route('appeal.assign', encrypt($row->id)) }}">মামলা এসাইন
                                                    </a>
                                                @else
                                                    <a class="dropdown-item bg-success" href="#">ইতিমধ্যে এসাইন করা হয়েছে
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                        @if(globalUserInfo()->role_id == 28)
                                            @if ($row->appeal_status == 'SEND_TO_ASST_EM')
                                                <a class="dropdown-item" href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন ও প্রেরণ</a>
                                            @endif
                                        @endif
                                        @if(globalUserInfo()->role_id == 39)
                                            @if ($row->appeal_status == 'SEND_TO_ASST_DM')
                                                <a class="dropdown-item" href="{{ route('appeal.edit', encrypt($row->id)) }}">সংশোধন ও প্রেরণ</a>
                                            @endif
                                        @endif
                                        @if(globalUserInfo()->role_id == 1 || globalUserInfo()->role_id == 2)
                                                <a class="dropdown-item danger" href="{{ url('appeal/delete/'.encrypt($row->id) )}}">মুছে ফেলুন</a>
                                        @endif
                                            

                                        @if($row->appeal_status == 'CLOSED')
                                            @if(globalUserInfo()->role_id == 36)
                                                @if($row->final_order_publish_status == 1 && $difference<=15 && $row->reviewed_to_lab == 0)
                                                    @if($row->is_applied_for_review == 0)
                                                        <a href="{{ route('citizen.appeal.review.create', encrypt($row->id)) }}" class="dropdown-item">
                                                            রিভিউ আবেদন
                                                        </a>
                                                    @elseif($row->is_applied_for_review == 1)
                                                        <a class="dropdown-item" href="#" style="color: green;">
                                                            রিভিউর জন্য আবেদিত 
                                                        </a>
                                                    @endif
                                                @else
                                                  <a class="dropdown-item" href="#" style="color: red;">
                                                        রিভিউ আবেদনের সময় শেষ  
                                                  </a>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
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
    </div>
    <!--end::Card-->
@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
    <!-- <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" /> -->
    <!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page --}}
@section('scripts')
    <!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
           <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
         -->


    <!--end::Page Scripts-->
@endsection
