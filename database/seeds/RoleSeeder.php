<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Role::create(['name' => 'Super Admin']);
		/*Role::create(['name' => 'Project Manager']);
		Role::create(['name' => 'Site Supervisor']);
		Role::create(['name' => 'Warehouse Supervisor']);
		Role::create(['name' => 'Procurement Officer']);*/
	}
}
