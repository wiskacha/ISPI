<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Detalle
 * 
 * @property int $id_detalle
 * @property int $cantidad
 * @property float $precio
 * @property float $total
 * @property int $id_movimiento
 * @property int $id_producto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Movimiento $movimiento
 * @property Producto $producto
 *
 * @package App\Models
 */
class Detalle extends Model
{
	use SoftDeletes;
	protected $table = 'detalles';
	protected $primaryKey = 'id_detalle';

	protected $casts = [
		'cantidad' => 'int',
		'precio' => 'float',
		'total' => 'float',
		'id_movimiento' => 'int',
		'id_producto' => 'int'
	];

	protected $fillable = [
		'cantidad',
		'precio',
		'total',
		'id_movimiento',
		'id_producto'
	];

	public function movimiento()
	{
		return $this->belongsTo(Movimiento::class, 'id_movimiento');
	}

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}
}
