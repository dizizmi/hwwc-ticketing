<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guest;

class LanyardType extends Model
{
    protected $fillable = [
        'name',
        'color',
        'description'
    ];

    public function guests() 
    {
        return $this->hasMany(Guest::class);
    }
}
