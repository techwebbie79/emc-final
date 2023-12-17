<div class="form-group">
    <div class="row">
        <div class="col-md-12">

            <div class="form-group">
                <h4 class="bg-gray-300 card-title h4 py-3 text-center">পেশকার কর্তৃক গৃহীত ব্যবস্থা, {{ en2bn($peshkar_initial_comments['order_date_peskar'] ?? '') }}</h4>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bg-gray-100 rounded-md rounded-right-0">
                                    <div class="p-4 h5">
                                        {!! nl2br($peshkar_initial_comments['peshkar_order'] ?? '') !!}</div>
                                </div>
                            </div>
                        </div>
                        @if(!empty($peshkar_initial_comments['peskar_files']))
                        <div class="row">
                            <fieldset class="col-md-12 border-0 bg-white">
                                @forelse (json_decode($peshkar_initial_comments['peskar_files'],true) as $key => $row)
                                    <div class="form-group mb-2"
                                        id="">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button class="btn bg-success-o-75"
                                                    type="button">{{ en2bn(++$key) . ' - নম্বর :' }}</button>
                                            </div>
                                            <input readonly type="text"
                                                class="form-control-md form-control "
                                                value="{{ $row['file_category'] ?? '' }}" />
                                            <div class="input-group-append">
                                                <a href="{{ asset($row['file_path'] . $row['file_name']) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-success font-size-h5 float-left">
                                                    <i
                                                        class="fa fas fa-file-pdf"></i>
                                                    <b>দেখুন</b>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
                            </fieldset>
                        </div>
                        @endif

                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>