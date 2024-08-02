<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ApiPostTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a user to authenticate for testing
        $this->user = User::factory()->create([
            'password' => bcrypt('password'), // Password should match in test cases
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_create_a_post_via_api()
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/posts', [
            'title' => 'API Test Post',
            'body' => 'This is the body of the API test post.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['title' => 'API Test Post']);
    }

    /** @test */
    public function an_authenticated_user_can_update_a_post_via_api()
    {
        $post = Post::factory()->create();

        Sanctum::actingAs($this->user);

        $response = $this->putJson("/api/posts/{$post->id}", [
            'title' => 'Updated API Post',
            'body' => 'This is the updated body of the API post.',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('posts', ['title' => 'Updated API Post']);
    }

    /** @test */
    public function an_authenticated_user_can_delete_a_post_via_api()
    {
        $post = Post::factory()->create();

        Sanctum::actingAs($this->user);

        $response = $this->deleteJson("/api/posts/{$post->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    /** @test */
    /** @test */
    public function it_can_fetch_posts_via_api_with_pagination_and_search()
    {
        Post::factory()->count(15)->create();
        Sanctum::actingAs($this->user);
        // Make the API request
        $response = $this->getJson('/api/posts?page=1&search=Test');
        $response->assertStatus(200);

        // Adjust JSON structure based on actual response
        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => ['id', 'title', 'body', 'created_at', 'updated_at', 'image'],
                ],
            ],
            'meta' => ['current_page', 'last_page', 'per_page', 'total'],
        ]);
    }

}
