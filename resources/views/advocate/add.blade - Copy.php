@extends('layouts.landing')
@section('content')
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid wizard" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-15 px-30">
                <!--begin::Aside header-->
                <a href="#" class="login-logo py-6">
                    <img class="img-responsive" src="{{ asset('images/logo.png') }}" alt="e-Court">
                </a>
                <!-- <h1 class="font-weight-bolder text-dark ">একাউন্ট তৈরি করুন</h1>
                <div class="text-muted font-weight-bold font-size-h4">ইতিমধ্যে একটি একাউন্ট আছে ?
                	<a href="javascript:;" data-toggle="modal" data-target="#exampleModalLong" id="kt_quick_user_toggle" class="text-primary font-weight-bolder">লগইন করুন</a>
        		</div> -->
                <!--end::Aside header-->
                <!--begin: Wizard Nav-->
                <div class="wizard-nav pt-5 pt-lg-30">
                    <!--begin::Wizard Steps-->
                    <div class="wizard-steps">
                        <!--begin::Wizard Step 1 Nav-->
                        <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">1</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">প্রাথমিক তথ্য </h3>
                                    <div class="wizard-desc">আপনার প্রাথমিক তথ্য সেটআপ করুন</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Wizard Step 1 Nav-->
                        <!--begin::Wizard Step 2 Nav-->
                        <div class="wizard-step" data-wizard-type="step">
                            <div class="wizard-wrapper">
                                <div class="wizard-icon">
                                    <i class="wizard-check ki ki-check"></i>
                                    <span class="wizard-number">2</span>
                                </div>
                                <div class="wizard-label">
                                    <h3 class="wizard-title">ঠিকানা </h3>
                                    <div class="wizard-desc">ঠিকানা সেটআপ করুন</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end::Wizard Steps-->
                </div>
                <!--end: Wizard Nav-->
            </div>

        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-column-fluid d-flex flex-column p-10">
            <!--begin::Top-->

            <!--end::Top-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-row-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-form-signup">
                    <!--begin::Form-->
                    <form class="form" method="POST" action="{{route('citizenRegister.store')}}" novalidate="novalidate" id="kt_login_signup_form">
                        @csrf
                        <!--begin: Wizard Step 1-->
                        <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                            <!--begin::Title-->
                            <div class="pb-10 pb-lg-15">
                                <h3 class="font-weight-bolder text-dark display5">নাগরিক নিবন্ধন করুন</h3>
                                <div class="text-muted font-weight-bold font-size-h4">ইতিমধ্যে নিবন্ধিত আছে ?
                                <a href="javascript:;" data-toggle="modal" data-target="#exampleModalLong" id="kt_quick_user_toggle" class="text-primary font-weight-bolder">লগইন করুন</a></div>
                            </div>
                            <!--begin::Title-->
                            <!--begin::Form Group-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">পুরো নাম <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" id="name" name="name" placeholder="পুরো নাম লিখুন" required />
                                         <span style="color: red">
                                            {{ $errors->first('name') }}
                                        </span>
                                    </div>
                                </div>
                                    <!--end::Form Group-->
                                    <!--begin::Form Group-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">ইউজারনেম <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" id="username" name="username"placeholder="ইউজারনেম নাম লিখুন"  required />
                                        <span style="color: red">
                                            {{ $errors->first('username') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">জন্ম তারিখ  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6 common_datepicker" id="dob" name="dob" placeholder="DD/MM/YYY" required />
                                         <span style="color: red">
                                            {{ $errors->first('dob') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="gender"class="font-size-h6 font-weight-bolder text-dark">লিঙ্গ</label>
                                            <select style="width: 100%;"class="selectDropdown form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" name="gender" id="gender">
                                                <option value="">বাছাই করুন</option>
                                                <option value="MALE">পুরুষ</option>
                                                <option value="FEMALE">নারী</option>
                                            </select>
                                         <span style="color: red">
                                            {{ $errors->first('gender') }}
                                        </span>
                                    </div>
                                </div>
                                    <!--end::Form Group-->
                                    <!--begin::Form Group-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">জাতীয় পরিচয়পত্র নং  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" id="nid" name="nid"placeholder="উদাহরণ- 19825624603112948"  required />
                                        <span style="color: red">
                                            {{ $errors->first('nid') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                                    <!--end::Form Group-->
                            <div class="row">
                                    <!--begin::Form Group-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">জন্ম সনদ নম্বর </label>&nbsp;
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" id="birth_reg_no" name="birth_reg_no"placeholder="উদাহরণ- ১৯৯৪৪৫৮৭৪৫০১২৫৪০২"  required />
                                        <span style="color: red">
                                            {{ $errors->first('birth_reg_no') }}
                                        </span>
                                    </div>
                                </div>
                                    <!--end::Form Group-->
                                <div class="col-xl-6">
                                    <!--begin::Form Group-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">মোবাইল নাম্বার <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" name="mobile_no" id="mobile_no" placeholder="মোবাইল নাম্বার লিখুন"/>
                                        <span style="color: red">
                                            {{ $errors->first('mobile_no') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">ইমেল <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" id="email" name="email" placeholder="ইমেল লিখুন"/>
                                        <span style="color: red">
                                            {{ $errors->first('email') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">পাসওয়ার্ড <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" name="password" id="password" placeholder="পাসওয়ার্ড লিখুন"  />
                                        <span style="color: red">
                                            {{ $errors->first('password') }}
                                        </span>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Form Group-->
                        </div>
                        <!--end: Wizard Step 1-->
                        <!--begin: Wizard Step 2-->
                        <div class="pb-5" data-wizard-type="step-content">
                            <!--begin::Title-->
                            <div class="pt-lg-0 pt-5 pb-15">
                                <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">ঠিকানার বিস্তারিত</h3>

                            </div>
                            <!--begin::Title-->
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-6">
                                    <!--begin::Input-->
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">বর্তমান ঠিকানা </label>
                                        <textarea type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" name="present_add" id="present_add" placeholder="বর্তমান ঠিকানা লিখুন"/></textarea>
                                        <span style="color: red">
                                            {{ $errors->first('present_add') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="font-size-h6 font-weight-bolder text-dark">স্থায়ী ঠিকানা </label>
                                        <textarea type="text" class="form-control h-auto py-3 px-3 border-0 rounded-md font-size-h6" name="permanent_add" id="permanent_add" placeholder="স্থায়ী ঠিকানা লিখুন"/></textarea>
                                        <span style="color: red">
                                            {{ $errors->first('permanent_add') }}
                                        </span>
                                    </div>

                                    <!--end::Input-->
                                </div>

                            </div>
                            <!--end::Row-->
                        </div>

                        <!--end: Wizard Step 4-->
                        <!--begin: Wizard Actions-->
                        <div class="d-flex justify-content-between pt-3">
                            <div class="mr-2">
                                <button type="button" class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3" data-wizard-type="action-prev">
                                <span class="svg-icon svg-icon-md mr-1">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1" />
                                            <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>পূর্ববর্তী</button>
                            </div>
                            <div>
                                <button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" data-wizard-type="action-submit" type="submit" id="kt_login_signup_form_submit_button">Submit
                                <span class="svg-icon svg-icon-md ml-2">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span></button>
                                <button type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3" data-wizard-type="action-next">পরবর্তী
                                <span class="svg-icon svg-icon-md ml-1">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span></button>
                            </div>
                        </div>
                        <!--end: Wizard Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
@endsection
@section('styles')
<link href="assets/css/pages/login/login-3.css" rel="stylesheet" type="text/css" />
@endsection
@section('scripts')
    <script src="assets/js/pages/custom/login/login-3.js"></script>
@endsection


