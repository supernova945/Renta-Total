<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;
use App\Models\EmpresaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class Clientes extends BaseController
{
    use ResponseTrait;

    protected $clienteModel;
    protected $empresaModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->empresaModel = new EmpresaModel();
    }

    /**
     * Display the clients page
     */
    public function index()
    {
        $data = [
            'clientes' => $this->clienteModel->getAllClients(),
            'empresas' => $this->empresaModel->getAllCompanies(),
            'current_date' => date('d/m/Y'),
            'logged_in_user_id' => session()->get('idUsuario')
        ];

        return view('clientes/index', $data);
    }

    /**
     * Create new client via AJAX
     */
    public function create()
    {
        if (!$this->request->isAJAX() || !$this->request->is('post')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('No se recibieron datos.', 400);
        }

        // Validate required fields
        $rules = [
            'Cliente' => 'required|max_length[100]',
            'idempresa' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        try {
            if ($this->clienteModel->insert($data)) {
                return $this->respondCreated([
                    'message' => 'Cliente creado exitosamente.',
                    'idCliente' => $this->clienteModel->getInsertID()
                ]);
            } else {
                return $this->fail('No se pudo crear el cliente.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creando cliente: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
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
     * Get client details
     */
    public function getClient($idCliente)
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $client = $this->clienteModel->getClientWithCompany($idCliente);

        if ($client) {
            return $this->respond($client);
        } else {
            return $this->failNotFound('Cliente no encontrado.');
        }
    }

    /**
     * Update client via AJAX
     */
    public function update($idCliente)
    {
        if (!$this->request->isAJAX() || !$this->request->is('put')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $data = $this->request->getJSON(true);

        if (empty($data)) {
            return $this->fail('No se recibieron datos.', 400);
        }

        // Validate required fields
        $rules = [
            'Cliente' => 'required|max_length[100]',
            'idempresa' => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        try {
            if ($this->clienteModel->update($idCliente, $data)) {
                return $this->respond([
                    'message' => 'Cliente actualizado exitosamente.'
                ]);
            } else {
                return $this->fail('No se pudo actualizar el cliente.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando cliente: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }

    /**
     * Delete client via AJAX
     */
    public function delete($idCliente)
    {
        if (!$this->request->isAJAX() || !$this->request->is('delete')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        try {
            if ($this->clienteModel->delete($idCliente)) {
                return $this->respond([
                    'success' => true,
                    'message' => 'Cliente eliminado exitosamente.'
                ]);
            } else {
                return $this->fail('No se pudo eliminar el cliente.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error eliminando cliente: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }
}
