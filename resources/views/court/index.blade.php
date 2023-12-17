@php
   $roleID = Auth::user()->role_id;
   $officeInfo = user_office_info();


if(isset($_GET['division']))
{
    $selected_division=$_GET['division'];
}
else {
    $selected_division=' ';
}
if(isset($_GET['district']))
{
    $selected_district=$_GET['district'];
}
else {
    $selected_district=' ';
}


@endphp

@extends('layouts.landing')

@section('content')

@if( request()->get('district') )
           <script>
           var disID = {{ request()->get('district') }};
         </script>
         @else
         <script>
            var disID = 0;
          </script>
        @endif
        @if( request()->get('upazila') )
        <script>var upID = {{  request()->get('upazila')}};</script>
        @else
        <script>
            var upID = 0;
        </script>
       @endif
       
<!--begin::Card-->
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
      <div class="card-title">
         <h3 class="card-title h2 font-weight-bolder">{{ $page_title }} </h3>
      </div>
      <div class="card-toolbar">
         <a href="{{ route('court.create') }}" class="btn btn-sm btn-primary font-weight-bolder">
            <i class="la la-plus"></i>নতুন আদালত এন্ট্রি
         </a>
      </div>
   </div>
   <div class="card-body">
      {{-- @if ($message = Session::get('success'))
      <div class="alert alert-success">
         <p>{{ $message }}</p>
      </div>
      @endif --}}
      @if($roleID == 1 || $roleID == 2 || $roleID == 3 || $roleID == 4)
         @include('court.search')
      @endif
      <table class="table table-hover mb-6 font-size-h6">
         <thead class="thead-light">
            <tr>
               <th scope="col" width="30">#</th>
               <th scope="col">আদালতের নাম</th>
               <th scope="col">বিভাগের নাম</th>
               <th scope="col">জেলার নাম</th>
               <th scope="col">স্ট্যাটাস</th>
               <th scope="col">অ্যাকশন</th>
            </tr>
         </thead>
         <tbody>
            @foreach ($courts as $row)
            <?php
              if($row->status == 1){
                  $courtStatus = '<span class="label label-inline label-light-primary font-weight-bold">এনাবল</span>';
               }else{
                  $courtStatus = '<span class="label label-inline label-light-primary font-weight-bold">ডিসএবল</span>';
               }
            ?>
            <tr>
               <th scope="row" class="tg-bn">{{ en2bn(++$i) }}</th>
               <td>{{ $row->court_name }}</td>
               <td>{{ $row->division_name_bn }}</td>
               <td>{{ $row->district_name_bn }}</td>
               <td><?=$courtStatus?></td>
               <td>
                  <a href="{{ route('court.edit', $row->id) }}" class="btn btn-success btn-shadow btn-sm font-weight-bold pt-1 pb-1">সংশোধন</a>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      {!! $courts->links() !!}
   </div>
</div>
<!--end::Card-->

@endsection

{{-- Includable CSS Related Page --}}
@section('styles')
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<!--end::Page Vendors Styles-->
@endsection

{{-- Scripts Section Related Page--}}
@section('scripts')
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('js/pages/crud/datatables/advanced/multiple-controls.js') }}"></script>



<script type="text/javascript">
      jQuery(document).ready(function ()
      {
         // District Dropdown
         jQuery('select[name="division"]').on('change',function(){
            var dataID = jQuery(this).val();
            // var category_id = jQuery('#category_id option:selected').val();
            jQuery("#district_id").after('<div class="loadersmall"></div>');
            // $("#loading").html("<img src='{{ asset('media/preload.gif') }}' />");
            // jQuery('select[name="mouja"]').html('<option><div class="loadersmall"></div></option');
            // jQuery('select[name="mouja"]').attr('disabled', 'disabled');
            // jQuery('.loadersmall').remove();
            if(dataID)
            {
               jQuery.ajax({
                  url : '/court-setting/dropdownlist/getdependentdistrict/' +dataID,
                  type : "GET",
                  dataType : "json",
                  success:function(data)
                  {
                     jQuery('select[name="district"]').html('<div class="loadersmall"></div>');
                     //console.log(data);
                     // jQuery('#mouja_id').removeAttr('disabled');
                     // jQuery('#mouja_id option').remove();

                     jQuery('select[name="district"]').html('<option value="">-- নির্বাচন করুন --</option>');
                     jQuery.each(data, function(key,value){
                        jQuery('select[name="district"]').append('<option value="'+ key +'">'+ value +'</option>');
                     });
                     jQuery('.loadersmall').remove();
                     // $('select[name="mouja"] .overlay').remove();
                     // $("#loading").hide();
                  }
               });
            }
            else
            {
               $('select[name="district"]').empty();
            }
         });
         // upazila Dropdown
      
         var divID = $('#division_id').find(":selected").val();

         if (divID !=' ') {
                    jQuery.ajax({
                        url: '/court-setting/dropdownlist/getdependentdistrict/' +
                            divID,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            jQuery('select[name="district"]').html(
                                '<div class="loadersmall"></div>');

                            jQuery('select[name="district"]').html(
                                '<option value="">-- জেলা নির্বাচন করুন --</option>');
                            jQuery.each(data, function(key, value) {
                                if (disID == key) {
                                    var selected = 'selected';
                                } else {
                                    var selected = ' ';
                                }
                                jQuery('select[name="district"]').append(
                                    '<option value="' + key +
                                    '"' + selected + '>' + value + '</option>');
                            });
                            jQuery('.loadersmall').remove();
                        }
                    });
                } else {
                    $('select[name="district"]').empty();
                }



      });


      

</script>
<!--end::Page Scripts-->
@endsection


