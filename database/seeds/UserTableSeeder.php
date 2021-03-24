<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

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
        $faker = Factory::create();
        App\Models\User::truncate();
        DB::table('user_roles')->truncate();
        $roles = App\Models\Role::all();
        for ($i=0; $i < 50; $i++) { 
            $u = new \App\Models\User();
            $d = [
                'name' => $faker->name,
                'email' => $i.'asd@gmail.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ];
            $u->fill($d);
            $u->save();

            $u->roles()->attach(
                $roles->random(rand(1,2))->pluck('id')->toArray()
            );
        }
        // $users = factory(App\Models\User::class, 50)->create()->each( function ($user) use ($roles) {
        //     dd($user->name);
        //     $user->roles()->attach(
        //         $roles->random(rand(1,2))->pluck('id')->toArray()
        //     );
        // });
    }
}
