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
 * Class Producto
 * 
 * @property int $id_producto
 * @property string $codigo
 * @property string $nombre
 * @property float $precio
 * @property string $presentacion
 * @property string $unidad
 * @property int|null $id_empresa
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Empresa|null $empresa
 * @property Collection|Adjunto[] $adjuntos
 * @property Collection|Detalle[] $detalles
 * @property Collection|Categoria[] $categorias
 *
 * @package App\Models
 */
class Producto extends Model
{
	use SoftDeletes;
	protected $table = 'productos';
	protected $primaryKey = 'id_producto';

	protected $casts = [
		'precio' => 'float',
		'id_empresa' => 'int'
	];

	protected $fillable = [
		'codigo',
		'nombre',
		'precio',
		'presentacion',
		'unidad',
		'id_empresa'
	];

	public function empresa()
	{
		return $this->belongsTo(Empresa::class, 'id_empresa');
	}

	public function adjuntos()
	{
		return $this->hasMany(Adjunto::class, 'id_producto');
	}

	public function detalles()
	{
		return $this->hasMany(Detalle::class, 'id_producto');
	}

	public function categorias()
	{
		return $this->belongsToMany(Categoria::class, 'productos_categorias', 'id_producto', 'id_categoria')
					->withPivot('deleted_at')
					->withTimestamps();
	}
}
