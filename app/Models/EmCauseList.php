<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmCauseList extends Model
{
    // protected $connection = 'appeal';
    public function Attachments()
    {
        return $this->hasMany(EmAttachment::class, 'cause_list_id', 'id');
    }
    public function Note()
    {
        return $this->hasOne(EmNote::class, 'cause_list_id', 'id');
    }
    public function appeal()
    {
        return $this->hasOne(EmAppeal::class, 'id', 'appeal_id');
    }
    public function causelistCaseshortdecision()
    {
        return $this->hasMany(EmCauselistCaseshortdecision::class, 'cause_list_id', 'id');
    }
}
