<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model {
	protected $fillable = [
		'product_id', 'purchase_order_id', 'stock_qty',
	];

	public function product() {
		return $this->belongsTo('App\Product');
	}
}
