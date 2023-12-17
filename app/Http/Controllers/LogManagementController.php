<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\AppealRepository;

class LogManagementController extends Controller
{
    public function index()
    {
        if(globalUserInfo()->role_id==37)
        {

            $cases = DB::table('em_appeals')
            ->orderBy('id','DESC')
            ->join('court', 'em_appeals.court_id', '=', 'court.id')
            ->join('division', 'court.division_id', '=', 'division.id')
            ->join('district', 'court.district_id', '=', 'district.id')
            ->join('upazila', 'em_appeals.upazila_id', '=', 'upazila.id')
            ->where('em_appeals.district_id','=',user_district())
            ->select('em_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
            ->paginate(30);
            

            
        }
        else
        {
            $cases = DB::table('em_appeals')
            ->orderBy('id','DESC')
            ->join('court', 'em_appeals.court_id', '=', 'court.id')
            ->join('division', 'court.division_id', '=', 'division.id')
            ->join('district', 'court.district_id', '=', 'district.id')
            ->join('upazila', 'em_appeals.upazila_id', '=', 'upazila.id')
            ->select('em_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
            ->paginate(30);
           
            
        }
        $page_title='মামলা কার্যকলাপ নিরীক্ষা';
        return view('logManagement.index',compact(['cases','page_title']));

        
    }
    public function log_index_search(Request $request)
    {
        $query = DB::table('em_appeals')
        ->orderBy('id','DESC')
        ->join('court', 'em_appeals.court_id', '=', 'court.id')
        ->join('division', 'court.division_id', '=', 'division.id')
        ->join('district', 'court.district_id', '=', 'district.id')
        ->join('upazila', 'em_appeals.upazila_id', '=', 'upazila.id')
        ->select('em_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn');
        if (!empty($request->case_no)) {

            $query->where('case_no', $request->case_no);
        }
        $cases=$query->paginate(5);
        $page_title='মামলা কার্যকলাপ নিরীক্ষা';
        return view('logManagement.index',compact(['cases','page_title']));
    }
    public function log_index_single($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = EmAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal']  = $appeal;
        $data["notes"] = $appeal->appealNotes;
        $data["districtId"]= $officeInfo->district_id;
        $data["divisionId"]=$officeInfo->division_id;
        $data["office_id"] = $office_id;
        $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();
         
        $info = DB::table('em_appeals')
        ->join('court', 'em_appeals.court_id', '=', 'court.id')
        ->join('division', 'court.division_id', '=', 'division.id')
        ->join('district', 'court.district_id', '=', 'district.id')
        ->join('upazila', 'em_appeals.upazila_id', '=', 'upazila.id')
        ->select('em_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
        ->where('em_appeals.id','=',  $id)
        ->first();
         
        $data['info']=$info;


        $data['page_title'] = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য';
        // return $data;
        $data['apepal_id']=encrypt($id);  
        $case_details=DB::table('em_log_book')->where('appeal_id','=',$id)->orderBy('id','desc')->get();
        $data['case_details']=$case_details;

        //dd($data);
        return view('logManagement.log')->with($data);
    }
    public function log_details_single_by_id($id)
    {
      
        $log_details_single_by_id=DB::table('em_log_book')->where('id','=',$id)->first();
        $data['log_details_single_by_id']=$log_details_single_by_id;
        $data['page_title'] = 'মামলার বিস্তারিত তথ্য';
        return view('logManagement.log_details_single_by_id')->with($data);

    }
    public function create_log_pdf($id)
    {
         
        $id = decrypt($id);
        
      

        $user = globalUserInfo();

       

        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = EmAppeal::findOrFail($id);

        

        $data = AppealRepository::getAllAppealInfo($id);

        

        $data['appeal']  = $appeal;
        $data["notes"] = $appeal->appealNotes;
        $data["districtId"]= $officeInfo->district_id;
        $data["divisionId"]=$officeInfo->division_id;
        $data["office_id"] = $office_id;
        $data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();
         
        $info = DB::table('em_appeals')
        ->join('court', 'em_appeals.court_id', '=', 'court.id')
        ->join('division', 'court.division_id', '=', 'division.id')
        ->join('district', 'court.district_id', '=', 'district.id')
        ->join('upazila', 'em_appeals.upazila_id', '=', 'upazila.id')
        ->select('em_appeals.*', 'court.court_name','division.division_name_bn','district.district_name_bn','upazila.upazila_name_bn')
        ->where('em_appeals.id','=',  $id)
        ->first();
         
        $data['info']=$info;

       
        $data['page_title'] = 'মামলার কার্যকলাপ নিরীক্ষার বিস্তারিত তথ্য';

        
        $case_details=DB::table('em_log_book')->where('appeal_id','=',$id)->orderBy('id','desc')->get();

        $data['case_details']=$case_details;
      
        

        //return view('report.pdf_log_management')->with($data);

        $html = view('report.pdf_log_management')->with($data);

        $this->generatePamentPDF($html);
    }
    public function generatePamentPDF($html)
    {
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 12,
            'default_font' => 'kalpurush',

        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
