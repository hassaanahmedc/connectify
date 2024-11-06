<?php

namespace App\Models;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    public function tokenable(): BelongsTo
    {
        return $this->morphTo();
    }
}
