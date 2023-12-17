<?php
$roleID = Auth::user()->role_id;
$officeInfo = user_office_info();
?>
<!-- <form class="form-inline" method="GET"> -->

      
   <div class="container p-0">
      <div class="row">
         <div class="col-lg-4 mb-5">
            <input type="text" name="date_start"  class="w-100 form-control common_datepicker" placeholder="তারিখ হতে" autocomplete="off" value="{{ isset($_GET['date_start']) ? $_GET['date_start'] : '' }}"> 
         </div>
         <div class="col-lg-4 mb-5">
            <input type="text" name="date_end" class="w-100 form-control common_datepicker" placeholder="তারিখ পর্যন্ত" autocomplete="off" value="{{ isset($_GET['date_end']) ? $_GET['date_end'] : ''}}">
         </div>
         <div class="col-lg-4">
               <input type="text" class="form-control w-100" name="case_no" placeholder="মামলা নং" value="{{ isset($_GET['case_no']) ? $_GET['case_no'] : ''}}">
         </div>
         
      </div>
  
      <div class="row">
         <div class="col-lg-4 mb-5">
            @php
            if(empty($_GET['caseStatus']))
            {
               $selected='';
            }elseif( $_GET['caseStatus']=='ON_TRIAL')
            {
               $selected='selected';
            }elseif($_GET['caseStatus']=='CLOSED')
            {
               $selected='selected';
            }
            
            
            @endphp
                <select name="caseStatus" class="form-control w-100">
                   
                  <option {{ isset($_GET['caseStatus']) ? 'selected' : ''}} value="">--মামলার অবস্থা নির্বাচন করুন--</option>

                  @if(!empty($_GET['caseStatus']) && $_GET['caseStatus'] == "ON_TRIAL")
                  <option selected value="ON_TRIAL">চলমান মামলা</option>
                  @else
                  <option  value="ON_TRIAL">চলমান মামলা</option>
                  @endif

                  @if(!empty($_GET['caseStatus']) && $_GET['caseStatus'] == "CLOSED")
                  <option selected  value="CLOSED" >নিষ্পত্তিকৃত মামলা</option>
                  @else
                  <option  value="CLOSED" >নিষ্পত্তিকৃত মামলা</option>
                  @endif

                  
                  
                 
               </select>
         </div>
         <div class="col-lg-4 mb-5">
                <input type="text" class="form-control w-100" name="printHeading" placeholder="শিরোনাম (কেবল প্রিন্টের জন্য)" value="{{ isset($_GET['printHeading']) ? $_GET['printHeading'] : ''}}">
         </div>
         <div class="col-lg-12 col-lg-2 text-right my-4">
            <button type="button" onclick="formSubmit()" class="btn btn-success font-weight-bolder mb-2 ml-2">অনুসন্ধান করুন</button>
         </div>
      </div>   
   </div>

<!-- </form> -->

@section('scripts')
<script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<script>
   // common datepicker
   $('.common_datepicker').datepicker({
      format: "dd/mm/yyyy",
      todayHighlight: true,
      orientation: "bottom left"
   });
</script>

   
@endsection
