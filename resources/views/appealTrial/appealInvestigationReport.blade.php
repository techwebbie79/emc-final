@extends('layouts.landing')

@section('content')
    <!--begin::Row-->
    <div class="row">

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
                    <div class="card-toolbar">
                        @include('appealTrial.inc._send_section')
                    </div>
                </div>

                <!-- <div class="loadersmall"></div> -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                        @include('appealTrial.inc._caseDetails')
                         <fieldset class="mb-8 p-7" style="background: none;" id="legalReportSection">
                            @include('appealTrial.inc._legalReportSection')
                        </fieldset>

                <!--begin::Form-->
            </div>
        </div>
        @include('appealTrial.inc.__modal')
        @include('appealTrial.inc.__orderPreview')
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    @include('appealTrial.inc._script')
@endsection
