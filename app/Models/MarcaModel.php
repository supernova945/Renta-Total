<?php namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class MarcaModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    // Asegúrate de que el nombre de la tabla coincida exactamente con tu DB
    // Según tu descripción, la tabla se llama 'marca' (en minúsculas), no 'marcas'
    protected $table      = 'marca';

    // Tu clave primaria es 'idmarca', no 'id'
    protected $primaryKey = 'idmarca';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array'; // O 'object' si prefieres objetos
    protected $useSoftDeletes = false; // Ajusta según si usas soft deletes para marcas

    // Listado de campos permitidos para inserción/actualización
    // Asegúrate de que todos los campos de tu tabla (incluyendo los nuevos) estén aquí
    protected $allowedFields = [
        'marca',        // Nombre del campo 'marca' en tu DB
        'responsable',
        'celular',
        'fecha_creacion',
        'creado_por',
        'fecha_modificacion',
        'modificado_por'
    ];

    // Configuración de Timestamps:
    // Habilita el uso de campos de tiempos para creación y modificación
    protected $useTimestamps = true;
    protected $createdField  = 'fecha_creacion';
    protected $updatedField  = 'fecha_modificacion';

    // Reglas de validación para el campo 'marca' (nombre de la marca)
    protected $validationRules    = [
        'marca' => 'required|min_length[2]|max_length[60]|is_unique[marca.marca,idmarca,{idmarca}]', // Usar 'marca.marca' para la tabla y columna
        'responsable' => 'permit_empty|max_length[100]',
        'celular' => 'permit_empty|max_length[9]',
        'creado_por' => 'permit_empty|integer',
        'modificado_por' => 'permit_empty|integer'
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false; 
}
