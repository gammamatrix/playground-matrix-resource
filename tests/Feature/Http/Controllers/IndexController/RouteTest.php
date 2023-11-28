<?php
/**
 * GammaMatrix
 */

namespace Tests\Feature\GammaMatrix\Playground\Matrix\Resource\Http\Controllers\IndexController;

use GammaMatrix\Playground\Test\Models\User;
use Tests\Feature\GammaMatrix\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Matrix\Resource\Http\Controllers\IndexController\RouteTest
 *
 */
class RouteTest extends TestCase
{
    public function test_guest_cannot_render_package_index_view()
    {
        $url = route('playground.matrix.resource');

        $response = $this->get($url);
        $response->assertRedirect();
    }

    public function test_user_can_render_package_index_view()
    {
        $user = User::factory()->create();

        $url = route('playground.matrix.resource');

        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(200);

        $this->assertAuthenticated();
    }
}
