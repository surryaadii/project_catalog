<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Administrator','User'];
        Role::truncate();
        foreach($roles as $role) {
            $model = new Role();
            $model->name = $role;
            $model->save();
        }
    }
}
