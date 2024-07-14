<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FlowerMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'qty' => [
                'type' => 'INT',
                'constraint' => 10,
                'null' => true
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true
            ],
            'created_date' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('t_flowers');
    }

    public function down()
    {
        $this->forge->dropTable('t_flowers');
    }
}
