class InventoryController extends Controller
{   //view all gift item and stock levels
    public function index()
    {
        $items = GiftItem::all()->map(function ($item) {
            return [
                'id'        => $item->id,
                'name'      => $item->name,
                'size'      => $item->size,
                'quantity'  => $item->quantity,
                'redeemed'  => $item->redeemed,
                'remaining' => $item->quantity - $item->redeemed,
                'status'    => ($item->quantity - $item->redeemed) === 0
                                ? 'out of stock'
                                : (($item->quantity - $item->redeemed) <= 5
                                ? 'low stock'
                                : 'available'),
            ];
        });

        return response()->json($items);
    }
