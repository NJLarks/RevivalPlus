/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        // ... your content paths, e.g.,
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                // Light Mode Color Palette
                'c1': '#0000B0', // Primary Blue
                'c2': '#384D48',   // Secondary Green-Grey
                'c3': '#FBFBFB',   // Off-White Background
                'c4': '#2F2F2F',   // Dark Grey Text
                'c5': '#9E9E9E',   // Muted Grey Accent

                // Light Mode Hover States
                'ch1': '#0000B0',
                'ch2': '#2D3D39',
                'ch3': '#EBEBEB',
                'ch4': '#1A1A1A',
                'ch5': '#8B8B8B',

                // Dark Mode Color Palette (d1, d2, etc.)
                'd1': '#8cebf9ff',   // Primary Blue (same as light mode for consistency)
                'd2': '#384D48',   // Secondary Green-Grey (same as light mode for consistency)
                'd3': '#1E1E1E',   // Main Dark Background (Inversion of c3)
                'd4': '#F0F0F0',   // Light Text (Inversion of c4)
                'd5': '#7A7A7A',   // Muted Grey Accent (Darker version of c5)

                // Dark Mode Hover States (dh1, dh2, etc.)
                'dh1': '#0000B0',
                'dh2': '#2D3D39',
                'dh3': '#2F2F2F',
                'dh4': '#E0E0E0',
                'dh5': '#6B6B6B',

                // System/Status Colors
                'warning': '#E53E3E',   // A nice, standard red
                'success': '#38A169',   // A nice, standard green
                'warningh': '#C53030',  // A slightly darker red for hover
                'successh': '#2F855A',  // A slightly darker green for hover
                'w': '#FFFFFF',   // White
                'b': '#000000',   // Black
            },
        },
    },

    plugins: [],
};
