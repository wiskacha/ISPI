<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Producto
 * 
 * @property int $id_producto
 * @property string $codigo
 * @property string $nombre
 * @property float $precio
 * @property string $presentacion
 * @property string $unidad
 * @property int|null $id_empresa
 * @property array|null $tags  // Nuevo campo JSON
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Empresa|null $empresa
 * @property Collection|Adjunto[] $adjuntos
 * @property Collection|Detalle[] $detalles
 *
 * @package App\Models
 */
class Producto extends Model
{
    use SoftDeletes;
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    // Definir los tipos de datos
    protected $casts = [
        'precio' => 'float',
        'id_empresa' => 'int',
        'tags' => 'array',  // Definir el campo tags como array
    ];

    // Definir los atributos asignables
    protected $fillable = [
        'codigo',
        'nombre',
        'precio',
        'presentacion',
        'unidad',
        'id_empresa',
        'tags'  // Incluir tags como parte de los fillables
    ];

    // Relación con Empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'id_empresa');
    }

    // Relación con Adjuntos
    public function adjuntos()
    {
        return $this->hasMany(Adjunto::class, 'id_producto');
    }

    // Relación con Detalles
    public function detalles()
    {
        return $this->hasMany(Detalle::class, 'id_producto');
    }
}
