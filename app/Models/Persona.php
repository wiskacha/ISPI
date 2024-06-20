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
 * Class Persona
 * 
 * @property int $id_persona
 * @property string $nombre
 * @property string $papellido
 * @property string $sapellido
 * @property string $carnet
 * @property int $celular
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Contacto[] $contactos
 * @property Collection|Movimiento[] $movimientos
 * @property Collection|Ubicacione[] $ubicaciones
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class Persona extends Model
{
	use SoftDeletes;
	protected $table = 'personas';
	protected $primaryKey = 'id_persona';

	protected $casts = [
		'celular' => 'int'
	];

	protected $fillable = [
		'nombre',
		'papellido',
		'sapellido',
		'carnet',
		'celular'
	];

	public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = ucwords(strtolower($value));
    }

    public function setPapellidoAttribute($value)
    {
        $this->attributes['papellido'] = ucwords(strtolower($value));
    }

	public function contactos()
	{
		return $this->hasMany(Contacto::class, 'id_persona');
	}

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'id_proveedor');
	}

	public function ubicaciones()
	{
		return $this->hasMany(Ubicacione::class, 'id_persona');
	}

	public function usuario()
	{
		return $this->hasOne(User::class, 'id');
	}
}
