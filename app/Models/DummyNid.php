<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DummyNid extends Model
{

	protected $table = 'dummy_nids';

	protected $fillable = [
		'name_en',	
		'gender',	
		'dob',	
		'father',	
		'mother',	
		'name_bn',	
		'spouse',	
		'national_id',	
		'permanent_address',	
		'present_address',	
		'religion',
	];

}
