<?php namespace App\Models;

use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class EstadoModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table      = 'estado';
    protected $primaryKey = 'idestado';

    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Incluye el campo 'estado' 
    protected $allowedFields = [
        'estado'
    ];

    // Deshabilita el uso de timestamps automáticos
    protected $useTimestamps = false;

    protected $validationRules    = [
        // Validar campo estado
        'estado' => 'required|min_length[2]|max_length[100]|is_unique[estado.estado,idestado,{idestado}]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
