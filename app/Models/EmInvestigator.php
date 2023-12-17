<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmInvestigator extends Model
{
    protected $fillable = [
        'appeal_id',
        'type_id',
        'nothi_id',
        'name',
        'organization',
        'designation',
        'mobile',
        'email',
        
    ];
    //Relation with appeal table
    public function appealInfo()
    {
        return $this->hasOne(EmAppeal::class,'id','appeal_id');
    }

}
