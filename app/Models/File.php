<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $sort
 * @property string $mime_type
 */
class File extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'path',
        'sort',
        'mime_type',
    ];
}
