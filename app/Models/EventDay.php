<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventDay extends Model
{
    use HasFactory;

    protected $fillable = ['event_id'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'id', 'event_id');
    }
}
