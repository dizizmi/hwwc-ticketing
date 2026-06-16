class ReportController extends Controller
{
    //full redemption summary - guests, checked in, total redemption, list of gift items
    public function summary()
    {   
        $totalGuests = Guest::count();
        $checkedIn = Guest::where('checked_in', true)->count();
        $totalRedemptions = Redemption::count();
        $giftItems = GiftItem::all()->map(function ($item) {
            return [
                'name' => $item->name,
                'size' => $item->size,
                'quantity' => $item->quantity,
                'redeemed' => $item->redeemed,
                'remaining' => $item->quantity - $item->redeemed,
            ];
        });

    return response()->json([
        'total_guests' => $totalGuests,
        'checked_in' =>$checkedIn,
        'not_checked_in' => $totalGuests - $checkedIn,
        'total_redemptionss' => $totalRedemptions,
        'inventory_summary' => $giftItems,
    ]);
    }

    //filter history redemptions
    public function redemptions(Request $request)
    {
        $query = Redemption::with(['ticket.guest', 'giftItem', 'user'])
            ->latest();
            

        //filer by gift item
        if ($request->has('gift_item_id')) {
            $query->where('gift_item_id', $request->gift_item_id);
        }

        //filter by date
        if ($request->has('date')) {
            $query->whereDate('redeemed_at', $request->date);
        }

        return response()->json($query->get());
    }

