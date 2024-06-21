<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

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
            //Admin
            [

                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active',

            ],
            
             //Supplier
             [

                'name' => 'Supplier',
                'username' => 'supplier',
                'email' => 'supplier@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'supplier',
                'status' => 'active',

            ],

            //Customer
            [

                'name' => 'Customer',
                'username' => 'customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'customer',
                'status' => 'active',

            ],





        ]);




    }
}
