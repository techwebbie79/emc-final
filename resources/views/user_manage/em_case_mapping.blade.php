@extends('layouts.landing')

@section('content')
    @php //echo $userManagement->name;
    //exit();
    @endphp

    <!--begin::Card-->

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-custom ">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label"> ব্যবহারকারীর বিস্তারিত </h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ route('user-management.index') }}"
                                class="btn btn-sm btn-primary font-weight-bolder">
                                <i class="la la-list"></i> ব্যবহারকারীর তালিকা
                            </a>
                        </div>
                    </div>
                    {{-- @foreach ($userManagement as $userManagement) --}}
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">নামঃ</span>
                            <span
                                class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->name }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইউজারনেমঃ</span>
                            <span
                                class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->username }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইউজার রোলঃ</span>
                            <span
                                class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->role_name }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">মোবাইল নাম্বারঃ</span>
                            <span
                                class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->mobile_no }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">অফিসের নামঃ</span>
                            <span
                                class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->office_name_bn }},
                                {{ $userManagement->upazila_name_bn }} {{ $userManagement->district_name_bn }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">ইমেইল এড্রেসঃ</span>
                            <span
                                class="text-dark flex-root font-weight-bolder font-size-h6">{{ $userManagement->email }}</span>
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">প্রোফাইল ইমেজঃ</span>
                            <span class="text-dark flex-root font-weight-bolder font-size-h6">
                                @if ($userManagement->profile_pic != null)
                                    <img src="{{ url('/') }}{{ $userManagement->profile_pic }}" width="200"
                                        height="200">
                                @else
                                    <img src="uploads/profile/default.jpg" width="200" height="200">
                                @endif

                            </span>
                            <!-- <img src="uploads/signature/{{ $userManagement->signature }}" width="300" height="300"> -->
                        </div>
                        <div class="d-flex mb-3">
                            <span class="text-dark-100 flex-root font-weight-bold font-size-h6">স্বাক্ষরঃ</span>
                            <span class="text-dark flex-root font-weight-bolder font-size-h6">
                                @if ($userManagement->signature != null)
                                    <img src="{{ url('/') }}{{ $userManagement->signature }}" height="100">
                                @else
                                    <span class="text-dark-100 flex-root font-weight-bold font-size-h6"></span>
                                @endif
                            </span>
                            <!-- <img src="uploads/signature/{{ $userManagement->signature }}" width="300" height="300"> -->
                        </div>
                        <!--  <div class="d-flex mb-3">
                 <span class="text-dark-100 flex-root font-weight-bold font-size-h6">স্ট্যাটাসঃ</span>
                 <span class="text-dark flex-root font-weight-bolder font-size-h6"></span>
              </div> -->
                    </div>
                    {{-- @endforeach --}}
                </div>
            </div>
            <div class="col-md-6">

                <?php $assignedipzilla=array();?>
                @foreach ($assignedupzilla as $assignedupzilla)
            <?php array_push($assignedipzilla,$assignedupzilla->upazilla_id); ?>
                @endforeach
                <div class="card card-custom ">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label"> ব্যবহারকারীর বিস্তারিত </h3>
                        </div>
                    </div>
                    {{-- @foreach ($userManagement as $userManagement) --}}
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                               <p>{{ $message }}</p>
                            </div>
                        @elseif($message = Session::get('danger'))
                          <div class="alert alert-danger">
                             <p>{{ $message }}</p>
                          </div>
                        @endif
                        <form action="{{ route('user-management.em-case-mapping-store') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $userManagement->id}}">
                            <input type="hidden" name="district_id" value="{{ $userManagement->district_id}}">
                            @foreach ($upzillas as $upzilla)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $upzilla->id }}" name="upzilla_case_mapping[]"
                                    {{in_array( $upzilla->id,$assignedipzilla) ? 'checked' : ''   }}>
                                    <label class="form-check-label" for="flexCheckDefault">
                                        {{ $upzilla->upazila_name_bn }}
                                    </label>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary">নিশ্চিত করুন</button>
                        </form>
                    </div>
                    {{-- @endforeach --}}
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

{{-- Scripts Section Related Page --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
@endsection
