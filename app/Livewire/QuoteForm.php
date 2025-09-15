<?php

namespace App\Livewire;

use Livewire\Component;
use App\Utils\Constants;
use App\Repositories\InsuranceQuoteRepositoryInterface;

class QuoteForm extends Component
{
    public $destination;
    public $startDate;
    public $endDate;
    public $coverageOptions = [];
    public $numberOfTravelers = 1;
    public $quotePrice = 0;
    public $quoteId = null;

    protected $rules = [
        'destination'       => 'required|string',
        'startDate'         => 'required|date|after_or_equal:today',
        'endDate'           => 'required|date|after_or_equal:startDate',
        'coverageOptions'   => 'required|array',
        'numberOfTravelers' => 'required|integer|min:1',
    ];

    protected $messages = [
        'destination.required'       => 'Please select your travel destination.',
        'startDate.required'         => 'The trip must have a start date.',
        'startDate.after_or_equal'   => 'Start date cannot be in the past.',
        'endDate.required'           => 'The trip must have an end date.',
        'endDate.after_or_equal'     => 'End date must be after the start date.',
        'coverageOptions.required'   => 'Choose at least one coverage option.',
        'numberOfTravelers.required' => 'Please enter the number of travelers.',
        'numberOfTravelers.min'      => 'There must be at least 1 traveler.',
    ];

    /**
     * Get the list of available destinations
     *
     * @return array
     */
    public function getTravelDestinations()
    {
        return Constants::DESTINATIONS;
    }

    /**
     * Calculates the insurance quote and saves/updates it in the database.
     *
     * @param InsuranceQuoteRepositoryInterface $repository
     * @return void
     */
    public function calculateTravelQuote(InsuranceQuoteRepositoryInterface $repository)
    {
        $validatedData = $this->validate();

        $destinations = [
            'Sri Lanka' => 100,
            'India'     => 200,
            'America'   => 300,
            'Europe'    => 400,
            'Australia' => 500,
            'Africa'    => 600
        ];

        $coverageOptionPrices = [
            'Baggage Loss'      => 100,
            'Trip Cancellation' => 120, 
            'Medical Expenses'  => 150 
        ];

        // Calculating the quote price
        $destinationCost = $destinations[$this->destination] ?? 0;
        $coverageCost = array_sum(
            array_map(
                fn($option) => $coverageOptionPrices[$option] ?? 0, $this->coverageOptions
            )
        );
        $this->quotePrice = $this->numberOfTravelers * ($destinationCost + $coverageCost);

        $returnData = [
            'destination' => $this->destination,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'coverage_options' => json_encode($this->coverageOptions),
            'number_of_travelers' => $this->numberOfTravelers,
            'price' => $this->quotePrice,
        ];

        $this->quoteId
            ? $repository->updateQuote($this->quoteId, $returnData)
            : $this->quoteId = $repository->saveQuote($returnData)->id;

    }

    /**
     * Resets the form inputs to their default values.
     *
     * @return void
     */
    public function resetForm()
    {
        $this->destination = null;
        $this->startDate = null;
        $this->endDate = null;
        $this->coverageOptions = [];
        $this->numberOfTravelers = 1;
        $this->quotePrice = 0;
        $this->quoteId = null;
    }

    /**
     * Handle changes to the startDate property.
     *
     * @param string $value The updated value of the `startDate` property.
     * @return void
     */
    public function updatedStartDate($value)
    {
        // Check if endDate is set and is earlier than the updated startDate
        if ($this->endDate && $this->endDate < $value) {
            $this->endDate = null;
        }
    }

    /**
     * Loads an existing quote into the form for editing.
     *
     * @param int $id Quote ID to edit
     * @param InsuranceQuoteRepositoryInterface $repository
     * @return void
     */
    public function editQuote($id, InsuranceQuoteRepositoryInterface $repository)
    {
        $quote = $repository->findQuoteById($id);

        // Bind data to form properties
        if ($quote) {
            $this->quoteId = $quote->id;
            $this->destination = $quote->destination;
            $this->startDate = $quote->start_date;
            $this->endDate = $quote->end_date;
            $this->coverageOptions = json_decode($quote->coverage_options, true);
            $this->numberOfTravelers = $quote->number_of_travelers;
            $this->quotePrice = $quote->price;
        }
    }

    /**
     * Renders the Livewire view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.quote-form')->layout('layouts.app');
    }
}
