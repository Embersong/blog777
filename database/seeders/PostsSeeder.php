<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('ru_RU');

        $categoriesIds = DB::table('categories')->pluck('id')->toArray();
        $categoriesMap = DB::table('categories')
            ->select('id', 'name')
            ->get()
            ->pluck('name', 'id')
            ->all();
        $usersIds = DB::table('users')->pluck('id')->toArray();

        $postData = [];
        for ($i = 0; $i < 250; $i++) {
            $categoryId = $faker->randomElement($categoriesIds);
            $categoryName = $categoriesMap[$categoryId];
            $postData[] = [
                'title' => $this->generateTitle($faker, $categoryName),
                'content' => $this->generateContent($faker, $categoryName),
                'category_id' => $categoryId,
                'user_id' => $faker->randomElement($usersIds),
            ];
        }

        DB::table('posts')->insert($postData);
    }


    private function generateTitle($faker, $categoryName): string
    {
        $templates = [
            "Основы работы с {$categoryName}",
            "Продвинутые техники в {$categoryName}",
            "Как начать изучать {$categoryName}",
            "Лучшие практики {$categoryName}",
            "Секреты {$categoryName}",
            "{$categoryName}: от А до Я",
            "{$categoryName} для начинающих",
            "Современный {$categoryName}",
            "{$categoryName} в реальных проектах",
            "Оптимизация в {$categoryName}",
            "Условия для работы в {$categoryName}",
        ];
        return $faker->randomElement($templates);
    }

    private function generateContent($faker, $categoryName): string
    {
        $intro = "В данной статье мы подробно разберем тему {$categoryName}.";
        $body = $faker->realText(rand(500, 1500));
        $conslusion = "Изучение {$categoryName} открывает новые возможности для профессионального роста.";

        return implode("\n\n", [$intro, $body, $conslusion]);
    }
}
