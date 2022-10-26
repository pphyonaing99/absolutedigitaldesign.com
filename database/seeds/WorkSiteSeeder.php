<?php

use App\WorkSite;
use Illuminate\Database\Seeder;

class WorkSiteSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		WorkSite::create([
			'name' => 'Kyi Myin Daing',
			'location' => 'https://goo.gl/maps/RVUU1EYmaESrpQGM7',
		]);
		WorkSite::create([
			'name' => 'North Oakalapa',
			'location' => 'https://goo.gl/maps/kMzK1L2JSPHdYMGc6',
		]);
	}
}
