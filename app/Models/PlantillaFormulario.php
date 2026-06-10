<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaFormulario extends Model
{
    protected $fillable = [
        'name',
        'content_data',
        'version',
    ];

    protected $hidden = [
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'content_data' => 'array',
        ];
    }
}
