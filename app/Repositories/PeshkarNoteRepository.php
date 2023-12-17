<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\ZoomRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Repositories\AppealRepository;

class PeshkarNoteRepository
{
    public static function store_peshkar_note($request_data, $appealId)
    {
      $em_notes=DB::table('em_notes_modified')->where('appeal_id',$appealId)->select('id')->orderBy('id','desc')->first();
      if(!empty($em_notes))
      {
        $em_notes_id=$em_notes->id;
      }
      else
      {
        $em_notes_id=null;
      }
      $user = globalUserInfo();
       $peskar_notes_table=[
           'appeal_id'=>$appealId,
           'em_notes_id'=>$em_notes_id,
           'approved'=>1,
           'case_short_decision_id'=>$request_data->shortOrder[0],
           'order_text'=>$request_data->note,
           'conduct_date'=>date('Y-m-d'),
           'next_date'=>date('Y-m-d'),
           'created_date'=>date('Y-m-d H:i:s'),
           'created_by_id'=>$user->id,
           'created_by_name'=>$user->name,
           'created_by_office'=>$user->office->office_name_bn,
           'created_by_designation'=>$user->role->role_name,
       ];
      
      $peshkar_note_id=DB::table('peskar_notes_modified')->insertGetId($peskar_notes_table);

       DB::table('em_appeals')->where('id',$appealId)->update([
        'action_required'=>'EM_DM'
       ]);

       return $peshkar_note_id;

    }
    public static function get_order_list($appealId)
    {
           return DB::table('em_notes_modified')
           ->join('em_case_shortdecisions','em_notes_modified.case_short_decision_id','em_case_shortdecisions.id')
           ->where('em_notes_modified.appeal_id',$appealId)
           ->select('em_notes_modified.conduct_date as conduct_date','em_case_shortdecisions.case_short_decision as short_order_name')
           ->get();

           
    }
    
    public static function get_last_order_list($appealId)
    {
           return DB::table('em_notes_modified')
           ->join('em_case_shortdecisions','em_notes_modified.case_short_decision_id','em_case_shortdecisions.id')
           ->where('em_notes_modified.appeal_id',$appealId)
           ->select('em_notes_modified.conduct_date as conduct_date','em_case_shortdecisions.case_short_decision as short_order_name')
           ->orderBy('em_notes_modified.id','desc')
           ->first();

           
    }

    public static function generate_order_shit($appealId)
    {
      

      

      $em_notes=DB::table('em_notes_modified')->where('appeal_id',$appealId)->get();
      
       
       if(count($em_notes)>0)
       {
        $shortoder_array=[];
        foreach($em_notes as $key=>$value)
        {
           if($key == 0)
           {
            $start_date=$value->conduct_date;
           }
           if($key == sizeof($em_notes)-1)
           {
            $end_date=$value->conduct_date;
           }
          $get_corresponding_peshkar=DB::table('peskar_notes_modified')->where('id',$value->peshkar_notes_id)->select('order_text')->first();
          
          $single_pair['order_date']=date_formater_helpers_make_bd($value->conduct_date);
          $single_pair['em_adm_name']=$value->created_by_name;
          $single_pair['em_adm_signature']=url('/').self::userSignature($value->created_by_id)->signature;
          $single_pair['designation']=$value->created_by_designation;
          $single_pair['peshkar_order']=$get_corresponding_peshkar->order_text;
          $single_pair['em_order']=$value->order_text;
  
          array_push($shortoder_array,$single_pair);
  
        }
  
        
        
        $data= [
          'case_info'=>AppealRepository::getCauselistCitizen($appealId),
          'case_District'=>self::caseDistrict($appealId),
          'case_Upzilla'=>self::caseUpzilla($appealId),
          'ordershit_start_date'=>date_formater_helpers_make_bd($start_date),
          'ordershit_end_date'=>date_formater_helpers_make_bd($end_date),
          'shortoder_array_date'=>$shortoder_array
        ];
        
        //dd($data);
        
        return $data;
       }
       
       return;

      
       
    }
    public static function userSignature($user_id)
    {
           return DB::table('users')->where('id',$user_id)->select('signature')->first();
    }
    public static function caseDistrict($appealId)
    {
          
        return DB::table('district')->join('em_appeals','em_appeals.district_id','district.id')->where('em_appeals.id',$appealId)->select('district.district_name_bn')->first()->district_name_bn;
    }
    public static function caseUpzilla($appealId)
    {
      return DB::table('upazila')->join('em_appeals','em_appeals.upazila_id','upazila.id')->where('em_appeals.id',$appealId)->select('upazila.upazila_name_bn')->first()->upazila_name_bn;
    }

    public static function order_list($appealId)
    {
      
      $em_notes=DB::table('em_notes_modified')->where('appeal_id',$appealId)->get();
      
       
       if(count($em_notes)>0)
       {
        $shortoder_array=[];
        foreach($em_notes as $key=>$value)
        {
           if($key == 0)
           {
            $start_date=$value->conduct_date;
           }
           if($key == sizeof($em_notes)-1)
           {
            $end_date=$value->conduct_date;
           }
          $get_corresponding_peshkar=DB::table('peskar_notes_modified')->where('id',$value->peshkar_notes_id)->first();
          
          $single_pair['order_date']=date_formater_helpers_make_bd($value->conduct_date);
          $single_pair['peshkar_order']=$get_corresponding_peshkar->order_text;
          $single_pair['em_order']=$value->order_text;
          $single_pair['peskar_files']=$get_corresponding_peshkar->peshkar_attachmets;
          $single_pair['em_files']=$value->em_attachmets;
          $single_pair['order_date_peskar']=date_formater_helpers_make_bd($get_corresponding_peshkar->conduct_date);

          array_push($shortoder_array,$single_pair);
  
        }
        
        //dd($shortoder_array);
        
        return $shortoder_array;
       }
       
       return;

      
       
    }
    public static function peshkar_initial_comments($appealId)
    {
      $get_corresponding_peshkar=DB::table('peskar_notes_modified')->where('appeal_id',$appealId)->orderBy('id','desc')->first();
      if(!empty($get_corresponding_peshkar))
      {
        return [
          'peshkar_order'=>$get_corresponding_peshkar->order_text,
          'order_date_peskar'=>date_formater_helpers_make_bd($get_corresponding_peshkar->conduct_date),
          'peskar_files'=>$get_corresponding_peshkar->peshkar_attachmets
  
        ];
      }
      else
      {
        return null;
      }
     
    }
    public  static function em_last_order($appealId)
    {
      $get_corresponding_em=DB::table('em_notes_modified')->where('appeal_id',$appealId)->orderBy('id','desc')->first();
      if(!empty($get_corresponding_em))
      {
        return [
          'em_order'=>$get_corresponding_em->order_text,
          'order_date_em'=>date_formater_helpers_make_bd($get_corresponding_em->conduct_date),
          'em_files'=>$get_corresponding_em->em_attachmets
  
        ];
      }
      else
      {
        return null;
      }
    }

  }