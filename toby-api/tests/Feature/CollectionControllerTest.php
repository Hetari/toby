<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CollectionControllerTest extends TestCase
{
    protected $user;
    protected $tag;
    protected $collection;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->tag = Tag::factory()->create(['user_id' => $this->user->id]);
        $this->collection = Collection::factory()->create([
            'user_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function it_can_retrieve_all_collections()
    {
        $response = $this->actingAs($this->user)->getJson('/api/collections');
        $response->assertStatus(200);
    }

    // #[Test]
    public function it_can_retrieve_a_single_collection_by_id()
    {
        $response = $this->actingAs($this->user)->getJson("/api/collections/{$this->collection->id}");
        $response->assertStatus(200);
    }

    // #[Test]
    public function it_can_create_a_new_collection_successfully()
    {
        $response = $this->actingAs($this->user)->postJson('/api/collections', [
            'title' => 'New Collection',
            'is_fav' => true,
            'description' => 'Test collection',
            'tagId' => $this->tag->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('collections', [
            'title' => 'New Collection',
            'description' => 'Test collection',
            'user_id' => $this->user->id,
        ]);
    }

    #[Test]
    public function it_can_update_a_collection_successfully()
    {
        $response = $this->actingAs($this->user)->putJson("/api/collections/{$this->collection->id}", [
            'title' => 'Updated Collection',
            'description' => 'Updated description',
            'is_fav' => true,
        ]);

        dump($response->json());

        $response->assertStatus(200);

        // $this->assertDatabaseHas('collections', [
        //     'id' => $this->collection->id,
        //     'title' => 'Updated Collection',
        //     'description' => 'Updated description',
        //     'is_fav' => true,
        // ]);
    }

    #[Test]
    public function it_fails_to_create_a_collection_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->postJson('/api/collections', [
            'title' => '', // Invalid data (empty title)
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }

    #[Test]
    public function it_fails_to_update_a_collection_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->putJson("/api/collections/{$this->collection->id}", [
            'title' => '', // Invalid title
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }

    #[Test]
    public function it_can_delete_a_collection_successfully()
    {
        $response = $this->actingAs($this->user)->deleteJson("/api/collections/{$this->collection->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Collection deleted',
            ]);

        $this->assertDatabaseMissing('collections', [
            'id' => $this->collection->id,
        ]);
    }

    #[Test]
    public function it_fails_to_delete_a_non_existent_collection()
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/collections/999999'); // Non-existent collection ID

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'message' => 'Collection not found',
            ]);
    }
}
