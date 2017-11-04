<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::where('email', 'admin@salsa.com')->first();
        if(!empty($user)){
            $id = $user->id;
            App\User::find($id)->roles()->detach(1);
            App\User::find($id)->delete();
        }
        DB::table('users')->insert(array(
            [
                'name'=>'super admin',
                'email'=>'admin@salsa.com',
                'password'=>bcrypt('$@l$@123')
            ]
        ));
        $id = App\User::where('email', 'admin@salsa.com')->first()->id;
        $role_id = App\Role::where('title','super admin')->first()->id;
        App\User::find($id)->roles()->attach($role_id);
    }
}
