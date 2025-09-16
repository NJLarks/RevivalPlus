<x-app-layout>
    <div class="py-12 bg-c3 dark:bg-d3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <section id="hero-verse-section" class="bg-c1 text-d4 rounded-lg shadow-lg p-8 md:p-12 mb-12 text-center overflow-hidden">
                <blockquote class="mb-4">
                    <p id="typewriter-verse" class="text-2xl md:text-4xl font-serif italic" data-testid="hero-verse-text">
                        {{-- Verse text will be typed here by JavaScript --}}
                        {{ $verse->text }}
                    </p>
                </blockquote>
                <cite id="typewriter-reference" class="block text-right text-lg md:text-xl font-semibold opacity-0" data-testid="hero-verse-reference">
                    — {{ $verse->reference }}
                </cite>
            </section>

            <div class="space-y-12">
                <livewire:churches-near-you />
                <livewire:meetups-near-you />
                <livewire:events-near-you />
                <livewire:programs-for-growth />
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const verseElement = document.getElementById('typewriter-verse');
            const referenceElement = document.getElementById('typewriter-reference');

            const verseText = verseElement.textContent.trim();
            verseElement.textContent = ''; // Clear original text

            let i = 0;
            const typingSpeed = 50; // Milliseconds per character

            function typeWriter() {
                if (i < verseText.length) {
                    verseElement.innerHTML += verseText.charAt(i);
                    i++;
                    setTimeout(typeWriter, typingSpeed);
                } else {
                    // When typing is done, fade in the reference
                    referenceElement.style.transition = 'opacity 1s ease-in-out';
                    referenceElement.style.opacity = '1';
                }
            }

            typeWriter();
        });
    </script>
    @endpush
</x-app-layout>
