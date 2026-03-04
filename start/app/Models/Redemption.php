<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\GiftItem;
use App\Models\User;


class Redemption extends Model
{
    protected $fillable = [
        'ticket_id',
        'gift_item_id',
        'user_id',
        'redeemed_at'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function gift_item()
    {
        return $this->belongsTo(GiftItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
