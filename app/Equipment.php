<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model {
	protected $fillable = [
		'serial_number', 'name', 'brand_name', 'stock_qty', 'reg_date',
	];
}
