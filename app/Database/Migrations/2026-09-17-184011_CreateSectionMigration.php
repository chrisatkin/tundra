<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSectionMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tab' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment' => 'FK -> tab.id'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('section');
    }

    public function down()
    {
        $this->forge->dropTable('section');
    }
}
