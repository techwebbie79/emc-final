<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmNote extends Model
{
    // protected $connection = 'appeal';
    public $timestamps = false;

   public function noteCauseList()
   {
       return $this->belongsTo(EmCauseList::class, 'cause_list_id', 'id');
   }
   public function attachments()
   {
       return $this->hasMany(EmAttachment::class, 'cause_list_id', 'cause_list_id');
   }
   public function shortOrderName()
   {
       return $this->hasOne(EmCaseShortdecisions::class, 'id', 'case_short_decision_id');
   }
}
