<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PersonalToken extends Model
{
    use HasFactory;

    protected $table = 'personal_access_tokens';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tokenable_id', 'us_codigo');
    }

    // ...  
}
