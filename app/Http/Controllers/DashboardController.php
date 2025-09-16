<?php

namespace App\Http\Controllers;

use App\Models\Verse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function __invoke(): View
    {
        // Fetch a random verse from the database.
        $verse = Verse::inRandomOrder()->first();

        // If no verses are found (e.g., before seeding), provide a default.
        if (!$verse) {
            $verse = new Verse([
                'reference' => 'Welcome',
                'text'      => 'Your journey begins here.'
            ]);
        }

        return view('dashboard', [
            'verse' => $verse,
        ]);
    }
}
