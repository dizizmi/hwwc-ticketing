<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'lanyard_type_id',
        'checked_in',
        'check_in_at'

    ];

    public function lanyard_types() 
    {
        return $this->belongsTo(LanyardType::class);   
    }

    
}   
