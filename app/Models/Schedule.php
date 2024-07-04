<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = [
        'date',
        'hourStart',
        'hourFinal',
        'reminderEmailSent',
        'clientfk',
        'collaboratorfk',
        'statusSchedulefk',
        'companyfk',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
