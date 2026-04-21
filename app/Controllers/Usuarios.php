<?php namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\EmpresaModel;

class Usuarios extends BaseController
{
    protected $usuarioModel;
    protected $empresaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->empresaModel = new EmpresaModel();
    }

    // Muestra la lista de usuarios

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('usuarios/index', $data);
    }

    // Muestra el formulario de creación de usuario

    public function create()
    {
        return view('usuarios/create');
    }

    // Maneja la creación de un nuevo usuario

    public function store()
{
    helper(['form']);
    
    // 1. Capturamos el valor para depurar si es necesario
    $passwordRecibido = $this->request->getVar('password');

    $rules = [
        'user'     => 'required|min_length[4]|is_unique[usuario.user]',
        'password' => [ // Cambiado a minúscula para coincidir con el estándar de formularios
            'label'  => 'Contraseña',
            'rules'  => 'required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])/]',
            'errors' => [
                'required'    => 'La contraseña es obligatoria.',
                'min_length'  => 'La contraseña debe tener al menos 8 caracteres.',
                'regex_match' => 'La contraseña debe incluir al menos una MAYÚSCULA y un CARÁCTER ESPECIAL.'
            ]
        ],
        'correo'   => 'required|valid_email',
        'nombre'   => 'required'
    ];

    // 2. Ejecutar validación
    if (!$this->validate($rules)) {
        // MUY IMPORTANTE: Esto detiene el proceso si no se cumplen las reglas
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // 3. Si llega aquí, significa que la validación PASÓ
    $model = new \App\Models\UsuarioModel();
    
    $data = [
        'nombre'   => $this->request->getVar('nombre'),
        'user'     => $this->request->getVar('user'),
        // Aquí usamos la P mayúscula solo para la BASE DE DATOS si así se llama tu columna
        'Password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        'correo'   => $this->request->getVar('correo'),
        'rol'      => $this->request->getVar('rol'),
        'estado'   => 1, 
        'intentos_fallidos' => 0
    ];

    if ($model->save($data)) {
        return redirect()->to('/usuarios')->with('message', 'Usuario creado exitosamente.');
    } else {
        return redirect()->back()->withInput()->with('error', 'No se pudo guardar en la base de datos.');
    }
}

    // Muestra el formulario de edición de usuario

    public function edit($id)
    {
        $data['usuario'] = $this->usuarioModel->find($id);
        return view('usuarios/edit', $data);
    }

    // Maneja la actualización de un usuario existente

    public function update($id)
    {
        // Validación de los campos del formulario
        
        $rules = [
            'nombre' => 'required|min_length[3]',
            'correo' => 'required|valid_email',
            'dui'    => 'required|regex_match[/^[0-9]{8}-[0-9]$/]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->usuarioModel->update($id, [
            'nombre'   => $this->request->getPost('nombre'),
            'user'     => $this->request->getPost('user'),
            'correo'   => $this->request->getPost('correo'),
            'estado'   => (bool)$this->request->getPost('estado'),
            'rol'      => $this->request->getPost('rol'),
            'dui'      => $this->request->getPost('dui'),
        ]);

        return redirect()->to('/usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    // Maneja la eliminación de un usuario

    public function delete($id)
    {
        $this->usuarioModel->delete($id);
        return $this->response->setJSON(['status' => 'ok']);
    }

    // Maneja la creación de un usuario vía AJAX

   // Maneja la creación de un usuario vía AJAX
    public function createViaAjax()
    {        
        $input = $this->request->getJSON(true) ?? [];

        // Validar campos
        $requiredFields = ['name', 'usuario', 'password', 'email', 'dui', 'estado', 'role'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || trim($input[$field]) === '') {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Campo requerido: $field"
                ]);
            }
        }

        // Chequear formato DUI
        if (!preg_match('/^\d{8}-\d$/', $input['dui'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Formato de DUI inválido. Use 00000000-0.'
            ]);
        }

        // ---------------------------------------------------------
        // ---> INICIO: POLÍTICAS ESTRICTAS DE CONTRASEÑA <---
        // ---------------------------------------------------------
        $password = $input['password'];
        
        // 1. Validar longitud mínima de 8 caracteres
        if (strlen($password) < 8) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'La contraseña debe tener al menos 8 caracteres.'
            ]);
        }
        
        // 2. Validar al menos una letra mayúscula
        if (!preg_match('/[A-Z]/', $password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'La contraseña debe incluir al menos una letra MAYÚSCULA.'
            ]);
        }
        
        // 3. Validar al menos un carácter especial
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'La contraseña debe incluir al menos un CARÁCTER ESPECIAL.'
            ]);
        }
        // ---------------------------------------------------------
        // ---> FIN: POLÍTICAS ESTRICTAS DE CONTRASEÑA <---
        // ---------------------------------------------------------

        // Validar campos únicos
        $errors = [];

        if ($this->usuarioModel->where('user', trim($input['usuario']))->first()) {
            $errors[] = 'El nombre de usuario ya está en uso.';
        }

        if ($this->usuarioModel->where('correo', trim($input['email']))->first()) {
            $errors[] = 'El correo ya está registrado.';
        }

        if ($this->usuarioModel->where('dui', trim($input['dui']))->first()) {
            $errors[] = 'El DUI ya está registrado.';
        }

        if (!empty($errors)) {
            return $this->response->setStatusCode(409)->setJSON([
                'error' => implode(' ', $errors)
            ]);
        }

        $this->usuarioModel->insert([
            'nombre'   => trim($input['name']),
            'user'     => trim($input['usuario']),
            'Password' => password_hash($input['password'], PASSWORD_DEFAULT),
            'correo'   => trim($input['email']),
            'dui'      => trim($input['dui']),
            'estado'   => $input['estado'] === 'activo' ? 1 : 0,
            'rol'      => trim($input['role']),
            'intentos_fallidos' => 0 // Es importante inicializar esto en 0 para tu login
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }

    public function show($id)
    {
        $user = $this->usuarioModel->find($id);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Usuario no encontrado.']);
        }

        return $this->response->setJSON($user);
    }

    // Muestra la lista de usuarios con formato de fecha

    public function usuarios()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        $data['empresas'] = $this->empresaModel->getAllCompanies();

        $formatter = new \IntlDateFormatter('es_ES', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
        $formatter->setPattern('d \'de\' MMMM, yyyy');
        $data['current_date'] = $formatter->format(new \DateTime());

        return view('usuarios/usuarios', $data);
    }

    // Maneja la creación de un usuario vía AJAX (segunda aplicacion)

    public function createViaAjax2()
    {        
        $input = $this->request->getJSON(true) ?? [];

        // Validar campos
        $requiredFields = ['name', 'usuario', 'password', 'email', 'dui', 'estado', 'role'];
        foreach ($requiredFields as $field) {
            if (!isset($input[$field]) || trim($input[$field]) === '') {
                return $this->response->setStatusCode(400)->setJSON([
                    'error' => "Campo requerido: $field"
                ]);
            }
        }

        // Chequear formato DUI
        if (!preg_match('/^\d{8}-\d$/', $input['dui'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Formato de DUI inválido. Use 00000000-0.'
            ]);
        }

        // ---------------------------------------------------------
        // ---> INICIO: POLÍTICAS ESTRICTAS DE CONTRASEÑA <---
        // ---------------------------------------------------------
        $password = $input['password'];
        
        // 1. Validar longitud mínima de 8 caracteres
        if (strlen($password) < 8) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'La contraseña debe tener al menos 8 caracteres.'
            ]);
        }
        
        // 2. Validar al menos una letra mayúscula
        if (!preg_match('/[A-Z]/', $password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'La contraseña debe incluir al menos una letra MAYÚSCULA.'
            ]);
        }
        
        // 3. Validar al menos un carácter especial
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'La contraseña debe incluir al menos un CARÁCTER ESPECIAL.'
            ]);
        }
        // ---------------------------------------------------------
        // ---> FIN: POLÍTICAS ESTRICTAS DE CONTRASEÑA <---
        // ---------------------------------------------------------

        // Validar campos únicos
        $errors = [];

        if ($this->usuarioModel->where('user', trim($input['usuario']))->first()) {
            $errors[] = 'El nombre de usuario ya está en uso.';
        }

        if ($this->usuarioModel->where('correo', trim($input['email']))->first()) {
            $errors[] = 'El correo ya está registrado.';
        }

        if ($this->usuarioModel->where('dui', trim($input['dui']))->first()) {
            $errors[] = 'El DUI ya está registrado.';
        }

        if (!empty($errors)) {
            return $this->response->setStatusCode(409)->setJSON([
                'error' => implode(' ', $errors)
            ]);
        }

        $this->usuarioModel->insert([
            'nombre'   => trim($input['name']),
            'user'     => trim($input['usuario']),
            'Password' => password_hash($input['password'], PASSWORD_DEFAULT),
            'correo'   => trim($input['email']),
            'dui'      => trim($input['dui']),
            'estado'   => $input['estado'] === 'activo' ? 1 : 0,
            'rol'      => trim($input['role']),
            'intentos_fallidos' => 0 // Es importante inicializar esto en 0 para tu login
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }

    // Actualiza un usuario existente vía AJAX

    public function updateUser($id)
    {
        $data = $this->request->getJSON(true);

        if (!$this->usuarioModel->find($id)) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Usuario no encontrado.']);
        }

        $this->usuarioModel->update($id, [
            'nombre' => $data['nombre'],
            'user'   => $data['user'],     
            'correo' => $data['correo'],
            'dui'    => $data['dui'],  
            'rol'    => $data['rol'],
            'estado' => $data['estado'],
        ]);


        return $this->response->setJSON(['status' => 'ok']);
    }



}
