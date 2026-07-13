<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            ['slug' => 'news', 'name' => 'News', 'name_mm' => 'သတင်းများ', 'subs' => []],
            ['slug' => 'weather-advisory', 'name' => 'Weather Advisory', 'name_mm' => 'ရာသီဥတုသတိပေးချက်', 'subs' => []],
            ['slug' => 'farming-advisory', 'name' => 'Farming Advisory', 'name_mm' => 'စိုက်ပျိုးရေးနည်းလမ်းများ', 'subs' => []],
            [
                'slug' => 'main-crops',
                'name' => 'Main Crops',
                'name_mm' => 'အဓိကသီးနှံများ',
                'subs' => [
                    'Rice' => 'ဆန်စပါး',
                    'Paddy' => 'စပါး',
                    'Maize' => 'ပြောင်းဖူး',
                    'Soybean' => 'ပဲပုပ်',
                    'Groundnut' => 'မြေပဲ',
                    'Sesame' => 'နှမ်း',
                    'Cotton' => 'ဝါ',
                    'Sugarcane' => 'ကြံ',
                    'Pulses' => 'ပဲမျိုးစုံ',
                    'Vegetables' => 'ဟင်းသီးဟင်းရွက်'
                ]
            ],
            [
                'slug' => 'pests',
                'name' => 'Pests',
                'name_mm' => 'ပိုးမွှားများ',
                'subs' => [
                    'Stem Borer' => 'ပင်စည်ဖောက်ပိုး',
                    'Leaf Folder' => 'အရွက်လိပ်ပိုး',
                    'Planthopper' => 'ပိုးနားတို',
                    'Armyworm' => 'စစ်တပ်ပိုး',
                    'Aphid' => 'ပိုးကောင်',
                    'Whitefly' => 'ဖြုတ်စိမ်း',
                    'Thrips' => 'မွှား',
                    'Cutworm' => 'မြေအောက်သီးနှံဖျက်ပိုး',
                    'Fruit Borer' => 'အသီးဖောက်ပိုး',
                    'Storage Pest' => 'သိုလှောင်ဖျက်ပိုး'
                ]
            ],
            [
                'slug' => 'pesticides',
                'name' => 'Pesticides',
                'name_mm' => 'ပိုးသတ်ဆေးများ',
                'subs' => [
                    'Insecticide' => 'ပိုးသတ်ဆေး',
                    'Herbicide' => 'ပေါင်းသတ်ဆေး',
                    'Fungicide' => 'မှိုသတ်ဆေး',
                    'Nematicide' => 'မြေအောက်ကောင်သတ်ဆေး',
                    'Rodenticide' => 'ကြွက်သတ်ဆေး',
                    'Bio Pesticide' => 'ဇီဝပိုးသတ်ဆေး',
                    'Seed Treatment' => 'မျိုးစေ့လူးနယ်ဆေး',
                    'Spray Equipment' => 'ဆေးဖျန်းကိရိယာ',
                    'Safety Guideline' => 'ဘေးကင်းရေးလမ်းညွှန်',
                    'Registration Info' => 'မှတ်ပုံတင်အချက်အလက်'
                ]
            ],
            [
                'slug' => 'crop-diseases',
                'name' => 'Crop Diseases',
                'name_mm' => 'သီးနှံရောဂါများ',
                'subs' => [
                    'Rice' => 'ဆန်စပါး',
                    'Paddy' => 'စပါး',
                    'Maize' => 'ပြောင်းဖူး',
                    'Soybean' => 'ပဲပုပ်',
                    'Groundnut' => 'မြေပဲ',
                    'Sesame' => 'နှမ်း',
                    'Cotton' => 'ဝါ',
                    'Sugarcane' => 'ကြံ',
                    'Pulses' => 'ပဲမျိုးစုံ',
                    'Vegetables' => 'ဟင်းသီးဟင်းရွက်'
                ]
            ],
            [
                'slug' => 'seeds',
                'name' => 'Seeds',
                'name_mm' => 'မျိုးစေ့များ',
                'subs' => [
                    'High Yield Variety' => 'အထွက်ကောင်းမျိုး',
                    'Hybrid Seed' => 'မျိုးစပ်မျိုး',
                    'Local Variety' => 'ဒေသမျိုး',
                    'Foundation Seed' => 'မွေးမြူရေးမျိုးစေ့',
                    'Certified Seed' => 'အသိအမှတ်ပြုမျိုးစေ့'
                ]
            ],
        ];

        foreach ($map as $item) {
            $root = Category::create([
                'name' => $item['name'],
                'name_mm' => $item['name_mm'],
                'slug' => $item['slug'],
                'level' => 1
            ]);

            foreach ($item['subs'] as $en => $mm) {
                $childSlug = $root->slug . '-' . \Illuminate\Support\Str::slug($en);

                Category::create([
                    'name' => $en,
                    'name_mm' => $mm,
                    'slug' => $childSlug,
                    'parent_id' => $root->id,
                    'level' => 2
                ]);
            }
        }
    }
}