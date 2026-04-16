<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivityToNotificationsType extends Migration
{
    public function up()
    {
        // Modify the type ENUM column to include 'activity'
        $this->forge->modifyColumn('notifications', [
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['motorcycle', 'service', 'rental', 'activity'],
            ],
        ]);
    }

    public function down()
    {
        // Remove 'activity' from the ENUM, revert to original values
        $this->forge->modifyColumn('notifications', [
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['motorcycle', 'service', 'rental'],
            ],
        ]);
    }
}
