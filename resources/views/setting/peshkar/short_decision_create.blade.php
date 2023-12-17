@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                            <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                            <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                        </div> -->
                    </div>
                </div>
                   @if ($errors->any())
                      
                     @foreach ($errors->all() as $error)
                      <li class="alert alert-danger">{{ $error }}</li>
                     @endforeach
                   
                @endif
                <!--begin::Form-->
                <form id="shortDecision" action="{{ route('peshkar.short.decision.store') }}" class="form" method="POST">
                @csrf
                    <div class="card-body row">
                        <div class="form-group col-lg-6">
                            <div class="form-group">
                                <label for="case_short_decision" class=" form-control-label">স্ট্যাটাসের নাম <span class="text-danger">*</span></label>
                                <input type="text" id="case_short_decision" name="case_short_decision" placeholder="স্ট্যাটাসের নাম লিখুন" class="form-control form-control-sm">
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
                                      <th scope="col">সিআরপিসি ধারা </th>
                                   </tr>
                                </thead>
                                <tbody>
                                   @foreach ($crpc_sections as $row)
                                   
                                  <tr>
                                     <td>
                                        <div class="checkbox-inline">
                                           <label class="checkbox">
                                           <input type="checkbox" name="law_sec_id[]"  value="{{ $row->crpc_id }}" /><span></span>
                                        </div>
                                     </td>
                                      <td>{{ $row->crpc_id }}</td>
                                     
                                   </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> <!--end::Card-body-->

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-5"></div>
                            <div class="col-lg-7">
                                <button type="button" class="btn btn-primary mr-2" onclick="myFunction()">সংরক্ষণ করুন</button>
                            </div>
                        </div>
                    </div>
                 
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
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
        <script type="text/javascript">
            
            function myFunction() {
                Swal.fire({
                    title: "আপনি কি সংরক্ষণ করতে চান?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "হ্যাঁ",
                    cancelButtonText: "না",
                })
                .then(function(result) {
                    if (result.value) {
                        // setTimeout(() => {
                        $('form#shortDecision').submit();
                        // }, 5000);
                        KTApp.blockPage({
                            // overlayColor: '#1bc5bd',
                            overlayColor: 'black',
                            opacity: 0.2,
                            // size: 'sm',
                            message: 'Please wait...',
                            state: 'danger' // a bootstrap color
                        });
                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: "সফলভাবে সাবমিট করা হয়েছে!",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        // toastr.success("সফলভাবে সাবমিট করা হয়েছে!", "Success");
                    }
                });
            }
        </script>
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
    <!--end::Page Scripts-->
@endsection
