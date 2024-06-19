<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Adjunto
 * 
 * @property int $id_adjunto
 * @property string $uri
 * @property string $descripcion
 * @property int $id_producto
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * 
 * @property Producto $producto
 *
 * @package App\Models
 */
class Adjunto extends Model
{
	use SoftDeletes;
	protected $table = 'adjuntos';
	protected $primaryKey = 'id_adjunto';

	protected $casts = [
		'id_producto' => 'int'
	];

	protected $fillable = [
		'uri',
		'descripcion',
		'id_producto'
	];

	public function producto()
	{
		return $this->belongsTo(Producto::class, 'id_producto');
	}
}
