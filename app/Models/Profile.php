<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'height',
        'weight',
        'birth_date',
        'gender',
        'grasa_corporal',
        'masa_muscular',
        'user_id',
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'height' => 'double',
        'weight' => 'double',
        'grasa_corporal' => 'double',
        'masa_muscular' => 'double',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
