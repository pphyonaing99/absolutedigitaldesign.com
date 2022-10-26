<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Part extends Model {
	protected $fillable = [
		'serial_number', 'name', 'brand_name', 'stock_qty', 'reg_date', 'item_id',
	];
}
