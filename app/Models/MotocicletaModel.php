<?php namespace App\Models;
 
use CodeIgniter\Model;
use App\Traits\ActivityLoggable;

class MotocicletaModel extends Model
{
    use ActivityLoggable;

    public function __construct()
    {
        parent::__construct();
        $this->initializeActivityLog();
    }

    protected $table      = 'motos'; // Asegúrate que en tu BD la tabla se llame así
    protected $primaryKey = 'placa';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // --- AQUÍ ESTÁ EL CAMBIO IMPORTANTE ---
    protected $allowedFields = [
        'placa',         
        'idestado',
        'idcliente',     
        'chasis',
        'motor',         
        'idmarca',       
        'año',           
        'modelo',
        'color',
        'fecha_entrega',
        'fecha_renovacion',
        'Envio',
        'taller',
        'iddepartamento',
        'idagencia',
        'renta_siniva',
        'renta_coniva',
        'naf',
        'creado_por',     
        'modificado_por',
         
        // CAMPOS NUEVOS AGREGADOS PARA RENOVACIÓN/REPOSICIÓN
        'motivo_ingreso',
        'placa_anterior'
    ];
    
    protected $useTimestamps = false; // Veo que usas timestamps manuales en el controller, así que esto en false está bien.
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'placa'       => 'required|max_length[15]|is_unique[motos.placa]', 
        'idestado'    => 'required|integer',
        'idmarca'     => 'required|integer', 
        'modelo'      => 'required|min_length[2]|max_length[50]',
        'año'         => 'required|integer|exact_length[4]', 
        'chasis'      => 'required|max_length[50]|is_unique[motos.chasis]',
        'creado_por'  => 'required|integer', 
        'idagencia'   => 'permit_empty|integer',
        
        // No necesitamos agregar reglas estrictas aquí para motivo_ingreso 
        // porque el Controlador ya se encarga de esa lógica compleja.
    ];
    protected $validationMessages = [];
    protected $skipValidation = false;
}