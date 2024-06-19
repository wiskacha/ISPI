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
 * Class Almacene
 * 
 * @property int $id_almacen
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Movimiento[] $movimientos
 *
 * @package App\Models
 */
class Almacene extends Model
{
	use SoftDeletes;
	protected $table = 'almacenes';
	protected $primaryKey = 'id_almacen';

	protected $fillable = [
		'nombre'
	];

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'id_almacen');
	}
}
