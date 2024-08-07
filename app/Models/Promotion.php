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
        'enabled',
        'type',
        'companyfk',
        'collaboratorfk',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_promotion', 'promotion_id', 'service_id');
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
