<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Ubicacione
 * 
 * @property int $id_ubicacion
 * @property string $direccion
 * @property int|null $telefono
 * @property string $tipo
 * @property string|null $nota
 * @property int $id_persona
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Persona $persona
 *
 * @package App\Models
 */
class Ubicacione extends Model
{
	use SoftDeletes;
	protected $table = 'ubicaciones';
	protected $primaryKey = 'id_ubicacion';

	protected $casts = [
		'telefono' => 'int',
		'id_persona' => 'int'
	];

	protected $fillable = [
		'direccion',
		'telefono',
		'tipo',
		'nota',
		'id_persona'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'id_persona');
	}
}
