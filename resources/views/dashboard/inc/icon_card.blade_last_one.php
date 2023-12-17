@if (globalUserInfo()->role_id != 32 && globalUserInfo()->role_id != 33)
    <div class="row">
        <div class="col-12 col-offset-9">
            <ul class="icon_card_top_row">
                <li>
                    <a href="">
                        <i class="fas fa-play"></i>
                        <span>নির্দেশিকা</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <i class="fas fa-phone-alt"></i>
                        <span>কল সেন্টার সাপোর্ট</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
            <a href="{{ route('appeal.all_case') }}">
                <div class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
                    <div class="card-body" style="">
                        <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                            <span class="symbol symbol-50 symbol-light-danger  mr-2">
                                <span>
                                    <i class="fas fa-border-all"></i>
                                </span>
                                <span class="text-light Count">{{ en2bn($total_case) }}</span>
                            </span>
                            <div class="text-left icn-card-label">
                                <span class="text-white mt-2 font-size-h3">মোট মামলা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        @if (!in_array(globalUserInfo()->role_id, [7]))
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                <a href="{{ route('appeal.pending_list') }}">
                    <div class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                        <div class="card-body" style="">
                            <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                                <span class="symbol symbol-50 symbol-light-success  mr-2">
                                    <span>
                                        <i class="fas fa-hands"></i>
                                    </span>
                                </span>
                                <span class="text-light  Count">{{ en2bn($pending_case) }}</span>
                                <div class="text-left icn-card-label">
                                    <span class="text-white mt-2 font-size-h3">গ্রহণের জন্য অপেক্ষমাণ </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endif



        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
            <a href="{{ route('appeal.index') }}">
                <div class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
                    <div class="card-body" style="">
                        <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                            <span class="symbol symbol-50 symbol-light-primary  mr-2">
                                <span>
                                    <i class="fas fa-walking"></i>
                                </span>
                            </span>
                            <span class="text-light  Count">{{ en2bn($running_case) }}</span>
                            <div class="text-left icn-card-label">
                                <span class="text-white mt-2 font-size-h3">চলমান মামলা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-12">
            <a href="{{ route('appeal.closed_list') }}">
                <div class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
                    <div class="card-body" style="">
                        <div class="align-items-center justify-content-between card-spacer flex-grow-1">
                            <span class="symbol symbol-50 symbol-light-success  mr-2">
                                <span>
                                    <i class="fas fa-hourglass-end"></i>
                                </span>
                            </span>
                            <span class="text-light Count">{{ en2bn($completed_case) }}</span>
                            <div class="text-left icn-card-label">
                                <span class="text-white mt-2 font-size-h3">নিষ্পত্তিকৃত মামলা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>



    </div>
@endif
