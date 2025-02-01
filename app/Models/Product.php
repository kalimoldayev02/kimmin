<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $price
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property-read Collection|Category[] $categories
 * @property-read Collection|File[] $files
 */
class Product extends Model
{
    use HasTranslations;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
        'description',
        'price',
    ];

    public array $translatable = [
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
        ];
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function files(): BelongsToMany
    {
        return $this->belongsToMany(File::class, 'product_file');
    }
}
