<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // init faker
        $faker = Faker::create();

        $admin_role = User::ROLE_ADMIN;

        for($i=0;$i<20;$i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->safeEmail,
                'role' => $admin_role,
                'password' => Hash::make('password'),
            ]);

            $todo_list_random_loop = rand(1,4);
            for($k=0;$k<$todo_list_random_loop;$k++) {
                $user->todo_lists()->create([
                    'body' => $faker->sentence(5),
                    'is_complete' => rand(1,2),
                ]);
            }
        }
    }
}
