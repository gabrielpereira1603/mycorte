<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Style extends Model
{
    use HasFactory;

    protected $table = 'style';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'companyfk', 'id');
    }
}
