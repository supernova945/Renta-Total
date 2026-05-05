<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RentaModel;
use App\Models\ClienteModel;
use CodeIgniter\API\ResponseTrait;

class Rentas extends BaseController
{
    use ResponseTrait;

    protected $rentaModel;
    protected $clienteModel;

    public function __construct()
    {
        $this->rentaModel = new RentaModel();
        $this->clienteModel = new ClienteModel();
    }

    /**
     * Display the main rentals page
     */
    public function index()
    {
        $data = [
            'rentas' => $this->rentaModel->getActiveRentals(),
            'motos_disponibles' => $this->rentaModel->getAvailableMotorcycles(),
            'clientes' => $this->clienteModel->getAllClients(),
            'current_date' => date('d/m/Y'),
            'logged_in_user_id' => session()->get('idUsuario'),
            'logged_in_username' => session()->get('nombreUsuario')
        ];

        return view('rentas/index', $data);
    }

    /**
     * Get rental details via AJAX
     */
    public function getRentalDetails($placa = null)
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        if ($placa === null) {
            return $this->failNotFound('Placa no especificada.');
        }

        $rental = $this->rentaModel->getRentalDetails($placa);

        if ($rental) {
            return $this->respond($rental);
        } else {
            return $this->failNotFound('Renta no encontrada.');
        }
    }

    /**
     * Create new rental via AJAX
     */
    public function createRental()
    {
        if (!$this->request->isAJAX() || !$this->request->is('post')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('No se recibieron datos.', 400);
        }

        $loggedInUserId = session()->get('idUsuario');
        if (!$loggedInUserId) {
            return $this->failUnauthorized('Usuario no autenticado.');
        }

        // Add the user who created the rental
        $data['modificado_por'] = $loggedInUserId;

        // Validate required fields
        $rules = [
            'placa' => 'required|max_length[15]',
            'idcliente' => 'required|integer',
            'fecha_entrega' => 'required|valid_date',
            'fecha_renovacion' => 'required|valid_date',
            'renta_siniva' => 'required|decimal',
            'renta_coniva' => 'required|decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        try {
            if ($this->rentaModel->createRental($data)) {
                return $this->respondCreated([
                    'message' => 'Renta creada exitosamente.',
                    'placa' => $data['placa']
                ]);
            } else {
                return $this->fail('No se pudo crear la renta.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creando renta: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }

    /**
     * Update rental via AJAX
     */
    public function updateRental($placa = null)
    {
        if (!$this->request->isAJAX() || !$this->request->is('post')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        if ($placa === null) {
            return $this->failNotFound('Placa no especificada.');
        }

        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('No se recibieron datos.', 400);
        }

        $loggedInUserId = session()->get('idUsuario');
        if (!$loggedInUserId) {
            return $this->failUnauthorized('Usuario no autenticado.');
        }

        $data['modificado_por'] = $loggedInUserId;

        // Validate the data
        if (!$this->rentaModel->validate($data)) {
            return $this->failValidationErrors($this->rentaModel->errors());
        }

        try {
            if ($this->rentaModel->updateRental($placa, $data)) {
                return $this->respondUpdated([
                    'message' => 'Renta actualizada exitosamente.',
                    'placa' => $placa
                ]);
            } else {
                return $this->fail('No se pudo actualizar la renta.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando renta: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }

    /**
     * End rental (return motorcycle) via AJAX
     */
    public function endRental($placa = null)
    {
        if (!$this->request->isAJAX() || !$this->request->is('post')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        if ($placa === null) {
            return $this->failNotFound('Placa no especificada.');
        }

        $loggedInUserId = session()->get('idUsuario');
        if (!$loggedInUserId) {
            return $this->failUnauthorized('Usuario no autenticado.');
        }

        try {
            if ($this->rentaModel->endRental($placa, $loggedInUserId)) {
                return $this->respondDeleted([
                    'message' => 'Renta finalizada exitosamente. La motocicleta está disponible para venta.',
                    'placa' => $placa
                ]);
            } else {
                return $this->fail('No se pudo finalizar la renta.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error finalizando renta: ' . $e->getMessage());
            return $this->fail('Error interno del servidor: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Get available motorcycles via AJAX
     */
    public function getAvailableMotorcycles()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $motorcycles = $this->rentaModel->getAvailableMotorcycles();

        return $this->respond($motorcycles);
    }

    /**
     * Get all clients via AJAX
     */
    public function getClients()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $clients = $this->clienteModel->getAllClients();

        return $this->respond($clients);
    }

    /**
     * Get expiring leases count via AJAX
     */
    public function getExpiringLeasesCount()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $daysAhead = $this->request->getGet('days') ?? 60;
        $count = $this->rentaModel->getExpiringLeasesCount((int)$daysAhead);

        return $this->respond(['count' => $count]);
    }

    /**
     * Get expiring leases list via AJAX
     */
    public function getExpiringLeases()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $daysAhead = $this->request->getGet('days') ?? 60;
        $expiringLeases = $this->rentaModel->getExpiringLeases((int)$daysAhead);

        return $this->respond($expiringLeases);
    }
}
