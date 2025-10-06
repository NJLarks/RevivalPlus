<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Church;
use App\Models\Event;
use Illuminate\Support\Collection;

class ContentCard extends Component
{
    public $item;
    public string $title;
    public string $subtitle;
    public ?array $photos;
    public Collection $featuredTags;
    public Collection $allTags;
    public Collection $socialLinks;
    public ?string $mapUrl;

    /**
     * Create a new component instance.
     *
     * @param Church|Event $item The model instance (either a Church or an Event).
     */
    public function __construct($item)
    {
        $this->item = $item;

        // Initialize all public properties with default empty values.
        $this->title = 'Untitled';
        $this->subtitle = '';
        $this->photos = [];
        $this->featuredTags = collect();
        $this->allTags = collect();
        $this->socialLinks = collect();
        $this->mapUrl = null;


        // Process the data differently depending on whether it's a Church or an Event
        if ($item instanceof Church) {
            $this->processChurchData($item);
        } elseif ($item instanceof Event) {
            $this->processEventData($item);
        }
    }

    /**
     * Process the data for a Church model.
     */
    private function processChurchData(Church $church): void
    {
        $this->title = $church->name;

        // Find the earliest Sunday service to display as the subtitle
        $firstService = $church->events()
            ->where('day_of_week', 0) // Sunday
            ->orderBy('start_time')
            ->first();
        $this->subtitle = $firstService ? 'Services: Sunday ' . \Carbon\Carbon::parse($firstService->start_time)->format('g:i A') : 'No scheduled services';

        // NOTE: This is placeholder data for the image carousel for Churches.
        $this->photos = [
            'https://placehold.co/400x300/2e5d4b/FFF?text=Photo+1',
            'https://placehold.co/400x300/384D48/FFF?text=Photo+2',
            'https://placehold.co/400x300/9E9E9E/FFF?text=Photo+3',
        ];

        // Prepare social and map links, only including them if the URL exists
        $this->socialLinks = collect([
            'website' => $church->website_url,
            'instagram' => $church->instagram_url,
            'facebook' => $church->facebook_url,
        ])->filter(); // filter() removes any null/empty values

        if ($church->latitude && $church->longitude) {
            $this->mapUrl = "https://www.google.com/maps?q={$church->latitude},{$church->longitude}";
        }

        // Logic to find the three featured tags
        $allItemTags = $church->tags;
        $this->featuredTags = collect([
            $allItemTags->where('category', 'service-style')->first(),
            $allItemTags->where('category', 'language')->first(),
            $allItemTags->where('category', 'service-offers')->first(),
        ])->filter(); // Ensure we don't have any nulls

        // Group all tags by category for the "Show More" dropdown
        $this->allTags = $allItemTags->groupBy('category');
    }

    /**
     * Process the data for an Event model.
     */
    private function processEventData(Event $event): void
    {
        $this->title = $event->eventType?->name ?? 'Event';
        $this->subtitle = ($event->church?->name ?? 'Unknown Location') . ' - ' . \Carbon\Carbon::parse($event->start_time)->format('g:i A');

        // FIX: Explicitly set the properties for an Event to safe, empty values.
        // This guarantees the view always has the variables it needs, resolving the error.
        $this->photos = []; // Events don't have a photo carousel
        $this->featuredTags = collect(); // Events don't have featured tags
        $this->allTags = collect(); // Events don't have a "Show More" section
        $this->socialLinks = collect(); // Events don't have social links
        $this->mapUrl = null; // Events don't have a map link
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.content-card');
    }
}

