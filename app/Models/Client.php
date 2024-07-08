<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory;

    protected $table = 'client';

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'image',
        'role'
    ];
}
