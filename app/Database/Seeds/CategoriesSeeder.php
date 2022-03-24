<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('categories')->insert(array('name' => 'Laptops'));
        $this->db->table('categories')->insert(array('name' => 'Tablets'));
        $this->db->table('categories')->insert(array('name' => 'Desktop PC'));
        $this->db->table('categories')->insert(array('name' => 'Mobile Phones'));
        $this->db->table('categories')->insert(array('name' => 'PC Components'));
    }
}
