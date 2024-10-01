<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
  private array $languages = [
    ['name' => 'English', 'code' => 'en', 'img' => 'https://www.countryflags.com/wp-content/uploads/united-states-of-america-flag-png-large.png'],
    ['name' => 'Spanish', 'code' => 'es', 'img' => 'https://www.countryflags.com/wp-content/uploads/spain-flag-png-large.png'],
    ['name' => 'Chinese', 'code' => 'zh', 'img' => 'https://www.countryflags.com/wp-content/uploads/china-flag-png-large.png'],
    ['name' => 'Hindia', 'code' => 'hi', 'img' => 'https://www.countryflags.com/wp-content/uploads/india-flag-png-large.png'],
    ['name' => 'Arabic', 'code' => 'ar', 'img' => 'https://www.countryflags.com/wp-content/uploads/egypt-flag-png-large.png'],
    ['name' => 'French', 'code' => 'fr', 'img' => 'https://www.countryflags.com/wp-content/uploads/france-flag-png-large.png'],
    ['name' => 'German', 'code' => 'de', 'img' => 'https://www.countryflags.com/wp-content/uploads/germany-flag-png-large.png'],
    ['name' => 'Japanese', 'code' => 'ja', 'img' => 'https://www.countryflags.com/wp-content/uploads/japan-flag-png-large.png'],
    ['name' => 'Russian', 'code' => 'ru', 'img' => 'https://www.countryflags.com/wp-content/uploads/russia-flag-png-large.png'],
    ['name' => 'Portuguese', 'code' => 'pt',  'img' => 'https://www.countryflags.com/wp-content/uploads/portugal-flag-png-large.png'],
    ['name' => 'Bengali', 'code' => 'bn', 'img' => 'https://www.countryflags.com/wp-content/uploads/bangladesh-flag-png-large.png'],
    ['name' => 'Korean', 'code' => 'ko', 'img' => 'https://www.countryflags.com/wp-content/uploads/south-korea-flag-png-large.png'],
    ['name' => 'Turkish', 'code' => 'tr', 'img' => 'https://www.countryflags.com/wp-content/uploads/turkey-flag-png-large.png'],
    ['name' => 'Italian', 'code' => 'it', 'img' => 'https://www.countryflags.com/wp-content/uploads/italy-flag-png-large.png'],
    ['name' => 'Vietnamese', 'code' => 'vi', 'img' => 'https://www.countryflags.com/wp-content/uploads/vietnam-flag-png-large.png'],
    ['name' => 'Polish', 'code' => 'pl', 'img' => 'https://www.countryflags.com/wp-content/uploads/poland-flag-png-large.png'],
    ['name' => 'Ukrainian', 'code' => 'uk', 'img' => 'https://www.countryflags.com/wp-content/uploads/ukraine-flag-png-large.png'],
    ['name' => 'Dutch', 'code' => 'nl', 'img' => 'https://www.countryflags.com/wp-content/uploads/netherlands-flag-png-large.png'],
    ['name' => 'Thai', 'code' => 'th', 'img' => 'https://www.countryflags.com/wp-content/uploads/thailand-flag-png-large.png'],
    ['name' => 'Swedish', 'code' => 'sv', 'img' => 'https://www.countryflags.com/wp-content/uploads/sweden-flag-png-large.png'],
    ['name' => 'Norwegian', 'code' => 'no', 'img' => 'https://www.countryflags.com/wp-content/uploads/norway-flag-png-large.png'],
    ['name' => 'Danish', 'code' => 'da', 'img' => 'https://www.countryflags.com/wp-content/uploads/denmark-flag-png-large.png'],
    ['name' => 'Greek', 'code' => 'el', 'img' => 'https://www.countryflags.com/wp-content/uploads/greece-flag-png-large.png'],
    ['name' => 'Hebrew', 'code' => 'he', 'img' => 'https://www.countryflags.com/wp-content/uploads/israel-flag-png-large.png'],
    ['name' => 'Malay', 'code' => 'ms', 'img' => 'https://www.countryflags.com/wp-content/uploads/malaysia-flag-png-large.png'],
    ['name' => 'Indonesian', 'code' => 'id', 'img' => 'https://www.countryflags.com/wp-content/uploads/indonesia-flag-png-large.png'],
    ['name' => 'Czech', 'code' => 'cs', 'img' => 'https://www.countryflags.com/wp-content/uploads/czech-republic-flag-png-large.png'],
    ['name' => 'Hungarian', 'code' => 'hu', 'img' => 'https://www.countryflags.com/wp-content/uploads/hungary-flag-png-large.png'],
    ['name' => 'Finnish', 'code' => 'fi', 'img' => 'https://www.countryflags.com/wp-content/uploads/finland-flag-png-large.png'],
    ['name' => 'Romanian', 'code' => 'ro', 'img' => 'https://www.countryflags.com/wp-content/uploads/romania-flag-png-large.png'],
    ['name' => 'Bulgarian', 'code' => 'bg', 'img' => 'https://www.countryflags.com/wp-content/uploads/bulgaria-flag-png-large.png'],
    ['name' => 'Slovak', 'code' => 'sk', 'img' => 'https://www.countryflags.com/wp-content/uploads/slovakia-flag-png-large.png'],
    ['name' => 'Lithuanian', 'code' => 'lt',  'img' => 'https://www.countryflags.com/wp-content/uploads/lithuania-flag-png-large.png'],
    ['name' => 'Latvian', 'code' => 'lv', 'img' => 'https://www.countryflags.com/wp-content/uploads/latvia-flag-png-large.png'],
    ['name' => 'Serbian', 'code' => 'sr', 'img' => 'https://www.countryflags.com/wp-content/uploads/serbia-flag-png-large.png'],
    ['name' => 'Croatian', 'code' => 'hr', 'img' => 'https://www.countryflags.com/wp-content/uploads/croatia-flag-png-large.png'],
    ['name' => 'Slovenian', 'code' => 'sl', 'img' => 'https://www.countryflags.com/wp-content/uploads/slovenia-flag-png-large.png'],
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
