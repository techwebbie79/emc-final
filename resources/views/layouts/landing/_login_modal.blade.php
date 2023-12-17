<div class="modal fade" id="exampleModalLong" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card" tabindex="0">
                    <div class="card-header border-0">
                        <div class="card-title">
                        </div>
                        <div class="card-toolbar">
                            <a href="#" data-dismiss="modal"
                                class="btn btn-icon btn-sm float-right bg-light-info btn-hover-light-info draggable-handle">
                                <i class="ki ki-close"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            <!--begin::Signin-->
                            <div class="login-form">
                                <!--begin::Form-->
                                <form action="javascript:void(0)"  class="form fv-plugins-bootstrap fv-plugins-framework" id="kt_login_singin_form"
                                    action="" novalidate="novalidate">
                                    @csrf
                                    <!--begin::Title-->
                                    <div class="pb-5 pb-lg-15 text-center">
                                        <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">লগইন
                                        </h3>
                                        <div class="text-muted font-weight-bold font-size-h4">এখনও কোন অ্যাকাউন্ট নেই?
                                            <a href="{{ url('/registration') }}" class="text-info font-weight-bolder">সাইনআপ</a>
                                        </div>
                                    </div>
                                    <!--begin::Title-->
                                    <!--begin::Form group-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <label class="font-size-h6 font-weight-bolder text-dark">ইমেইল, ইউজারনেম, এন আই ডি</label>
                                        <input class="form-control h-auto border-info px-5 py-5 is-valid"
                                            placeholder="ইমেইল, ইউজারনেম, এন আই ডি" type="text" name="email" autocomplete="off">
                                        <div class="fv-plugins-message-container"></div>
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Form group-->
                                    <div class="form-group fv-plugins-icon-container has-success">
                                        <div class="d-flex justify-content-between mt-n5">
                                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">পাসওয়ার্ড</label>
                                            <a href="custom/pages/login/login-3/forgot.html"
                                                class="text-info font-size-h6 font-weight-bolder text-hover-info pt-5">
                                            </a>
                                        </div>
                                        <input class="form-control h-auto border-info px-5 py-5 is-valid"
                                            placeholder="পাসওয়ার্ড" type="password" name="password"
                                            autocomplete="off">
                                        <div class="fv-plugins-message-container"></div>
                                        <div class="row">
                                            <div class="col-md-8"></div>
                                            <div class="col-md-4">
                                                <a href="{{ url('/forget/password') }}" type="button" 
                                         value="">{{ __('পাসওয়ার্ড রিসেট') }}</a>
                                            </div>
                                        </div>
                                          
                                    </div>
                                    <!--end::Form group-->
                                    <!--begin::Action-->
                                    <div class="pb-lg-0 pb-5">
                                        <button onclick="labelmk()" id="kt_login_singin_form_submit_button"
                                            class="text-center btn btn-info font-size-h6 px-8 py-4 my-3 mr-3"
                                            wait-class="spinner spinner-right spinner-white pr-15">লগইন</button>
                                    </div>
                                    <!--end::Action-->
                                    <input type="hidden">
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Signin-->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    body {
        padding-right: 0 !important
    }

</style>
<script>

</script>
<script type="text/javascript">
    function labelmk(){
        var _token = $("#kt_login_singin_form input[name='_token']").val();
        var email = $("#kt_login_singin_form input[name='email']").val();
        var password = $("#kt_login_singin_form input[name='password']").val();

        if(email == '' || password == ''){
            toastr.info('Email or password not will be null!', "Error");
            return;
        }
        $.ajax({
            url: "{{ url('') }}/csLogin",
            type: 'POST',
            data: {
                _token: _token,
                email: email,
                password: password,
            },
            success: function(data) {
                console.log(data);
                if ($.isEmptyObject(data.error)) {
                    toastr.success(data.success, "Success");
                    $('#exampleModalLong').modal('toggle');
                    console.log(data.success);
                    setTimeout(function(){
                        // location.reload();
                        $(location).attr('href', "{{ url('') }}/dashboard");
                    }, 1000);
                } else {
                    toastr.error(data.error, "Error");
                    console.log(data.error);
                    
                    // printErrorMsg(data.error);
                }
            }
        });
    }
    $(document).ready(function() {
        $("#kt_login_singin_form_submit_button").click(function(e) {
            return;
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var email = $("input[name='email']").val();
            var password = $("input[name='password']").val();
            $.ajax({
                url: "/register",
                type: 'POST',
                data: {
                    _token: _token,
                    profetion: profetion,
                    name: name,
                    email: email,
                    password: password,
                    agreeCheckboxUser: agreeCheckboxUser
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        alert(data.success);
                        // window.location.replace(data.url);
                    } else {
                        alert('data.error');
                        // printErrorMsg(data.error);
                    }
                }
            });
        });

        function printErrorMsg(msg) {
            // $(".print-error-msg").find("ul").html('');
            $(".error_msg").css('display', 'block');
            $("#first_name_err").append(msg['first_name']);
            $("#last_name_err").append(msg['last_name']);
            $("#email_err").append(msg['email']);
            $("#address_err").append(msg['address']);
            // $.each( msg, function( key, value ) {
            //     $(".print-error-msg").find("ul").append(key+'<li>'+value+'</li>');
            //     if(key=='first_name'){
            //     }
            // });
        }
    });
</script>
