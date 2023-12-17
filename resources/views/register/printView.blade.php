<html>
    <!-- <title><?=$page_title?></title> -->
<body onload="onload()">
<div class="card card-custom">
   <div class="card-header flex-wrap py-5">
        @if($_GET['printHeading'] != '' && $_GET['date_start'] != '')
            <div class="card-title" style="text-align: center;">
                <h3 class="card-title h2 font-weight-bolder">{{ $_GET['printHeading'] }}</h3>
                <h4 class="card-title h4 font-weight-bolder">{{ en2bn($_GET['date_start']) }} হতে {{ en2bn($_GET['date_end']) }}</h4>
            </div>
        @elseif($_GET['printHeading'] != '' && $_GET['date_start'] == '')
            <div class="card-title" style="text-align: center;">
                <h3 class="card-title h2 font-weight-bolder">{{ $_GET['printHeading'] }}</h3>
            </div>
        @else
            <div class="card-title" style="text-align: center;">
                <h3 class="card-title h2 font-weight-bolder">{{ $page_title }}</h3>
            </div>
        @endif  
      
   </div>
   <div class="card-body overflow-auto">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
         {{ $message }}
      </div>
      @endif

      
      <table border="1" style="border-collapse: collapse;"  class="table table-hover mb-6 font-size-h5">
         <thead class="thead-light font-size-h6">
            <tr>
               @if(isset($req['kromikNo'])) 
               <th class="serialNo" scope="col" width="30"> ক্রমিক নম্বর</th>
               @endif
               @if(isset($req['appealStatus'])) 
               <th class="appealStat" scope="col">আপিল অবস্থা</th>
               @endif
               @if(isset($req['caseNo'])) 
               <th class="caseNum" scope="col">মামলা নম্বর</th>
               @endif
               @if(isset($req['caseDecision'])) 
               <th class="caseResult" scope="col">মামলার সিদ্ধান্ত</th>
               @endif
               @if(isset($req['relatedCourt'])) 
               <th class="courtName" scope="col">সংশ্লিষ্ট আদালত</th>
               @endif
               @if(isset($req['nextHearingDate'])) 
               <th class="nxtSunaniDate" scope="col">পরবর্তী শুনানীর তারিখ</th>
               @endif
               @if(isset($req['nextHearingTime'])) 
               <th class="nxtSunaniTime" scope="col">পরবর্তী শুনানীর সময়</th>
               @endif
               @if(isset($req['appellantName'])) 
               <th class="applicantName" scope="col">আপীলকারীর নাম</th>
               @endif
               @if(isset($req['ruleName'])) 
               <th class="lawName" scope="col"> লঙ্ঘিত আইন ও ধারা</th>
               @endif
            </tr>
         </thead>
         <tbody>
            @foreach ($results as $key => $row)
                <tr>

                    <td scope="row" class="tg-bn serialNo">{{ en2bn($key+1) }}.</td>
                    <td class="appealStat"> {{ appeal_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                    <td class="caseNum">{{ $row->case_no }}</td>
                    <td class="caseResult"> {{ case_dicision_status_bng($row->appeal_status) }}</td> {{-- Helper Function for Bangla Status --}}
                    <td class="courtName">{{ isset($row->court->court_name) ? $row->court->court_name : '-' }} </td>
                    <td class="nxtSunaniDate">
                         {{--  @dd($row->appealCauseList);   --}}
                        @php
                            $hearingDate = null;
                            if($row->is_hearing_required == 1)
                            {
                                $hearingDate=en2bn($row->next_date);
                            }
                        @endphp
                        {{  en2bn($row->next_date) ?? ''}}
                    </td>
                    <td class="nxtSunaniTime">
                        @php
                             $hearingTime = null;
                            if($row->is_hearing_required == 1)
                            {
                                $hearingTime=en2bn($row->next_date_trial_time); 
                            }
                            @endphp
                            {{  $hearingTime }}
                    </td>
                    <td class="applicantName">
                        {{-- @dd($row->appealCitizensJoin); --}}
                        @php
                            $appName = null;
                        @endphp
                        @foreach ($row->appealCitizens as $key => $item)
                            @foreach ($item->citizenType as $i => $it)
                                @if ($it->citizen_type == 'applicant')
                                    @foreach ($item->citizensAppealJoin as $activeCheck)
                                        @if ($activeCheck->active == 1 && $appName == null && $row->id == $activeCheck->appeal_id)
                                            @php
                                                $appName = $item->citizen_name;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        @endforeach
                        {{  $appName ?? '' }}
                    </td>
                    <td class="lawName">@php 
                    
                     
                        if($row->law_section == 1)
                        {
                            echo '100';
                        }
                        elseif ($row->law_section == 2) {
                            echo '107';
                        }
                        elseif ($row->law_section == 3) {
                            echo '108';
                        }
                        elseif ($row->law_section == 4) {
                            echo '109';
                        }
                        elseif ($row->law_section == 5) {
                            echo '110';
                        }
                        elseif ($row->law_section == 6) {
                            echo '144';
                        } 
                        elseif ($row->law_section == 7) {
                            echo '145';
                        }  
                         @endphp</td>

                </tr>
            @endforeach
         </tbody>
      </table>

      
   </div>
</div>
<script type="text/javascript">
    function onload() {
       window.print()
    }
</script>
</body>
</html>

  
