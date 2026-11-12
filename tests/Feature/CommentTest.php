<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_leave_a_comment(): void
    {
        $user = User::factory()->create();
        $post = $this->createPost($user);

        $response = $this->actingAs($user)->post(route('comments.store', $post), [
            'comment' => 'Полезная статья',
        ]);

        $response->assertRedirect(route('posts.show', $post));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'comment' => 'Полезная статья',
        ]);
    }

    public function test_guest_cannot_leave_a_comment(): void
    {
        $post = $this->createPost(User::factory()->create());

        $response = $this->post(route('comments.store', $post), [
            'comment' => 'Полезная статья',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_comment_is_required(): void
    {
        $user = User::factory()->create();
        $post = $this->createPost($user);

        $response = $this->actingAs($user)->post(route('comments.store', $post), [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors('comment');
        $this->assertDatabaseCount('comments', 0);
    }

    private function createPost(User $user): Post
    {
        $category = Category::create([
            'name' => 'Тестовая категория',
            'slug' => 'test-category',
        ]);

        return Post::create([
            'title' => 'Тестовый пост',
            'content' => 'Текст поста',
            'category_id' => $category->id,
            'user_id' => $user->id,
        ]);
    }
}
