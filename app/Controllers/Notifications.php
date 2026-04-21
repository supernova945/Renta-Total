<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityLogModel;
use CodeIgniter\HTTP\ResponseInterface;

class Notifications extends BaseController
{
    protected $activityLogModel;

    public function __construct()
    {
        $this->activityLogModel = new ActivityLogModel();
    }

    /**
     * Get notification count for the current user (recent activities)
     */
    public function count()
    {
        $userId = session()->get('idUsuario');
        $userRole = session()->get('rol');

        if (!$userId) {
            return $this->response->setJSON(['count' => 0]);
        }

        // Only show notifications for Administrador and Jefatura roles
        if (!in_array($userRole, ['Administrador', 'Jefatura'])) {
            return $this->response->setJSON(['count' => 0]);
        }

        // Count recent activity log entries from last 7 days
        $activities = $this->activityLogModel->getRecentActivities(500); // Get a larger set to count
        $count = count($activities);

        return $this->response->setJSON(['count' => min($count, 99)]); // Cap at 99
    }

    /**
     * Get notification list for the current user (recent activity log entries)
     */
    public function list()
    {
        $userId = session()->get('idUsuario');
        $userRole = session()->get('rol');

        if (!$userId) {
            return $this->response->setJSON([]);
        }

        // Only show notifications for Administrador and Jefatura roles
        if (!in_array($userRole, ['Administrador', 'Jefatura'])) {
            return $this->response->setJSON([]);
        }

        // Get recent activity log entries (with user info)
        $activities = $this->activityLogModel->getRecentActivities(20);

        // Format as notifications
        $notifications = [];
        foreach ($activities as $activity) {
            $notifications[] = [
                'id' => $activity['id'],
                'title' => $this->getActivityTitle($activity),
                'message' => $this->getActivityMessage($activity),
                'type' => 'activity',
                'created_at' => $activity['created_at'],
                'relative_time' => $this->getRelativeTime($activity['created_at']),
                'is_read' => false // Always show as unread since we're not tracking read status
            ];
        }

        return $this->response->setJSON($notifications);
    }

    /**
     * Get activity notification title
     */
    private function getActivityTitle($activity)
    {
        // Format like the activity log: "INSERT en motos (ID: HSYAAS)"
        $tableDisplayName = $this->getTableDisplayName($activity['table_name']);
        return ucfirst(strtolower($activity['action'])) . " en {$tableDisplayName} (ID: {$activity['record_id']})";
    }

    /**
     * Get activity notification message
     */
    private function getActivityMessage($activity)
    {
        return date('d/m/Y H:i', strtotime($activity['created_at'])) . " - Usuario: {$activity['user_name']}";
    }

    /**
     * Get display name for table
     */
    private function getTableDisplayName($tableName)
    {
        $names = [
            'motos' => 'motos',
            'servicios' => 'servicios',
            'usuario' => 'usuario',
            'cliente' => 'cliente',
            'empresa' => 'empresa',
            'rentas' => 'rentas',
            'rental_history' => 'rental_history'
        ];
        return $names[$tableName] ?? $tableName;
    }

    /**
     * Get relative time string
     */
    private function getRelativeTime($datetime)
    {
        $now = new \DateTime();
        $created = new \DateTime($datetime);
        $diff = $now->diff($created);

        if ($diff->y > 0) {
            return $diff->y . ' año' . ($diff->y > 1 ? 's' : '');
        } elseif ($diff->m > 0) {
            return $diff->m . ' mes' . ($diff->m > 1 ? 'es' : '');
        } elseif ($diff->d > 0) {
            return $diff->d . ' día' . ($diff->d > 1 ? 's' : '');
        } elseif ($diff->h > 0) {
            return $diff->h . ' hora' . ($diff->h > 1 ? 's' : '');
        } elseif ($diff->i > 0) {
            return $diff->i . ' minuto' . ($diff->i > 1 ? 's' : '');
        } else {
            return 'Ahora';
        }
    }
}
