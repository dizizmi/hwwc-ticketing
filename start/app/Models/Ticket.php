<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guest;
use App\Models\Redemption;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_code',
        'guest_id',
        'is_active'

    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }
}
