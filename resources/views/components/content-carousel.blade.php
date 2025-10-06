@props([
    // The collection of items (Churches or Events) from the controller.
    'items',
    // The title for this carousel section.
    'title',
])

{{-- 
|--------------------------------------------------------------------------
| Content Carousel Component (V3)
|--------------------------------------------------------------------------
|
| This version moves the navigation chevrons outside the card scrolling area
| for a cleaner presentation and ensures the scrollbar is hidden.
|
--}}

@php
    $carouselId = Illuminate\Support\Str::slug($title);
@endphp

<section class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-labelledby="{{ $carouselId }}-heading">
    <div
        x-data="{
            isAtStart: true,
            isAtEnd: false,
            init() { this.handleScroll(); },
            handleScroll() {
                const viewport = this.$refs.viewport;
                this.isAtStart = viewport.scrollLeft < 10;
                this.isAtEnd = Math.abs(viewport.scrollWidth - viewport.clientWidth - viewport.scrollLeft) < 10;
            },
            scrollTo(direction) {
                const viewport = this.$refs.viewport;
                const scrollAmount = (viewport.clientWidth * 0.75) * direction;
                viewport.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }"
        class="relative"
    >
        {{-- Carousel Title --}}
        <h2 id="{{ $carouselId }}-heading" class="text-3xl font-bold text-c4 dark:text-d4 mb-4">{{ $title }}</h2>

        {{-- Carousel Viewport --}}
        <div
            x-ref="viewport"
            @scroll.debounce.100ms="handleScroll()"
            @wheel.prevent="$el.scrollLeft += $event.deltaY"
            class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbar"
            id="{{ $carouselId }}-viewport"
        >
            @forelse ($items as $item)
                <div class="flex-none w-[90%] sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 snap-start">
                    <x-content-card :item="$item" />
                </div>
            @empty
                <p class="italic text-c5 dark:text-d5">No items to display yet.</p>
            @endforelse
        </div>

        {{-- Previous Chevron --}}
        <button
            x-show="!isAtStart"
            @click="scrollTo(-1)"
            class="absolute top-1/2 -translate-y-1/2 -left-9 md:-left-11 z-10 p-1 transition duration-300 rounded-full bg-c3/80 text-c4 hover:bg-c1 hover:text-b dark:bg-d3/80 dark:text-d4 dark:hover:bg-d1 dark:hover:text-w"
            aria-label="Previous Item"
            id="{{ $carouselId }}-prev"
            x-transition
        >
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- Next Chevron --}}
        <button
            x-show="!isAtEnd"
            @click="scrollTo(1)"
            class="absolute top-1/2 -translate-y-1/2 -right-9 md:-right-11 z-10 p-1 transition duration-300 rounded-full bg-c3/80 text-c4 hover:bg-c1 hover:text-b dark:bg-d3/80 dark:text-d4 dark:hover:bg-d1 dark:hover:text-w"
            aria-label="Next Item"
            id="{{ $carouselId }}-next"
            x-transition
        >
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</section>

{{-- Add this CSS somewhere in your global styles or within a <style> tag --}}
<style>
    /* Hide horizontal scrollbar */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .hide-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;     /* Firefox */
    }
</style>
