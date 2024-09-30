<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Adjunto
 * 
 * @property int $id_adjunto
 * @property string $uri
 * @property string $descripcion
 * @property string|null $mime_type  // Nuevo campo mime_type
 * @property int $id_producto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Producto $producto
 *
 * @package App\Models
 */
class Adjunto extends Model
{
	protected $table = 'producto_adjuntos';
	protected $primaryKey = 'id_adjunto';

	// Definir los tipos de datos
	protected $casts = [
		'id_producto' => 'int',
	];

	// Definir los atributos asignables
	protected $fillable = [
		'uri',
		'descripcion',
		'mime_type',  // Incluir mime_type
		'id_producto'
	];

	// Relación con Producto
	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}
}
