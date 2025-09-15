<?php

namespace App\Repositories;

use App\Models\InsuranceQuote;

class InsuranceQuoteRepository implements InsuranceQuoteRepositoryInterface
{
    /**
     * Save a new insurance quote data to the database.
     *
     * @param array data array $data.
     * @return InsuranceQuote InsuranceQuote model instance.
     */
    public function saveQuote(array $data): InsuranceQuote
    {
        return InsuranceQuote::create($data);
    }

    /**
     * Find an insurance quote by its ID.
     *
     * @param int $id The ID of the insurance quote to find.
     * @return InsuranceQuote|null InsuranceQuote instance.
     */
    public function findQuoteById(int $id)
    {
        return InsuranceQuote::find($id);
    }

    /**
     * Update an existing insurance quote in the database.
     *
     * @param int $id The ID of the insurance quote to update.
     * @param array $data array.
     * @return InsuranceQuote|null Insurance Quote model instance or null if not found.
     */
    public function updateQuote(int $id, array $data)
    {
        $quote = InsuranceQuote::find($id);
        if ($quote) {
            $quote->update($data);
            return $quote;
        }

        return null;
    }
}
