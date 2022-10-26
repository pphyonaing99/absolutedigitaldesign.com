<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveOrder extends Model {
	protected $fillable = [
		'purchase_order_id', 'employee_id', 'arrival_date', 'status', 'comment',

	];
}
