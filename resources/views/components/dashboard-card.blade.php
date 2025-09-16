@props([
    'imageUrl' => 'https://via.placeholder.com/400x225.png?text=Faith+Image', // Default placeholder
    'title',
    'subtitle'
])

<div data-testid="content-card" class="bg-c3 dark:bg-d3 rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 hover:shadow-xl transition-all duration-300 ease-in-out">
    <img class="w-full h-48 object-cover" src="{{ $imageUrl }}" alt="{{ $title }}">
    <div class="p-4 md:p-6">
        <h3 data-testid="content-card-title" class="text-lg font-bold text-c4 dark:text-d4 mb-1 truncate">{{ $title }}</h3>
        <p data-testid="content-card-subtitle" class="text-sm text-c5 dark:text-d5">{{ $subtitle }}</p>
    </div>
</div>
