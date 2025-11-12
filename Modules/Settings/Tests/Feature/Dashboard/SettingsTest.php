<?php

namespace Modules\Settings\Tests\Feature\Dashboard;

use App\Http\Middleware\VerifyCsrfToken;
use Laraeast\LaravelSettings\Facades\Settings;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    /** @test */
    public function it_can_display_list_of_settings()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.settings.index', ['tab' => 'main']));

        $response->assertSuccessful();
    }

    /** @test */
    public function it_can_update_admin_settings()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails

        $this->actingAsAdmin();

        $this->put(route('dashboard.settings.update'), [
            'facebook' => 'https://www.facebook.com/',
            'twitter' => 'https://www.twitter.com/',
            'instagram' => 'https://www.instagram.com/',
            'youtube' => 'https://www.youtube.com/',
        ])->assertRedirect();

        $this->assertEquals('https://www.facebook.com/', Settings::get('facebook'));
        $this->assertEquals('https://www.twitter.com/', Settings::get('twitter'));
        $this->assertEquals('https://www.instagram.com/', Settings::get('instagram'));
        $this->assertEquals('https://www.youtube.com/', Settings::get('youtube'));
    }
}
