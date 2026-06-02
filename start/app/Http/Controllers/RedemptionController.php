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

