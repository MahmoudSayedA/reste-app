<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl dark:text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex m-2 p-2">
                <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white dark:bg-gray-700">reservation Index</a>
            </div>
            <div class="m-2 p-2 bg-slate-100 rounded">
                <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                    <!-- create reservation form -->
                    <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}">
                        @csrf
                        @method('PUT')
                        <!-- first name -->
                        <div class="sm:col-span-6">
                            <label for="first_name" class="block text-sm font-medium text-gray-700"> First Name </label>
                            <div class="mt-1">
                                <input type="text" id="first_name" value="{{$reservation->first_name}}" name="first_name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('first_name') border-red-400 @enderror" />
                            </div>
                            @error('first_name')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- last name -->
                        <div class="sm:col-span-6">
                            <label for="last_name" class="block text-sm font-medium text-gray-700"> Last Name </label>
                            <div class="mt-1">
                                <input type="text" id="last_name" value="{{$reservation->last_name}}" name="last_name" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('last_name') border-red-400 @enderror" />
                            </div>
                            @error('last_name')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- email -->
                        <div class="sm:col-span-6">
                            <label for="email" class="block text-sm font-medium text-gray-700"> Email </label>
                            <div class="mt-1">
                                <input type="email" id="email" value="{{$reservation->email}}" name="email" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('email') border-red-400 @enderror" />
                            </div>
                            @error('email')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- phone -->
                        <div class="sm:col-span-6">
                            <label for="phone" class="block text-sm font-medium text-gray-700"> Phone </label>
                            <div class="mt-1">
                                <input type="text" id="phone" value="{{$reservation->phone}}" name="phone" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('phone') border-red-400 @enderror" />
                            </div>
                            @error('phone')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- guest number -->
                        <div class="sm:col-span-6">
                            <label for="guest_num" class="block text-sm font-medium text-gray-700"> Guest Number </label>
                            <div class="mt-1">
                                <input type="number" id="guest_num" value="{{$reservation->guest_num}}" name="guest_num" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('guest_num') border-red-400 @enderror" />
                            </div>
                            @error('guest_num')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- table id -->
                        <div class="sm:col-span-6 pt-5">
                            <label for="table" class="block text-sm font-medium text-gray-700">Table Id</label>
                            <div class="mt-1">
                                <select id="table" name="table_id" class="form-multiselect block w-full mt-1">
                                    @foreach ($tables as $table)
                                    <option value={{ $table->id }} title="id={{$table->id}}" @selected($table->id === $reservation->table->id)>{{ $table->name . "  ([$table->guest_num] Guests)" }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- reservation date time -->
                        <div class="sm:col-span-6">
                            <label for="reservation_date" class="block text-sm font-medium text-gray-700"> Reservation Date </label>
                            <div class="mt-1">
                                <input type="datetime-local" value="{{$reservation->reservation_date}}" id="reservation_date" name="reservation_date" class="block w-full appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5 @error('reservation_date') border-red-400 @enderror" />
                            </div>
                            @error('reservation_date')
                            <div class="text-sm text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-6 p-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-700 rounded-lg text-white dark:bg-gray-700">Store</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>