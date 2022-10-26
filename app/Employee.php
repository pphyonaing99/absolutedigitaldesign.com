<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
	protected $fillable = [
		'employee_code', 'name', 'phone', 'address', 'photo', 'employed_date', 'user_id', 'salary',
	];
}
