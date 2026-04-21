<?php 

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class AgenciaModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    // Cambiado de 'agencia' a 'agencias' para coincidir con tu DB
    protected $table      = 'agencia'; 
    protected $primaryKey = 'idagencia';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Campos permitidos según tu captura de pantalla
    protected $allowedFields = [
        'agencia',
        'dirrecion' // Mantenemos la doble 'r' como está en tu DB
    ];

    protected $useTimestamps = false;
    
    // Reglas de validación ajustadas a la estructura real
    protected $validationRules = [
    // El placeholder {idagencia} ahora es opcional para evitar el error en "Nuevo"
    'agencia'   => 'required|min_length[3]|max_length[100]|is_unique[agencia.agencia,idagencia,{idagencia}]',
    'dirrecion' => 'permit_empty|max_length[250]',
];

    protected $validationMessages = [
        'agencia' => [
            'is_unique' => 'Ese nombre de agencia ya existe.',
            'required'  => 'El nombre de la agencia es obligatorio.'
        ],
    ];
    

    protected $skipValidation = false;
}