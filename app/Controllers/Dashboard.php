<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\Models\MotocicletaModel;
use App\Models\MarcaModel;
use App\Models\EstadoModel;
use App\Models\AgenciaModel;
use App\Models\UsuarioModel;
use App\Models\RentaModel;
use App\Models\ServicioModel;
use App\Models\ClienteModel;
use App\Models\ActivityLogModel;
use App\Services\NotificationService;
use App\Models\NotificationModel;

class Dashboard extends BaseController
{
    protected $rentaModel;
    protected $servicioModel;
    protected $clienteModel;
    protected $motocicletaModel;
    protected $activityLogModel;
    protected $notificationService;
    protected $notificationModel;

    public function __construct()
    {
        $this->rentaModel = new RentaModel();
        $this->servicioModel = new ServicioModel();
        $this->clienteModel = new ClienteModel();
        $this->motocicletaModel = new MotocicletaModel();
        $this->activityLogModel = new ActivityLogModel();
        $this->notificationService = new NotificationService();
        $this->notificationModel = new NotificationModel();
    }

    public function dashboard()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }
        
        $rol = $session->get('rol');

        // Obtener el ID del usuario desde la sesión y sus datos desde la BD
        $userId = $session->get('idUsuario');
        $usuarioModel = new UsuarioModel();
        $user = $usuarioModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        // Inicializar los modelos necesarios
        $marcaModel = new MarcaModel();
        $estadoModel = new EstadoModel();
        $agenciaModel = new AgenciaModel();

        $marcas = $marcaModel->findAll();
        $estados = $estadoModel->findAll();
        $agencias = $agenciaModel->findAll();

        // Get real statistics
        $stats = $this->getDashboardStats();

        // Get recent activity logs
        $recentActivities = $this->activityLogModel->getRecentActivities(20);

        // Preparar los datos para la vista
        $data = [
        'title'             => 'Panel de Administrador',
        'current_date'      => date('d/m/Y'),
        'logged_in_user_id' => $session->get('idusuario'),
        'stats'             => $this->getDashboardStats(),
        'recent_activities' => $this->activityLogModel->getRecentActivities(20),
        'marca'             => $marcaModel->findAll(),
        'estado'            => $estadoModel->findAll(),
        'agencia'           => $agenciaModel->findAll(),
        // ESTA ES LA CLAVE PARA LAS SUGERENCIAS:
        'motocicletas'      => $this->motocicletaModel
                                 ->select('motos.placa, motos.modelo, marca.marca AS nombre_marca')
                                 ->join('marca', 'marca.idmarca = motos.idmarca')
                                 ->findAll(),
    ];

        // Escoger la vista según el rol del usuario
        $allowedRoles = ['admin', 'Administrador', 'Jefatura'];

        if (in_array($rol, $allowedRoles)) {
            //Unir datos existentes con los nuevos datos de marcas, estados y agencias
            $data = array_merge($data, [
                'marca' => $marcas,
                'estado' => $estados,
                'agencia' => $agencias
            ]);
            return view('dashboard/dashboarda', $data);
        }

        // Informacion para usuarios no administradores
        return view('dashboard/dashboard', array_merge($data, [
            'title' => 'Panel de Usuario'
        ]));
    }

    /**
     * Calculate real dashboard statistics
     */
    private function getDashboardStats()
    {
        // Get motorcycle counts by status
        $totalMotorcycles = count($this->motocicletaModel->findAll());
        $availableMotorcycles = count($this->rentaModel->getAvailableMotorcycles());
        $rentedMotorcycles = count($this->rentaModel->getActiveRentals());

        // Calculate inventory value (sum of rental prices for all motorcycles)
        $inventoryValue = $this->calculateInventoryValue();

        // Get service statistics
        $activeServices = count($this->servicioModel->whereIn('estado_servicio', ['pendiente', 'en_progreso'])->findAll());
        $pendingServices = count($this->servicioModel->where('estado_servicio', 'pendiente')->findAll());
        $completedServices = count($this->servicioModel->where('estado_servicio', 'completado')->findAll());

        // Get client count
        $totalClients = count($this->clienteModel->getAllClients());

        // Calculate low inventory alerts (motorcycles with issues - status 4 "Fuera de Servicio")
        $lowInventoryAlerts = count($this->motocicletaModel->where('idestado', 4)->findAll());

        return [
            'total_motorcycles' => $totalMotorcycles,
            'available_motorcycles' => $availableMotorcycles,
            'rented_motorcycles' => $rentedMotorcycles,
            'inventory_value' => $inventoryValue,
            'active_services' => $activeServices,
            'pending_services' => $pendingServices,
            'completed_services' => $completedServices,
            'total_clients' => $totalClients,
            'low_inventory_alerts' => $lowInventoryAlerts,
            // Calculate some mock percentage changes (in a real app, you'd compare with previous period)
            'motorcycles_change' => $this->calculatePercentageChange($availableMotorcycles, $totalMotorcycles),
            'rented_change' => $this->calculatePercentageChange($rentedMotorcycles, $totalMotorcycles),
            'inventory_change' => 8.2, // Mock value
            'alerts_change' => $this->calculatePercentageChange($lowInventoryAlerts, $totalMotorcycles),
            'pending_change' => $this->calculatePercentageChange($pendingServices, $activeServices),
            'services_change' => $this->calculatePercentageChange($activeServices, $totalMotorcycles)
        ];
    }

    /**
     * Calculate total inventory value based on rental prices
     */
    private function calculateInventoryValue()
    {
        $motorcycles = $this->motocicletaModel->findAll();
        $totalValue = 0;

        foreach ($motorcycles as $moto) {
            // Use the higher of the two rental prices, or a default value
            $rentalPrice = max($moto['renta_sinIva'] ?? 0, $moto['renta_conIva'] ?? 0);
            if ($rentalPrice == 0) {
                $rentalPrice = 100; // Default value if no rental price set
            }
            $totalValue += $rentalPrice;
        }

        return $totalValue;
    }

    /**
     * Calculate percentage change (simplified version)
     */
    private function calculatePercentageChange($current, $total)
    {
        if ($total == 0) return 0;

        // This is a simplified calculation - in a real app you'd compare with historical data
        $percentage = ($current / $total) * 100;

        // Return a reasonable percentage for demo purposes
        if ($percentage > 50) {
            return -mt_rand(1, 5); // Negative change
        } else {
            return mt_rand(1, 8); // Positive change
        }
    }

    /**
     * Activity Log Page
     */
    public function activityLog()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }

        $rol = $session->get('rol');

        // Check if user has permission to view activity log
        $allowedRoles = ['admin', 'Administrador', 'Jefatura'];
        if (!in_array($rol, $allowedRoles)) {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos para ver el registro de actividades.');
        }

        // Get date filter parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Get activities with date filtering
        $activities = $this->activityLogModel->getActivitiesWithDateFilter($startDate, $endDate);

        // Prepare data for view
        $data = [
            'title' => 'Registro de Actividad',
            'activities' => $activities,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'current_date' => date('d/m/Y')
        ];

        return view('activity_log/index', $data);
    }

    /**
     * Export Activity Log to CSV
     */
    public function exportActivityLogCsv()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }

        $rol = $session->get('rol');

        // Check if user has permission to export activity log
        $allowedRoles = ['admin', 'Administrador', 'Jefatura'];
        if (!in_array($rol, $allowedRoles)) {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos para exportar el registro de actividades.');
        }

        // Get date filter parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Get activities with date filtering
        $activities = $this->activityLogModel->getActivitiesWithDateFilter($startDate, $endDate);

        // Generate filename with date range
        $filename = 'registro_actividad';
        if ($startDate || $endDate) {
            $filename .= '_';
            if ($startDate) $filename .= str_replace('-', '', $startDate);
            $filename .= '_';
            if ($endDate) $filename .= str_replace('-', '', $endDate);
        }
        $filename .= '_' . date('Y-m-d_H-i-s') . '.csv';

        // Set headers for CSV download
        $response = $this->response;
        $response->setHeader('Content-Type', 'text/csv; charset=utf-8');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');
        $response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $response->setHeader('Pragma', 'no-cache');
        $response->setHeader('Expires', '0');

        // Create CSV content
        $output = fopen('php://output', 'w');

        // Add BOM for UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

        // CSV headers
        fputcsv($output, [
            'ID',
            'Tabla',
            'ID Registro',
            'Acción',
            'Usuario',
            'Fecha y Hora',
            'Valores Anteriores',
            'Valores Nuevos'
        ]);

        // Add data rows
        foreach ($activities as $activity) {
            fputcsv($output, [
                $activity['id'],
                ucfirst($activity['table_name']),
                $activity['record_id'],
                ucfirst(strtolower($activity['action'])),
                $activity['user_username'] ?: 'Usuario desconocido',
                date('d/m/Y H:i:s', strtotime($activity['created_at'])),
                $activity['old_values'] ? $this->formatJsonForCsv($activity['old_values']) : '',
                $activity['new_values'] ? $this->formatJsonForCsv($activity['new_values']) : ''
            ]);
        }

        fclose($output);
        return $response;
    }

    /**
     * Format JSON data for CSV export
     */
    private function formatJsonForCsv($jsonString)
    {
        $data = json_decode($jsonString, true);
        if (!$data) return '';

        $formatted = [];
        foreach ($data as $key => $value) {
            $formatted[] = $key . ': ' . (is_array($value) ? json_encode($value) : $value);
        }

        return implode(' | ', $formatted);
    }

    /**
     * Get notifications count for current user
     */
    public function getNotificationsCount()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON(['count' => 0])->setStatusCode(401);
        }

        $userId = $session->get('idusuario');
        $count = $this->notificationService->getUserNotificationCount($userId);

        return $this->response->setJSON(['count' => $count])->setStatusCode(200);
    }

    /**
     * Get notifications list for current user
     */
    public function getNotificationsList()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON([])->setStatusCode(401);
        }

        $userId = $session->get('idusuario');
        $limit = $this->request->getGet('limit') ?: 50;

        $notifications = $this->notificationService->getUserNotifications($userId, $limit, false);

        // Format notifications for display
        $formattedNotifications = array_map(function($notification) {
            return [
                'id' => $notification['id'],
                'title' => $notification['title'],
                'message' => $notification['message'],
                'type' => $notification['type'],
                'is_read' => (bool)$notification['is_read'],
                'created_at' => $notification['created_at'],
                'relative_time' => $this->getRelativeTime($notification['created_at'])
            ];
        }, $notifications);

        return $this->response->setJSON($formattedNotifications)->setStatusCode(200);
    }

    /**
     * Mark a notification as read
     */
    public function markNotificationAsRead($notificationId)
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado'])->setStatusCode(401);
        }

        $userId = $session->get('idusuario');

        try {
            $result = $this->notificationService->markNotificationAsRead($notificationId, $userId);

            if ($result) {
                return $this->response->setJSON(['success' => true])->setStatusCode(200);
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'No se pudo marcar la notificación como leída'])->setStatusCode(400);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error marking notification as read: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    /**
     * Mark all notifications as read for current user
     */
    public function markAllNotificationsAsRead()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado'])->setStatusCode(401);
        }

        $userId = $session->get('idusuario');

        try {
            $result = $this->notificationService->markAllNotificationsAsRead($userId);

            return $this->response->setJSON(['success' => true, 'marked_count' => $result])->setStatusCode(200);
        } catch (\Exception $e) {
            log_message('error', 'Error marking all notifications as read: ' . $e->getMessage());
            return $this->response->setJSON(['success' => false, 'message' => 'Error interno del servidor'])->setStatusCode(500);
        }
    }

    /**
     * Helper function to get relative time
     */
    private function getRelativeTime($timestamp)
    {
        $now = new \DateTime();
        $then = new \DateTime($timestamp);
        $diff = $now->diff($then);

        if ($diff->days == 0) {
            if ($diff->h == 0) {
                if ($diff->i == 0) {
                    return 'Hace ' . $diff->s . ' segundos';
                } else {
                    return 'Hace ' . $diff->i . ' minutos';
                }
            } else {
                return 'Hace ' . $diff->h . ' horas';
            }
        } elseif ($diff->days == 1) {
            return 'Ayer';
        } elseif ($diff->days < 7) {
            return 'Hace ' . $diff->days . ' días';
        } elseif ($diff->days < 30) {
            $weeks = floor($diff->days / 7);
            return 'Hace ' . $weeks . ' semana' . ($weeks > 1 ? 's' : '');
        } else {
            return $then->format('d/m/Y');
        }
    }
}
