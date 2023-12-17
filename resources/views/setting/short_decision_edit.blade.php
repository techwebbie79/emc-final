@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom col-12">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-label"> {{ $page_title }} </h3>
            </div>
            <!-- <div class="card-toolbar">
             <a href="{{ url('division') }}" class="btn btn-sm btn-primary font-weight-bolder">
                <i class="la la-list"></i> ব্যবহারকারীর তালিকা
             </a>
          </div> -->
        </div>

        <form action="{{ route('setting.short-decision.update', $shortDecision->id) }}" method="POST">
            @csrf

            <div class="card-body row">
                        <div class="form-group col-lg-6">
                            <div class="form-group col-lg-6">
                                <label for="case_short_decision" class=" form-control-label">স্ট্যাটাসের নাম <span class="text-danger">*</span></label>
                                <input type="text" id="case_short_decision" name="case_short_decision" placeholder="স্ট্যাটাসের নাম লিখুন" class="form-control form-control-sm" value="{{ $shortDecision->case_short_decision}}">
                                <span style="color: red">
                                      {{ $errors->first('name') }}
                                </span>
                            </div>

                        </div>
                        <div class="form-group col-lg-6">
                            <table class="table table-hover mb-6 font-size-h6" >
                                <thead class="thead-light">
                                   <tr>
                                      <!-- <th scope="col" width="30">#</th> -->
                                       <th scope="col" >
                                        সিলেক্ট করুণ
                                     </th>
                                      <th scope="col">সিআরপিসি ধারা</th>
                                   </tr>
                                </thead>
                                <tbody>
                                   @foreach ($crpc_sections as $row)
                                   
                                  <tr>
                                     <td>
                                        <div class="checkbox-inline">
                                            
                                            @php
                                                $law_sec = DB::table('em_case_shortdecisions')->select('law_sec_id')->where('em_case_shortdecisions.id', $shortDecision->id)->first()->law_sec_id;
                                                $mk = explode(",",str_replace(array('[',']','"'), '', $law_sec));
                                            @endphp
                                           <label class="checkbox"> 
                                           <input type="checkbox" name="law_sec_id[]"  value="{{ $row->crpc_id }}" {{ in_array($row->crpc_id, $mk) ? 'checked': '' }} /><span></span>
                                        </div>
                                     </td>
                                      <td>{{ $row->crpc_id }}</td>
                                     
                                   </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                     </div>
                  </div>
    <!-- </div> -->

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ</button>
                    </div>
                </div>
            </div>

        </form>
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
