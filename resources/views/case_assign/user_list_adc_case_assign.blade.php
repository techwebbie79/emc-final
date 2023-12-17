@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    @section('content')
    <!--begin::Card-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <div class="card">

        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h2> {{ $page_title }}</h2>
            </div>
        </div>


        <div class="card-body">


            @php
                
                if (isset($_GET['search_key'])) {
                    $case_no = $_GET['search_key'];
                } else {
                    $case_no = null;
                }
            @endphp
            
            <form class="form-inline" method="GET" action="{{ route('doptor.user.management.user_list.segmented.all.pick.adm.search',['office_id'=>encrypt($office_id)]) }}">
                <div class="container mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control " name="search_key" placeholder="নাম, নথি আইডি, পদবী"
                                value="{{ $case_no }}" required>
                        </div>
                        <div class="col-md-2 mt-1">
                            <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান
                                করুন</button>
                        </div>
                    </div>
                </div>
            </form>



            <input type="hidden" name="" id="office_id_hidden" value="{{ $office_id }}">
            <table class="table table-striped table-hover" id="example" width="100%">
                <thead>

                    <tr>
                        <td>ক্রম</td>
                        <td>নাম</td>
                        <td>পদবী</td>
                        <td>পদবী ইংরেজি</td>
                        <td>রোল</td>
                        <td>মামলা প্রদান করুন</td>
                        <td>স্ট্যাটাস</td>
                    </tr>
                </thead>
                <tbody>
                  
                    @php $increment=1; @endphp
                    @foreach ($list_of_ADC as $value)
                          @php
                                $is_em = false;
                                $is_peshkar_adm_dm=false;
                                $is_dm=false;
                                $is_adm= false;
                                $is_peshkar_em=false;
                                if ($value['role_id'] == 39) {
                                    $is_peshkar_adm_dm = true;
                                }
                                elseif ($value['role_id'] == 27) {
                                    $is_em=true;
                                }
                                elseif ($value['role_id'] == 37) {
                                    $is_dm=true;
                                }
                                elseif ($value['role_id'] == 38) {
                                    $is_adm=true;
                                }
                                elseif ($value['role_id'] == 28) {
                                    $is_peshkar_em=true;
                                }
                            @endphp
                        <tr>
                            <input type="hidden" name="" id="office_name_bn_{{ $increment }}"
                                value="{{ $value['office_name_bn'] }}">
                            <input type="hidden" name="" id="office_name_en_{{ $increment }}"
                                value="{{ $value['office_name_en'] }}">
                            <input type="hidden" name="" id="unit_name_bn_{{ $increment }}"
                                value="{{ $value['unit_name_bn'] }}">
                            <input type="hidden" name="" id="unit_name_en_{{ $increment }}"
                                value="{{ $value['unit_name_en'] }}">
                            <input type="hidden" name="" id="designation_bng_{{ $increment }}"
                                value="{{ $value['designation_bng'] }}">
                            <input type="hidden" name="" id="office_id_{{ $increment }}"
                                value="{{ $value['office_id'] }}">
                            <input type="hidden" name="" id="username_{{ $increment }}"
                                value="{{ $value['username'] }}">
                            <input type="hidden" name="" id="employee_name_bng_{{ $increment }}"
                                value="{{ $value['employee_name_bng'] }}">

                            <td>{{ $increment }}</td>

                            <td><input type="text" class="form-control" value="{{ $value['employee_name_bng'] }}"
                                    readonly>
                            </td>
                            <td><input type="text" class="form-control" value="{{ $value['designation_bng'] }}"
                                    readonly>
                            </td>
                            <td><input type="text" class="form-control" value="{{ $value['designation_eng'] }}"
                                    readonly>
                            </td>
                             <td>

                                @if ($is_peshkar_adm_dm)
                                 <input type="text" class="form-control" value=" পেশকার (এ ডি এম)" readonly>
                                @elseif($is_em)
                                <input type="text" class="form-control" value="এক্সিকিউটিভ ম্যাজিস্ট্রেট" readonly>
                                @elseif($is_dm)
                                <input type="text" class="form-control" value="জেলা ম্যাজিস্ট্রেট" readonly>
                                            
                                @elseif($is_adm)
                                    <input type="text" class="form-control" value="অতিরিক্ত জেলা ম্যাজিস্ট্রেট" readonly>
                                @elseif($is_peshkar_em)
                                    <input type="text" class="form-control" value="পেশকার (ইএম)" readonly>            
                                                
                                @else
                                        <input type="hidden" class="form-control" value="7"
                                            id="role_id_{{ $increment }}">

                                        <input type="text" class="form-control" value="অতিরিক্ত জেলা প্রশাসক (এডিসি)" readonly>
                                @endif
                             </td>
                             <td>
                                @php
                                        if ($is_peshkar_adm_dm) {
                                            $disabled='disabled';
                                        }elseif($is_em)
                                        {
                                            $disabled='disabled';
                                        }
                                        elseif ($is_dm) {
                                            $disabled='disabled';
                                        }
                                        elseif ($is_peshkar_em) {
                                            $disabled='disabled';
                                        }
                                        elseif ($is_adm) {
                                            $disabled='disabled';
                                        }
                                        else {
                                            $disabled=' ';
                                        }
                                    @endphp
                                <select name="court_select" class="court_select form-control form-control-sm"
                                    class="form-control form-control-sm" id="{{ $increment }}">

                                    <option value="0" {{ $disabled }}>কোন মামলা দেওয়া হয় নাই</option>

                                    @if ($disabled == 'disabled')
                                    @foreach ($courtlist_distrcit_all as $available_court_single)
                                        @php
                                            $selected=' ';
                                            if ($available_court_single->id == $value['court_id']) {
                                                $selected='selected';
                                            }
                                        @endphp
                                        <option value="{{ $available_court_single->id }}" {{ $selected }}
                                            {{ $disabled }}>
                                            {{ $available_court_single->court_name }}</option>
                                    @endforeach
                                @else
                    
                                    @foreach ($case_details as $case_detail_single)
                                        @php
                                            $selected=' ';
                                            if ($case_detail_single->id == $value['appeal_id']) {
                                                $selected='selected';
                                            }
                                        @endphp
                                        <option value="{{ $case_detail_single->id }}" {{ $selected }}
                                            {{ $disabled }} class="real_appeal_id_where_assign">
                                            {{ $case_detail_single->case_no }}</option>
                                    @endforeach
                                @endif
                                </select>
                            </td>
                            <td>
                                @php 
                                $court_ids=[]; 
                                $assinged_cases=[];
                                @endphp
                                    @foreach ($courtlist_distrcit_all as $available_court_single)
                                        @php  array_push($court_ids,$available_court_single->id); @endphp
                                    @endforeach
                                     
                                     @foreach($all_assigned_cases as $assigned_case_single)

                                     @php  
                                     
                                     if($assigned_case_single->username == $value['username'])
                                     {

                                         array_push($assinged_cases,$assigned_case_single->case_no); 
                                     }
                                     $case_name_showing='উক্ত মামালা গুলতে জনাব বরাদ্দ আছেন '.implode(', ',$assinged_cases);
                                     
                                     @endphp

                                     @endforeach

                                    @if (in_array($value['court_id'], $court_ids))
                                        @php
                                            $court_name_showing='';
                                            foreach ($courtlist_distrcit_all as $available_court_single) {
                                                if ($available_court_single->id == $value['court_id']) {
                                                    $court_name_showing = $available_court_single->court_name;
                                                }
                                            }
                                        @endphp
                                        <button class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $court_name_showing }}
                                            এনাবেল</button>
                                            
                                    @elseif(!empty($assinged_cases))
                                        
                                    <button class="btn-sm btn btn-primary court_name_{{ $increment }}">{{ $case_name_showing }}
                                        এনাবেল</button>
                                    
                                    @else
                                        <button class="btn-sm btn btn-danger court_name_{{ $increment }}">কোন আদালত /মামলা 
                                            দেয়া হয় নাই ডিজেবেল</button>
                                    @endif

                            </td>
                        </tr>
                        @php $increment++; @endphp
                    @endforeach

                </tbody>
            </table>

            <div>
            </div>
        </div>
    </div>
    <!--end::Card-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

        $('.court_select').on('change',function(){


            const id=$(this).attr('id');
            

            swal.showLoading();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('doptor.user.management.store.adc.appeal_id') }}',
                method: 'post',
                data: {
                    office_name_bn:$('#'+'office_name_bn_'+id).val(),
                    office_name_en:$('#'+'office_name_en_'+id).val(),
                    unit_name_bn:$('#'+'unit_name_bn_'+id).val(),
                    unit_name_en:$('#'+'unit_name_en_'+id).val(),
                    designation_bng:$('#'+'designation_bng_'+id).val(),
                    office_id:$('#'+'office_id_'+id).val(),
                    username:$('#'+'username_'+id).val(),
                    employee_name_bng:$('#'+'employee_name_bng_'+id).val(),
                    appeal_id: $(this).find('option:selected').val(),
                    real_appeal_id_where_assign : $('.real_appeal_id_where_assign').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                   Swal.close();
                    if (response.success == 'error') {
                        Swal.fire({
                            icon: 'error',
                            text: response.message,
                            
                            })
                    }
                    else if(response.success == 'success')
                    {
                        
                        Swal.fire({
                            icon: 'success',
                            text: response.message,
                            
                            })
                            location.reload(); 
                            // if(response.case_no=='No_court')
                            // {
                            //     $('.court_name_'+id).html('কোন আদালত / মামালা দেয়া হয় নাই ডিজেবেল');
                            //     $('.court_name_'+id).removeClass('btn-primary');
                            //     $('.court_name_'+id).addClass('btn-danger');
                            // }
                            // else
                            // {
                            //     let texthtml= response.case_no+' এনাবেল';
                            //     $('.court_name_'+id).html(texthtml);
                            //     $('.court_name_'+id).removeClass('btn-danger');
                            //     $('.court_name_'+id).addClass('btn-primary');
                            // }
                    }
                }
            });

        });
    </script> 

  
@endsection
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

    <script>
        $(document).ready(function() {



            var myTable = $('#example').DataTable({
                ordering: false,
                searching: false,
                dom: '<"top"i>rt<"bottom"flp><"clear">',

            });

        });
    </script>

@endsection