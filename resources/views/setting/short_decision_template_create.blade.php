@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            <div class="card-toolbar">
                {{-- <a href="{{ route('setting.crpcsection.add') }}" class="btn btn-sm btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>নতুন সেকশন এন্ট্রি
                </a> --}}
            </div>
        </div>
            <form id="shortDecisionTemplates" action="{{ route('setting.short-decision.details_store') }}" class="form" method="POST">
            @csrf
                <div class="card-body row">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                    <div class="form-group col-lg-12">
                        <label style="font-size:15px;" for="case_short_decision_id" class=" form-control-label">সংক্ষিপ্ত আদেশ:</label>
                        <input type="hidden" name="case_short_decision_id" value="{{ $shortDecision->id }}">
                        <span style="font-size:20px;font-weight: bold;" >{{ $shortDecision->case_short_decision }}</span>
                        <span style="color: red">
                            {{ $errors->first('name') }}
                        </span>
                    </div>
                    <div class="form-group col-lg-12">
                        
                        <table class="table table-hover mb-6 font-size-h6">
                                <tr>
                                    <th scope="col">ধারা</th>
                                    <th scope="col">সংক্ষিপ্ত আদেশ</th>
                                    <th scope="col">ক্ষুদে বার্তা</th>
                                </tr>
                                @forelse($law_sec_id as $key=> $row)
                                <tr>
                                    <td scope="col"><input type="hidden" name="law_sec_id[]" value="{{ $row }}">{{ $row }}</td>
                                    <td scope="col">
                                        <textarea type="text" id="details" name="details[]" rows="5" placeholder="মন্তব্যের টেমপ্লেট লিখুন" class="form-control form-control-sm">{{ isset($shortDecisionDetails[$key][0]->delails) ? $shortDecisionDetails[$key][0]->delails : ''}}</textarea>
                                    </td>
                                    <td scope="col">
                                        <textarea type="text" id="sms_templet" name="sms_templet[]" rows="5" placeholder="ক্ষুদে বার্তা লিখুন" class="form-control form-control-sm">{{ isset($smsDetails[$key][0]->sms_templet) ? $smsDetails[$key][0]->sms_templet : ''}}</textarea>
                                    </td>
                                </tr>
                                @empty
                                @endforelse                
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-5"></div>
                        <div class="col-lg-7">
                            <button type="button" class="btn btn-primary mr-2" onclick="myFunction()">সংরক্ষণ করুন</button>
                        </div>
                    </div>
                </div>
            </form>

            

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
                        $('form#shortDecisionTemplates').submit();
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
