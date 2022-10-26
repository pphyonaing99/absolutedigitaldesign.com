<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkSite extends Model {
	protected $fillable = [
		'name', 'location',
	];
}
