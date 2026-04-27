<?php 

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Database\Exceptions\DataException;

class Auth extends BaseController
{
    // Muestra el formulario de inicio de sesión
    public function loginForm()
    {    
        $session = session();
        $logoutMessage = $this->request->getCookie('logout_message');

        if ($logoutMessage) {
            $session->setFlashdata('message', $logoutMessage);
        }

        return view('login');
    }

    // Maneja el inicio de sesión del usuario
    public function doLogin()
    {
        helper('form');
        $session = session();
        $usuarioModel = new UsuarioModel();

        // 1. Reglas de Validación de entrada
        $rules = [
            'usuario'  => 'required|alpha_dash|min_length[4]',
            'password' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim($this->request->getVar('usuario'));
        $password = trim($this->request->getVar('password'));

        // 2. Buscar al usuario
        $user = $usuarioModel->where('user', $username)->first();

        if ($user) {
            // 3. VERIFICACIÓN DE ESTADO (0 = inactivo)
            // Usamos (int) para asegurar que comparamos números correctamente
            if ((int)$user['estado'] === 0) {
                return redirect()->back()->with('error', 'Esta cuenta está bloqueada. Contacta al administrador.');
            }

            // 4. Verificar la contraseña
            if (password_verify($password, $user['password'])) {
                
                // LOGIN EXITOSO: Resetear intentos
                if ($user['intentos_fallidos'] > 0) {
                    $usuarioModel->update($user['idUsuario'], ['intentos_fallidos' => 0]);
                }

                // Establecer datos de sesión
                $session->set([
                    'idUsuario'   => $user['idusuario'],
                    'nombre'      => $user['nombre'],
                    'rol'         => $user['rol'],
                    'isLoggedIn'  => true
                ]);

                return redirect()->to($user['rol'] === 'admin' ? '/dashboarda' : '/dashboard');        

            } else {
                // LOGIN FALLIDO: Incrementar contador
                $nuevosIntentos = $user['intentos_fallidos'] + 1;
                $updateData = ['intentos_fallidos' => $nuevosIntentos];

                // Si llega al límite de 4 intentos, cambiar estado a 0 (inactivo)
                if ($nuevosIntentos >= 4) {
                    $updateData['estado'] = 0; // Guardamos 0 para inactivo
                    $usuarioModel->update($user['idUsuario'], $updateData);
                    return redirect()->back()->with('error', 'Has fallado 4 intentos. Tu cuenta ha sido desactivada por seguridad.');
                }

                $usuarioModel->update($user['idusuario'], $updateData);
                $restantes = 4 - $nuevosIntentos;
                
                return redirect()->back()->with('error', "Contraseña incorrecta. Te quedan $restantes intentos.");
            }
        }

        return redirect()->back()->with('error', 'Usuario o contraseña inválidos.');    
    }

    public function logout()
    {
        $response = service('response');
        session()->destroy();
        $response->setCookie('logout_message', 'Sesión cerrada correctamente.', 10);
        return $response->redirect(base_url('/login'));
    }
}