<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'whatsapp',
        'email',
        'notes',
        'source',
        'status',
        'advisor_id'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
}
