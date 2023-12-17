@extends('layouts.landing')

@section('content')
    <!--begin::Card-->
    <div class="card py-5">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label text-center">
                    রোল পারমিশন নির্বাচন করুন
                </h3>
            </div>
        </div>
        <div class="alert alert-danger" role="alert" id="role_permission_select_alert">
            অনুগ্রহ করে রোল নির্বাচন করুন
        </div>
        <div class="p-5">

            <form action="" id="role_permisssion_form">
                @csrf
    
                <div class="form-group mb-2 mr-2">
                    <select name="role_id" class="form-control" id="role_id">
                        <option value="0">-রোল নির্বাচন করুন-</option>
                        @foreach ($role as $roles)
                            <option value="{{ $roles->id }}">{{ $roles->role_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="perssion_list">
                    <table class="table table-hover mb-6 font-size-h6">
                        <thead class="thead-light">
                            <tr>
                                <!-- <th scope="col" width="30">#</th> -->
                                <th scope="col" class="text-center" width="10%">
                                    সিলেক্ট করুণ
                                </th>
                                <th scope="col" class="text-center"> নাম</th>
                                <!-- <th scope="col" class="text-center">permission details</th> -->
                            </tr>
                        </thead>
                        <tbody style="text-align: center;" class="text-center">
    
    
                            @foreach ($permission as $permissions)
                                <?php
                                ?>
                                <tr>
                                    <td>
                                        <div class="checkbox-inline">
                                            <label class="checkbox">
                                                <input type="checkbox" name="role_permisson[]"
                                                    value="{{ $permissions->id }}" class="role_permission_check" /><span></span>
                                        </div>
                                    </td>
                                    <td>{{ $permissions->name }}</td>
                                    <!-- <td>{{ $permissions->details }}</td> -->
    
                                </tr>
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
    
                    <button type="submit" class="btn btn-primary">নিশ্চিত করুন</button>
                </div>
            </form>
        </div>
    </div>

    <!--end::Card-->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#role_permission_select_alert').hide();


        $('#role_id').on('change', function() {

            swal.showLoading();
            $('.perssion_list').empty();

            var formdata = new FormData();

            $.ajax({
                url: '{{ route('role-permission.show_permission') }}',
                method: 'post',
                data: {
                    id: $('#role_id :selected').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.close();
                        $('.perssion_list').html(response.html);

                    }
                }
            });
        })





        $("#role_permisssion_form").on('submit', function(event) {
            event.preventDefault();
            var permission = true;
            if ($('#role_id :selected').val() == 0) {
                permission = false;
                $('#role_permission_select_alert').show();
            }

            if (permission) {

                $('#role_permission_select_alert').hide();

                const fd = new FormData(this);

                // confirm the court //


                $.ajax({
                    url: '{{ route('role-permission.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {

                            Swal.fire(
                                'সফলভাবে সাবমিট করা হয়েছে',
                                
                            )
                        }
                    }
                });
            }

        })
    </script>
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
