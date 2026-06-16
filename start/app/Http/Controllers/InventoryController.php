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
    //add new gift
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'size'     => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = GiftItem::create([
            'name'     => $request->name,
            'size'     => $request->size,
            'quantity' => $request->quantity,
            'redeemed' => 0,
        ]);

        return response()->json([
            'message' => 'Gift item added successfully',
            'item'    => $item,
        ], 201);
    }
    //update stock qty
    public function update(Request $request, int $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = GiftItem::findOrFail($id);
        $item->update(['quantity' => $request->quantity]);

        return response()->json([
            'message' => 'Inventory updated successfully',
            'item'    => $item,
        ]);
    }
