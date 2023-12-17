<?php


namespace App\Repositories;


use App\Models\EmCauselistCaseshortdecision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CauseListShortDecisionRepository
{
    public static function storeCauseListCaseShortDecision($causeListId,$caseShortDecision, $appealId = null){
        // dd($caseShortDecision);
        $user = globalUserInfo();
        // $mkid = [];
        // $user = Session::get('userInfo');
        self::deleteShortOrderListByCauseListId($causeListId);
        if(isset($caseShortDecision)){
            foreach ($caseShortDecision AS $shortDecisionId){
                $causeListCaseShortDecision=new EmCauselistCaseshortdecision();
                $causeListCaseShortDecision->appeal_id=$appealId;
                $causeListCaseShortDecision->cause_list_id=$causeListId;
                $causeListCaseShortDecision->case_shortdecision_id=$shortDecisionId;
                $causeListCaseShortDecision->created_at=date('Y-m-d H:i:s');
                $causeListCaseShortDecision->created_by=$user->id;
                $causeListCaseShortDecision->updated_at=date('Y-m-d H:i:s');
                $causeListCaseShortDecision->updated_by=$user->id;
                $causeListCaseShortDecision->save();
                // $mkid[] = $causeListCaseShortDecision->id;
                // dd($causeListCaseShortDecision);

            }
        }
        // dd($mkid);
    }

    public static function deleteShortOrderListByCauseListId($causeListId){
        $shortOrderList=EmCauselistCaseshortdecision::where('cause_list_id',$causeListId);
        $shortOrderList->delete();

        return;
    }


    public static function getShortOrderListByAppealIdAndCauseListId($appealId,$causeListId)
    {
        // $shortOrderList=DB::connection('appeal')
        $shortOrderList=DB::connection('mysql')
            ->table('em_cause_lists')
            ->join('em_causelist_caseshortdecisions', 'em_cause_lists.id', '=', 'em_causelist_caseshortdecisions.cause_list_id')
            ->where('em_cause_lists.appeal_id',$appealId )
            ->where('em_cause_lists.id',$causeListId )
            ->get();
        return $shortOrderList;
    }

    public static function getCauseListShortOrderInfoByCauseListId($causeListId){
        $caseShortDecision=DB::connection('appeal')
            ->select(DB::raw(
                "SELECT cs.case_short_decision FROM causelist_caseshortdecisions ccd
                  JOIN  case_shortdecisions cs ON ccd.case_shortdecision_id=cs.id
                  WHERE ccd.cause_list_id=$causeListId"
            ));
        return $caseShortDecision;

    }

}
