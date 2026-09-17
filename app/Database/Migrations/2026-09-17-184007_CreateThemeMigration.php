<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateThemeMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'varchar', 'constraint' => 50],
            'description' => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'directory'   => ['type' => 'varchar', 'constraint' => 50],
            'creator'     => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment' => 'FK -> users.id'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('theme');
    }

    public function down()
    {
        $this->forge->dropTable('theme');
    }
}
