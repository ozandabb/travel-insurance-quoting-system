<div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 px-6">
        <div class="md:col-span-2 p-4 rounded">
            <div class="w-full border border-gray-300 rounded-lg p-8">
                <form wire:submit.prevent="calculateTravelQuote" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Destination -->
                        <div>
                            <label for="destination" class="block text-base font-medium text-gray-800 mb-1">Destination</label>
                            <select
                                wire:model="destination"
                                id="destination"
                                class="w-full border border-gray-300 p-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                                <option value="">Select Your Destination</option>
                                @foreach (\App\Utils\Constants::DESTINATIONS as $key => $price)
                                    <option value="{{ $key }}">{{ $key }} (+${{ $price }})</option>
                                @endforeach
                            </select>
                            @error('destination') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Number of Travelers -->
                        <div>
                            <label for="numberOfTravelers" class="block text-base font-medium text-gray-800 mb-1">
                                No of travelers
                            </label>
                            <input
                                type="number"
                                wire:model="numberOfTravelers"
                                id="numberOfTravelers"
                                min="1"
                                class="block w-full border border-gray-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm p-2"/>
                            @error('numberOfTravelers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Travel Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="startDate" class="block text-base font-medium text-gray-800 mb-1">Start date</label>
                            <input
                                type="date"
                                wire:model.lazy="startDate"
                                id="startDate"
                                min="{{ now()->toDateString() }}"
                                class="block w-full border border-gray-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm p-2"
                            />
                            @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="endDate" class="block text-base font-medium text-gray-800 mb-1">End date</label>
                            <input
                                type="date"
                                wire:model="endDate"
                                id="endDate"
                                :disabled="!$wire.startDate"
                                :min="$wire.startDate ? $wire.startDate : ''"
                                class="block w-full border border-gray-300 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 sm:text-sm p-2"
                            />
                            @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Coverage Options -->
                    <div>
                        <span class="block text-base font-medium text-gray-800 mb-1">Coverage options</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach (\App\Utils\Constants::COVERAGE_OPTIONS as $key => $price)
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        wire:model="coverageOptions"
                                        value="{{ $key }}"
                                        class="h-4 w-4 appearance-none border border-gray-300 rounded-md 
                                            checked:bg-sky-500 checked:border-sky-500 checked:text-white
                                            flex items-center justify-center"
                                    />
                                    <span class="text-gray-700 text-sm">{{ $key }} (+${{ $price }})</span>
                                </label>
                            @endforeach
                        </div>

                        @error('coverageOptions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-between space-x-3">
                        <!-- Reset Button -->
                        <button
                            type="button"
                            wire:click="resetForm"
                            class="px-4 py-2 bg-gray-300 text-gray-800 font-semibold text-sm 
                            hover:bg-gray-400 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-gray-400 transition">
                            Reset
                        </button>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            class="px-4 py-2 bg-sky-600 text-white font-semibold text-sm
                            hover:bg-sky-700 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-sky-500 transition">
                            {{ $quoteId ? 'Update Quote' : 'Calculate Quote' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="md:col-span-3 p-4">
           <div class="grid grid-cols-5 bg-gradient-to-br from-sky-50 to-sky-100 p-6 rounded-xl border border-sky-300">
                @if ($quotePrice > 0)
                    <div class="col-span-4 p-4">
                        <h1 class="text-2xl font-bold">Total Price Quoted</h1>
                        <span class="text-gray-600">{{ $destination }} from {{ $startDate }} to {{ $endDate }} for {{ $numberOfTravelers }} {{$numberOfTravelers === 1 ? 'traveler' : 'travelers'}}.</span><br/>
                        <span class="text-small text-gray-600">{{ implode(', ', $coverageOptions) }} included</span>
                    </div>
                    <div class="col-span-1 p-4 text-end">
                        <h1 class="text-5xl text-sky-700 font-bold">${{ $quotePrice }}</h1>
                    </div>
                @else
                    <div class="col-span-5">Your quote will appear once the calculation is complete.</div>
                @endif
            </div>
        </div>
    </div>
</div>
