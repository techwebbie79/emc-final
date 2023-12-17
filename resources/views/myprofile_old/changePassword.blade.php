@extends('layouts.landing')
@section('content')
<!-- <div class="container"> -->
    <!-- <div class="row justify-content-center"> -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('/my-profile/update-password') }}">
                        @csrf

                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach

                        <div class="form-group ">
                            <label for="password" class="col-md-4 col-form-label text-md-left">বর্তমান পাসওয়ার্ড</label>

                            <div class="col-md-4">
                                <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="password" class="col-md-4 col-form-label text-md-left">নতুন পাসওয়ার্ড</label>

                            <div class="col-md-4">
                                <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="password" class="col-md-4 col-form-label text-md-left">নতুন কনফার্ম পাসওয়ার্ড</label>

                            <div class="col-md-4">
                                <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 mt-10 offset-md-1">
                                <button type="submit" class="btn btn-primary">
                                   পাসওয়ার্ড হালনাগাদ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </div> -->
<!-- </div> -->
@endsection
