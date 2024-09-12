<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    protected $user;
    protected $collection;
    protected $tag;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->collection = Collection::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $this->tag = Tag::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_can_create_a_new_tag_successfully()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tags', [
            'title' => 'New Tag',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Tag created successfully',
            ]);

        $this->assertDatabaseHas('tags', [
            'title' => 'New Tag',
            'user_id' => $this->user->id,
        ]);
    }

    /** @test */
    public function it_fails_to_create_a_tag_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tags', [
            'title' => '', // Invalid data (empty title)
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }

    /** @test */
    public function it_can_retrieve_all_tags()
    {
        $response = $this->actingAs($this->user)->getJson('/api/tags');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_retrieve_a_tag_by_id()
    {
        $response = $this->actingAs($this->user)->getJson("/api/tags/{$this->tag->id}");

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_update_a_tag_successfully()
    {
        $response = $this->actingAs($this->user)->putJson("/api/tags/{$this->tag->id}", [
            'title' => 'Updated Tag',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Tag updated successfully',
                'data' => [
                    'title' => 'Updated Tag',
                ],
            ]);
    }

    /** @test */
    public function it_can_delete_a_tag_successfully()
    {
        $response = $this->actingAs($this->user)->deleteJson("/api/tags/{$this->tag->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Tag deleted successfully',
            ]);

        $this->assertDatabaseMissing('tags', [
            'id' => $this->tag->id,
        ]);
    }
}
