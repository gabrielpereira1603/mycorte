<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSchedule extends Model
{
    use HasFactory;

    protected $table = 'status_schedule';

    protected $fillable = [
        'status',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'statusSchedulefk');
    }
}
