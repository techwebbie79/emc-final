<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrpcSection extends Model
{

	protected $table = 'crpc_sections';

	protected $fillable = [
	'id',
	'crpc_id',
	'crpc_name',
	'status',
	];

}
