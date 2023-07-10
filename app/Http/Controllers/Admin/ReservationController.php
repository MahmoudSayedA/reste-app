<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('table')->get();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tables = Table::where('status', TableStatus::Available)->get();

        return view('admin.reservations.create', compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationStoreRequest $request)
    {
        // Check if num of guests suitable for table capacity
        $table = Table::findOrFail($request->input('table_id'));
        $guests = $request->input('guest_num');
        if ($guests > $table->guest_num) {
            return back()->withInput()
                ->with('warning', "table [$table->name] can just hold $table->guest_num guest not $guests");
        }
        // Catch the pre resevation date
        if (!($this->checkReservationDate($request, $table))) {
            return back()->withInput()
                ->with('warning', "table[$table->name] is resrved at this date");
        }
        Reservation::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'table_id' => $request->input('table_id'),
            'guest_num' => $request->input('guest_num'),
            'reservation_date' => $request->input('reservation_date'),
        ]);

        return to_route('admin.reservations.index')->with('success', 'reservation added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $tables = Table::where('status', TableStatus::Available)->get();

        return view('admin.reservations.edit', compact('tables', 'reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationStoreRequest $request, Reservation $reservation)
    {
        // Check if num of guests suitable for table capacity
        $table = Table::findOrFail($request->input('table_id'));
        $guests = $request->input('guest_num');
        if ($guests > $table->guest_num) {
            return redirect()->back()->withInput()
                ->with('warning', "table [$table->name] can just hold $table->guest_num guest not $guests");
        }
        // Catch the pre resevation date
        if (!($this->checkReservationDate($request, $table))) {
            return back()->withInput()
                ->with('warning', "table[$table->name] is resrved at this date");
        }
        $reservation->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'guest_num' => $request->input('guest_num'),
            'table_id' => $request->input('table_id'),
            'reservation_date' => $request->input('reservation_date'),
        ]);

        return to_route('admin.reservations.index')->with('success', 'reservation updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->back()->with('danger', 'reservation deleted successfully');
    }
    /**
     * check if the reservation date is pre-reseved
     *
     * @param Request $request
     * @param Table $table
     * @return boolean
     */
    private function checkReservationDate($request, Table $table): bool
    {
        $period = RESERVATION_PERIOD;
        $res_date = Carbon::parse($request->input('reservation_date'));
        $end_res_date = $res_date->copy()->addMinutes($period);

        foreach ($table->reservations as $res) {
            // Catch the pre resevation date
            $prev_date = Carbon::parse($res->reservation_date);
            $end_prev_date = $prev_date->copy()->addMinutes($period);

            if (
                $res_date->format('Y-m-d') == $prev_date->format('Y-m-d') &&
                ($res_date->between($prev_date, $end_prev_date) ||
                    $end_res_date->between($prev_date, $end_prev_date))
            ) {
                return false;
            }
        }
        return true;
    }
}
