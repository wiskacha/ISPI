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
 * Class Recinto
 * 
 * @property int $id_recinto
 * @property string $nombre
 * @property string $direccion
 * @property string $tipo
 * @property int $telefono
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Movimiento[] $movimientos
 *
 * @package App\Models
 */
class Recinto extends Model
{
	use SoftDeletes;
	protected $table = 'recintos';
	protected $primaryKey = 'id_recinto';

	protected $casts = [
		'telefono' => 'int'
	];

	protected $fillable = [
		'nombre',
		'direccion',
		'tipo',
		'telefono'
	];

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'id_recinto');
	}
}
