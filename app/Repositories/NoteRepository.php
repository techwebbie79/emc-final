<?php

namespace App\Repositories;

use App\Appeal;

use App\Models\EmNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class NoteRepository
{

   
    public static function store_em_dm_note($request_data, $appealId){

        $peshkar_notes=DB::table('peskar_notes_modified')->where('appeal_id',$appealId)->select('id')->orderBy('id','desc')->first();
      if(!empty($peshkar_notes))
      {
        $peshkar_notes_id=$peshkar_notes->id;
      }
      else
      {
        $peshkar_notes_id=null;
      }
      $user = globalUserInfo();
       $em_notes_table=[
           'appeal_id'=>$appealId,
           'peshkar_notes_id'=>$peshkar_notes_id,
           'approved'=>1,
           'case_short_decision_id'=>$request_data->shortOrder[0],
           'order_text'=>$request_data->note,
           'conduct_date'=>date('Y-m-d'),
           'next_date'=>date_formater_helpers($request_data->trialDate),
           'created_date'=>date('Y-m-d H:i:s'),
           'created_by_id'=>$user->id,
           'created_by_name'=>$user->name,
           'created_by_office'=>$user->office->office_name_bn,
           'created_by_designation'=>$user->role->role_name,
       ];
      
       $em_note_id=DB::table('em_notes_modified')->insertGetId($em_notes_table);

       DB::table('em_appeals')->where('id',$appealId)->update([
        'action_required'=>'PESH'
       ]);
       
       return $em_note_id;
       
    }




    public static function storeNote($orderText,$shortOrder,$appealId,$causeListId,$noteId, $status = null){
        // dd($shortOrder);
        // $user = Session::get('userInfo');
        // $user_role = Session::get('userRole')
        $user = globalUserInfo();
        $user_role = $user->role->role_name;
        if($noteId){
            $note=self::getNoteByNoteId($noteId);
        }else{
            $note=new EmNote();
        }

        $note->order_text=$orderText;
        $note->appeal_id=$appealId;
        $note->cause_list_id=$causeListId;
        $note->case_short_decision_id=$shortOrder;

        $note->created_by_id=$user->id;
        $note->created_date=date('Y-m-d H:i:s');
        $note->created_by_name=$user->name;
        $note->created_by_designation=$user->role->role_name;
        $note->created_by_office=$user->office->office_name_bn;
        $note->approved= $user_role =='Peshkar' ?0:1; //if peshkar then it would be 0 ,other user (GCO) 1
        // $note->approved= $status == 'DRAFT' || $status == 'SEND_TO_GCO' ? 0 : 1; //if peshkar then it would be 0 ,other user (GCO) 1

        $note->save();
        // dd($note);
    }

    public static function destroyNote($appealId){
        $note=EmNote::where('appeal_id',$appealId);
        $note->delete();
        return;
    }
    public static function destroyNoteByCauseListId($appealId,$causeListId){
        $note=EmNote::where('appeal_id',$appealId)->where('cause_list_id',$causeListId );
        $note->delete();
        return;
    }

    public static function getNoteByNoteId($noteId){
        $note=EmNote::find($noteId);
        return $note;
    }

    public static function getNoteCauseListByAppealId($appealId){
        $noteCauseList=DB::connection('mysql')
            ->table('em_notes')
            ->join('em_cause_lists', 'em_cause_lists.id', '=', 'em_notes.cause_list_id')
            ->where('em_notes.appeal_id',$appealId )
            ->orderBy('em_notes.cause_list_id', 'DESC')
            ->get();
        return $noteCauseList;
    }

    public static function getApprovedNoteList($appealId){
        // $noteCauseList=DB::table('em_notes')
        //     ->join('em_cause_lists', 'em_cause_lists.id', '=', 'em_notes.cause_list_id')
        //     ->where('em_notes.appeal_id',$appealId )
        //     ->where('em_notes.approved',1 )
        //     ->groupBy('em_notes.id')
        //     ->get();
        // return $noteCauseList;
        $noteCauseList=EmNote::orderby('id', 'DESC')->where('appeal_id',$appealId )
            ->where('approved',1 )
            // ->groupBy('em_notes.id')
            ->get();
        return $noteCauseList;

    }

    public static function getNotApprovedNote($appealId){

        $noteCauseList=DB::connection('mysql')
            ->select(DB::raw(
                "SELECT nt.order_text,nt.approved,
                        cl.trial_date,cl.trial_time,cl.conduct_date,cl.conduct_time,cl.id as cause_list_id,nt.id as noteId
                      --  ccd.case_shortdecision_id
                       FROM em_notes nt
                       JOIN em_cause_lists cl ON cl.id=nt.cause_list_id
                       -- LEFT JOIN causelist_caseshortdecisions ccd ON ccd.cause_list_id=cl.id
                       WHERE nt.appeal_id=$appealId AND nt.approved=0
                       ORDER BY cl.id LIMIT 1
                       "
            ));
        return $noteCauseList;
    }



}
