<?php

namespace App\Models;
namespace App\Http\Controllers;

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

    public function redeem(Request $request)
    {   
        $request->validate([
            'ticket_code' => 'required|string',
            'gift_item_id' => 'required|exists:gift_items,id'

        ]);

        $ticket = Ticket::with('guest')
            ->where('ticket_code', $request->ticket_code)
            ->first();
        
        //check if ticket exists
        if (!$ticket || !$ticket->is_active) {
            return response()->json([
                'message' => 'Invalid or inactive ticket'
            ], 404);
        };

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
