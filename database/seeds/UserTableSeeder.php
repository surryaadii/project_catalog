<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\Models\User::truncate();
        DB::table('user_roles')->truncate();
        $roles = App\Models\Role::all();
        factory(App\Models\User::class, 50)->create()->each( function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(rand(1,2))->pluck('id')->toArray()
            );
        });
    }
}
