<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmpresaModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class Empresas extends BaseController
{
    use ResponseTrait;

    protected $empresaModel;

    public function __construct()
    {
        $this->empresaModel = new EmpresaModel();
    }

    /**
     * Display the companies page
     */
    public function index()
    {
        $data = [
            'empresas' => $this->empresaModel->getAllCompanies(),
            'current_date' => date('d/m/Y'),
            'logged_in_user_id' => session()->get('idUsuario')
        ];

        return view('empresas/index', $data);
    }

    /**
     * Create new company via AJAX
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
            'Empresa' => 'required|max_length[50]|is_unique[empresa.Empresa]',
            'direccion' => 'permit_empty|max_length[250]',
            'telefono' => 'permit_empty|max_length[9]|regex_match[/^[0-9]+$/]',
            'correo' => 'permit_empty|valid_email|max_length[100]',
            'nit' => 'permit_empty|max_length[17]|regex_match[/^[0-9]{4}-[0-9]{6}-[0-9]{3}-[0-9]$/]',
            'representante_legal' => 'permit_empty|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        try {
            if ($this->empresaModel->insert($data)) {
                return $this->respondCreated([
                    'message' => 'Empresa creada exitosamente.',
                    'idempresa' => $this->empresaModel->getInsertID()
                ]);
            } else {
                return $this->fail('No se pudo crear la empresa.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error creando empresa: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }

    /**
     * Get all companies via AJAX
     */
    public function getCompanies()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $companies = $this->empresaModel->getAllCompanies();

        return $this->respond($companies);
    }

    /**
     * Get company details
     */
    public function getCompany($idEmpresa)
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $company = $this->empresaModel->getCompany($idEmpresa);

        if ($company) {
            return $this->respond($company);
        } else {
            return $this->failNotFound('Empresa no encontrada.');
        }
    }

    /**
     * Update company via AJAX
     */
    public function update($idEmpresa)
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
            'Empresa' => 'required|max_length[50]|is_unique[empresa.Empresa,idempresa,' . $idEmpresa . ']'
        ];

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        try {
            if ($this->empresaModel->update($idEmpresa, $data)) {
                return $this->respond([
                    'message' => 'Empresa actualizada exitosamente.'
                ]);
            } else {
                return $this->fail('No se pudo actualizar la empresa.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error actualizando empresa: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }

    /**
     * Delete company via AJAX
     */
    public function delete($idEmpresa)
    {
        if (!$this->request->isAJAX() || !$this->request->is('delete')) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        try {
            if ($this->empresaModel->delete($idEmpresa)) {
                return $this->respond([
                    'success' => true,
                    'message' => 'Empresa eliminada exitosamente.'
                ]);
            } else {
                return $this->fail('No se pudo eliminar la empresa.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error eliminando empresa: ' . $e->getMessage());
            return $this->fail('Error interno del servidor.', 500);
        }
    }
}
