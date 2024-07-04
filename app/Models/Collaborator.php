<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Collaborator extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'email', 'enabled', 'image', 'name', 'password', 'role', 'telephone', 'companyfk'
    ];

    protected $table = 'collaborator';


    public function service(): HasMany
    {
        return $this->hasMany(Service::class, 'collaboratorfk', 'id');
    }
}
