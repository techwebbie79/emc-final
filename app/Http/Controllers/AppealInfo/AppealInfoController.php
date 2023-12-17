<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/22/17
 * Time: 4:19 PM
 */

namespace App\Http\Controllers\AppealInfo;

use App\Http\Controllers\Controller;
use App\Models\Appeal;
use App\Models\EmAppealOrderSheet;
use App\Models\EmCaseShortdecisionTemplates;
use App\Models\CaseDecision;
use App\Models\CaseShortdecisionTemplates;
use App\Models\CauseList;
use App\Models\RaiOrder;
use App\Repositories\AppealRepository;
use App\Repositories\CauseListRepository;
use App\Repositories\ShortOrderRepository;
use App\Services\AdminAppServices;
use App\Services\MobileCourtServices;
use App\Services\PaymentService;
use App\Services\ProjapotiServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AppealInfoController extends Controller
{
    public $permissionCode='certificateView';

   /* public function __construct()
    {
     //   $this->middleware('auth');
        AppealBaseController::__construct();

    }*/

    public function getAppealOrderSheets(Request $request, $id){
        $appealId=$id;
        $data['appealOrderLists']=EmAppealOrderSheet::where('appeal_id',$appealId)->get();
        $data['page_title']='আদেশ নামা';

        return view('nothiList.nothiOrderSheet')->with($data);

    }


    public function getAppealShortOrderSheets(Request $request, $id){
        // dd($appealId);
        $data_to_qr_codded=url()->full();
        $imageName = 'QR_short_decision_template'.$id;

        $content = file_get_contents('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='.$data_to_qr_codded.'');
        file_put_contents(public_path().'/QRCodes/'.$imageName, $content);
        
        $data['data_image_path']='/QRCodes/'.$imageName;

        $data['appealShortOrderLists']=EmCaseShortdecisionTemplates::where('id',$id)->get();
        // return $data['appealShortOrderLists'];
        $data['page_title']='সংক্ষিপ্ত আদেশ';
        $data['nothi_id'] = $id;
        return view('nothiList.nothiShortOrderSheet')->with($data);

    }


    public function getAppealWarrentOrderSheet(Request $request, $id){
        $id = decrypt($id);
        // dd($id);
        $data['appealShortOrderLists']=EmCaseShortdecisionTemplates::where('appeal_id',$id)->where('case_shortdecision_id',19)->get();
        // return $data['appealShortOrderLists'];
        $data['page_title']='সংক্ষিপ্ত আদেশ';
        
        return view('nothiList.nothiShortOrderSheet')->with($data);
        
    }


    public function getAppealInvestigationOrderSheet(Request $request, $id){
        $id = decrypt($id);
        // dd($id);
        $data['appealShortOrderLists']=EmCaseShortdecisionTemplates::where('appeal_id',$id)->where('case_shortdecision_id',5)->get();
        // return $data['appealShortOrderLists'];
        $data['page_title']='সংক্ষিপ্ত আদেশ';
        
        return view('nothiList.nothiShortOrderSheet')->with($data);
        
    }



   public function generatePDF($html){
    $mpdf = new \Mpdf\Mpdf([
     'default_font_size' => 12,
     'default_font'      => 'kalpurush'
     ]);
    $mpdf->WriteHTML($html);
    $mpdf->Output();
  }


    public function showHelpPage(){
        return view('help');
    }

    public function getCaseDecisionList(){
        $caseDecisions=CaseDecision::all();
        return response()->json($caseDecisions);

    }

    public function getCalendarEventList(){
//        $causeList=CauseList::all();        //single event
//        return response()->json($causeList);

        $causeListEvent=CauseListRepository::getCauseListEventList(); //event count
        return response()->json($causeListEvent);
    }

    public function getThana(){

        $userInfo=Session::get('userInfo');
        $thanaList=AdminAppServices::getThana($userInfo->districtId);
        return response()->json([
            'thanaList' => $thanaList
        ]);

    }

    public function getUserZillaFromSession(){
        $userDistrictId=Session::get('districtCode');
        $userDistrictName=Session::get('districtName');
        return response()->json([
            'districtCode' => $userDistrictId,
            'districtName' => $userDistrictName
        ]);
    }

    public function getUpazilla(){

        $userInfo=Session::get('userInfo');
        $upazillaList=AdminAppServices::getUpazilla($userInfo->districtId);
        return response()->json([
            'upazillaList' => $upazillaList
        ]);

    }



    public function getShortTemplateByid(Request $request){
        $shortOrderTemplateId=$request->templateId;
        $shortOrderTemplate=CaseShortdecisionTemplates::find($shortOrderTemplateId);

        return response()->json([
            'shortOrderTemplate' => $shortOrderTemplate,
        ]);
    }

    public function getAppealRayNama(Request $request){
        $appealId=$request->appealId;
        $appealRayNama=RaiOrder::where('appeal_id',$appealId)->get();
        return response()->json([
            'appealRayNama' => $appealRayNama
        ]);
    }

    public function getAdmList(){
        //get Adm list
        $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('ADM_');

        $admList=array();

        if(Session::get('flagForSSOLogin')==1){
            $admList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo,Session::get('userInfo')->districtId);
        }else{
            $admList=ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo,Session::get('userInfo')->districtId);
        }
        return response()->json([
            'admList' => $admList
        ]);
    }

    public function getDmList(){
        //get DM role office info
        $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('DM_');
        //get Dm list
        $dmListArray=array();
        $dmList=array();

        //get Dm list
        if(Session::get('flagForSSOLogin')==1){
            $dmLists=ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo,Session::get('userInfo')->districtId);
        }else{
            $dmLists=ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo,Session::get('userInfo')->districtId);
        }
        foreach ($dmLists as $dmList ){
            $dmListArray [$dmList->username] =  $dmList;
        }
        return response()->json([
            'dmList' => $dmListArray
        ]);
    }

    public function getGcoList(){
        //get GCO role office info
        $roleOfficeInfo=AdminAppServices::getOfficeInfoByRoleCode('GCO_');
        //get GCO list
        $gcoListArray=array();
        $gcoLists=array();

        //get Dm list
        if(Session::get('flagForSSOLogin')==1){
            $gcoLists=ProjapotiServices::getUserListByDistrictAndOrganogramOriginIdByAPI($roleOfficeInfo,Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        }else{
            $gcoLists=ProjapotiServices::getUserListByDistrictAndOrganogramOriginId($roleOfficeInfo,Session::get('userInfo')->districtId, Session::get('userInfo')->office_id);
        }


        foreach ($gcoLists as $gcoList ){
            $gcoListArray [$gcoList->username] =  $gcoList;
        }
        return response()->json([
            'gcoList' => $gcoListArray
        ]);
    }

    public function getAppealInfo(Request $request){ //this function used by peshkar appeal view populate and Adm Appeal view Populate
        $appealId=$request->appealId;
        $data=AppealRepository::getAllAppealInfo($appealId);
        return response()->json([
            'data' => $data
        ]);
    }
    public function getShortOrderList(){
        $shortOrderList=ShortOrderRepository::getShortOrderList();
        return response()->json([
            'shortOrderList' => $shortOrderList
        ]);
    }

    public function getCriminalFromMobileCourt(Request $request){
        $caseNo=$request->caseNo;

        $criminalList=MobileCourtServices::getCriminalListByCaseNo($caseNo);

        return response()->json([
            'criminalList'=> $criminalList
        ]);
    }

    public function getCriminalInfoFromMobileCourt(Request $request){
        $caseNo=$request->caseNo;
        $criminalId=$request->criminalId;

        $criminalInfo=MobileCourtServices::getCriminalProsecutionInfo($caseNo,$criminalId);

        return response()->json([
            'criminalInfo'=> $criminalInfo
        ]);
    }

    /**
     * @param Request $request
     */
    public function checkHolidays(Request $request){
        $trialDate = $request->date;

        $dateInfo =AdminAppServices::getHoliday($trialDate);
        return response()->json([
            'dateInfo'=> $dateInfo
        ]);
    }

    public function getPaymentInfo(Request $request){
        $appealId=$request->appealId;
        $paymentInfo=[];
        $totalLoanAmount='';
        $caseNumber='';
        $totalDueAmount='';
        if(isset($appealId)){
            $totalLoanAmount=Appeal::find($appealId)->loan_amount;
            $caseNumber=Appeal::find($appealId)->case_no;
            $paymentStatus=Appeal::find($appealId)->payment_status;
            $paymentInfo=PaymentService::getPaidListByAppealId($appealId);
            $totalDueAmount=PaymentService::getTotalDueAmount($appealId,$totalLoanAmount);
            $totalAuctionSale=PaymentService::getAuctionTotalAmount($appealId);
        }

        return response()->json([
            'caseNumber'=> $caseNumber,
            'paymentStatus'=> $paymentStatus,
            'totalAuctionSale'=> $totalAuctionSale,
            'paymentList'=> $paymentInfo,
            'totalLoanAmount'=>$totalLoanAmount,
            'totalDueAmount'=>$totalDueAmount
        ]);

    }

}
