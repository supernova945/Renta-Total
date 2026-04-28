<?php namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class EmpresaModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table = 'empresa';
    protected $primaryKey = 'idempresa';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'Empresa',
        'direccion',
        'telefono',
        'correo',
        'nit',
        'representante_legal'
    ];

    protected $useTimestamps = false;
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];

    protected $validationMessages = [
        'Empresa' => [
            'required' => 'El nombre de la empresa es requerido.',
            'max_length' => 'El nombre de la empresa no puede exceder 50 caracteres.',
            'is_unique' => 'Esta empresa ya existe en el sistema.'
        ],
        'direccion' => [
            'max_length' => 'La dirección no puede exceder 250 caracteres.'
        ],
        'telefono' => [
            'max_length' => 'El teléfono no puede exceder 9 dígitos.',
            'regex_match' => 'El teléfono debe contener solo números.'
        ],
        'correo' => [
            'valid_email' => 'El correo electrónico debe tener un formato válido.',
            'max_length' => 'El correo electrónico no puede exceder 100 caracteres.'
        ],
        'nit' => [
            'max_length' => 'El NIT no puede exceder 17 caracteres.',
            'regex_match' => 'El NIT debe tener el formato 0000-000000-000-0.'
        ],
        'representante_legal' => [
            'max_length' => 'El nombre del representante legal no puede exceder 100 caracteres.'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get all companies
     */
    public function getAllCompanies()
    {
        return $this->findAll();
    }

    /**
     * Get company by ID
     */
    public function getCompany($idEmpresa)
    {
        return $this->find($idEmpresa);
    }
}
