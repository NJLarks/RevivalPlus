{{--
|--------------------------------------------------------------------------
| Rebuilt & Refined Content Card Component (V3)
|--------------------------------------------------------------------------
|
| This version introduces a "framed" design, with a visible border around
| the entire card content, including the image carousel, to create an
| overhang/inset effect.
|
--}}
<div class="flex h-full flex-col rounded-3xl border border-c5/10 bg-red-500 p-3 shadow-xl dark:border-d5/10 dark:bg-d3" id="content-card-{{ $item->id }}">

    {{-- Image Carousel with surrounding frame --}}
    @if (!empty($photos))
        <div class="rounded-2xl overflow-hidden">
            <div x-data="{ activeSlide: 1, totalSlides: {{ count($photos) }} }" class="relative" id="card-{{ $item->id }}-carousel">
                {{-- Carousel Wrapper --}}
                <div class="relative h-56 overflow-hidden">
                    @foreach ($photos as $index => $photoUrl)
                        <div x-show="activeSlide === {{ $index + 1 }}" class="absolute inset-0 transition-opacity duration-300" x-transition:enter="ease-out" x-transition:leave="ease-in">
                            <img src="{{ $photoUrl }}" alt="{{ $title }} photo {{ $index + 1 }}" class="h-full w-full object-cover">
                        </div>
                    @endforeach
                </div>
                {{-- Carousel Controls --}}
                <div class="absolute inset-0 flex items-center justify-between px-2">
                    <button @click="activeSlide = activeSlide === 1 ? totalSlides : activeSlide - 1" class="rounded-full bg-black/30 p-1 text-white transition hover:bg-black/50 focus:outline-none" aria-label="Previous Slide" id="card-{{ $item->id }}-carousel-prev">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button @click="activeSlide = activeSlide === totalSlides ? 1 : activeSlide + 1" class="rounded-full bg-black/30 p-1 text-white transition hover:bg-black/50 focus:outline-none" aria-label="Next Slide" id="card-{{ $item->id }}-carousel-next">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
                 {{-- Pagination Dots (Now inside the frame) --}}
                <div class="absolute bottom-2 left-1/2 flex -translate-x-1/2 space-x-2" id="card-{{ $item->id }}-carousel-dots">
                    @foreach ($photos as $index => $photoUrl)
                        <button @click="activeSlide = {{ $index + 1 }}" :class="{ 'bg-white scale-110': activeSlide === {{ $index + 1 }}, 'bg-white/50': activeSlide !== {{ $index + 1 }} }" class="h-2 w-2 rounded-full transition-all duration-300 focus:outline-none" aria-label="Go to slide {{ $index + 1 }}"></button>
                    @endforeach 
                </div>
            </div>
        </div>
    @endif

    {{-- Main Content Section --}}
    <div x-data="{ showMore: false }" class="flex flex-grow flex-col px-3 pt-4 pb-1">
        {{-- Denomination and Distance Pill Tags --}}
        @if ($item instanceof \App\Models\Church)
            <div class="mb-4 flex items-center justify-between text-xs" id="card-{{ $item->id }}-info-bar">
                <span class="rounded-full border border-c5/30 bg-c5/10 px-3 py-1 font-semibold text-c4 dark:border-d5/30 dark:bg-d5/10 dark:text-d4" id="card-{{ $item->id }}-denomination">
                    {{ $item->denomination?->name ?? 'Church' }}
                </span>
                <span class="flex items-center rounded-full border border-c5/30 bg-c5/10 px-3 py-1 font-semibold text-c4 dark:border-d5/30 dark:bg-d5/10 dark:text-d4" id="card-{{ $item->id }}-distance">
                    <svg class="mr-1 h-4 w-4 text-c1 dark:text-d1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                    2.5km
                </span>
            </div>
        @endif

        {{-- Title & Subtitle --}}
        <h3 class="text-2xl font-bold tracking-tight text-c4 dark:text-d4" id="card-{{ $item->id }}-title">{{ $title }}</h3>
        <p class="mt-1 text-sm text-c5 dark:text-d5" id="card-{{ $item->id }}-subtitle">{{ $subtitle }}</p>

        {{-- Social & Map Links with Borders --}}
        @if ($socialLinks->isNotEmpty() || isset($mapUrl))
            <div class="mt-6 grid grid-cols-3 text-c4 dark:text-d4">
                @if($socialLinks->has('website'))
                    <a href="{{ $socialLinks['website'] }}" target="_blank" class="flex justify-center border-y border-c5/20 py-3 transition-colors hover:bg-c5/10 dark:border-d5/20 dark:hover:bg-d5/10" aria-label="Website" id="card-{{ $item->id }}-website-link">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                    </a>
                @else
                    <div class="border-y border-c5/20 py-3 dark:border-d5/20"></div>
                @endif
                @if($socialLinks->has('instagram'))
                    <a href="{{ $socialLinks['instagram'] }}" target="_blank" class="flex justify-center border-y border-x border-c5/20 py-3 transition-colors hover:bg-c5/10 dark:border-d5/20 dark:hover:bg-d5/10" aria-label="Instagram" id="card-{{ $item->id }}-instagram-link">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 5a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6zm5-8a1 1 0 00-1-1h-1a1 1 0 100 2h1a1 1 0 001-1z" clip-rule="evenodd"/><path d="M10 0C4.477 0 0 4.477 0 10s4.477 10 10 10 10-4.477 10-10S15.523 0 10 0zm0 18a8 8 0 110-16 8 8 0 010 16z"/></svg>
                    </a>
                @else
                     <div class="border-y border-x border-c5/20 py-3 dark:border-d5/20"></div>
                @endif
                @if(isset($mapUrl))
                     <a href="{{ $mapUrl }}" target="_blank" class="flex justify-center border-y border-c5/20 py-3 transition-colors hover:bg-c5/10 dark:border-d5/20 dark:hover:bg-d5/10" aria-label="View on map" id="card-{{ $item->id }}-map-link">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                    </a>
                @else
                    <div class="border-y border-c5/20 py-3 dark:border-d5/20"></div>
                @endif
            </div>
        @endif

        <div class="flex-grow"></div>

        {{-- "Show More" Button --}}
        @if($allTags->isNotEmpty())
            <div class="mt-6">
                <button @click="showMore = !showMore" class="flex w-full items-center justify-center rounded-full bg-c5/20 px-4 py-2 text-sm font-semibold text-c4 transition-colors hover:bg-c5/30 dark:bg-d5/20 dark:text-d4 dark:hover:bg-d5/30" id="card-{{ $item->id }}-show-more-button">
                    <span x-show="!showMore">Show More</span>
                    <span x-show="showMore">Show Less</span>
                    <svg class="ml-1 h-4 w-4 transition-transform duration-300" :class="{ 'rotate-180': showMore }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </button>
            </div>
        @endif

        {{-- Collapsible Details Section --}}
        <div x-show="showMore" x-cloak x-transition class="mt-4 border-t border-c5/20 pt-4 dark:border-d5/20" id="card-{{ $item->id }}-details">
            <div class="max-h-48 space-y-4 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-c5/50 scrollbar-track-transparent dark:scrollbar-thumb-d5/50">
                @foreach($allTags as $category => $tags)
                    <div>
                        <h4 class="mb-2 text-sm font-bold capitalize text-c4 dark:text-d4">{{ str_replace('-', ' ', $category) }}</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <span class="flex items-center rounded-full bg-c5/20 px-3 py-1 text-xs font-semibold text-c4 dark:bg-d5/20 dark:text-d4">
                                    @isset($tag->emoji)<span class="mr-1.5">{{ $tag->emoji }}</span>@endisset
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

