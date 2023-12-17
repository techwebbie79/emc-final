<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class EmCitizen extends Model
{
    // protected $connection = 'appeal';

    public function citizenType()
    {
        return $this->belongsToMany(EmCitizenTypes::class,'em_appeal_citizens','citizen_id', 'citizen_type_id');

    }
    public function citizensAppealJoin()
    {
        return $this->hasMany(EmAppealCitizen::class,'citizen_id', 'id');
    }
}
