<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use App\Models\MotocicletaModel;
use App\Models\MarcaModel;
use App\Models\EstadoModel;
use App\Models\AgenciaModel;
use App\Models\ServicioModel;
use App\Models\RentaModel;
use App\Models\BitacoraModel;

class Motocicletas extends BaseController
{
    use ResponseTrait;

    protected $motocicletaModel;
    protected $marcaModel;
    protected $estadoModel;
    protected $agenciaModel;
    protected $servicioModel;
    protected $rentaModel;
    protected $bitacoraModel;
    public function __construct()
    {
        $this->motocicletaModel = new MotocicletaModel();
        $this->marcaModel = new MarcaModel();
        $this->estadoModel = new EstadoModel();
        $this->agenciaModel = new AgenciaModel();
        $this->servicioModel = new ServicioModel();
        $this->rentaModel = new RentaModel();
        $this->bitacoraModel = new BitacoraModel();
    }

    /**
     * Muestra la página principal de motocicletas con un listado y el formulario de creación.
     */
    public function index()
    {
        // Cargar todos los datos necesarios para la vista
        $data['motocicletas'] = $this->motocicletaModel
                                 ->select('motos.*, marca.marca AS nombre_marca, estado.estado AS nombre_estado, agencia.agencia AS nombre_agencia')
                                 ->join('marca', 'marca.idmarca = motos.idmarca') 
                                 ->join('estado', 'estado.idestado = motos.idestado')
                                 ->join('agencia', 'agencia.idagencia = motos.idagencia', 'left')
                                 ->findAll();

        $data['marca'] = $this->marcaModel->findAll();
        $data['estado'] = $this->estadoModel->findAll();
        $data['agencia'] = $this->agenciaModel->findAll();

        // Variables adicionales que la vista pueda necesitar
        $data['current_date'] = date('d/m/Y');

        $data['logged_in_user_id'] = session()->get('idUsuario');
        $data['logged_in_username'] = session()->get('nombreUsuario');
        $data['logged_in_user_role'] = session()->get('rol');

        // Cargar la vista principal de motocicletas
        return view('motocicletas/motocicletas', $data);
    }

    /**
     * Maneja la creación de una nueva motocicleta vía AJAX.
     */
    public function createViaAjax()
    {
        $input = $this->request->getJSON(true);

        if (empty($input)) {
            return $this->fail('No se recibieron datos.', 400);
        }

        $loggedInUserId = session()->get('idUsuario');
        if (!$loggedInUserId) {
            return $this->failUnauthorized('Usuario no autenticado.');
        }

        // 1. REGLAS DE VALIDACIÓN BASE
        $rules = [
            'placa'          => 'required|max_length[15]',
            'marca'          => 'required|integer',
            'modelo'         => 'required|min_length[2]|max_length[50]',
            'anio'           => 'required|integer|exact_length[4]',
            'chasis'         => 'required|max_length[50]',
            'idestado'       => 'required|integer',
            // Validamos que el motivo sea uno de los permitidos
            'motivo_ingreso' => 'required|in_list[NUEVO,RENOVACION,REPOSICION]'
        ];
        $messages = [
    'placa' => [
        'is_unique' => '❌ La Placa ingresada ya está registrada en el sistema.'
    ],
    'chasis' => [
        'is_unique' => '❌ El número de Chasis ya pertenece a otra motocicleta.'
    ]
];

if (!$this->validate($rules, $messages)) {
    // Retornamos los errores de validación directamente
    return $this->fail($this->validator->getErrors(), 400);
}
 
        // 2. VALIDACIÓN DINÁMICA: Si no es NUEVO, la placa anterior es OBLIGATORIA
        $motivo = $input['motivo_ingreso'] ?? 'NUEVO';
        
        if ($motivo !== 'NUEVO') {
            $rules['placa_anterior'] = 'required|max_length[15]';
        }

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        // Preparamos los datos de la NUEVA moto
        $dataNuevaMoto = [
            'placa'            => $input['placa'],
            'idestado'         => $input['idestado'],
            'idmarca'          => $input['marca'],
            'modelo'           => $input['modelo'],
            'año'              => $input['anio'],
            'chasis'           => $input['chasis'],
            
            // --- CAMPOS NUEVOS ---
            'motivo_ingreso'   => $motivo,
            // Si es nuevo, forzamos NULL, si no, guardamos la placa anterior
            'placa_anterior'   => ($motivo !== 'NUEVO') ? $input['placa_anterior'] : null,
            // ---------------------

            'creado_por'       => $loggedInUserId,
            'fecha_creacion'   => date('Y-m-d H:i:s'),
            'activo'           => 1,
            
            // Campos opcionales
            'chasis'           => $input['chasis'] ?? null,
            'idcliente'        => $input['idcliente'] ?? null,
            'sucursal'         => $input['sucursal'] ?? null,
            'color'            => $input['color'] ?? null,
            'fecha_entrega'    => $input['fecha_entrega'] ?? null,
            'fecha_renovacion' => $input['fecha_renovacion'] ?? null,
            'envio'            => $input['envio'] ?? null,
            'taller'           => $input['taller'] ?? null,
            'iddepartamento'   => $input['iddepartamento'] ?? null,
            'idagencia'        => $input['idagencia'] ?? null,
            'renta_siniva'     => $input['renta_siniva'] ?? null,
            'renta_coniva'     => $input['renta_coniva'] ?? null,
            'naf'              => $input['naf'] ?? null,
        ];

        // --- INICIO DE TRANSACCIÓN (Todo o Nada) ---
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // PASO A: LÓGICA DE ACTUALIZACIÓN DE MOTO ANTERIOR (Si aplica)
            if ($motivo !== 'NUEVO' && !empty($input['placa_anterior'])) {
                
                $placaAnterior = $input['placa_anterior'];
                
                // 1. Verificamos que la moto anterior exista
                $motoVieja = $this->motocicletaModel->find($placaAnterior);
                
                if (!$motoVieja) {
                    // Si no existe, lanzamos excepción para cancelar todo
                    throw new \Exception("La placa anterior ($placaAnterior) no existe en el sistema.");
                }

                // 2. Determinamos el nuevo estado de la vieja según el motivo
                $nuevoEstadoId = null;
                
                if ($motivo === 'RENOVACION') {
                    $nuevoEstadoId = 5; // ID 5 = Disponible para venta
                } elseif ($motivo === 'REPOSICION') {
                    $nuevoEstadoId = 4; // ID 4 = Perdida Total
                }

                // 3. Ejecutamos la actualización de la vieja
                if ($nuevoEstadoId) {
                    $this->motocicletaModel->update($placaAnterior, [
                        'idestado'       => $nuevoEstadoId,
                        'modificado_por' => $loggedInUserId,
                        // Opcional: Podrías actualizar fecha_renovacion aquí si tu lógica lo requiere
                    ]);
                }
            }

            // PASO B: INSERTAR LA NUEVA MOTO
            if (!$this->motocicletaModel->insert($dataNuevaMoto)) {
                // Si falla el insert, lanzamos error para que el catch haga rollback
                return $this->failServerError("No se pudo guardar la motocicleta por favor revisar chasis y placa no estar repetido.");
            }

            // Si todo salió bien, confirmamos la transacción
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                // Si algo falló internamente en la DB durante la transacción
                return $this->failServerError('Error en la transacción de base de datos.');
            }

            return $this->respondCreated([
                'message' => 'Motocicleta agregada exitosamente.',
                // Retornamos la placa como ID ya que no es autoincrementable
                'id'      => $input['placa'] 
            ]);

        } catch (\CodeIgniter\Database\Exception\DatabaseException $e) {
            // Error 1062 es el código SQL para "Entrada Duplicada" (Duplicate entry)
            if ($e->getCode() === 1062) {
                $mensajeError = $e->getMessage();
                
                // Verificamos si el error menciona la 'placa'
                if (strpos($mensajeError, 'placa') !== false) {
                    return $this->fail('Esta PLACA ya existe en el sistema.', 409);
                }
                
                // Verificamos si el error menciona el 'chasis'
                if (stripos($mensajeError, 'chasis') !== false) { // stripos es insensible a mayúsculas/minúsculas
                    return $this->fail('Este número de CHASIS ya está registrado en otra moto.', 409);
                }

                // Si es otro campo duplicado (ej. motor)
                return $this->fail('Ya existe un registro duplicado (Placa, Chasis o Motor). Verifique los datos.', 409);
            }

            // Otros errores de base de datos
            log_message('error', 'Error de BD: ' . $e->getMessage());
            return $this->fail('Error de base de datos: ' . $e->getMessage(), 500);

        } catch (\Exception $e) {
            // Errores lógicos generales
            return $this->fail($e->getMessage(), 400);
        }
    }

    public function getMotocicletaDetails($placa)
    {
        // Aegurarse de que la solicitud es AJAX
        if (!$this->request->isAJAX()) {
            // Si no es una solicitud AJAX, retornar un error 401 Unauthorized
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        // Obtener los detalles de la motocicleta por placa
        $motocicleta = $this->motocicletaModel
                            ->select('motos.*, marca.marca AS nombre_marca, estado.estado AS nombre_estado, agencia.agencia AS nombre_agencia')
                            ->join('marca', 'marca.idmarca = motos.idmarca')
                            ->join('estado', 'estado.idestado = motos.idestado')
                            ->join('agencia', 'agencia.idagencia = motos.idagencia', 'left') // Use LEFT JOIN
                            ->find($placa); // Use the primary key to find the specific motorcycle

        if ($motocicleta) {
            // Retornar los detalles de la motocicleta como respuesta JSON
            return $this->respond($motocicleta);
        } else {
            // Si la motocicleta no se encuentra, retornar un error 404 Not Found
            return $this->failNotFound('Motocicleta no encontrada.');
        }
    }
 
    public function update($placa)
    {
        // Asegurarse de que la solicitud es AJAX y es un método POST
        if (!$this->request->isAJAX() || !$this->request->is('post')) {
            return $this->failUnauthorized('Acceso no autorizado o método no permitido.');
        }

        // Obtener los datos del cuerpo de la solicitud
        $data = $this->request->getJSON(true); // verdadero para obtener un array asociativo

        // Validar los datos recibidos)
        if (!$this->motocicletaModel->validate($data)) {
            return $this->failValidationErrors($this->motocicletaModel->errors());
        }

        // Intentar actualizar la motocicleta
        if ($this->motocicletaModel->update($placa, $data)) {
            return $this->respondUpdated(['message' => 'Motocicleta actualizada exitosamente.', 'placa' => $placa]);
        } else {
            // Si la actualización falla, retornar un error 500 Internal Server Error
            return $this->failServerError('No se pudo actualizar la motocicleta. Intente de nuevo.');
        }
    }

    public function delete($placa = null)
    {
        // Asegurarse de que la solicitud es AJAX
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado para eliminar.');
        }

        // Validar que se ha proporcionado una placa

        if ($placa === null) {
            return $this->failNotFound('No se especificó la placa de la motocicleta a eliminar.');
        }

        // Verificar si la motocicleta existe

        if ($this->motocicletaModel->delete($placa)) {
            return $this->respondDeleted(['message' => 'Motocicleta eliminada exitosamente.']);
        } 
        
        // Si la motocicleta no se pudo eliminar, verificar si existe

        else {
            return $this->failServerError('No se pudo eliminar la motocicleta. Podría no existir o tener dependencias.');
        }
    }

    /**
     * Get all services and rental history for a specific motorcycle (both completed and active services, plus rental history)
     */
    public function getServicesForMotorcycle($placa)
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        if ($placa === null) {
            return $this->failNotFound('Placa no especificada.');
        }

        try {
            // Get motorcycle details
            $motocicleta = $this->motocicletaModel
                ->select('motos.*, marca.marca AS marca, estado.estado AS estado, agencia.agencia AS agencia')
                ->join('marca', 'marca.idmarca = motos.idmarca')
                ->join('estado', 'estado.idestado = motos.idestado')
                ->join('agencia', 'agencia.idagencia = motos.idagencia', 'left')
                ->find($placa);

            if (!$motocicleta) {
                return $this->failNotFound('Motocicleta no encontrada.');
            }

            // Get completed services
            $completedServices = $this->servicioModel
                ->select('servicios.*')
                ->where('servicios.placa_motocicleta', $placa)
                ->where('servicios.estado_servicio', 'completado')
                ->orderBy('servicios.fecha_completado', 'DESC')
                ->findAll();

            // Get active services
            $activeServices = $this->servicioModel
                ->select('servicios.*')
                ->where('servicios.placa_motocicleta', $placa)
                ->whereIn('servicios.estado_servicio', ['pendiente', 'en_progreso'])
                ->orderBy('servicios.fecha_inicio', 'DESC')
                ->findAll();

            // Get rental history for the motorcycle (from the dedicated rental_history table)
            $rentalHistoryModel = new \App\Models\RentalHistoryModel();
            $rentalHistory = $rentalHistoryModel->getRentalHistoryByPlaca($placa);

            // gET comentario de renta
            $comentarios = $this->bitacoraModel->getComentariosPorPlaca($placa);

            return $this->respond([
                'motocicleta' => $motocicleta,
                'completed' => $completedServices,
                'active' => $activeServices,
                'rentas' => $rentalHistory,
                'comentarios' => $comentarios,
                'total_completed' => count($completedServices),
                'total_active' => count($activeServices),
                'total_rentas' => count($rentalHistory),
                'total_comentarios' => count($comentarios)
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error getting services and rentals for motorcycle: ' . $e->getMessage());
            return $this->fail('Error al obtener los servicios y rentas.', 500);
        }
    }
    /**
     * Agrega un nuevo comentario a la bitácora vía AJAX
     */
    public function addComment()
    {
        if (!$this->request->isAJAX()) {
            return $this->failUnauthorized('Acceso no autorizado.');
        }

        $input = $this->request->getJSON(true);
        $userId = session()->get('idUsuario'); // Asumiendo que guardas el ID en sesión como 'idUsuario'

        if (!$userId) {
            return $this->failUnauthorized('Debe iniciar sesión para comentar.');
        }

        // Validación simple
        if (empty($input['placa']) || empty($input['comentario'])) {
            return $this->fail('La placa y el comentario son obligatorios.', 400);
        }

        $data = [
            'placa'      => $input['placa'],
            'comentario' => $input['comentario'],
            'idusuario'  => $loggedInUserId
        ];

        try {
            if ($this->bitacoraModel->insert($data)) {
                return $this->respondCreated(['message' => 'Comentario agregado correctamente.']);
            } else {
                return $this->fail('No se pudo guardar el comentario.', 500);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error agregando comentario: ' . $e->getMessage());
            return $this->fail('Error del servidor: ' . $e->getMessage(), 500);
        }
    }   

}
