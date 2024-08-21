<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
    private array $languages = [
        ['name' => 'English', 'code' => 'en'],
        ['name' => 'Spanish', 'code' => 'es'],
        ['name' => 'Chinese', 'code' => 'zh'],
        ['name' => 'Hindi', 'code' => 'hi'],
        ['name' => 'Arabic', 'code' => 'ar'],
        ['name' => 'French', 'code' => 'fr'],
        ['name' => 'German', 'code' => 'de'],
        ['name' => 'Japanese', 'code' => 'ja'],
        ['name' => 'Russian', 'code' => 'ru'],
        ['name' => 'Portuguese', 'code' => 'pt'],
        ['name' => 'Bengali', 'code' => 'bn'],
        ['name' => 'Korean', 'code' => 'ko'],
        ['name' => 'Turkish', 'code' => 'tr'],
        ['name' => 'Italian', 'code' => 'it'],
        ['name' => 'Vietnamese', 'code' => 'vi'],
        ['name' => 'Polish', 'code' => 'pl'],
        ['name' => 'Ukrainian', 'code' => 'uk'],
        ['name' => 'Dutch', 'code' => 'nl'],
        ['name' => 'Thai', 'code' => 'th'],
        ['name' => 'Swedish', 'code' => 'sv'],
        ['name' => 'Norwegian', 'code' => 'no'],
        ['name' => 'Danish', 'code' => 'da'],
        ['name' => 'Greek', 'code' => 'el'],
        ['name' => 'Hebrew', 'code' => 'he'],
        ['name' => 'Malay', 'code' => 'ms'],
        ['name' => 'Indonesian', 'code' => 'id'],
        ['name' => 'Czech', 'code' => 'cs'],
        ['name' => 'Hungarian', 'code' => 'hu'],
        ['name' => 'Finnish', 'code' => 'fi'],
        ['name' => 'Romanian', 'code' => 'ro'],
        ['name' => 'Bulgarian', 'code' => 'bg'],
        ['name' => 'Slovak', 'code' => 'sk'],
        ['name' => 'Lithuanian', 'code' => 'lt'],
        ['name' => 'Latvian', 'code' => 'lv'],
        ['name' => 'Serbian', 'code' => 'sr'],
        ['name' => 'Croatian', 'code' => 'hr'],
        ['name' => 'Slovenian', 'code' => 'sl']
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->languages as $lang) {
            Language::create($lang);
        }
    }
}
