<?php

use App\Models\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;

class IsAuthenticatedTest extends TestCase
{
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_can_check_if_user_is_authenticated()
    {
        $response = $this->get('/api/collections');
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function it_can_check_if_user_is_authenticated_with_auth()
    {
        $response = $this->actingAs($this->user)->get('/api/collections');
        $response->assertStatus(Response::HTTP_OK);
    }
}
