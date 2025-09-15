<?php

use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use App\Repositories\InsuranceQuoteRepositoryInterface;

it('updates an existing quote', function () {
    $repository = Mockery::mock(InsuranceQuoteRepositoryInterface::class);
    $this->app->instance(InsuranceQuoteRepositoryInterface::class, $repository);

    $repository->shouldReceive('updateQuote')
        ->once()
        ->with(55, Mockery::on(function ($data) {
            return $data['destination'] === 'America'
                && $data['price'] === 1 * (300 + 120);
        }));

    Livewire::test(QuoteForm::class, ['quoteId' => 55])
        ->set('destination', 'America')
        ->set('startDate', '2025-11-01')
        ->set('endDate', '2025-11-05')
        ->set('coverageOptions', ['Trip Cancellation'])
        ->set('numberOfTravelers', 1)
        ->call('calculateTravelQuote', $repository);
});

it('requires valid input', function () {
    Livewire::test(QuoteForm::class)
        ->set('destination', '')
        ->set('numberOfTravelers', 0)
        ->call('calculateTravelQuote', app(InsuranceQuoteRepositoryInterface::class))
        ->assertHasErrors(['destination', 'numberOfTravelers']);
});