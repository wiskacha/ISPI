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
 * Class Empresa
 * 
 * @property int $id_empresa
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Contacto[] $contactos
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Empresa extends Model
{
	use SoftDeletes;
	protected $table = 'empresas';
	protected $primaryKey = 'id_empresa';

	protected $fillable = [
		'nombre',
	];

	public function contactos()
	{
		return $this->hasMany(Contacto::class, 'id_empresa');
	}

	public function productos()
	{
		return $this->hasMany(Producto::class, 'id_empresa');
	}
}
