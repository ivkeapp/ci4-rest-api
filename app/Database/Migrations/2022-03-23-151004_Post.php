<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Post extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks(); // foreignkey check escape
        $this->forge->addField([
            'post_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'headtitle' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'body' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'creator_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'date_added datetime default current_timestamp',
        ]);
        $this->forge->addPrimaryKey('post_id');
        $this->forge->addForeignKey('category', 'categories', 'category_id');
        $this->forge->addForeignKey('creator_id', 'user', 'user_id');
        $this->forge->createTable('post');
        
        $this->db->enableForeignKeyChecks(); // end of foreignkey check escape
    }

    public function down()
    {
        $this->forge->dropTable('post');
    }
}
