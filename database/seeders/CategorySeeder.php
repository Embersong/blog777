<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Веб-разработка',
                'slug' => 'web-development',
                'description' => 'Статьи о создании веб-сайтов и приложений, фронтенд и бэкенд разработка.',
            ],
            [
                'name' => 'Оптимизация',
                'slug' => 'optimization',
                'description' => 'Советы по улучшению производительности кода, кешированию и оптимизации запросов.',
            ],
            [
                'name' => 'Фреймворки',
                'slug' => 'frameworks',
                'description' => 'Обзоры и сравнения популярных PHP-фреймворков: Laravel, Symfony, Yii и другие.',
            ],
            [
                'name' => 'Базы данных',
                'slug' => 'databases',
                'description' => 'Проектирование схем, индексация, репликация, работа с MySQL, PostgreSQL и NoSQL решениями.',
            ],
            [
                'name' => 'DevOps и деплой',
                'slug' => 'devops-deploy',
                'description' => 'CI/CD пайплайны, контейнеризация, настройка серверов, мониторинг и автоматизация развёртывания.',
            ],
            [
                'name' => 'Тестирование',
                'slug' => 'testing',
                'description' => 'Unit, feature и e2e тесты, TDD, моки, фабрики и обеспечение качества кода.',
            ],
            [
                'name' => 'API и интеграции',
                'slug' => 'api-integrations',
                'description' => 'RESTful и GraphQL API, OAuth, вебхуки, работа со сторонними сервисами и микросервисная архитектура.',
            ],
            [
                'name' => 'Безопасность',
                'slug' => 'security',
                'description' => 'Защита от уязвимостей, аутентификация, авторизация, шифрование и лучшие практики безопасности.',
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
