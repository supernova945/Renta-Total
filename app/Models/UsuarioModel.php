<?php namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class UsuarioModel extends Model
{
    use ActivityLoggable;   

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table = 'usuario';
    protected $primaryKey = 'idusuario';
    protected $allowedFields = ['nombre', 'user', 'password', 'correo', 'estado', 'rol', 'dui', 'intentos_fallidos'];
    protected $useTimestamps = true;
}
