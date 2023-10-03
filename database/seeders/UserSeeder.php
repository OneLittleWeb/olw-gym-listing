<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $superadmin =  User::create([
           'name' => 'Super Admin',
           'email' => 'www@gmail.com',
            'slug' => Str::slug('Super Admin','-'),
            'password' => Hash::make('123456789')
        ]);
       $superadmin->assignRole('superadmin');

       $admin =  User::create([
           'name' => 'Admin',
           'email' => 'admin@gmail.com',
           'slug' => Str::slug('Admin','-'),
            'password' => Hash::make('123456789')
        ]);
       $admin->assignRole('admin');

        $editor =  User::create([
           'name' => 'Editor',
           'email' => 'editor@gmail.com',
            'slug' => Str::slug('Editor','-'),
            'password' => Hash::make('123456789')
        ]);
       $editor->assignRole('editor');

       $publisher =  User::create([
           'name' => 'Publisher',
           'email' => 'publisher@gmail.com',
            'slug' => Str::slug('Publisher','-'),
            'password' => Hash::make('123456789')
        ]);
       $publisher->assignRole('publisher');

       $user =  User::create([
           'name' => 'User',
           'email' => 'user@gmail.com',
            'slug' => Str::slug('User','-'),
            'password' => Hash::make('123456789')
        ]);
       $user->assignRole('user');
    }
}
