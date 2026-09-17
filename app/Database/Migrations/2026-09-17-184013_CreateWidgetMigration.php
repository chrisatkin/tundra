<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWidgetMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title'   => ['type' => 'varchar', 'constraint' => 100],
            'type'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment' => 'FK -> widget_type.id'],
            'config'  => ['type' => 'text', 'null' => true, 'comment' => 'serialized PHP array'],
            'column'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment' => 'FK -> section.id'],
            'refresh' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 0, 'comment' => 'minutes; 0 = never'],
            'order'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'default' => 1],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('widget');
    }

    public function down()
    {
        $this->forge->dropTable('widget');
    }
}
