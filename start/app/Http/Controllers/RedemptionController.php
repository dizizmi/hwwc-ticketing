        //preventing race conditions, lock in db transaction
        $redemption = DB::transaction(function () use ($ticket, $request){
            $giftItem = GiftItem::lockForUpdate()->find($request->gift_item_id);

