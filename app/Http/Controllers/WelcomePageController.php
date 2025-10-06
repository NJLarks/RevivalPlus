<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\Event;
use App\Models\Verse;
use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    /**
     * Handle the incoming request to show the welcome page.
     */
    public function __invoke(Request $request)
    {
        // 1. Fetch a random verse for the hero section.
        $heroVerse = Verse::inRandomOrder()->first();

        // 2. Fetch churches for the "Local Churches" carousel.
        // We'll take 8 for now.
        $churches = Church::latest()->take(8)->get();

        // 3. Fetch "Meetups" (Small Groups & Youth Groups).
        $meetups = Event::whereHas('eventType', function ($query) {
            $query->whereIn('slug', ['small-group', 'youth-night']);
        })->with(['church', 'eventType'])->latest()->take(8)->get();

        // 4. Fetch other "Events" (Worship Nights & Prayer Nights).
        $events = Event::whereHas('eventType', function ($query) {
            $query->whereIn('slug', ['worship-nights', 'prayer-nights']);
        })->with(['church', 'eventType'])->latest()->take(8)->get();

        // 5. Fetch "Programs" (Courses & Studies).
        $programs = Event::whereHas('eventType', function ($query) {
            $query->whereIn('slug', ['discipleship-course', 'bible-study']);
        })->with(['church', 'eventType'])->latest()->take(8)->get();

        // 6. Pass all the data to the view.
        return view('welcome', [
            'heroVerse' => $heroVerse,
            'churches' => $churches,
            'meetups' => $meetups,
            'events' => $events,
            'programs' => $programs,
        ]);
    }
}
