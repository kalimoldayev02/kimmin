<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'path',
        'mime_type',
    ];
}
