
<style>
    .social:hover {
        -webkit-transform: scale(1.1);
        -moz-transform: scale(1.1);
        -o-transform: scale(1.1);
    }
    .social {
        -webkit-transform: scale(0.8);
        /* Browser Variations: */

        -moz-transform: scale(0.8);
        -o-transform: scale(0.8);
        -webkit-transition-duration: 0.5s;
        -moz-transition-duration: 0.5s;
        -o-transition-duration: 0.5s;
    }

    /*
        Multicoloured Hover Variations
    */

    #social-fb:hover {
        color: #3B5998;
    }
    #social-tw:hover {
        color: #4099FF;
    }
    #social-gp:hover {
        color: #d34836;
    }
    #social-em:hover {
        color: #f39c12;
    }
</style>
<section class="container">
<div class="row">
    <div class="col-md-3 mt-5">
        <h4>গুরুত্বপূর্ণ তথ্য</h4>
        <ul class="fa-ul text-left">
            <li><a href="javascript:featureComingSoon();">ব্যবহারের শর্তাবলি</a></li>
            <li><a data-toggle="modal" href="#modalOverallCollaborators">সার্বিক সহযোগিতায়</a></li>
            <li><a data-toggle="modal" href="#modalContactInformation">যোগাযোগ</a></li>
        </ul>
    </div>
    <div class="col-md-3 mt-5">
        <h4>গুরুত্বপূর্ণ লিঙ্ক</h4>
        <ul class="fa-ul text-left">
            <li><a href="http://bangladesh.gov.bd/" target="_blank">জাতীয় তথ্য বাতায়ন</a></li>
            <li><a href="http://www.cabinet.gov.bd/" target="_blank">মন্ত্রিপরিষদ বিভাগ</a></li>
            <li><a href="http://a2i.pmo.gov.bd/" target="_blank">এটুআই</a></li>
        </ul>
    </div>
    <div class="col-md-3 mt-5">
        <h4>সামাজিক যোগাযোগ</h4>
        
        <a href="#"><i id="social-fb" class="fa fa-facebook-square fa-3x social"></i></a>
        <a href="#"><i id="social-tw" class="fa fa-twitter-square fa-3x social"></i></a>
        <a href="#"><i id="social-gp" class="fa fa-google-plus-square fa-3x social"></i></a>
        <a href="#"><i id="social-em" class="fa fa-envelope-square fa-3x social"></i></a>
    </div>
    <div class="col-md-3 mt-5">
        <h4>পরিকল্পনা ও বাস্তবায়নে</h4>
        <ul class="row">
            <li class="mr-5">
                <a href="http://a2i.pmo.gov.bd/" target="_blank">
                    <img height="40" src="{{ asset('images/a2ilogo-final.png') }}">
                </a>
            </li>
            <li>
                <a href="http://cabinet.gov.bd/" target="_blank">
                    <img height="40" src="{{ asset('images/bd_gov.png') }}">
                </a>
            </li>
        </ul>
        <!-- <div class="cleardiv">&nbsp;</div> -->
        <!-- <div class="copy-right-title"> -->
            <p>স্বর্বসত্ত্ব © ২০১৭ মন্ত্রিপরিষদ বিভাগ</p>
            <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
        <!-- </div> -->
    </div>
</div>
</section>
