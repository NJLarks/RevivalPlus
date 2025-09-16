<?php

namespace Database\Seeders;

use App\Models\Verse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VerseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $verses = [
            ['reference' => 'Philippians 4:13', 'text' => 'I can do all this through him who gives me strength.'],
            ['reference' => 'John 3:16', 'text' => 'For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.'],
            ['reference' => 'Romans 8:28', 'text' => 'And we know that in all things God works for the good of those who love him, who have been called according to his purpose.'],
            ['reference' => 'Proverbs 3:5-6', 'text' => 'Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.'],
            ['reference' => 'Jeremiah 29:11', 'text' => 'For I know the plans I have for you,” declares the Lord, “plans to prosper you and not to harm you, plans to give you hope and a future.'],
            ['reference' => 'Matthew 6:33', 'text' => 'But seek first his kingdom and his righteousness, and all these things will be given to you as well.'],
        ];

        // Using firstOrCreate to prevent duplicates if the seeder is run multiple times.
        foreach ($verses as $verse) {
            Verse::firstOrCreate(
                ['reference' => $verse['reference']],
                ['text' => $verse['text']]
            );
        }
    }
}

