<?php
namespace App\Controllers;
use App\Models\AgenciaModel;
use CodeIgniter\API\ResponseTrait;

class Agencias extends BaseController {
    use ResponseTrait;

    // Obtener datos para la tabla
    public function getAgencias() {
        $model = new AgenciaModel();
        $data = $model->findAll();
        return $this->respond($data);
    }
    public function delete($id = null) {
    $model = new \App\Models\AgenciaModel();
    
    // 1. Validar integridad (Ejemplo: verificar si hay clientes asociados)
    // Supongamos que tienes un ClienteModel
    $clienteModel = new \App\Models\ClienteModel();
    $tieneClientes = $clienteModel->where('idempresa', $id)->first(); // Ajustar según tu relación DB

    if ($tieneClientes) {
        return $this->respond([
            'success' => false, 
            'message' => 'No se puede eliminar la agencia porque tiene clientes asociados.'
        ], 400);
    }
    
    // 2. Si está limpia, proceder al borrado
    if ($id && $model->delete($id)) {
        return $this->respond(['success' => true]);
    }
    
    return $this->respond(['success' => false, 'message' => 'Error al intentar eliminar.'], 500);
}

    // Guardar o Actualizar
    public function save() {
    $model = new AgenciaModel();
    $data = $this->request->getJSON(true);
    
    // Si idagencia es un string vacío (viene de un formulario nuevo), lo removemos
    // para que el modelo entienda que es un INSERT y no un UPDATE.
    if (empty($data['idagencia'])) {
        unset($data['idagencia']);
    }
    
    try {
        // El método save() de CodeIgniter es inteligente: 
        // Si hay ID, hace UPDATE. Si no hay ID, hace INSERT.
        if ($model->save($data)) {
            return $this->respond(['success' => true]);
        } else {
            // Si la validación falla, enviamos los mensajes de error
            return $this->respond([
                'success' => false, 
                'message' => 'Error de validación',
                'errors' => $model->errors() 
            ], 400);
        }
    } catch (\Exception $e) {
        return $this->respond(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}