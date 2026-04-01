<?php

namespace Tests\Feature;

use App\Filament\Resources\SurveyResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Statikbe\Surveyhero\Models\Survey;
use Tests\TestCase;

class SurveyResourceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_can_render_survey_list_page(): void
    {
        $response = $this->get(SurveyResource::getUrl('index'));

        $response->assertStatus(200);
    }

    public function test_can_render_survey_view_page(): void
    {
        $survey = Survey::create([
            'name' => 'Test Survey',
            'surveyhero_id' => 123456,
        ]);

        $response = $this->get(SurveyResource::getUrl('view', ['record' => $survey]));

        $response->assertStatus(200);
    }
}
