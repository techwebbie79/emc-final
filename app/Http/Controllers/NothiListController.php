<?php

/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/12/17
 * Time: 12:56 PM
 */

namespace App\Http\Controllers;

// use App\Models\Appeal;
use App\Models\EmAppeal;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Models\EmAppealOrderSheet;
use App\Services\AdminAppServices;
use Illuminate\Support\Facades\DB;
use App\Repositories\AppealRepository;
use Illuminate\Support\Facades\Session;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\PeshkarNoteRepository;
use App\Services\ShortOrderTemplateService;
use App\Repositories\CitizenAttendanceRepository;
use App\Services\ShortOrderTemplateServiceUpdated;



class NothiListController extends Controller
{
    public $permissionCode = 'certificateNothiList';

    public function index(Request $request)
    {
        $date = date($request->date);
        $userRole = Session::get('userRole');
        $districtId = Session::get('userInfo')->districtId;
        $upazilaList = AdminAppServices::getUpazilla($districtId);
        $gcoUserName = '';
        if ($userRole == 'GCO') {
            $gcoUserName = Session::get('userInfo')->username;
        }
        return view('nothiList.nothiList', compact('date', 'gcoUserName', 'upazilaList'));
    }

    public function nothiData(Request $request)
    {
        $usersPermissions = Session::get('userPermissions');
        $nothiData = AppealRepository::getNothiListBySearchParam($request);

        return response()->json([
            'data' => $nothiData,
            'userPermissions' => $usersPermissions,
            'userName' => Session::get('userInfo')->username

        ]);
    }

    public function nothiViewPage(Request $request)
    {
        $id = decrypt($request->id);
        $caseNumber = EmAppeal::find($id)->case_no;
        $appealId = $request->id;
        $nothiData = AppealRepository::getNothiListFromAppeal($id);
        $citizenAttendanceList = CitizenAttendanceRepository::getCitizenAttendanceByAppealId($id);

        $shortOrderTemplateList = ShortOrderTemplateServiceUpdated::getShortOrderTemplateListByAppealId($id);

        //$paymentAttachment = PaymentService::getPaymentAttachmentByAppealId($id);
        $page_title  = 'বিস্তারিত নথি | ' . $caseNumber;

        return view('nothiList.nothiView', compact('nothiData', 'appealId', 'shortOrderTemplateList', 'citizenAttendanceList', 'page_title'));
    }

    public function nothiViewOrderSheetDetails($id)
    {
        $data_to_qr_codded=url()->full();
        $imageName = 'QR_'.$id;

        $content = file_get_contents('https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl='.$data_to_qr_codded.'');
        file_put_contents(public_path().'/QRCodes/'.$imageName, $content);
        //dd($content);
        //file_put_contents(public_path() . $upload_path . $imageName, $content);

        $appealId = decrypt($id);
        
        $data['data_image_path']='/QRCodes/'.$imageName;

        $data['appealOrderLists'] = PeshkarNoteRepository::generate_order_shit($appealId);
        $data['nothi_id'] = $id;
        $data['page_title'] = 'আদেশ নামা';
       if(!empty($data['appealOrderLists'] )){

           return view('nothiList.nothiOrderSheetDetails')->with($data);
       }
       else
       {
        return redirect()->back()->with('error','এখনও আদেশনামা তৈরি হয় নাই');
       }

        // return view('nothiList.nothiOrderSheetDetails_JSPDF_OLD')->with($data);
    }


    public function pdf_order_sheet($id)
    {
        $appealId = $id;
        $data['appealOrderLists'] = EmAppealOrderSheet::where('appeal_id', $appealId)->get();
        $data['page_title'] = 'আদেশ নামা';

        $html = view('nothiList.pdf_order_sheet')->with($data);
        // Generate PDF
        $this->generatePDF($html);
    }


    public function generatePDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font'      => 'kalpurush'
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
