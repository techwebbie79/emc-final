<p>{{$day}} {{$month_name}}, {{$year}}</p>
জনাব, <strong>{{ $name_of_receiver }}</strong>,
<p>{{$body}}</p>

@if(!empty($shortorderTemplateUrl))
@foreach($shortorderTemplateUrl as $key=>$value)
<a href="{{ $value }}" target="_blank">{{ $shortorderTemplateName[$key] }} আদেশের নথি দেখুন </a>
<br> 
@endforeach
@endif

<p>প্রেরক ,</p>
<p>{{ $user_name }}</p>
<p>{{ $user_designation }}, {{ $court_name }}, {{ $district_name_bn }}</p>
<p><a href="{{ url('/') }}">স্মার্ট এক্সিকিউটিভ ম্যাজিস্ট্রেট কোর্ট </a></p>
