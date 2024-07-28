<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $fillable = ['name', 'time', 'value', 'enabled', 'collaboratorfk'];


    public function schedules()
    {
        return $this->belongsToMany(Schedule::class);
    }
}
