<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Church;
use App\Models\Verse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request and display the main dashboard.
     * This is a single-action controller, invoked when the route points to the class.
     */
    public function __invoke(Request $request)
    {
        // 1. Fetch a random bible verse for the hero section.
        // This query correctly selects a random record from your 'verses' table.
        $heroVerse = Verse::inRandomOrder()->first();

        // 2. Fetch the latest 8 churches.
        // This query correctly gets the most recent churches to display in the first carousel.
        $churches = Church::latest()->take(8)->get();

        // 3. Fetch "Meetups" (Small Groups & Youth Groups).
        // This query correctly finds all 'Event' models that are linked to an 'EventType'
        // with a slug of 'small-group' or 'youth-night'.
        $meetups = Event::whereHas('eventType', function ($query) {
            $query->whereIn('slug', ['small-group', 'youth-night']);
        })->with(['church', 'eventType'])->orderBy('day_of_week')->orderBy('start_time')->take(8)->get();

        // 4. Fetch other "Events" (Worship Nights & Prayer Nights).
        // This query correctly finds all 'Event' models for worship and prayer nights.
        $events = Event::whereHas('eventType', function ($query) {
            $query->whereIn('slug', ['worship-nights', 'prayer-nights']);
        })->with(['church', 'eventType'])->orderBy('day_of_week')->orderBy('start_time')->take(8)->get();

        // 5. Fetch "Programs" (Courses & Studies).
        // This query correctly finds all 'Event' models for discipleship and bible study.
        $programs = Event::whereHas('eventType', function ($query) {
            $query->whereIn('slug', ['discipleship-course', 'bible-study']);
        })->with(['church', 'eventType'])->orderBy('day_of_week')->orderBy('start_time')->take(8)->get();


        // Finally, this correctly returns the 'dashboard' view and passes all the
        // data collections to it, making them available to your carousel components.
        return view('dashboard', [
            'heroVerse' => $heroVerse,
            'churches' => $churches,
            'meetups' => $meetups,
            'events' => $events,
            'programs' => $programs,
        ]);
    }
}

