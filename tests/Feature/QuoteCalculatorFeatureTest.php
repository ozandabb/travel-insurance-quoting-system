<?php

use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

/**
 * Test that validation fails when endDate is before startDate.
 */
it('fails validation when endDate is before startDate', function () {
    Livewire::test(\App\Livewire\QuoteForm::class)
        ->set('destination', 'Europe')
        ->set('startDate', '2025-12-25')
        ->set('endDate', '2025-12-20')
        ->call('calculateTravelQuote')
        ->assertHasErrors(['endDate' => 'after_or_equal']);
});

/**
 * Test fails validation if numberOfTravelers is less than 1
 */
it('fails validation if numberOfTravelers is less than 1', function () {
    Livewire::test(\App\Livewire\QuoteForm::class)
        ->set('destination', 'Sri Lanka')
        ->set('startDate', '2025-12-25')
        ->set('endDate', '2025-10-15')
        ->set('numberOfTravelers', 0)
        ->call('calculateTravelQuote')
        ->assertHasErrors(['numberOfTravelers' => 'min']);
});

/**
 * submit and checks if the JSON column contains the specified value
 */
it('submit and checks if the JSON column contains the specified value', function () {
    Livewire::test(\App\Livewire\QuoteForm::class)
        ->set('destination', 'Sri Lanka')
        ->set('startDate', '2025-12-25')
        ->set('endDate', '2026-01-25')
        ->set('coverageOptions', ['Medical Expenses'])
        ->set('numberOfTravelers', 1)
        ->call('calculateTravelQuote');

    // Assertion that checks if the JSON column contains the specified value
    $this->assertTrue(
        DB::table('insurance_quotes')
            ->where('destination', 'Sri Lanka')
            ->whereJsonContains('coverage_options', 'Medical Expenses')
            ->exists(),
        'Failed asserting correct JSON value in the coverage_options column.'
    );
});

/**
 * Test that the quote summary is displayed correctly.
 */
// it('displays the quote summary correctly', function () {
//     Livewire::test(\App\Livewire\QuoteForm::class)
//         ->set('destination', 'Italy')
//         ->set('startDate', '2025-10-01')
//         ->set('endDate', '2025-10-15')
//         ->set('coverageOptions', ['Medical Expenses', 'Trip Cancellation'])
//         ->set('numberOfTravelers', 2)
//         ->call('calculateTravelQuote')
//         ->assertSee('America')
//         ->assertSee('2025-10-01')
//         ->assertSee('2025-10-15')
//         ->assertSee('Medical Expenses, Trip Cancellation')
//         ->assertSee('$160');
// });

/**
 * check calculation scales with for more travelers
 */
// it('calculates price correctly for multiple travelers', function () {
//     Livewire::test(\App\Livewire\QuoteForm::class)
//         ->set('destination', 'Sri Lanka')
//         ->set('startDate', '2025-10-01')
//         ->set('endDate', '2025-10-15')
//         ->set('coverageOptions', ['Medical Expenses'])
//         ->set('numberOfTravelers', 3)
//         ->call('calculateTravelQuote')
//         ->assertSee('$90');
// });

/**
 * Test for multiple JSON values
 */
it('stores multiple coverage options in JSON column', function () {
    Livewire::test(\App\Livewire\QuoteForm::class)
        ->set('destination', 'Sri Lanka')
        ->set('startDate', '2025-10-01')
        ->set('endDate', '2025-10-15')
        ->set('coverageOptions', ['Medical Expenses', 'Trip Cancellation'])
        ->set('numberOfTravelers', 1)
        ->call('calculateTravelQuote');

    $this->assertTrue(
        DB::table('insurance_quotes')
            ->where('destination', 'Sri Lanka')
            ->whereJsonContains('coverage_options', 'Medical Expenses')
            ->whereJsonContains('coverage_options', 'Trip Cancellation')
            ->exists(),
        'Failed asserting multiple coverage options were stored in JSON.'
    );
});

/**
 * Test stores a new record on each submission
 */
it('stores a new record on each submission', function () {
    Livewire::test(\App\Livewire\QuoteForm::class)
        ->set('destination', 'Sri Lanka')
        ->set('startDate', '2025-10-01')
        ->set('endDate', '2025-10-15')
        ->set('coverageOptions', ['Trip Cancellation'])
        ->set('numberOfTravelers', 1)
        ->call('calculateTravelQuote');

    Livewire::test(\App\Livewire\QuoteForm::class)
        ->set('destination', 'Sri Lanka')
        ->set('startDate', '2025-10-01')
        ->set('endDate', '2025-10-15')
        ->set('coverageOptions', ['Trip Cancellation'])
        ->set('numberOfTravelers', 1)
        ->call('calculateTravelQuote');

    $this->assertDatabaseCount('insurance_quotes', 2);
});



