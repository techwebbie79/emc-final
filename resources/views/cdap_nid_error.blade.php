@extends('layouts.landing')

@section('style')
@endsection

@section('landing')
   
        <div class="container" style="margin-top: 100px">

            <div class="py-5 text-center">
                <div class="alert alert-danger" role="alert">
                    আপনার এন আই ডি , আপনার MyGov / CDAP Account এ Verify করা নেই , NID Verify করতে নিচের Button এ Click করুন 
                  </div>
                <a class="btn btn-primary" href="{{ $link }}" target="_blank" id="go_to_mygov">Click Here</a>

                <a class="btn btn-primary" href="{{ route('cdap.v2.login')}}"  id="go_to_refresh" style="display:none">Refresh</a>
            </div>

        </div>
        
    

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
         $('#go_to_mygov').on('click',function(){
            //alert();
            $(this).hide();
            $('#go_to_refresh').show();
         })
        });
</script>
@endsection