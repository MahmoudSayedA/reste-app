<x-guest-layout>
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-center mb-8">Thank You for Your Reservation!</h1>
        <p class="text-lg text-center mb-4">We have received your reservation and look forward to welcoming you to our restaurant soon.</p>
        <div class="bg-gray-100 rounded-lg px-8 py-6 mb-8">
            <h2 class="text-lg font-bold mb-4">Reservation Details:</h2>
            <ul class="text-lg">
                <li><span class="font-bold">Name:</span> {{ $reservation->first_name ?? '' }} {{ $reservation->last_name ?? '' }}</li>
                <li><span class="font-bold">Date:</span> {{ date('Y-m-d', strtotime($reservation->reservation_date)) ?? '' }}</li>
                <li><span class="font-bold">Time:</span> {{ date('H:i', strtotime($reservation->reservation_date)) ?? '' }}</li>
                <li><span class="font-bold">Number of Guests:</span> {{ $reservation->guest_num ?? '' }}</li>
                <li><span class="font-bold">Contact Number:</span> {{ $reservation->phone ?? '' }}</li>
            </ul>
        </div>
        <p class="text-lg mb-8">If you need to make any changes to your reservation, please call us at <a href="tel:{{ $restaurant->phone_num ?? '' }}" class="text-blue-500 hover:underline">{{ $restaurant->phone_num ?? '' }}</a> or email us at <a href="mailto:{{ $restaurant->email ?? '' }}" class="text-blue-500 hover:underline">{{ $restaurant->email ?? '' }}</a>.</p>
        <p class="text-lg text-center">Thank you again for choosing our restaurant. We look forward to serving you!</p>
    </div>
</x-guest-layout>
