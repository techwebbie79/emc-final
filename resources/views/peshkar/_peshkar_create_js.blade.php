<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var office_name=$('#office_name').val();

    $('#nothi_user_check').on('click', function() {
        $('#nothiCheck').show();
        $('password').attr('readonly', true); 
    })
    $('#general_user_check').on('click', function() {
        $('#nothiCheck').hide();
        $('#username').val('');
        $('#name').val('');
        $('#mobile_no').val('');
        $('#email').val('');
        $('#office_name').val(office_name);
        $('#designation_nothi').val('');
       
        
    })

    // if ($('#general_user_check').is(':checked')) {
    //     $('#nothiCheck').hide();
    // } else {
    //     $('password').attr('readonly', true);
    // }

    function checkPeskarADM() {

        Swal.showLoading();
        $.ajax({
            method: "GET",
            url: "{{ route('peshkar.doptor.check') }}",
            data: {

                nothiID: $('#nothiID').val(),
                _token: '{{ csrf_token() }}'

            },
            success: (result) => {
                if (result.success == 'success') {
                    Swal.close();
                    $('#username').val(result.username);
                    $('#name').val(result.name);
                    $('#mobile_no').val(result.mobile_no);
                    $('#email').val(result.email);
                    if(result.office_name==' ')
                    {
                        
                        $('#office_name').val('');
                    }
                    else
                    {

                        $('#office_name').val(result.office_name);
                    }
                    $('#designation_nothi').val(result.designation_nothi);
                   

                }
                if (result.error == 'error') {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'কোন তথ্য পাওয়া যায় নি!',

                    })
                }
            },
            error: (error) => {
                // console.log(error);

            }
        });


    }

    $('.active').on('click',function(){
        
        if($(this).hasClass('btn-primary'))
        {
              var active=1;
        }
        else
        {
            var active=0;
        }

        Swal.showLoading();
    $.ajax({
        method: "GET",
        url: "{{ route('peshkar.active') }}",
        data: {

            active: active,
            user_id:$(this).data('user'),
            _token: '{{ csrf_token() }}'

        },
        success: (result) => {
            if (result.success == 'success') {
                Swal.close();
                if($(this).hasClass('btn-primary'))
                {
                    $(this).removeClass('btn-primary');
                    $(this).addClass('btn-danger');
                    $(this).text('ইন অ্যাক্টিভ');
                }
                else
                {
                    $(this).addClass('btn-primary');
                    $(this).removeClass('btn-danger');
                    $(this).text('অ্যাক্টিভ');
                }

                if($('.status').hasClass('btn-success'))
                {
                    $('.status').removeClass('btn-success');
                    $('.status').addClass('btn-danger');
                    $('.status').text('ইন অ্যাক্টিভ')
                }
                else
                {
                    $('.status').removeClass('btn-danger');
                    $('.status').addClass('btn-success');
                    $('.status').text('অ্যাক্টিভ');
                }
               

            }
            if (result.error == 'error') {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'কোন তথ্য পাওয়া যায় নি!',

                })
            }
        },
        error: (error) => {
            // console.log(error);

        }
    });
    });
</script>
