<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftItem extends Model
{
    protected $fillable = [
        'name',
        'size',
        'quantity',
        'redeemed'
    ];

    #method declaration
    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    
}
