<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class EmAppeal extends Model
{
    // protected $connection = 'appeal';
    // protected $table = 'GccAppeal';


    //Relation with appeal table
    public function appealLawsBroken()
    {
        return $this->hasMany(LawBroken::class,'appeal_id','id');
    }

    public function causelistCaseshortdecision()
    {
        return $this->hasMany(EmCauselistCaseshortdecision::class,'appeal_id','id');
    }
    public function appealCauseList()
    {
        return $this->hasMany(EmCauseList::class,'appeal_id','id');
    }

    public function appealNotes()
    {
        return $this->hasMany(EmNote::class,'appeal_id','id');
    }

    public function appealCitizens()
    {
        return $this->belongsToMany(EmCitizen::class,'em_appeal_citizens','appeal_id', 'citizen_id');

    }
    public function appealWithAppealCitizens()
    {
        return $this->hasMany(EmAppealCitizen::class,'appeal_id','id');

    }

    public function appealAttachment()
    {
        return $this->hasMany(Attachment::class,'appeal_id','id');
    }
    public function division()
    {
        return $this->hasOne(Division::class,'id','division_id');
    }
    public function district()
    {
        return $this->hasOne(District::class,'id','district_id');
    }
    public function upazila()
    {
        return $this->hasOne(Upazila::class,'id','upazila_id');
    }
    public function caseCreator()
    {
        return $this->hasOne(User::class,'id','created_by');
    }
    public function reviewCreator()
    {
        return $this->hasOne(User::class,'id','review_applied_by');
    }
    public function crpcSection()
    {
        return $this->hasOne(CrpcSection::class,'id','law_section');
    }
    public function court()
    {
        return $this->hasOne(Court::class, 'id', 'court_id');
    }







}
