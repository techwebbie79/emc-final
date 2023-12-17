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
<!-- </div>
<div class="row"> -->
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
</div>




