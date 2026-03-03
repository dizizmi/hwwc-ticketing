<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
