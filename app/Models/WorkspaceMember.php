<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkspaceMember extends Model
{
    protected $fillable = [
        'member_role',
        'user_id',
        'workspace_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
