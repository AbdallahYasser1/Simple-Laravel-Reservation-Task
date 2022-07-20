<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Controllers\UserProfileController;
use App\Models\User;
use App\Models\UserProfile;
use http\Env\Request;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin=new UserProfileController;
       $request['none']='none';
        $admin= UserProfile::create([
            'picture'=>'empty'
        ]);

        $admin->save();
        $user = new User;
        $user->email = 'admin@ceo.com';
        $user->name = 'admin';
        $user-> password = '1234';
        $admin->profile()->save($user);
        $user->save();
        $user->assignRole('Admin');

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
