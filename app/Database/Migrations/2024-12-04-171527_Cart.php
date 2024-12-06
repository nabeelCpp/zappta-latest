<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cart extends Migration
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
            'cart_contents' => [
                'type'       => 'LONGTEXT',
            ],
        ]);

        // Automatically manage created_at and updated_at columns
        $this->forge->addField('created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
        $this->forge->addField('updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('carts');
    }

    public function down()
    {
        $this->forge->dropTable('carts');
    }
}
