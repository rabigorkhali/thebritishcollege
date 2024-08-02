<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create([
            'password' => Hash::make('password')
        ]);
    }

    /** @test */
    public function a_user_can_create_a_post()
    {
        $response = $this->actingAs($this->user)->post('/posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ]);

        $response->assertStatus(302); // Assuming redirect on success
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
        ]);
    }

    /** @test */
    public function a_user_can_view_all_posts()
    {
        Post::factory()->count(5)->create();

        $response = $this->actingAs($this->user)->get('/posts');

        $response->assertStatus(200);
    }


    /** @test */
    public function a_user_can_update_a_post()
    {
        $post = Post::factory()->create([
            'title' => 'Old Title',
            'body' => 'Old body.',
        ]);

        $response = $this->actingAs($this->user)->put('/posts/' . $post->id, [
            'title' => 'Updated Title',
            'body' => 'Updated body.',
        ]);

        $response->assertStatus(302); // Assuming redirect on success
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated body.',
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_post()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($this->user)->delete('/posts/' . $post->id);

        $response->assertStatus(302); // Assuming redirect on success
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
