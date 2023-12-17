@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header flex-wrap py-5">
            <div class="card-title">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('peshkar.short.decision.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
                    <i class="la la-plus"></i>নতুন সংক্ষিপ্ত আদেশ তৈরি
                </a>
            </div>
        </div>
        <div class="card-body">
            <form class="form-inline" method="GET">
                <div class="container">
                   <div class="row">
                      <div class="col-lg-3 mb-5">
                         <input type="text" name="search_short_order_name" class="w-100 form-control common_datepicker" placeholder="সংক্ষিপ্ত আদেশ" autocomplete="off">
                      </div>
                      <div class="col-lg-3 col-lg-2 text-right">
                     </div>
                     <div class="col-lg-3 col-lg-2 text-right">
                    </div>
                      <div class="col-lg-3 col-lg-2 text-right">
                         <button type="submit" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
                      </div>
                   </div>
                </div>
             
             </form>
             
            <table class="table table-hover mb-6 font-size-h6">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" width="30">#</th>
                        <th scope="col">সংক্ষিপ্ত আদেশ</th>
                        <th scope="col" width="150" class="text-center">অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($shortDecision as $key => $row)
                        <tr>
                            <td scope="row" class="tg-bn">{{ en2bn($key + $shortDecision->firstItem()) }}.</td>
                            <td>{{ en2bn($row->case_short_decision) }}</td>
                            <td>
                                <a href="{{ route('peshkar.short.decision.details.create', $row->id) }}"
                                    class="btn btn-primary btn-shadow btn-sm font-weight-bold pt-1 pb-1">টেমপ্লেট
                                </a>
                                <a href="{{ route('peshkar.short.decision.edit', $row->id) }}"
                                    class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন
                                </a>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {!! $shortDecision->links() !!}
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
        <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>
        <!--end::Page Scripts-->
    @endsection
