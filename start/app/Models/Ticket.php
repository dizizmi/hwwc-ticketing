<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Guest;
use App\Models\Redemption;

class Ticket extends Model

{
    use HasFactory; 

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
