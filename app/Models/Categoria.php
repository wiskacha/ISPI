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
 * Class Categoria
 * 
 * @property int $id_categoria
 * @property string $nombre
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Producto[] $productos
 *
 * @package App\Models
 */
class Categoria extends Model
{
	use SoftDeletes;
	protected $table = 'categorias';
	protected $primaryKey = 'id_categoria';

	protected $fillable = [
		'nombre'
	];

	public function productos()
	{
		return $this->belongsToMany(Producto::class, 'productos_categorias', 'id_categoria', 'id_producto')
					->withPivot('deleted_at')
					->withTimestamps();
	}
}
