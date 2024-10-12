<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Movimiento
 * 
 * @property int $id_movimiento
 * @property string $codigo
 * @property Carbon $fecha
 * @property Carbon $fecha_f
 * @property string|null $glose
 * @property string $tipo
 * @property int|null $id_cliente
 * @property int|null $id_recinto
 * @property int|null $id_proveedor
 * @property int $id_operador
 * @property int $id_almacen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Almacene $almacene
 * @property Persona|null $persona
 * @property Usuario $usuario
 * @property Recinto|null $recinto
 * @property Collection|Cuota[] $cuotas
 * @property Collection|Detalle[] $detalles
 *
 * @package App\Models
 */
class Movimiento extends Model
{
	use SoftDeletes;
	protected $table = 'movimientos';
	protected $primaryKey = 'id_movimiento';

	protected $casts = [
		'fecha' => 'datetime',
		'fecha_f' => 'datetime',
		'id_cliente' => 'int',
		'id_recinto' => 'int',
		'id_proveedor' => 'int',
		'id_operador' => 'int',
		'id_almacen' => 'int'
	];

	protected $fillable = [
		'codigo',
		'fecha',
		'fecha_f',
		'glose',
		'tipo',
		'id_cliente',
		'id_recinto',
		'id_proveedor',
		'id_operador',
		'id_almacen'
	];

	public function almacene()
	{
		return $this->belongsTo(Almacene::class, 'id_almacen');
	}

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'id_proveedor');
	}

	public function cliente()
	{
		return $this->belongsTo(Persona::class, 'id_cliente');
	}

	public function usuario()
	{
		return $this->belongsTo(User::class, 'id_operador');
	}

	public function recinto()
	{
		return $this->belongsTo(Recinto::class, 'id_recinto');
	}

	public function cuotas()
	{
		return $this->hasMany(Cuota::class, 'id_movimiento');
	}

	public function detalles()
	{
		return $this->hasMany(Detalle::class, 'id_movimiento');
	}
}
