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

        $guest = Guest::create($request->all());

        

    }
}
