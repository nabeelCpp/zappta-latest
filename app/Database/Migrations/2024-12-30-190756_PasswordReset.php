<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PasswordReset extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ],
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255
            ]
        ]);

        // Automatically manage created_at and updated_at columns
        $this->forge->addField('created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('password_resets');
    }

    public function down()
    {
        $this->forge->dropTable('password_resets');
    }
}
