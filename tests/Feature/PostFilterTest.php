<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_can_be_filtered_by_category(): void
    {
        $user = User::factory()->create();
        $php = $this->createCategory('PHP', 'php');
        $js = $this->createCategory('JavaScript', 'javascript');

        $this->createPost($user, $php, 'PHP post');
        $this->createPost($user, $js, 'JavaScript post');

        $response = $this->get(route('posts.index', [
            'filter' => ['category' => $php->id],
        ]));

        $response->assertOk();
        $response->assertSee('PHP post');
        $response->assertDontSee('JavaScript post');
    }

    public function test_posts_can_be_filtered_by_multiple_categories(): void
    {
        $user = User::factory()->create();
        $php = $this->createCategory('PHP', 'php');
        $js = $this->createCategory('JavaScript', 'javascript');
        $other = $this->createCategory('Other', 'other');

        $this->createPost($user, $php, 'PHP post');
        $this->createPost($user, $js, 'JavaScript post');
        $this->createPost($user, $other, 'Other post');

        $response = $this->get(route('posts.index', [
            'filter' => ['category' => "{$php->id},{$js->id}"],
        ]));

        $response->assertOk();
        $response->assertSee('PHP post');
        $response->assertSee('JavaScript post');
        $response->assertDontSee('Other post');
    }

    public function test_posts_can_be_filtered_by_user(): void
    {
        $firstAuthor = User::factory()->create();
        $secondAuthor = User::factory()->create();
        $category = $this->createCategory('PHP', 'php');

        $this->createPost($firstAuthor, $category, 'Post by first author');
        $this->createPost($secondAuthor, $category, 'Post by second author');

        $response = $this->get(route('posts.index', [
            'filter' => ['user' => $firstAuthor->id],
        ]));

        $response->assertOk();
        $response->assertSee('Post by first author');
        $response->assertDontSee('Post by second author');
    }

    public function test_posts_can_be_searched_by_title_substring(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory('PHP', 'php');

        $this->createPost($user, $category, 'Laravel Query Builder');
        $this->createPost($user, $category, 'Symfony Framework');

        $response = $this->get(route('posts.index', [
            'filter' => ['title' => 'query'],
        ]));

        $response->assertOk();
        $response->assertSee('Laravel Query Builder');
        $response->assertDontSee('Symfony Framework');
    }

    public function test_empty_filters_do_not_filter_posts(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory('PHP', 'php');

        $this->createPost($user, $category, 'Visible post');

        $response = $this->get(route('posts.index', [
            'filter' => [
                'category' => '',
                'user' => '',
                'title' => '',
            ],
        ]));

        $response->assertOk();
        $response->assertSee('Visible post');
    }

    public function test_pagination_links_keep_filters(): void
    {
        $user = User::factory()->create();
        $category = $this->createCategory('PHP', 'php');

        for ($i = 1; $i <= 12; $i++) {
            $this->createPost($user, $category, "Pagination post {$i}");
        }

        $response = $this->get(route('posts.index', [
            'filter' => ['title' => 'Pagination'],
        ]));

        $response->assertOk();
        $response->assertSee('filter%5Btitle%5D', false);
    }

    private function createCategory(string $name, string $slug): Category
    {
        return Category::create([
            'name' => $name,
            'slug' => $slug,
        ]);
    }

    private function createPost(User $user, Category $category, string $title): Post
    {
        return Post::create([
            'title' => $title,
            'content' => 'Post content',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }
}
