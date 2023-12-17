@extends('layouts.landing')
@section('content')
<!-- <div class="container"> -->
    <!-- <div class="row justify-content-center"> -->
        
        <style>
            #password-strength-status {
                padding: 5px 10px;
                color: #FFFFFF;
                border-radius: 4px;
                margin-top: 5px;
            }

            .medium-password {
                background-color: #b7d60a;
                border: #BBB418 1px solid;
            }

            .weak-password {
                background-color: #ce1d14;
                border: #AA4502 1px solid;
            }

            .strong-password {
                background-color: #12CC1A;
                border: #0FA015 1px solid;
            }

            .waring-border-field {
                border: 2px solid #f5c6cb !important;

            }

            .warning-message-alert {
                color: red;
            }

            .waring-border-field-succes {
                border: 2px solid #c3e6cb !important;

            }
        </style>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('update.new.password') }}">
                        @csrf

                         @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                         @endforeach
                         <div class="row">

                             <div class="col-lg-6 mb-5 form-group">
    
                                <label>পাসওয়ার্ড <span class="text-danger">*</span></label>
                                <div class="input-group" id="show_hide_password_reset_password">
                                    <input type="password"  id="password" name="new_password"  
                                        class="form-control form-control-sm" />
    
                                    <div class="input-group-addon bg-secondary">
                                        <a href=""><i class="fa fa-eye-slash p-5 mt-1"
                                                aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <div id="password-strength-status" class="text-danger"></div>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-5 form-group">
                                <label>কনফার্ম পাসওয়ার্ড <span class="text-danger">*</span></label>

                                <input type="password"  id="confirm_password" name="new_confirm_password"
                                    class="form-control form-control-sm" />
                                <span id='message'></span>
                                @error('confirm_password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                         </div>
                       
                         <div class="row">
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn btn-success mr-2"
                                    onclick="return confirm('আপনি কি সংরক্ষণ করতে চান?')">সংরক্ষণ করুন</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    <!-- </div> -->
<!-- </div> -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
$('#password, #confirm_password').on('keyup', function() {
    if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Matching').css('color', 'green');
    } else
        $('#message').html('Not Matching').css('color', 'red');
});

$("#password").on('keyup', function() {
  
    var number = /([0-9])/;
    var alphabets = /([a-zA-Z])/;
    var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
    if ($('#password').val().length < 6) {
        $('#password-strength-status').removeClass();
        $('#password-strength-status').addClass('weak-password');
        $('#password-strength-status').html("দুর্বল (অন্তত 6টি অক্ষর হতে হবে।)");
        jQuery('#password').removeClass('waring-border-field-succes');
        jQuery('#password').addClass('waring-border-field');
    } else {
        if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $(
                '#password').val().match(special_characters)) {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('strong-password');
            $('#password-strength-status').html("শক্তিশালী");
            jQuery('#password').removeClass('waring-border-field');
            jQuery('#password').addClass('waring-border-field-succes');
        } else {
            $('#password-strength-status').removeClass();
            $('#password-strength-status').addClass('medium-password');
            $('#password-strength-status').html(
                "মাঝারি (বর্ণমালা, সংখ্যা এবং বিশেষ অক্ষর বা কিছু সংমিশ্রণ অন্তর্ভুক্ত করা উচিত।)"
            );
            jQuery('#password').removeClass('waring-border-field');
            jQuery('#password').addClass('waring-border-field-succes');
        }
    }
});

$("#show_hide_password_reset_password a").on('click', function(event) {
event.preventDefault();
if ($('#show_hide_password_reset_password input').attr("type") == "text") {
    $('#show_hide_password_reset_password input').attr('type', 'password');
    $('#show_hide_password_reset_password i').addClass("fa-eye-slash");
    $('#show_hide_password_reset_password i').removeClass("fa-eye");
} else if ($('#show_hide_password_reset_password input').attr("type") == "password") {
    $('#show_hide_password_reset_password input').attr('type', 'text');
    $('#show_hide_password_reset_password i').removeClass("fa-eye-slash");
    $('#show_hide_password_reset_password i').addClass("fa-eye");
}
});
</script>

@endsection
