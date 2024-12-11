<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervalCollaborator extends Model
{
    use HasFactory;

    protected $table = 'interval_collaborator';

    protected $fillable = [
        'reason',
        'hourStart',
        'hourFinal',
        'date',
        'collaboratorfk',
    ];

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'collaboratorfk');
    }
}
