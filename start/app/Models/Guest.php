<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LanyardType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'lanyard_type_id',
        'checked_in',
        'check_in_at'

    ];

    public function lanyardType() 
    {
        return $this->belongsTo(LanyardType::class);   
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}   
