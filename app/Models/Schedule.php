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

    public function client()
    {
        return $this->belongsTo(Client::class, 'clientfk');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function collaborator()
    {
        return $this->belongsTo(Collaborator::class, 'collaboratorfk');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'companyfk');
    }

    public function statusSchedule()
    {
        return $this->belongsTo(StatusSchedule::class, 'statusSchedulefk');
    }

}
