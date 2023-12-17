<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.all_case') }}">
            <div class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-danger  mr-2">
                            <span class="symbol-label">
                                <i class="text-danger icon-2x fas fa-archway"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1  Count">{{ en2bn($total_case) }}</span>
                            <span class="text-white mt-2 font-size-h3">মোট মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.pending_list') }}">
            <div class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span class="symbol-label">
                                <i class="text-success icon-2x fas fa-file-invoice"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1 Count">{{ en2bn($pending_case) }}</span>
                            <span class="text-white mt-2 font-size-h3">গ্রহণের জন্য অপেক্ষমাণ</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.index') }}">
            <div class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-primary  mr-2">
                            <span class="symbol-label">
                                <i class="text-primary icon-2x fas fa-book-open"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1 Count">{{ en2bn($running_case) }}</span>
                            <span class="text-white mt-2 font-size-h3">চলমান মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.rejected_list') }}">
            <div class="card card-custom bg-info bg-hover-state-info card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-info  mr-2">
                            <span class="symbol-label">
                                <i class="text-info icon-2x far fa-file-excel"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1 Count">{{ en2bn($rejected_case) }}</span>
                            <span class="text-white mt-2 font-size-h3">খারিজকৃত মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('appeal.closed_list') }}">
            <div class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span class="symbol-label">
                                <i class="text-success icon-2x far fa-check-circle"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1  Count">{{ en2bn($completed_case) }}</span>
                            <span class="text-white mt-2 font-size-h3">নিষ্পত্তিকৃত মামলা</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('office') }}">
            <div class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-danger  mr-2">
                            <span class="symbol-label">
                                <i class="text-danger icon-2x fas fas fa-home"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1 Count">{{ en2bn($total_office) }}</span>
                            <span class="text-white mt-2 font-size-h3">মোট অফিস</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('user-management.index') }}">
            <div class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-success  mr-2">
                            <span class="symbol-label">
                                <i class="text-success icon-2x far fas fa-user-friends"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1 Count">{{ en2bn($total_user) }}</span>
                            <span class="text-white mt-2 font-size-h3">মোট ইউজার</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

@if(globalUserInfo()->role_id == 27 || globalUserInfo()->role_id == 37  || globalUserInfo()->role_id == 38 )
<a href="{{ route('appeal.pending_list') }}">
    <div class="row mb-5">
        <div class="col-xl-6">
            <div class="">
                <div class="toast-header py-3">
                    <i class="text-primary icon fas fas fa-bell m"></i>
                  <strong class="ml-2 mr-auto">পদক্ষেপ নিতে হবে এমন মামলাসমূহ</strong>
                  <span class="badge badge-danger">{{$notifications ?? ''}}</span>
                </div>
                <div class="toast-body bg-light">
                    গ্রহণের জন্য অপেক্ষমাণ নতুন আবেদন <span class="badge badge-danger ml-5">{{$notifications ?? ''}}</span>
                </div>
              </div>
        </div>
    </div>
</a>
@endif
<!--
<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
        <a href="{{ route('court') }}">
            <div class="card card-custom bg-warning bg-hover-state-warning card-stretch gutter-b">
                <div class="card-body p-0" style="">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <span class="symbol symbol-50 symbol-light-warning  mr-2">
                            <span class="symbol-label">
                                <i class="text-warning icon-2x fas fa-laptop-house"></i>
                            </span>
                        </span>
                        <div class="d-flex flex-column text-right">
                            <span class="text-light font-size-h1 Count">{{ en2bn($total_court) }}</span>
                            <span class="text-white mt-2 font-size-h3">মোট আদালত</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div> -->
