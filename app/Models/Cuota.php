<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cuota
 * 
 * @property int $id_cuota
 * @property int $numero
 * @property string $codigo
 * @property string $concepto
 * @property Carbon $fecha_venc
 * @property float $monto_pagar
 * @property float $monto_pagado
 * @property float $monto_adeudado
 * @property string $condicion
 * @property int $id_movimiento
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Movimiento $movimiento
 *
 * @package App\Models
 */
class Cuota extends Model
{
	protected $table = 'cuotas';
	protected $primaryKey = 'id_cuota';

	protected $casts = [
		'numero' => 'int',
		'fecha_venc' => 'datetime',
		'monto_pagar' => 'float',
		'monto_pagado' => 'float',
		'monto_adeudado' => 'float',
		'id_movimiento' => 'int'
	];

	protected $fillable = [
		'numero',
		'codigo',
		'concepto',
		'fecha_venc',
		'monto_pagar',
		'monto_pagado',
		'monto_adeudado',
		'condicion',
		'id_movimiento'
	];

	public function movimiento()
	{
		return $this->belongsTo(Movimiento::class, 'id_movimiento');
	}
}
