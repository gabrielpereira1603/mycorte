<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Collaborator extends Authenticatable
{
    use HasFactory;

    protected $table = 'collaborator';

    protected $fillable = [
        'email',
        'enabled',
        'image',
        'name',
        'password',
        'role',
        'telephone',
        'resetPasswordToken',
        'companyfk',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyfk');
    }

    public function service(): HasMany
    {
        return $this->hasMany(Service::class, 'collaboratorfk', 'id');
    }

    public function enabledServices(): HasMany
    {
        return $this->hasMany(Service::class, 'collaboratorfk', 'id')->where('enabled', true);
    }

    public function promotion(): HasMany
    {
        return $this->hasMany(Promotion::class, 'collaboratorfk');
    }
}
