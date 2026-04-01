<?php

namespace Tests\Feature;

use App\Filament\Pages\SecurityTxtPage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityTxtPageTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_render_security_txt_page(): void
    {
        $response = $this->get(SecurityTxtPage::getUrl());

        $response->assertStatus(200);
    }
}
