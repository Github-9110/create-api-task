<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Post extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
            'type' => 'INT',
            'constraint' => 255,
            'unsigned' => true,
            'auto_increment' => true
            ],
            
            'users_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                 ],

            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                ],

            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                 ],

            'image' => [
            'type' => 'VARCHAR',
            'constraint' => '255',
             ],

            'created_at' => [
            'type' => 'TIMESTAMP',
            'null' => true
             ],

            'updated_at' => [
            'type' => 'TIMESTAMP',
            'null' => true
          ],
             ]);
        
        $this->forge->addForeignKey('users_id', 'users', 'id');
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('posts');
    }

    public function down()
    {
        
        $this->forge->dropTable('posts');
    }
}
