<?php

namespace Tests\Feature;

use App\Filament\Resources\PageResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageResourceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_render_page_list(): void
    {
        $response = $this->get(PageResource::getUrl('index'));

        $response->assertStatus(200);
    }

    public function test_can_render_create_page_form(): void
    {
        $response = $this->get(PageResource::getUrl('create'));

        $response->assertStatus(200);
    }
}
