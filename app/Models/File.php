<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $sort
 * @property string $mime_type
 * @property-read Collection|Product[] $products
 */
class File extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'path',
        'mime_type',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'file_product', 'file_id', 'product_id');
    }
}
