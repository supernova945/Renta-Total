<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verificar si el usuario está autenticado
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Si no se pasan argumentos, permitir acceso
        if (empty($arguments)) {
            return;
        }

        $userRole = session()->get('rol');

        // Verificar si el rol del usuario está en la lista de roles permitidos
        if (!in_array($userRole, $arguments)) {
            $requiredRoles = implode(', ', array_map(function($role) {
                return ucfirst(strtolower($role));
            }, $arguments));

            session()->setFlashdata('error', 'Acceso denegado. Esta sección requiere uno de los siguientes roles: ' . $requiredRoles . '. Tu rol actual es: ' . ucfirst(strtolower($userRole)) . '.');
            return redirect()->to('/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita hacer nada después de la petición
    }
}
