<?php

use Illuminate\Database\Seeder;
use App\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::create([
			'name' => 'Computer',
			'stock_qty' => '30',
			'brand_name' => 'Lenovo',
		]);

		Item::create([
			'name' => 'Computer',
			'stock_qty' => '20',
			'brand_name' => 'Dell',
		]);

		Item::create([
			'name' => 'Computer',
			'stock_qty' => '10',
			'brand_name' => 'HP',
		]);
    }
}
