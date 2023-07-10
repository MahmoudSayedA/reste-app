<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use App\Rules\WorkHoursRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * step one of reservation
     */
    public function stepOne(Request $request)
    {
        $reservation = $request->session()->get('reservation');
        $min_date = Carbon::now()->format('Y-m-d\TH:i');
        $max_date = Carbon::now()->addWeek()->format('Y-m-d\TH:i');

        return view('reservations.step-one', compact('reservation', 'min_date', 'max_date'));
    }

    /**
     * step two of reservation
     */
    public function stepTwo(Request $request)
    {
        // get the reservation from the session
        $reservation = $request->session()->get('reservation');
        if (empty($reservation)) {
            return to_route('reservations.step.one');
        }
        // get the reserved tables

        // first get the start and end time for reservations
        $period = RESERVATION_PERIOD;
        $res_date = Carbon::parse($reservation->reservation_date);
        $end_res_date = $res_date->copy()->addMinutes($period);
        // get the table ids that is reserved during this dateTime
        $reserved_table_ids = Reservation::orderBy('reservation_date')->get()->filter(function ($value) use ($res_date, $end_res_date, $period) {
            // now get the start and end time for each reservation from stored
            $prev_date = Carbon::parse($value->reservation_date);
            $end_prev_date = $prev_date->copy()->addMinutes($period);
            // return true if the upcomming reservation is has conflict the stored reservation
            return ($res_date->format('Y-m-d') == $prev_date->format('Y-m-d') &&
                ($res_date->between($prev_date, $end_prev_date) ||
                    $end_res_date->between($prev_date, $end_prev_date)));
        })->pluck('table_id');

        // select the suitable and available tables and reject table that is reserved at this time
        $tables = Table::where('status', TableStatus::Available)
            ->where('guest_num', '>=', $reservation->guest_num)
            ->whereNotIn('id', $reserved_table_ids)->get();

        return view('reservations.step-two', compact('tables', 'reservation'));
    }

    /**
     *  store step one of reservation
     */
    public function StoreStepOne(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'alpha_dash:ascii', 'max:50'],
            'last_name' => ['required', 'alpha_dash:ascii', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'max:50', 'regex:/^(?:\+20|0)?1\d{9}$/'],
            'guest_num' => ['required',],
            // 'reservation_date' => ['required'],
            'reservation_date' => ['required', 'date_format:Y-m-d\TH:i', 'after:now', 'before:+8 day', new WorkHoursRule()],
        ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors());
        // }
        $validated = $validator->validated();
        // create session if not found and get the session in case found
        $reservation = empty($request->session()->get('reservation')) ?
            new Reservation() : $request->session()->get('reservation');

        $reservation->fill($validated);
        $request->session()->put('reservation', $reservation);

        return to_route('reservations.step.two');
    }

    /**
     * store step two of reservation
     */
    public function StoreStepTwo(Request $request)
    {
        $validated = $request->validate([
            'table_id' => ['required', 'numeric', 'exists:App\Models\Table,id',],
        ]);
        $reservation = $request->session()->get('reservation');
        $reservation->fill($validated);
        $reservation->save();
        $request->session()->forget('reservation');
        return to_route('welcome.tankyou', $reservation->id);
    }
}
