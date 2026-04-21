<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class ServicioModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table            = 'servicios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'placa_motocicleta',
        'tipo_servicio',
        'descripcion',
        'estado_servicio',
        'fecha_solicitud',
        'fecha_inicio',
        'fecha_completado',
        'costo_estimado',
        'costo_real',
        'tecnico_responsable',
        'notas',
        'prioridad',
        'kilometraje_actual',
        'estado_original_motocicleta',
        'creado_por',
        'modificado_por'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'placa_motocicleta' => 'required|max_length[15]',
        'tipo_servicio'     => 'required|max_length[100]',
        'descripcion'       => 'required|min_length[10]',
        'estado_servicio'   => 'required|in_list[pendiente,en_progreso,completado,cancelado]',
        'fecha_solicitud'   => 'required|valid_date',
        'costo_estimado'    => 'permit_empty|decimal',
        'costo_real'        => 'permit_empty|decimal',
        'tecnico_responsable' => 'permit_empty|max_length[100]',
        'prioridad'         => 'required|in_list[baja,media,alta,urgente]',
        'kilometraje_actual' => 'permit_empty|integer',
        'creado_por'        => 'required|integer'
    ];

    protected $validationMessages = [
        'placa_motocicleta' => [
            'required' => 'La placa de la motocicleta es requerida.',
            'max_length' => 'La placa no puede exceder 15 caracteres.'
        ],
        'tipo_servicio' => [
            'required' => 'El tipo de servicio es requerido.',
            'max_length' => 'El tipo de servicio no puede exceder 100 caracteres.'
        ],
        'descripcion' => [
            'required' => 'La descripción del servicio es requerida.',
            'min_length' => 'La descripción debe tener al menos 10 caracteres.'
        ],
        'estado_servicio' => [
            'required' => 'El estado del servicio es requerido.',
            'in_list' => 'El estado debe ser: pendiente, en_progreso, completado o cancelado.'
        ],
        'fecha_solicitud' => [
            'required' => 'La fecha de solicitud es requerida.',
            'valid_date' => 'La fecha de solicitud debe ser una fecha válida.'
        ],
        'prioridad' => [
            'required' => 'La prioridad del servicio es requerida.',
            'in_list' => 'La prioridad debe ser: baja, media, alta o urgente.'
        ],
        'creado_por' => [
            'required' => 'El usuario creador es requerido.',
            'integer' => 'El ID del usuario creador debe ser un número entero.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Relationships
    public function getWithMotorcycle()
    {
        return $this->select('servicios.*, motos.modelo, marca.marca AS nombre_marca, motos.año, motos.color')
                    ->join('motos', 'motos.placa = servicios.placa_motocicleta')
                    ->join('marca', 'marca.idmarca = motos.idmarca')
                    ->findAll();
    }

    public function getServiceWithMotorcycle($id)
    {
        return $this->select('servicios.*, motos.modelo, marca.marca AS nombre_marca, motos.año, motos.Motor, motos.color')
                    ->join('motos', 'motos.placa = servicios.placa_motocicleta')
                    ->join('marca', 'marca.idmarca = motos.idmarca')
                    ->find($id);
    }

    /**
     * Get upcoming services within specified days
     */
    public function getUpcomingServices($daysAhead = 7)
    {
        $currentDate = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+{$daysAhead} days"));

        try {
            // Get services with upcoming start dates
            $upcomingStartServices = $this->select('servicios.*, motos.modelo, marca.marca AS nombre_marca, motos.año, motos.color')
                                       ->join('motos', 'motos.placa = servicios.placa_motocicleta')
                                       ->join('marca', 'marca.idmarca = motos.idmarca')
                                       ->where('servicios.fecha_inicio >=', $currentDate)
                                       ->where('servicios.fecha_inicio <=', $futureDate)
                                       ->where('servicios.estado_servicio !=', 'completado')
                                       ->where('servicios.estado_servicio !=', 'cancelado')
                                       ->findAll();

            // Get services with upcoming completion dates
            $upcomingCompletionServices = $this->select('servicios.*, motos.modelo, marca.marca AS nombre_marca, motos.año, motos.color')
                                            ->join('motos', 'motos.placa = servicios.placa_motocicleta')
                                            ->join('marca', 'marca.idmarca = motos.idmarca')
                                            ->where('servicios.fecha_completado >=', $currentDate)
                                            ->where('servicios.fecha_completado <=', $futureDate)
                                            ->where('servicios.estado_servicio', 'en_progreso')
                                            ->findAll();

            // Combine and remove duplicates
            $allServices = array_merge($upcomingStartServices, $upcomingCompletionServices);

            // Remove duplicates based on service ID
            $uniqueServices = [];
            $seenIds = [];
            foreach ($allServices as $service) {
                if (!in_array($service['id'], $seenIds)) {
                    $uniqueServices[] = $service;
                    $seenIds[] = $service['id'];
                }
            }

            // Sort by date (earliest first)
            usort($uniqueServices, function($a, $b) {
                $dateA = $a['fecha_inicio'] ?? $a['fecha_completado'];
                $dateB = $b['fecha_inicio'] ?? $b['fecha_completado'];
                return strtotime($dateA) - strtotime($dateB);
            });

            return $uniqueServices;
        } catch (\Exception $e) {
            log_message('error', 'Error in getUpcomingServices: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get count of upcoming services within specified days
     */
    public function getUpcomingServicesCount($daysAhead = 7)
    {
        $currentDate = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+{$daysAhead} days"));

        try {
            // Count services with upcoming start dates
            $startCount = $this->where('fecha_inicio >=', $currentDate)
                             ->where('fecha_inicio <=', $futureDate)
                             ->where('estado_servicio !=', 'completado')
                             ->where('estado_servicio !=', 'cancelado')
                             ->countAllResults();

            // Count services with upcoming completion dates
            $completionCount = $this->where('fecha_completado >=', $currentDate)
                                  ->where('fecha_completado <=', $futureDate)
                                  ->where('estado_servicio', 'en_progreso')
                                  ->countAllResults();

            return $startCount + $completionCount;
        } catch (\Exception $e) {
            log_message('error', 'Error in getUpcomingServicesCount: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Update motorcycle status based on service status
     * Called after insert and update operations
     */
    protected function updateMotorcycleStatus(array $data)
    {
        if (!isset($data['data']['placa_motocicleta']) || !isset($data['data']['estado_servicio'])) {
            return $data;
        }

        $placa = $data['data']['placa_motocicleta'];
        $estadoServicio = $data['data']['estado_servicio'];
        $serviceId = $data['id'] ?? null;

        try {
            $db = \Config\Database::connect();
            $motoBuilder = $db->table('motos');
            $servicioBuilder = $db->table('servicios');

            // Update motorcycle status based on service status
            if ($estadoServicio === 'en_progreso') {
                // Get current motorcycle status before changing it
                $currentMoto = $motoBuilder->where('placa', $placa)->get()->getRowArray();
                if ($currentMoto) {
                    // Store the original status in the service record
                    $servicioBuilder->where('id', $serviceId)->update(['estado_original_motocicleta' => $currentMoto['idestado']]);

                    // Set motorcycle to "En Mantenimiento" (idestado = 2)
                    $motoBuilder->where('placa', $placa)->update(['idestado' => 2]);
                    log_message('info', "Motorcycle {$placa} status changed from {$currentMoto['idestado']} to 'En Mantenimiento' due to service in progress");
                }
            } elseif (in_array($estadoServicio, ['completado', 'cancelado'])) {
                // Get the original status from the service record
                $service = $servicioBuilder->where('id', $serviceId)->get()->getRowArray();
                $originalStatus = $service['estado_original_motocicleta'] ?? 1; // Default to "Disponible" if not found

                // Restore motorcycle to its original status
                $motoBuilder->where('placa', $placa)->update(['idestado' => $originalStatus]);
                log_message('info', "Motorcycle {$placa} status restored to {$originalStatus} due to service completion/cancellation");
            }

        } catch (\Exception $e) {
            log_message('error', 'Error updating motorcycle status: ' . $e->getMessage());
        }

        return $data;
    }

    /**
     * Restore motorcycle status when service is deleted
     * Called after delete operations
     */
    protected function restoreMotorcycleStatus(array $data)
    {
        if (!isset($data['placa_motocicleta'])) {
            return $data;
        }

        $placa = $data['placa_motocicleta'];
        $originalStatus = $data['estado_original_motocicleta'] ?? 1; // Default to "Disponible" if not found

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('motos');

            // Restore motorcycle to its original status
            $builder->where('placa', $placa)->update(['idestado' => $originalStatus]);
            log_message('info', "Motorcycle {$placa} status restored to {$originalStatus} due to service deletion");

        } catch (\Exception $e) {
            log_message('error', 'Error restoring motorcycle status: ' . $e->getMessage());
        }

        return $data;
    }
}
