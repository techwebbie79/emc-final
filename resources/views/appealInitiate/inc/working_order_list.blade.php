<div class="card card-custom mb-5 shadow">
                            <div class="card-header bg-primary-o-50">
                                <div class="card-title">
                                    <span class="card-icon">
                                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path
                                                        d="M8,7 C7.44771525,7 7,6.55228475 7,6 C7,5.44771525 7.44771525,5 8,5 L16,5 C18.209139,5 20,6.790861 20,9 C20,11.209139 18.209139,13 16,13 L8,13 C6.8954305,13 6,13.8954305 6,15 C6,16.1045695 6.8954305,17 8,17 L17,17 C17.5522847,17 18,17.4477153 18,18 C18,18.5522847 17.5522847,19 17,19 L8,19 C5.790861,19 4,17.209139 4,15 C4,12.790861 5.790861,11 8,11 L16,11 C17.1045695,11 18,10.1045695 18,9 C18,7.8954305 17.1045695,7 16,7 L8,7 Z"
                                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                    <path
                                                        d="M9.79289322,3.79289322 C10.1834175,3.40236893 10.8165825,3.40236893 11.2071068,3.79289322 C11.5976311,4.18341751 11.5976311,4.81658249 11.2071068,5.20710678 L8.20710678,8.20710678 C7.81658249,8.59763107 7.18341751,8.59763107 6.79289322,8.20710678 L3.79289322,5.20710678 C3.40236893,4.81658249 3.40236893,4.18341751 3.79289322,3.79289322 C4.18341751,3.40236893 4.81658249,3.40236893 5.20710678,3.79289322 L7.5,6.08578644 L9.79289322,3.79289322 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(7.500000, 6.000000) rotate(-270.000000) translate(-7.500000, -6.000000) " />
                                                    <path
                                                        d="M18.7928932,15.7928932 C19.1834175,15.4023689 19.8165825,15.4023689 20.2071068,15.7928932 C20.5976311,16.1834175 20.5976311,16.8165825 20.2071068,17.2071068 L17.2071068,20.2071068 C16.8165825,20.5976311 16.1834175,20.5976311 15.7928932,20.2071068 L12.7928932,17.2071068 C12.4023689,16.8165825 12.4023689,16.1834175 12.7928932,15.7928932 C13.1834175,15.4023689 13.8165825,15.4023689 14.2071068,15.7928932 L16.5,18.0857864 L18.7928932,15.7928932 Z"
                                                        fill="#000000" fill-rule="nonzero"
                                                        transform="translate(16.500000, 18.000000) scale(1, -1) rotate(270.000000) translate(-16.500000, -18.000000) " />
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                    <h3 class="card-label">কার্যক্রম
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="panel panel-info">
                                    @include('appealInitiate.inc.em_last_order')
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                               <div class="form-group">
                                                <label for="form-label">সংক্ষিপ্ত আদেশের উপর গৃহীত ব্যবস্থা খুঁজুন</label>
                                                <input type="text" id="search_short_order_important" class="form-control" >          
                                            </div> 
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group"><label>সংক্ষিপ্ত আদেশের উপর গৃহীত ব্যবস্থা</label>
                                                    <div class="form-control form-control-md"
                                                        style="height: 253px; overflow-y: scroll;">
                                                        @forelse ($shortOrderList as $row)
                                                            @php
                                                                $checked = '';
                                                                if (count($notApprovedShortOrderCauseList) > 0) {
                                                                    foreach ($notApprovedShortOrderCauseList as $key => $value) {
                                                                        // dd($notApprovedShortOrderCauseList);
                                                                        if ($value->case_shortdecision_id == $row->id) {
                                                                            $checked = 'checked';
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <label class="radio radio-outline radio-primary mb-3 radio_id_{{ $row->id ?? '' }}">
                                                                <input value="{{ $row->id ?? '' }}" type="radio"
                                                                    class="shortOrderCheckBox" onchange="updateNote(this)"
                                                                    name="shortOrder[]"
                                                                    id="shortOrder_{{ $row->id ?? '' }}"
                                                                    desc="{{ $row->delails ?? '' }}"
                                                                    sms="{{ $row->sms_templet ?? '' }}"
                                                                    {{ $checked }}>
                                                                <!-- <input value="{{ $row->sms_templet ?? '' }}" type="hidden"
                                                                        class="shortOrderCheckBox" onchange="updateNote(this)"
                                                                        name="sms_templet[]"
                                                                        id="shortOrder_{{ $row->id ?? '' }}"
                                                                        desc="{{ $row->delails ?? '' }}"
                                                                        {{ $checked }}> -->
                                                                <span class="mr-2 case_short_decision_data" data-string="{{ $row->case_short_decision ?? '' }}" data-row_id_index="{{ $row->id ?? '' }}"></span>
                                                                {{ $row->case_short_decision ?? '' }}
                                                            </label>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-group"><label for="note">আদেশের উপর গৃহীত ব্যবস্থা</label>

                                                    <textarea id="note" name="note" rows="10" class="form-control">{{ $appeal->initial_note }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <fieldset class="col-md-12 border-0  bg-success-o-50">
                                            <div class="row">
                                                
                                                <div class="col-md-12" id="nextDatePublish" style="display: block;">
                                                    <div class="row form-group">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>মন্তব্যের তারিখ</label>
                                                                <input readonly type="text" name="conductDate"
                                                                    id="conductDate"
                                                                    value="{{ date('d-m-Y', strtotime(now())) ?? '' }}"
                                                                    class="form-control form-control-md"
                                                                    placeholder="দিন/মাস/তারিখ" autocomplete="off" readonly>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>