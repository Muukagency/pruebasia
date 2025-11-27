<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'advisor_id',
        'scheduled_date',
        'scheduled_time',
        'channel',
        'status'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
