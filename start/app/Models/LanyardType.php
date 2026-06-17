<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Guest;

class LanyardType extends Model
{
    use HasFactory;
     
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
