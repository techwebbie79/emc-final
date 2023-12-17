<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmAppealCitizen extends Model
{
    // protected $connection = 'appeal';
    public function Citizen()
    {
        return $this->hasOne(EmCitizen::class, 'id', 'citizen_id', );
    }
}
