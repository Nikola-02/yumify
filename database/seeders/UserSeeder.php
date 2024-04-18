<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role_id = Role::where('name','admin')->first();
        $user_role_id = Role::where('name','user')->first();
        User::create([
            'username'=>'test',
            'email'=>'test@gmail.com',
            'password'=>bcrypt('test123'),
            'role_id'=>$user_role_id->id
        ]);

        User::create([
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('admin123'),
            'role_id'=>$admin_role_id->id
        ]);
    }
}
