<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use DateTime;
use Illuminate\Contracts\Validation\ValidationRule;

class WorkHoursRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Convert the input value to a Unix timestamp
        $carbon = Carbon::parse($value);
        $time = $carbon->format('H:i');

        // Convert the start and end times of the work hours to Unix timestamps
        $start_time = WORK_HOURS_START_TIME;
        $end_time = WORK_HOURS_END_TIME;

        // Check if the input value is between the start and end times of the work hours
        if ($time < $start_time || $time > $end_time) {
            $fail("Please choose the time between $start_time - $end_time.");
        }
    }
}
