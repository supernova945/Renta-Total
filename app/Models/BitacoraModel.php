<?php

namespace App\Models;

use CodeIgniter\Model;

class BitacoraModel extends Model
{
    protected $table            = 'motocicleta_bitacora';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['placa', 'comentario', 'idUsuario'];

    // Activamos las fechas automáticas
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Deshabilitado porque es bitácora
    protected $deletedField  = ''; // Deshabilitado

    // REGLAS DE SEGURIDAD: Bloqueamos edición y borrado desde el modelo
    public function update($id = null, $data = null): bool
    {
        return false; 
    }

    public function delete($id = null, bool $purge = false)
    {
        return false; 
    }

    /**
     * Obtiene los comentarios uniendo con la tabla de usuarios
     * para saber quién escribió cada nota.
     */
    public function getComentariosPorPlaca($placa)
    {
        // Seleccionamos los datos de la bitácora y el nombre del usuario
        return $this->select('motocicleta_bitacora.*, usuario.nombre as nombre_usuario, usuario.user as user_usuario')
                    ->join('usuario', 'usuario.idusuario = motocicleta_bitacora.idusuario')
                    ->where('motocicleta_bitacora.placa', $placa)
                    ->orderBy('motocicleta_bitacora.created_at', 'DESC')
                    ->findAll();
    }
}