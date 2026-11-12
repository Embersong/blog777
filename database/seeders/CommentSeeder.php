<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('ru_RU');
        $userIds = DB::table('users')->pluck('id')->toArray();

        $posts = Post::all();

        foreach ($posts as $post) {
            for ($i = 0; $i < rand(2, 15); $i++) {

/*                DB::table('comments')->insert([
                    'post_id' => $post->id,
                    'user_id' => $faker->randomElement($userIds),
                    'content' => $faker->realText(rand(100, 500)),
                ]);*/

                $post->comments()->create([
                    'user_id' => $faker->randomElement($userIds),
                    'comment' => $faker->realText(rand(100, 500)),
                ]);
            }
        }
    }
}
