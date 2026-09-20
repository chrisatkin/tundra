<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Sessions table for session.driver = Database\MySQLiHandler (app/Config/Session.php).
 * Column set matches what CodeIgniter\Session\Handlers\DatabaseHandler::write()
 * actually reads/writes (vendor/codeigniter4/framework/system/Session/Handlers/DatabaseHandler.php).
 * Needed once the app runs as more than one replica behind a load balancer
 * with no session affinity -- the stock file handler is per-pod local disk.
 */
class CreateSessionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'varchar', 'constraint' => 140],
            'ip_address' => ['type' => 'varchar', 'constraint' => 45],
            'timestamp'  => ['type' => 'timestamp', 'null' => false, 'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP')],
            'data'       => ['type' => 'mediumtext'],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('timestamp');
        $this->forge->createTable('ci_sessions');
    }

    public function down()
    {
        $this->forge->dropTable('ci_sessions');
    }
}
