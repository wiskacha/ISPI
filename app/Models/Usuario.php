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
 * Class Usuario
 * 
 * @property int $id_usuario
 * @property string $nick
 * @property string $pass
 * @property string|null $remember_token
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Persona $persona
 * @property Collection|Movimiento[] $movimientos
 * @property Collection|Sesione[] $sesiones
 *
 * @package App\Models
 */
class Usuario extends Model
{
	use SoftDeletes;
	protected $table = 'usuarios';
	protected $primaryKey = 'id_usuario';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'remember_token'
	];

	protected $fillable = [
		'nick',
		'pass',
		'remember_token',
		'email',
		'email_verified_at'
	];

	public function persona()
	{
		return $this->belongsTo(Persona::class, 'id_usuario');
	}

	public function movimientos()
	{
		return $this->hasMany(Movimiento::class, 'id_operador');
	}

	public function sesiones()
	{
		return $this->hasMany(Sesione::class, 'id_usuario');
	}
}
