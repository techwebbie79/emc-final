@extends('layouts.landing')

@section('content')
<style>
	.thumb{
		width: 200px;
		height: 200Spx;
	}
</style>
<div class="row">
	<div class="card card-custom col-12">
		<div class="col-lg-4 mb-5 mt-5 ml-15" id="thumb-output">
		    <span class="text-dark flex-root font-weight-bolder font-size-h6">
			       @if($userManagement->profile_pic != NULL)
		              <img src="{{url('/')}}/uploads/profile/{{ $userManagement->profile_pic }}" width="200" height="200">
		           @else
		              <img src="{{url('/')}}/uploads/profile/default.jpg" width="200" height="200">
		           @endif
		    </span>
		</div>

		<form action="{{ route('my-profile.image_update') }}" method="POST" enctype="multipart/form-data">
			@csrf
			<div class="col-lg-4 mb-5 ">
				<fieldset>
					<legend>প্রোফাইল ইমেজ সংযুক্তি<span class="text-danger">*</span></legend>
					   <label  class=" form-control-label"> </label>
					   <div class="form-group">
					       <label></label>
					       <div></div>
					       <div class="custom-file">
					           <input type="file" name="image" class="custom-file-input" id="customFile" />
					           <label class="custom-file-label" for="customFile">ইমেজ নির্বাচন করুন</label>
					       </div>
					   </div>
			   </fieldset>
			</div>
			<div class="card-footer">
			    <div class="row">
			       <div class="col-lg-12 text-center">
			          <button type="submit" class="btn btn-primary font-weight-bold mr-2">সংরক্ষণ করুন</button>
			       </div>
			    </div>
			</div>
		</form>
	</div>
</div>
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
$(document).ready(function(){
        $(':input[type=file]').on('change', function(){ //on file input change

            if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
            {
                $('#thumb-output').html(''); //clear html of output element
                    var data = $(this)[0].files; //this file data

                    $.each(data, function(index, file){ //loop though each file
                        if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                            var fRead = new FileReader(); //new filereader
                            fRead.onload = (function(file){ //trigger function on successful read
                            return function(e) {
                                var img = $('<img/>').addClass('thumb').attr('src', e.target.result); //create image element
                                $('#thumb-output').append(img); //append image to output element
                            };
                            })(file);
                            fRead.readAsDataURL(file); //URL representing the file's data.
                        }
                    });
            }else{
                alert("Your browser doesn't support File API!"); //if File API is absent
            }
        });


    });
</script>

<!--end::Page Scripts-->
@endsection
