<?php namespace App\Controllers;

use App\Models\UsuarioModel;

class Profile extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }

        // Obtener el ID del usuario desde la sesión
        $userId = $session->get('idUsuario');

        // Obtener los datos completos del usuario desde la base de datos
        $user = $this->usuarioModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        // Preparar los datos para la vista del perfil
        $data = [
            'title' => 'Mi Perfil',
            'user' => $user, // Datos completos del usuario desde BD
            'current_date' => date('d/m/Y')
        ];

        return view('profile', $data);
    }

    public function edit()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }

        // Obtener el ID del usuario desde la sesión (current user, not by parameter)
        $userId = $session->get('idUsuario');

        // Obtener los datos del usuario actual desde la base de datos
        $user = $this->usuarioModel->find($userId);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Usuario no encontrado.');
        }

        // Preparar los datos para la vista de edición del perfil
        $data = [
            'title' => 'Editar Mi Perfil',
            'user' => $user, // Datos del usuario actual desde BD
            'current_date' => date('d/m/Y')
        ];

        return view('profile', $data); // Return the same profile view with edit modal
    }

    public function update()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Usuario no autenticado'
            ])->setStatusCode(401);
        }

        $userId = $session->get('idUsuario');

        if (!$userId) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'ID de usuario no encontrado en la sesión'
            ])->setStatusCode(400);
        }

        // Get JSON input
        $json = $this->request->getJSON();
        if (!$json) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Datos JSON requeridos'
            ])->setStatusCode(400);
        }

        // Validación de los campos del formulario (same as Usuarios controller)
        $rules = [
            'nombre' => 'required|min_length[3]',
            'correo' => 'required|valid_email',
            'dui'    => 'required|regex_match[/^[0-9]{8}-[0-9]$/]',
        ];

        // Get data from JSON
        $data = [
            'nombre' => $json->nombre ?? '',
            'user' => $json->user ?? '',
            'correo' => $json->correo ?? '',
            'dui' => $json->dui ?? '',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Validate the data
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Datos de formulario inválidos: ' . implode(', ', $this->validator->getErrors())
            ])->setStatusCode(400);
        }

        try {
            // Update the user (same pattern as Usuarios controller)
            $updated = $this->usuarioModel->update($userId, $data);

            if ($updated) {
                // Update session data
                $session->set('nombre', $data['nombre']);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Perfil actualizado correctamente',
                    'data' => $data
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'error' => 'No se pudo actualizar el perfil'
                ])->setStatusCode(500);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'Error al actualizar el perfil: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function changePassword()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión primero.');
        }

        $userId = $session->get('idUsuario');

        if (!$userId) {
            return redirect()->to('/profile')->with('error', 'ID de usuario no encontrado.');
        }

        // Get current user data to verify current password (include Password field with capital P)
        $user = $this->usuarioModel->select('idUsuario, nombre, correo, dui, user, Password, created_at, updated_at, estado, rol')
                                   ->find($userId);

        if (!$user) {
            return redirect()->to('/profile')->with('error', 'Usuario no encontrado.');
        }

        // Get form data
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validate form data
        $rules = [
            'current_password' => 'required',
            // Aplicamos la política estricta a la nueva contraseña
            'new_password' => 'required|min_length[8]|regex_match[/(?=.*[A-Z])(?=.*[!@#$%^&*(),.?":{}|<>])/]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        $messages = [
            'current_password' => [
                'required' => 'La contraseña actual es requerida.'
            ],
            'new_password' => [
                'required' => 'La nueva contraseña es requerida.',
                'min_length' => 'La nueva contraseña debe tener al menos 8 caracteres.',
                'regex_match' => 'La nueva contraseña debe incluir al menos una letra MAYÚSCULA y un CARÁCTER ESPECIAL.'
            ],
            'confirm_password' => [
                'required' => 'La confirmación de contraseña es requerida.',
                'matches' => 'La confirmación de contraseña no coincide con la nueva contraseña.'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->to('/profile')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Verify current password
        if (!password_verify($currentPassword, $user['Password'])) {
            return redirect()->to('/profile')->withInput()->with('error', 'La contraseña actual es incorrecta.');
        }

        try {
            // Hash the new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Verify the hash was created successfully
            if (!$hashedPassword) {
                return redirect()->to('/profile')->with('error', 'Error al procesar la nueva contraseña.');
            }

            // Update password
            $data = [
                'Password' => $hashedPassword,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $updated = $this->usuarioModel->update($userId, $data);

            if ($updated) {
                // Verify the update worked by checking the database
                $updatedUser = $this->usuarioModel->select('Password')->find($userId);
                if ($updatedUser && password_verify($newPassword, $updatedUser['Password'])) {
                    return redirect()->to('/profile')->with('success', 'Contraseña actualizada correctamente.');
                } else {
                    return redirect()->to('/profile')->with('error', 'Contraseña no se pudo verificar después de la actualización.');
                }
            } else {
                return redirect()->to('/profile')->with('error', 'No se pudo actualizar la contraseña.');
            }
        } catch (\Exception $e) {
            return redirect()->to('/profile')->with('error', 'Error al actualizar la contraseña: ' . $e->getMessage());
        }
    }
}
