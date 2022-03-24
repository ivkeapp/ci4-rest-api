<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PostsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 1000; $i++) { //to add 10 clients. Change limit as desired
            $this->db->table('post')->insert($this->generateFakePostData());
        }
    }

    private function generateFakePostData(): array
    {
        $faker = Factory::create();
        return [
            'category' => 1,
            'headtitle' => $faker->sentence($nbWords = 4, $variableNbWords = true),
            'body' => $faker->text($maxNbChars = 500),
            'image_path' => $faker->imageUrl($width = 640, $height = 480),
            'creator_id' => 1
        ];
    }
}
