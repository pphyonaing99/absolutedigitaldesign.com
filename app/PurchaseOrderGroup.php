<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderGroup extends Model {
	protected $fillable = [
		'group_name', 'group_id', 'purchase_order_id',
	];
}
