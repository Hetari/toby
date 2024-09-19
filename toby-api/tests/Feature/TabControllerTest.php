<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

// TODO: add assertJson for all tests
class TabControllerTest extends TestCase
{
    // use RefreshDatabase;
    protected $user;
    protected $tab;
    protected $collection;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

        $this->collection = Collection::factory()
            ->for($this->user)
            ->create();

        $this->tab = Tab::factory()
            ->for($this->collection)
            ->create();
    }

    #[Test]
    public function it_can_create_a_new_tab_successfully()
    {
        $collection = $this->collection;

        $response = $this->actingAs($this->user)->postJson('/api/tabs', [
            'title' => 'Example Tab',
            'url' => 'https://example.com',
            'collection_id' => $collection->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    #[Test]
    public function it_fails_to_create_a_tab_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->postJson('/api/tabs', [
            'title' => '',
            'url' => 'invalid-url',
            'collection_id' => 99999999999999, // Non-existent collection
        ]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }


    #[Test]
    public function it_can_retrieve_all_tabs()
    {
        $response = $this->actingAs($this->user)->getJson("/api/tabs/");
        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function it_can_retrieve_a_specific_tab_by_id()
    {
        $response = $this->actingAs($this->user)->getJson("/api/tabs/{$this->tab->id}");
        $response->assertStatus(Response::HTTP_OK);
    }
    #[Test]
    public function it_can_update_a_tab_successfully()
    {
        $response = $this->actingAs($this->user)->putJson("/api/tabs/{$this->tab->id}", [
            'title' => 'Updated Tab',
            'url' => 'https://www.chatgpt.com/',
            'collection_id' => $this->collection->id,
        ]);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('tabs', [
            'id' => $this->tab->id,
            'title' => 'Updated Tab',
            'url' => 'https://www.chatgpt.com/',
        ]);
    }

    #[Test]
    public function it_can_delete_a_tab_successfully()
    {
        $response = $this->actingAs($this->user)->deleteJson("/api/tabs/{$this->tab->id}");

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('tabs', [
            'id' => $this->tab->id,
        ]);
    }

    #[Test]
    public function it_returns_not_found_for_non_existent_tab()
    {
        $response = $this->actingAs($this->user)->getJson('/api/tabs/9999999999999999');

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'success' => false,
                'message' => 'Not found',

            ]);
    }

    #[Test]
    public function it_fails_to_update_a_tab_with_invalid_data()
    {
        $response = $this->actingAs($this->user)->putJson("/api/tabs/{$this->tab->id}", [
            'title' => '', // Invalid data
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }

    #[Test]
    public function it_returns_not_found_when_deleting_non_existent_tab()
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/tabs/9999'); // Assuming ID 9999 doesn't exist

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJson([
                'success' => false,
                'message' => 'Not found',
            ]);
    }

    #[Test]
    public function it_fails_to_retrieve_tabs_if_unauthenticated()
    {
        $response = $this->getJson('/api/tabs'); // No actingAs

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
            ->assertJson([
                'success' => false,
                'error' => 'Unauthorized',
                'message' => 'You must be logged in to access this resource.',
            ]);
    }

    #[Test]
    public function it_can_search_for_tabs_by_title()
    {
        Tab::factory()->create([
            'title' => 'Important Tab',
            'collection_id' => $this->collection->id,
        ]);

        $response = $this->actingAs($this->user)->getJson('/api/tabs?search=Important');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'url', 'collection_id', 'created_at', 'updated_at'],
                ],
            ]);
    }
}
