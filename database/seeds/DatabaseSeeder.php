<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        DB::table('users')->insert([
            'name' =>"locphan",
            'email' => 'locphan.edu.@gmail.com',
            'password' => Hash::make('12344321'),
        ]);

        DB::table('tags')->insert([
            'name' =>"HL"
        ]);
        DB::table('tags')->insert([
            'name' =>"AI"
        ]);

        DB::table('categories')->insert([
            'name' =>"Technology"
        ]);
        DB::table('categories')->insert([
            'name' =>"Science"
        ]);
    }
}
