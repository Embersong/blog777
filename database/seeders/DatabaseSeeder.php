<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('comments')->truncate();
        DB::table('posts')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.ru',
            'password' => bcrypt('123'),
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@user.ru',
            'password' => bcrypt('123')
        ]);

        User::factory(10)->create();

        $this->call([
            CategorySeeder::class,
            PostsSeeder::class,
            CommentSeeder::class,
        ]);

    }
}
