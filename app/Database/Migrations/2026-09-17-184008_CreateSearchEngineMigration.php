<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSearchEngineMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'     => ['type' => 'varchar', 'constraint' => 50],
            'action'   => ['type' => 'varchar', 'constraint' => 255, 'comment' => 'form action URL'],
            'modifier' => ['type' => 'varchar', 'constraint' => 20, 'comment' => 'query string param name, e.g. q'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('search_engine');
    }

    public function down()
    {
        $this->forge->dropTable('search_engine');
    }
}
