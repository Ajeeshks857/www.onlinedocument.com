<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFormSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'         => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'text'            => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'email'           => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'phone'           => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'address'         => [
                'type' => 'TEXT',
                'null' => true,
            ],
            
            'created_at'      => ['type' => 'datetime', 'null' => true],
            'updated_at'      => ['type' => 'datetime', 'null' => true],
        ]);


        $this->forge->addForeignKey('user_id', 'users', 'id');

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('form_submissions');
    }

    public function down()
    {
        $this->forge->dropTable('form_submissions');
    }
}
