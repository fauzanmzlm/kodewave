<?php

use App\TodoList;
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

        // register admin
        User::create([
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => Hash::make('password'),
            'role' => User::ROLE_ADMIN,
        ]);

        // register user
        User::create([
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => Hash::make('password'),
            'role' => User::ROLE_USER,
        ]);

        // seed todolist
        $statuses = User::statuses();
        $sar = array_rand($statuses);
        $rsar = $statuses[$sar];
        for($i=0;$i<10;$i++) {
            TodoList::create([
                'user_id' => User::inRandomOrder()->first()->id,
                'body' => $faker->sentence(5),
                'is_complete' => $faker->sentence(5),
            ]);
        }
    }
}
