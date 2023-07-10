<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Reservation;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $specials = Category::with('menus')->first();
        return view('welcome', compact('specials'));
    }
    public function thankyou(Reservation $reservation)
    {
        if ($reservation == null)
            return to_route('reservations.step.one');

        return view('thankyou', compact('reservation'));
    }
}
