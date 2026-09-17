<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserProfileMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id'       => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'comment' => 'FK -> users.id'],
            'theme'         => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'comment' => 'FK -> theme.id'],
            'search_engine' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'comment' => 'FK -> search_engine.id'],
        ]);
        $this->forge->addPrimaryKey('user_id');
        $this->forge->createTable('user_profile');
    }

    public function down()
    {
        $this->forge->dropTable('user_profile');
    }
}
