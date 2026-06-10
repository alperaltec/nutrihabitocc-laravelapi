<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Workspace extends Model
{
    protected $fillable = [
        'name',
        'is_active'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function clinicalHistory(): HasMany
    {
        return $this->hasMany(ClinicalHistory::class);
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'workspace_members')
            ->withPivot('member_role', 'is_active')
            ->withTimestamps();
    }

    public function planesNutricionales(): HasMany
    {
        return $this->hasMany(PlanNutricional::class);
    }

}
