<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotion';

    protected $fillable = [
        'name',
        'dataHourStart',
        'dataHourFinal',
        'value',
        'servicefk',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'servicefk');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyfk');
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'collaboratorfk');
    }


}
