<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
           
        Users::create([
            'name'=>'Junaid rehman',
            'email'=>'rehmanjunaid007@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user1',
            'email'=>'user1@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user2',
            'email'=>'user2@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user3',
            'email'=>'user3@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user4',
            'email'=>'user4@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user5',
            'email'=>'user5@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user6',
            'email'=>'user6@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user7',
            'email'=>'user7@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user8',
            'email'=>'user8@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
        Users::create([
            'name'=>'user9',
            'email'=>'user9@gmail.com',
            'role'=>'user',
            'password'=>Hash::make('12345678'),
            'phone'=>'2344324324',
            'address'=>'rahim yar khan',
        ]);
    }
}
