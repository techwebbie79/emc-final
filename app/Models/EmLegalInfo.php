<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmLegalInfo extends Model
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
}
