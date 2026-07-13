<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Redemption;

class GiftItem extends Model
{
    //add soft delete function
    use SoftDeletes;

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

    //helper to check remainders stock
    public function remainingStock(): int
    {
        return $this->quantity - $this->redeemed;
    }

    public function isAvailable(): bool
    {
        return $this->remainingStock() > 0;
    }


}
