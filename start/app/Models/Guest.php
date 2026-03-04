<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LanyardType;

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

    public function lanyard_type() 
    {
        return $this->belongsTo(LanyardType::class);   
    }


}   
