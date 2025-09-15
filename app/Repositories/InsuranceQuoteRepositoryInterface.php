<?php

namespace App\Repositories;

use App\Models\InsuranceQuote;

interface InsuranceQuoteRepositoryInterface
{
    /**
     * Save a new insurance quote to the database.
     *
     * @param array $data An array of data for the insurance quote.
     * @return InsuranceQuote InsuranceQuote model instance.
     */
    public function saveQuote(array $data): InsuranceQuote;

    /**
     * Find an insurance quote by its ID.
     *
     * @param int $id The ID of the insurance quote to find.
     * @return InsuranceQuote|null Insurance Quote instance or null if not found.
     */
    public function findQuoteById(int $id);

    /**
     * Update an existing insurance quote in the database.
     *
     * @param int $id The ID of the insurance quote to update.
     * @param array $data An array of data to update the insurance quote.
     * @return InsuranceQuote|null Insurance Quote model instance or null if not found.
     */
    public function updateQuote(int $id, array $data);
}
