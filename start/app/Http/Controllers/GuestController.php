<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illumiunate\Support\Facades\Cache;

/* so guest we will  
1. register, 
2. create ticket code, 
3. look up their code when typed out, 
4. then they can check in 
*/

class GuestController extends Controller
{   
    //list all guest
    public function index(){
        $guests = Guest::with('lanyardType')->get();

        return response()->json($guests);
    }


    //register
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:guests',
            'phone' => 'nullable|string',
            'lanyard_type_id' => 'required|exists:lanyard_types,id',
        ]);

        //ticket code for new user
        //note a random 10 upper case code is generated for every new created & requested guest
        $guest = Guest::create($request->all());

        $ticket = Ticket::create([
            'ticket_code' => strtoupper(Str::random(10)),
            'guest_id' => $guest->id,
            'is_active' => true,
        ]);
    }

    public function findByTicket(string $code)
    {
        $ticket = Ticket::with(['guest.lanyardType', 'redemptions.giftItem'])
            ->where('ticket_code', $code);
        
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        return response()->json($ticket);
    }

}
