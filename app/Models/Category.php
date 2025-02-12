<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read Collection|Product[] $products
 */
class Category extends Model
{
    use HasTranslations;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    public array $translatable = [
        'name',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
