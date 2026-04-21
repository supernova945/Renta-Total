<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRentalHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'placa' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => false,
            ],
            'idcliente' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'fecha_entrega' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'fecha_renovacion' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'renta_sinIva' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'renta_conIva' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'naf' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'fecha_finalizacion' => [
                'type' => 'DATETIME',
                'null' => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'finalizado_por' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'idmarca' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'modelo' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
            ],
            'año' => [
                'type' => 'INT',
                'constraint' => 4,
                'null' => false,
            ],
            'idagencia' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('rental_history');

        // Change collation to match existing tables
        $this->db->query("ALTER TABLE `rental_history` COLLATE utf8mb4_unicode_ci");
    }

    public function down()
    {
        $this->forge->dropTable('rental_history');
    }
}
