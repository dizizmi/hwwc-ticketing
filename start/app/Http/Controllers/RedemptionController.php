        $request->validate([
            'ticket_code' => 'required|string',
            'gift_item_id' => 'required|exists:gift_items,id',
        ]);

        $ticket = Ticket::with('guest')
            ->where('ticket_code', $request->ticket_code)
            ->first();

        //check ticket exist and active
        if (!$ticket || !$ticket->is_active) {
            return response()->json([
                'message' => 'Invalid or inactive ticket'
            ], 404);
        }

        //check if guest already redeemed this specific gift
        $alreadyRedeemed = Redemption::where('ticket_id', $ticket->id)
            ->where('gift_item_id', $request->gift_item_id)
            ->exists();

        if ($alreadyRedeemed) {
            return response()->json([
                'message' => 'Guest has already redeemed this gift'
            ], 409);
        }
        //preventing race conditions, lock in db transaction
        $redemption = DB::transaction(function () use ($ticket, $request){
            $giftItem = GiftItem::lockForUpdate()->find($request->gift_item_id);

            //check inventory
            if ($giftItem->redeemed >= $giftItem->quantity){
                throw new \Exception('Gift item no more');
            }

            //create redemption record
            $redemption = Redemption::create([
                'ticket_id' => $ticket->id,
                'gift_item_id' => $giftItem->id,
                'user_id' => Auth::id(),
                'redeemed_at' => now(),
            ]);

            //decrement inventory
            $giftItem-> increment('redeemed');

            //clear relevant caches
            Cache::forget("ticket_{$ticket->ticket_code}");
            Cache::forget('gift_items_all');
            
            return $redemption;
        
            });
        
        return response()->json([
            'message' => 'Gift redeemed successfully',
            'redemption' => $redemption->load(['ticket.guest', 'giftItem']),
        ], 201);
    
        }
    public function history(string $code)
    {
        $ticket = Ticket::with(['redemptions.giftItem', 'guest'])
            ->where('ticket_code', $code)
            ->first();
        if (!$ticket) {
            return response()->json(['message' => 'Ticket no found'], 404);
        }
        return response()->json([
            'guest' => $ticket->guest,
            'redemptions' => $ticket->redemptions,
        ]);
    }
    //all redemptions (for report tab)
    public function allRedemptions()
    {
        $redemptions = Redemption::with(['ticket.guest', 'giftItem', 'user'])
            ->latest()
            ->get();

        return response()->json($redemptions);
    } 

