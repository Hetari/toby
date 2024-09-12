<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Tab;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TabControllerTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_can_create_a_new_tab_successfully()
    {
        $collection = Collection::factory()->create();

        $response = $this->postJson('/api/tabs', [
            'title' => 'Example Tab',
            'url' => 'https://example.com',
            'collection_id' => $collection->id,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Tab created successfully',
            ]);

        $this->assertDatabaseHas('tabs', [
            'title' => 'Example Tab',
            'url' => 'https://example.com',
            'collection_id' => $collection->id,
        ]);
    }

    /** @test */
    public function it_fails_to_create_a_tab_with_invalid_data()
    {
        $response = $this->postJson('/api/tabs', [
            'title' => '',
            'url' => 'invalid-url',
            'collection_id' => 999999, // Non-existent collection
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid input',
            ]);
    }


    /** @test */
    public function it_can_retrieve_all_tabs()
    {
        $user = User::factory()->create(); // Helper method to authenticate
        Tab::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson('/api/tabs');

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_retrieve_a_specific_tab_by_id()
    {
        $user = User::factory()->create();
        $tab = Tab::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/tabs/{$tab->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $tab->id,
                ]
            ]);
    }
    /** @test */
    public function it_can_update_a_tab_successfully()
    {
        $user = User::factory()->create();
        $tab = Tab::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson("/api/tabs/{$tab->id}", [
            'title' => 'Updated Tab',
            'url' => 'https://updated-url.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Tab updated successfully',
            ]);

        $this->assertDatabaseHas('tabs', [
            'id' => $tab->id,
            'title' => 'Updated Tab',
            'url' => 'https://updated-url.com',
        ]);
    }
}
