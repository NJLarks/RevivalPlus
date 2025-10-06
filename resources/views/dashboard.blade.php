<x-app-layout>
    {{--
    |--------------------------------------------------------------------------
    | Page Header Slot
    |--------------------------------------------------------------------------
    |
    | Defines the content for the 'header' slot in the main app layout.
    | It includes theme-aware text colors.
    |
    --}}
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-c4 dark:text-d4">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{--
    |--------------------------------------------------------------------------
    | Main Dashboard Container
    |--------------------------------------------------------------------------
    |
    | This is the root element for the dashboard page content.
    | It sets the base background and text colors for both light and dark modes.
    |
    --}}
    <div id="dashboard-page" class="bg-c3 text-c4 dark:bg-d3 dark:text-d4">

        {{--
        |--------------------------------------------------------------------------
        | Hero Section
        |--------------------------------------------------------------------------
        |
        | A prominent section at the top of the page to welcome users.
        | Features a dynamic typewriter effect for the Bible verse.
        |
        --}}
        <section id="hero-section" class="relative overflow-hidden text-center">
            {{-- Background Image/Styling --}}
            <div class="absolute inset-0 bg-c2 opacity-90"></div>
            {{-- This adds a subtle dot pattern for texture --}}
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 1rem 1rem;"></div>

            {{-- Hero Content --}}
            <div class="relative z-10 max-w-4xl px-4 py-24 mx-auto md:py-32">
                <h1 id="typewriter-text" class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl min-h-[120px] md:min-h-[180px]"></h1>
                <p id="verse-reference" class="mt-4 text-lg text-w/70 opacity-0 transition-opacity duration-1000">- {{ $heroVerse->reference ?? 'Welcome' }}</p>
            </div>
        </section>

        {{--
        |--------------------------------------------------------------------------
        | Main Content Area
        |--------------------------------------------------------------------------
        |
        | This section contains the various content carousels, pulling data
        | passed from the DashboardController.
        |
        --}}
        <main id="dashboard-content" class="py-16">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                {{-- The space-y-16 class ensures consistent vertical spacing between each carousel --}}
                <div class="space-y-16">
                    {{--
                    | Each <x-content-carousel> is a reusable component instance.
                    | We pass a unique title and the corresponding data collection.
                    --}}
                    @if($churches->isNotEmpty())
                        <x-content-carousel title="Churches Near You" :items="$churches" />
                    @endif

                    @if($meetups->isNotEmpty())
                        <x-content-carousel title="Meetups Near You" :items="$meetups" />
                    @endif

                    @if($events->isNotEmpty())
                        <x-content-carousel title="Upcoming Events" :items="$events" />
                    @endif

                    @if($programs->isNotEmpty())
                        <x-content-carousel title="Programs for Growth" :items="$programs" />
                    @endif
                </div>
            </div>
        </main>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | Page-Specific Scripts
    |--------------------------------------------------------------------------
    |
    | This script powers the typewriter effect in the hero section.
    | Using @push ensures it's loaded at the correct place in your main layout file.
    |
    --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typewriterElement = document.getElementById('typewriter-text');
            const referenceElement = document.getElementById('verse-reference');

            if (typewriterElement && referenceElement) {
                // Safely inject the verse text from PHP into JavaScript.
                const verseText = @json($heroVerse->text ?? 'Your journey to find community starts here.');
                let i = 0;

                function typeWriter() {
                    if (i < verseText.length) {
                        typewriterElement.innerHTML += verseText.charAt(i);
                        i++;
                        setTimeout(typeWriter, 55); // Adjust typing speed here (in ms)
                    } else {
                        // Once typing is complete, fade in the verse reference for a polished effect.
                        setTimeout(() => {
                            referenceElement.style.opacity = '1';
                        }, 500);
                    }
                }
                // Add a slight delay before starting the animation.
                setTimeout(typeWriter, 500);
            }
        });
    </script>
    @endpush
</x-app-layout>