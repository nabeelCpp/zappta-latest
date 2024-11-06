<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationsTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true
            ],
            'vendor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false
            ],
            'message' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['user', 'vendor'],
                'null'       => false
            ],
            'is_read' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0
            ]
        ]);

        // Automatically manage created_at and updated_at columns
        $this->forge->addField('created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
