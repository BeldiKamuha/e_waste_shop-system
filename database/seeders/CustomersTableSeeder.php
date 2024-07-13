<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            //admin
            [
                'name'=>'Admin',
                'username'=>'Admin',
                'email'=>'admin@gmail.com',
                'password'=>hash::make('111'),
                'role'=>'Admin',
                'status'=>'active',
            ],
            //supplier
            [
                'name' => 'Kimani Supplier',
                'username'=>'supplier',
                'email'=>'supplier@gmail.com',
                'password'=>hash::make('111'),
                'role'=>'supplier',
                'status'=>'active',
            ],
            //customer
            [
                'name'=>'Customer',
                'username'=>'customer',
                'email'=>'customer@gmail.com',
                'password'=>hash::make('111'),
                'role'=>'customer',
                'status'=>'active',
            ],
        ]);




    }
}
