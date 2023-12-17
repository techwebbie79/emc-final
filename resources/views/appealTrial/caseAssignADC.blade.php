@extends('layouts.landing')

@section('content')
    <!--begin::Row-->
    <div class="card card-custom gutter-b example example-compact">
        <div class="card-header">
            <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            <div class="card-toolbar">
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <!--begin::Card-->
                <form id="assignCase" action="{{ route('appeal.assignStore') }}" class="form" method="POST" enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-group" id="officer">
                                <fieldset>
                                    <legend></legend>
                                    <input type="hidden" id="appeal_id" class="form-control" name="appeal_id" value="{{ $appeal_id }}">
                                    <div class="row" id="nothiCheck">
                                        <div class="col-md-12">
                                            <div class="text-dark font-weight-bold h4">
                                            <h4 for="">দপ্তর যাচাই : </h4>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input  type="text" id="doptorID" class="form-control" placeholder="দপ্তর আইডি প্রদান করুন " name="nothiID">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="button" id="doptorAdcCheck" name="investigatorCheck" onclick="doptorAdcCheck()" class="btn btn-danger" value="সন্ধান করুন"> <span class="ml-5" id="res_applicant_1"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adcName"class="control-label">নাম</label>
                                                <input name="adcName"id="adcName" class="form-control form-control-sm" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adcInstituteName"
                                                    class="control-label"><span
                                                        style="color:#FF0000"></span>প্রতিষ্ঠানের নাম</label>
                                                <input name="adcInstituteName"id="adcInstituteName" class="form-control form-control-sm" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adcMobile"class="control-label">মোবাইল</label>
                                                <input name="adcMobile" id="adcMobile"class="form-control form-control-sm" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="adcEmail"class="control-label">ইমেইল</label>
                                                <input name="adcEmail" id="adcEmail"class="form-control form-control-sm" value="">
                                            </div>
                                        </div>
                                    </div>
                                    
                                </fieldset>
                                 
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-success mr-2" onclick="myFunction()">সংরক্ষণ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
@endsection

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
                $('form#assignCase').submit();
                KTApp.blockPage({
                    overlayColor: 'black',
                    opacity: 0.2,
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
            }
        });
    }
</script>
@endsection
