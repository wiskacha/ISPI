<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sesione
 * 
 * @property int $id_sesion
 * @property int $id_usuario
 * @property string|null $direc_ip
 * @property string|null $medio
 * @property string $payload
 * @property int $last_activity
 * 
 * @property Usuario $usuario
 *
 * @package App\Models
 */
class Sesione extends Model
{
	protected $table = 'sesiones';
	protected $primaryKey = 'id_sesion';
	public $timestamps = false;

	protected $casts = [
		'id_usuario' => 'int',
		'last_activity' => 'int'
	];

	protected $fillable = [
		'id_usuario',
		'direc_ip',
		'medio',
		'payload',
		'last_activity'
	];

	public function usuario()
	{
		return $this->belongsTo(Usuario::class, 'id_usuario');
	}
}
