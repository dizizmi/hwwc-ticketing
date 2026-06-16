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

