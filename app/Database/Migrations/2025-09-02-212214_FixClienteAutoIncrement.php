<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixClienteAutoIncrement extends Migration
{
    public function up()
    {
        // Add AUTO_INCREMENT to idCliente column
        $this->db->query('ALTER TABLE cliente MODIFY COLUMN idCliente INT(11) NOT NULL AUTO_INCREMENT');
    }

    public function down()
    {
        // Remove AUTO_INCREMENT from idCliente column
        $this->db->query('ALTER TABLE cliente MODIFY COLUMN idCliente INT(11) NOT NULL');
    }
}
