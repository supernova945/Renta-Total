<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogModel extends Model
{
    protected $table            = 'activity_log';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['table_name', 'record_id', 'action', 'old_values', 'new_values', 'user_id', 'created_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'table_name' => 'required|max_length[100]',
        'record_id'  => 'required|max_length[100]',
        'action'     => 'required|in_list[INSERT,UPDATE,DELETE]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Log an activity
     */
    public function logActivity($table, $recordId, $action, $oldValues = null, $newValues = null, $userId = null)
    {
        $data = [
            'table_name' => $table,
            'record_id'  => $recordId,
            'action'     => strtoupper($action),
            'old_values' => $oldValues ? json_encode($oldValues) : null,
            'new_values' => $newValues ? json_encode($newValues) : null,
            'user_id'    => $userId,
        ];

        return $this->insert($data);
    }

    /**
     * Get recent activities
     */
    public function getRecentActivities($limit = 50)
    {
        return $this->select('activity_log.*, usuario.nombre as user_name, usuario.user as user_username')
                    ->join('usuario', 'usuario.idUsuario = activity_log.user_id', 'left')
                    ->orderBy('activity_log.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get activities for a specific table
     */
    public function getActivitiesByTable($table, $limit = 50)
    {
        return $this->where('table_name', $table)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get activities with date filtering
     */
    public function getActivitiesWithDateFilter($startDate = null, $endDate = null)
    {
        $builder = $this->select('activity_log.*, usuario.nombre as user_name, usuario.user as user_username')
                        ->join('usuario', 'usuario.idUsuario = activity_log.user_id', 'left')
                        ->orderBy('activity_log.created_at', 'DESC');

        if ($startDate) {
            $builder->where('DATE(activity_log.created_at) >=', $startDate);
        }

        if ($endDate) {
            $builder->where('DATE(activity_log.created_at) <=', $endDate);
        }

        return $builder->findAll();
    }
}
