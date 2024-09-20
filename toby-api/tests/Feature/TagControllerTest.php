<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function it_can_create_a_new_tag_successfully()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tags', [
            'title' => 'New Tagskdhsd',
            'collection_id' => $this->collection->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED)->assertJson([
            'success' => true,
            'message' => 'Tag created successfully',
            'errors' => [],
        ]);
    }

    #[Test]
    public function it_fails_to_create_a_tag_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tags', [
            'title' => '', // Invalid data (empty title)
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }

    #[Test]
    public function it_can_retrieve_all_tags()
    {
        $response = $this->actingAs($this->user)->getJson('/api/tags');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
            ])
        ;
    }

    #[Test]
    public function it_can_retrieve_a_tag_by_id()
    {
        $response = $this->actingAs($this->user)->getJson("/api/tags/1");
        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function it_can_update_a_tag_successfully()
    {
        $response = $this->actingAs($this->user)->putJson("/api/tags/{$this->tag->id}", [
            'title' => 'Updated Tag',
            'collection_id' => $this->collection->id,
        ]);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson([
                'success' => true,
                'message' => 'Tag updated successfully',
                'errors' => [],
            ]);
    }

    #[Test]
    public function it_can_delete_a_tag_successfully()
    {
        $response = $this->actingAs($this->user)->deleteJson("/api/tags/{$this->tag->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('tags', [
            'id' => $this->tag->id,
        ]);
    }

    #[Test]
    public function it_returns_not_found_for_non_existent_tag()
    {
        $response = $this->actingAs($this->user)->getJson('/api/tags/9999999999999999');

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'success' => false,
                'message' => 'Not found',
            ]);
    }

    #[Test]
    public function it_fails_to_update_a_tag_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->putJson("/api/tags/{$this->tag->id}", [
            'title' => '', // Invalid data
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }

    #[Test]
    public function it_returns_not_found_when_deleting_non_existent_tag()
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/tags/9999'); // Assuming ID 9999 doesn't exist

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'success' => false,
                'message' => 'Not found',
            ]);
    }

    #[Test]
    public function it_fails_to_retrieve_tags_if_unauthenticated()
    {
        $response = $this->getJson('/api/tags'); // No actingAs

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'You must be logged in to access this resource.',
            ]);
    }

    #[Test]
    public function it_can_search_for_tags_by_title()
    {
        Tag::factory()->create([
            'title' => 'Important Tag',
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/tags?search=Important');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'user_id', 'created_at', 'updated_at'],
                ],
            ]);
    }
}
