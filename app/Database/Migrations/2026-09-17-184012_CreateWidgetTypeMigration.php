<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWidgetTypeMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'varchar', 'constraint' => 50],
            'configuration' => ['type' => 'text', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('widget_type');
    }

    public function down()
    {
        $this->forge->dropTable('widget_type');
    }
}
