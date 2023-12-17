<style>
    .custom-img-width-icon-card
    {
        width: 60px !important;
        height: 60px !important;
    }
</style>

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
                @if(in_array(globalUserInfo()->role_id,[36,20]) && globalUserInfo()->is_cdap_user == 1)
                <li>
                    <div id="mygov-sso-widget"></div>
                </li>
                @endif
                @if(!empty(globalUserInfo()->doptor_user_flag) &&  globalUserInfo()->doptor_user_flag == 1)
                <li>
                    <div><?=dorptor_widget()?></div>
                </li>
                @endif
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
                                {{-- <span>
                                   <img src="{{ asset('icons/icons8-law-90.png') }}" class="custom-img-width-icon-card" alt="">
                                </span> --}}
                                <span class="text-light Count ml-5">{{ en2bn($total_case) }}</span>
                            </span>
                            <div class="text-left icn-card-label">
                                <span class="text-white font-size-h3 mx-5 mt-5">মোট মামলা</span>
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
                                    {{-- <span>
                                        <img src="{{ asset('icons/icons8-hourglass-100.png') }}" class="custom-img-width-icon-card" alt="">
                                    </span> --}}
                                </span>
                                <span class="text-light  Count ml-5">{{ en2bn($pending_case) }}</span>
                                <div class="text-left icn-card-label">
                                    <span class="text-white mt-5 font-size-h3 ">গ্রহণের জন্য অপেক্ষমাণ </span>
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
                                {{-- <span>
                                    <img src="{{ asset('icons/icons8-processing-64.png') }}" class="custom-img-width-icon-card" alt="">
                                </span> --}}
                            </span>
                            <span class="text-light  Count ml-5">{{ en2bn($running_case) }}</span>
                            <div class="text-left icn-card-label">
                                <span class="text-white mt-5 font-size-h3" >চলমান মামলা</span>
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
                                {{-- <span>
                                    <img src="{{ asset('icons/icons8-task-completed-100.png') }}"  class="custom-img-width-icon-card" alt="">
                                </span> --}}
                            </span>
                            <span class="text-light Count ml-5">{{ en2bn($completed_case) }}</span>
                            <div class="text-left icn-card-label">
                                <span class="text-white mt-5 font-size-h3">নিষ্পত্তিকৃত মামলা</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    @if(globalUserInfo()->role_id == 27)
    <div class="row mb-5">
        <div class="col-xl-8">
            @if ($total_case_running_case_by_em > 0)
                <div class="">
                     <a href="{{ route('appeal.case_by_em') }}">
                        <div class="toast-header py-3">
                            <i class="text-primary icon fas fas fa-bell m"></i>
                            <strong class="ml-2 mr-auto">আপনার পরিচালিত মামলাসমূহ</strong>
                            <span class="badge badge-danger">{{ en2bn($total_case_running_case_by_em) ?? '' }}</span>
                        </div>    
                    </a>   
                </div>
            @else
                <div class="toast-body bg-light">আপনার পরিচালিত মামলাসমূহ মামলা পাওয়া যায়নি</div>
            @endif
        </div>
    </div>
    @endif
@endif
