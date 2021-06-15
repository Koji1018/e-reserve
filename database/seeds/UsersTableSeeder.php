<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
			'email' => 'admin@test.com',
			'password' => Hash::make('admintest'),
			'user_group' => 0,
		]);
    }
}
