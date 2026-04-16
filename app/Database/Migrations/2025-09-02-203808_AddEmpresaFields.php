<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmpresaFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('empresa', [
            'direccion' => [
                'type' => 'VARCHAR',
                'constraint' => 250,
                'null' => true,
                'after' => 'Empresa'
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => true,
                'after' => 'direccion'
            ],
            'correo' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'telefono'
            ],
            'nit' => [
                'type' => 'VARCHAR',
                'constraint' => 17,
                'null' => true,
                'after' => 'correo'
            ],
            'representante_legal' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'nit'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('empresa', [
            'direccion',
            'telefono',
            'correo',
            'nit',
            'representante_legal'
        ]);
    }
}
