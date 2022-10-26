<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		/*$sitemanager = Role::where('name', 'Site Manager')->first();

		$user = User::create([
			'name' => 'Site Manager',
			'email' => 'sitemanager@gmail.com',
			'password' => \Hash::make('1234567890'),
			'work_site_id' => 1,
			'remember_token' => Str::random(60),
		]);
		$user->assignRole($sitemanager);
		$user->save();

		$whmanager = Role::where('name', 'Warehouse Manager')->first();
		$users = User::create([
			'name' => 'Warehouse Manager',
			'email' => 'whmanager@gmail.com',
			'password' => \Hash::make('1234567890'),
			'work_site_id' => 2,
			'remember_token' => Str::random(60),
		]);
		$users->assignRole($whmanager);
		$users->save();*/

		$superadmin = Role::where('name', 'Super Admin')->first();
		$users = User::create([
			'name' => 'superadmin',
			'email' => 'superadmin@gmail.com',
			'password' => \Hash::make('1234567890'),
			'work_site_id' => 3,
			'remember_token' => Str::random(60),
		]);
		$users->assignRole($superadmin);
		$users->save();
	}
}
