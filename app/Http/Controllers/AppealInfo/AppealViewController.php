<?php
/**
 * Created by PhpStorm.
 * User: ashraful
 * Date: 12/22/17
 * Time: 10:36 AM
 */

namespace App\Http\Controllers\AppealInfo;


use App\Models\User;
use App\Models\EmAppeal;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Repositories\AppealRepository;
use App\Repositories\ShortOrderRepository;
use App\Repositories\PeshkarNoteRepository;
use App\Services\ShortOrderTemplateService;
use App\Http\Controllers\AppealBaseController;



class AppealViewController extends Controller
{
    // public $permissionCode='certificateView';

    // public function showAppealViewPage(Request $request)
    // {
    //     $appealId=$request->id;

    //     return view('appealView.appealView')->with('appealId',$appealId);

    // }
    public function showAppealViewPage($id)
    {
        $id = decrypt($id);
        //dd($id);
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
       $data["appeal_id"]=$id;
        $data['page_title'] = 'মামলার বিস্তারিত তথ্য';
        //return $data;
      
        return view('appealView.appealView')->with($data);
    }

    public function showAppealTrakingPage($id)
    {
        $id = decrypt($id);
        $user = globalUserInfo();
        $office_id = $user->office_id;
        $roleID = $user->role_id;
        $officeInfo = user_office_info();

        $appeal = EmAppeal::findOrFail($id);
        $data = AppealRepository::getAllAppealInfo($id);
        $data['appeal']  = $appeal;
        //$data["notes"] = $appeal->appealNotes;
        //$data["districtId"]= $officeInfo->district_id;
        //$data["divisionId"]=$officeInfo->division_id;
        //$data["office_id"] = $office_id;
        //$data["gcoList"] = User::where('office_id', $user->office_id)->where('id', '!=', $user->id)->get();

        $data['shortOrderNameList'] = PeshkarNoteRepository::get_order_list($appeal->id);


        $data['page_title'] = 'মামলা ট্র্যাকিং';
        // return $data["notes"];
        return view('appealView.appealCaseTraking')->with($data);
    }



}
