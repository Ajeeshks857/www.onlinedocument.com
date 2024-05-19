<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'form_submission_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'file_name'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_path'          => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'user_id'            => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'approval_status'    => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default'    => 'pending',
            ],
            'approved_date'      => [
                'type'  => 'datetime',
                'null'  => true,
                'after' => 'approval_status',
            ],
           'description'       => [
                'type'           => 'TEXT',
                'null'           => true,
                'after'          => 'approved_date',
            ],
            'created_at'         => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('form_submission_id', 'form_submissions', 'id');
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->createTable('documents');
    }

    public function down()
    {
        $this->forge->dropTable('documents');
    }
}
