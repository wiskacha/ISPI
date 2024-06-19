<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductosCategoria
 * 
 * @property int $id_producto
 * @property int $id_categoria
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Producto $producto
 * @property Categoria $categoria
 *
 * @package App\Models
 */
class ProductosCategoria extends Model
{
	use SoftDeletes;
	protected $table = 'productos_categorias';
	public $incrementing = false;

	protected $casts = [
		'id_producto' => 'int',
		'id_categoria' => 'int'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}

	public function categoria()
	{
		return $this->belongsTo(Categoria::class, 'id_categoria');
	}
}
