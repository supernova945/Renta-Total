<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEstadoOriginalMotocicletaToServicios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('servicios', [
            'estado_original_motocicleta' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'default' => null,
                'after' => 'kilometraje_actual',
                'comment' => 'Estado original de la motocicleta antes del servicio'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('servicios', 'estado_original_motocicleta');
    }
}
