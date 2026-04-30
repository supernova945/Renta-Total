<?php namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class ClienteModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table = 'cliente';
    protected $primaryKey = 'idcliente';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'cliente',
        'idempresa'
    ];

    protected $useTimestamps = false;
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'cliente' => 'required|max_length[100]',
        'idempresa' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'cliente' => [
            'required' => 'El nombre del cliente es requerido.',
            'max_length' => 'El nombre del cliente no puede exceder 100 caracteres.'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get all clients with company information
     */
    public function getAllClients()
    {
        return $this->select('cliente.*, empresa.empresa as nombre_empresa')
                    ->join('empresa', 'empresa.idempresa = cliente.idempresa', 'left')
                    ->findAll();
    }

    /**
     * Get client by ID with company information
     */
    public function getClientWithCompany($idcliente)
    {
        return $this->select('cliente.*, empresa.empresa as nombre_empresa')
                    ->join('empresa', 'empresa.idempresa = cliente.idempresa', 'left')
                    ->find($idcliente);
    }

    /**
     * Get client by ID (simple method)
     */
    public function getClient($idcliente)
    {
        return $this->find($idcliente);
    }
}
