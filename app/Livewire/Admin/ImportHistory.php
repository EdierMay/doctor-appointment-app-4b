<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class ImportHistory extends Component
{
    public function render()
    {
        $histories = \App\Models\ImportHistory::latest()->take(5)->get();
        return view('livewire.admin.import-history', compact('histories'));
    }
}
