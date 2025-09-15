<?php

namespace App\Livewire;

use Livewire\Component;

class QuoteForm extends Component
{
    public function render()
    {
        return view('livewire.quote-form')->layout('layouts.app');
    }
}
