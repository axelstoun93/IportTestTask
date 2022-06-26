<?php

namespace App\Models;

use Hemp\Presenter\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $product_code
 * @property string $name
 * @property array $images
 * @property float $price
 * @property float $original_price
 * @property string $state
 * @property string $serial_number
 * @property string $stock
 * @property string $active
 */

class Product extends Model
{
    use HasFactory,Presentable;

    const ACTIVE_ON = 'yes';
    const ACTIVE_OFF = 'no';

    protected $table = 'products';

    protected $casts = [
        'images' => 'json'
    ];

    protected $fillable = [
        'product_code',
        'name',
        'images',
        'price',
        'original_price',
        'state',
        'serial_number',
        'stock',
        'active',
        'created_at',
        'updated_at'
    ];

    public function scopeGetActiveProduct($query){
        return $query->where('active','=',$this::ACTIVE_ON)->count();
    }

    public function scopeGetProducts($query,object $filterParams){
        $sql = $query;

        if($filterParams->active){
            $sql->where('active','=',$this::ACTIVE_ON);
        }else{
            $sql->where('active','=',$this::ACTIVE_OFF);
        }

        return $sql;
    }

}
