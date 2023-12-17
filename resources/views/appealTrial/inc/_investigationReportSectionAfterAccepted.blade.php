<div class="card card-custom mb-5 shadow">
    <div class="card-header bg-primary-o-50">
        <div class="card-title">
            <span class="card-icon">
                <span class="svg-icon svg-icon-primary svg-icon-2x">
                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Files\File-done.svg--><svg
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <path
                                d="M3.51471863,18.6568542 L13.4142136,8.75735931 C13.8047379,8.36683502 14.4379028,8.36683502 14.8284271,8.75735931 L16.2426407,10.1715729 C16.633165,10.5620972 16.633165,11.1952621 16.2426407,11.5857864 L6.34314575,21.4852814 C5.95262146,21.8758057 5.31945648,21.8758057 4.92893219,21.4852814 L3.51471863,20.0710678 C3.12419433,19.6805435 3.12419433,19.0473785 3.51471863,18.6568542 Z"
                                fill="#000000" opacity="0.3" />
                            <path
                                d="M9.87867966,6.63603897 L13.4142136,3.10050506 C13.8047379,2.70998077 14.4379028,2.70998077 14.8284271,3.10050506 L21.8994949,10.1715729 C22.2900192,10.5620972 22.2900192,11.1952621 21.8994949,11.5857864 L18.363961,15.1213203 C17.9734367,15.5118446 17.3402718,15.5118446 16.9497475,15.1213203 L9.87867966,8.05025253 C9.48815536,7.65972824 9.48815536,7.02656326 9.87867966,6.63603897 Z"
                                fill="#000000" />
                            <path
                                d="M17.3033009,4.86827202 L18.0104076,4.16116524 C18.2056698,3.96590309 18.5222523,3.96590309 18.7175144,4.16116524 L20.8388348,6.28248558 C21.0340969,6.47774772 21.0340969,6.79433021 20.8388348,6.98959236 L20.131728,7.69669914 C19.9364658,7.89196129 19.6198833,7.89196129 19.4246212,7.69669914 L17.3033009,5.5753788 C17.1080387,5.38011665 17.1080387,5.06353416 17.3033009,4.86827202 Z"
                                fill="#000000" opacity="0.3" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </span>
            <h3 class="card-label">তদন্তের রিপোর্ট গৃহীত 
        </div>
    </div>
    <div class="card-body">
        {{-- @php 
             var_dump($em_investigation_report_after_accepted);
        @endphp --}}
        <table class="table table-hover table-bordered report">
            <thead class="headding">
                <tr>
                    <th class="text-center">নাম</th>
                    <th class="text-center">অফিসের নাম</th>
                   
                    <th class="text-center">তারিখ</th>
                    
                    <th class="text-center">প্রধান সংযুক্তি</th>
                  
                    <th class="text-center">পদক্ষেপ</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($em_investigation_report_after_accepted as $value)
                    <tr>
                        @php
                            $investigation_date = explode('/', $value->investigation_date);
                            $investigation_date_final = $investigation_date[2] . '-' . $investigation_date[0] . '-' . $investigation_date[1];
                        @endphp
                        <th class="text-center">{{ $value->investigator_name }}</th>
                        <th class="text-center">{{ $value->investigator_organization }}</th>
                        <th class="text-center">{{ en2bn($investigation_date_final) }}</th>
                        <th>
                            @php
                                if (!empty($value->investigation_attachment_main)) {
                                    $files = json_decode($value->investigation_attachment_main);
                                    foreach ($files as $file) {
                                        echo '<a href="'.asset($file->file_path . $file->file_name).'" target="_blank" class="btn btn-sm btn-success font-size-h5 float-left mr-3 btn-block">
                          <i class="fa fas fa-file-pdf"></i>
                          <b>' .
                                            $file->file_category .
                                            '</b></a>';
                                    }
                                }
                            @endphp
                        </th>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('investigation.details.single',['id'=>$value->id]) }}"><button class="btn btn-info btn-sm btn-block" type="button">বিস্তারিত </button></a>
                            </div>    
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.min.js"
            integrity="sha512-dnyteqeKASHjUgi20CTeO5cfd1JwMTNV2ZS+tx5rlPCdWgnd6UKYNLM2EarSU9E6J3lMtMhUkcA6g8f3cAjoQQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script>
            function investigation_delete(id) {
                Swal.fire({
                        title: "আপনি মুছে ফেলতে চান ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "হ্যাঁ",
                        cancelButtonText: "না",
                    })
                    .then(function(result) {
                        if (result.value) {
                            KTApp.blockPage({
                                // overlayColor: '#1bc5bd',
                                overlayColor: 'black',
                                opacity: 0.2,
                                // size: 'sm',
                                message: 'Please wait...',
                                state: 'danger' // a bootstrap color
                            });


                            $.ajax({
                                url: '{{ route('investigation.delete') }}',
                                dataType: "json",
                                method: 'get',
                                data: {
                                    id: id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(data) {

                                    if(data.success=='success')
                                    {

                                        Swal.fire({
                                            position: "top-right",
                                            icon: "success",
                                            title: "সফলভাবে মুছে ফেলা হয়েছে!",
                                            showConfirmButton: false,
                                            timer: 1500,
                                        });
                                        KTApp.unblockPage();
                                        location.reload(); 
                                    }
                                    
                                },
                                error: function(xhr, exception) {
                                    var msg = "";
                                    if (xhr.status === 0) {
                                        msg = "Not connect.\n Verify Network." + xhr.responseText;
                                    } else if (xhr.status == 404) {
                                        msg = "Requested page not found. [404]" + xhr.responseText;
                                    } else if (xhr.status == 500) {
                                        msg = "Internal Server Error [500]." + xhr.responseText;
                                    } else if (exception === "parsererror") {
                                        msg = "Requested JSON parse failed.";
                                    } else if (exception === "timeout") {
                                        msg = "Time out error." + xhr.responseText;
                                    } else if (exception === "abort") {
                                        msg = "Ajax request aborted.";
                                    } else {
                                        msg = "Error:" + xhr.status + " " + xhr.responseText;
                                    }
                                    
                                    KTApp.unblockPage();
                                }
                            })
                            
                        }
                    });
            }

            function investigation_approve(id) {
                Swal.fire({
                        title: "আপনি গ্রহণ করতে চান ?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "হ্যাঁ",
                        cancelButtonText: "না",
                    })
                    .then(function(result) {
                        if (result.value) {
                            KTApp.blockPage({
                                // overlayColor: '#1bc5bd',
                                overlayColor: 'black',
                                opacity: 0.2,
                                // size: 'sm',
                                message: 'Please wait...',
                                state: 'danger' // a bootstrap color
                            });


                            $.ajax({
                                url: '{{ route('investigation.approve') }}',
                                dataType: "json",
                                method: 'get',
                                data: {
                                    id: id,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(data) {

                                    if(data.success=='success')
                                    {

                                        Swal.fire({
                                            position: "top-right",
                                            icon: "success",
                                            title: "সফলভাবে গ্রহন করা হয়েছে!",
                                            showConfirmButton: false,
                                            timer: 1500,
                                        });
                                        KTApp.unblockPage();
                                        location.reload(); 
                                    }
                                    
                                },
                                error: function(xhr, exception) {
                                    var msg = "";
                                    if (xhr.status === 0) {
                                        msg = "Not connect.\n Verify Network." + xhr.responseText;
                                    } else if (xhr.status == 404) {
                                        msg = "Requested page not found. [404]" + xhr.responseText;
                                    } else if (xhr.status == 500) {
                                        msg = "Internal Server Error [500]." + xhr.responseText;
                                    } else if (exception === "parsererror") {
                                        msg = "Requested JSON parse failed.";
                                    } else if (exception === "timeout") {
                                        msg = "Time out error." + xhr.responseText;
                                    } else if (exception === "abort") {
                                        msg = "Ajax request aborted.";
                                    } else {
                                        msg = "Error:" + xhr.status + " " + xhr.responseText;
                                    }
                                    
                                    KTApp.unblockPage();
                                }
                            })
                            
                        }
                    });
            }
        </script>



    </div>
</div>
