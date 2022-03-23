<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UsersSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1000; $i++) { //to add 10 clients. Change limit as desired
            $this->db->table('user')->insert($this->generateFakeUserData());
        }
    }

    private function generateFakeUserData(): array
    {
        $faker = Factory::create();
        return [
            'username' => $faker->userName(),
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'phone' => $faker->phoneNumber(),
            'email' => $faker->email
        ];
    }
}
