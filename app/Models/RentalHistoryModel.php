<?php namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class RentalHistoryModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table = 'rental_history';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'placa',
        'idcliente',
        'fecha_entrega',
        'fecha_renovacion',
        'renta_sinIva',
        'renta_conIva',
        'naf',
        'fecha_finalizacion',
        'finalizado_por',
        'idmarca',
        'modelo',
        'año',
        'idagencia'
    ];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'fecha_finalizacion';

    protected $validationRules = [
        'placa' => 'required|max_length[15]',
        'idcliente' => 'required|integer',
        'fecha_entrega' => 'required|valid_date',
        'fecha_renovacion' => 'permit_empty|valid_date',
        'renta_sinIva' => 'permit_empty|decimal',
        'renta_conIva' => 'permit_empty|decimal',
        'naf' => 'permit_empty|max_length[20]',
        'finalizado_por' => 'required|integer',
        'idmarca' => 'required|integer',
        'modelo' => 'required|max_length[50]',
        'año' => 'required|integer|exact_length[4]',
        'idagencia' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'placa' => [
            'required' => 'La placa es requerida.',
            'max_length' => 'La placa no puede exceder 15 caracteres.'
        ],
        'idcliente' => [
            'required' => 'El cliente es requerido.',
            'integer' => 'ID de cliente inválido.'
        ],
        'fecha_entrega' => [
            'required' => 'La fecha de entrega es requerida.',
            'valid_date' => 'Fecha de entrega inválida.'
        ],
        'fecha_renovacion' => [
            'valid_date' => 'Fecha de renovación inválida.'
        ],
        'finalizado_por' => [
            'required' => 'El usuario que finaliza es requerido.',
            'integer' => 'ID de usuario inválido.'
        ],
        'idmarca' => [
            'required' => 'La marca es requerida.',
            'integer' => 'ID de marca inválido.'
        ],
        'modelo' => [
            'required' => 'El modelo es requerido.',
            'max_length' => 'El modelo no puede exceder 50 caracteres.'
        ],
        'año' => [
            'required' => 'El año es requerido.',
            'integer' => 'Año inválido.',
            'exact_length' => 'El año debe tener exactamente 4 dígitos.'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get rental history for a specific motorcycle
     */
    public function getRentalHistoryByPlaca($placa)
    {
        return $this->select('rental_history.*, cliente.Cliente as nombre_cliente, marca.marca as nombre_marca, agencia.agencia as nombre_agencia')
                    ->join('cliente', 'cliente.idCliente = rental_history.idcliente', 'left')
                    ->join('marca', 'marca.idmarca = rental_history.idmarca', 'left')
                    ->join('agencia', 'agencia.idagencia = rental_history.idagencia', 'left')
                    ->where('rental_history.placa', $placa)
                    ->orderBy('rental_history.fecha_finalizacion', 'DESC')
                    ->findAll();
    }

    /**
     * Get all rental history with client information
     */
    public function getAllRentalHistory()
    {
        return $this->select('rental_history.*, cliente.Cliente as nombre_cliente, marca.marca as nombre_marca, agencia.agencia as nombre_agencia')
                    ->join('cliente', 'cliente.idCliente = rental_history.idcliente', 'left')
                    ->join('marca', 'marca.idmarca = rental_history.idmarca', 'left')
                    ->join('agencia', 'agencia.idagencia = rental_history.idagencia', 'left')
                    ->orderBy('rental_history.fecha_finalizacion', 'DESC')
                    ->findAll();
    }

    /**
     * Store a finished rental in history
     */
    public function storeFinishedRental($rentalData, $finishedBy)
    {
        $historyData = [
            'placa' => $rentalData['placa'],
            'idcliente' => $rentalData['idcliente'],
            'fecha_entrega' => $rentalData['fecha_entrega'],
            'fecha_renovacion' => $rentalData['fecha_renovacion'],
            'renta_sinIva' => $rentalData['renta_sinIva'],
            'renta_conIva' => $rentalData['renta_conIva'],
            'naf' => $rentalData['naf'],
            'finalizado_por' => $finishedBy,
            'idmarca' => $rentalData['idmarca'],
            'modelo' => $rentalData['modelo'],
            'año' => $rentalData['año'],
            'idagencia' => $rentalData['idagencia']
        ];

        return $this->insert($historyData);
    }
}
