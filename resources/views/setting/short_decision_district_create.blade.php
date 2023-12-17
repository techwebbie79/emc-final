@extends('layouts.landing')

@section('content')

    <style type="text/css">
        #appRowDiv td {
            padding: 5px;
            border-color: #ccc;
        }

        #appRowDiv th {
            padding: 5px;
            text-align: center;
            border-color: #ccc;
            color: black;
        }

    </style>
    <!--begin::Row-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        <!-- <div class="example-tools justify-content-center">
                                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
                                <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
                            </div> -->
                    </div>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger">{{ $error }}</li>
                    @endforeach
                @endif

                <!--begin::Form-->
                <form action="{{ route('setting.crpcsection.save') }}" class="form" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="form-group row">
                            <div class="col-lg-4">
                                <label>সিআরপিসি সেকশন (কোড)</label>
                                <input type="number" name="crpc_id" class="form-control" placeholder="" />
                                <span style="color: red">
                                    {{ $errors->first('crpc_id') }}
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>সিআরপিসি সেকশন (নাম)</label>
                                <input type="text" name="crpc_name" class="form-control" placeholder="" />
                                <span style="color: red">
                                    {{ $errors->first('crpc_name') }}
                                </span>
                            </div>

                            <div class="col-lg-12" style="margin-top:20px;">
                                <label>সিআরপিসি সেকশনের বিস্তারিত</label>
                                <textarea name="crpc_details" class="form-control"></textarea>
                                <span style="color: red">
                                    {{ $errors->first('crpc_details') }}
                                </span>
                            </div>
                        </div>
                        <!--end::Card-body-->

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-7">
                                    {{-- <button type="button" data-toggle="modal" data-target="#myModal"
                                    class="btn btn-primary mr-3" id="preview">প্রিভিউ</button> --}}
                                    <button type="submit" class="btn btn-primary mr-2"
                                        onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                                </div>
                            </div>
                        </div>


                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>

    </div>
    <!--end::Row-->

@endsection
