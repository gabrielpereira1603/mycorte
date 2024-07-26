<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    public function style()
    {
        return $this->hasOne(Style::class, 'companyfk');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'companyfk');
    }

}
