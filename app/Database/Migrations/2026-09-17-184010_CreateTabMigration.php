<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment' => 'FK -> users.id'],
            'name' => ['type' => 'varchar', 'constraint' => 50],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('tab');
    }

    public function down()
    {
        $this->forge->dropTable('tab');
    }
}
