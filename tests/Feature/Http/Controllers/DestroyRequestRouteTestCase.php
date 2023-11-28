<?php
/**
 * GammaMatrix
 */

namespace Tests\Feature\GammaMatrix\Playground\Matrix\Resource\Http\Controllers;

use GammaMatrix\Playground\Test\Models\User;
use Tests\Feature\GammaMatrix\Playground\Matrix\Resource\TestCase;

/**
 * \Tests\Feature\GammaMatrix\Playground\Matrix\Resource\Http\Controllers\DestroyRequestRouteTestCase
 *
 */
abstract class DestroyRequestRouteTestCase extends TestCase
{
    public function test_destroy_as_guest_and_fail()
    {
        $fqdn = $this->fqdn;

        $model = $fqdn::factory()->create();

        $this->assertDatabaseHas($this->packageInfo['table'], [
            'id' => $model->id,
            // 'owned_by_id' => $user->id,
            'deleted_at' => null,
        ]);

        $url = route(sprintf(
            '%1$s.destroy',
            $this->packageInfo['model_route']
        ), [
            $this->packageInfo['model_slug'] => $model->id,
        ]);

        $response = $this->get($url);
        $response->assertRedirect();

        $this->assertDatabaseHas($this->packageInfo['table'], [
            'id' => $model->id,
            // 'owned_by_id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    // public function test_user_can_render_destroy_view_with_return_url()
    // {
    //     $fqdn = $this->fqdn;

    //     $model = $fqdn::factory()->create();

    //     $user = User::factory()->create();

    //     $index = route($this->packageInfo['model_route']);

    //     $url = route(sprintf(
    //         '%1$s.destroy',
    //         $this->packageInfo['model_route']
    //     ), [
    //         $this->packageInfo['model_slug'] => $model->id,
    //         '_return_url' => $index,
    //     ]);

    //     $response = $this->actingAs($user)->get($url);

    //     $response->assertStatus(200);

    //     $this->assertAuthenticated();

    //     $response->assertSee(sprintf(
    //         '<input type="hidden" name="_return_url" value="%1$s">',
    //         $index
    //     ), false);
    // }

    // public function test_destroy_with_user_using_json()
    // {
    //     $fqdn = $this->fqdn;

    //     $model = $fqdn::factory()->create();

    //     $user = User::factory()->create();

    //     $url = route(sprintf(
    //         '%1$s.destroy',
    //         $this->packageInfo['model_route']
    //     ), [
    //         $this->packageInfo['model_slug'] => $model->id,
    //     ]);

    //     $response = $this->actingAs($user)->getJson($url);

    //     $response->assertStatus(200);
    //     // $response->dump();

    //     $response->assertJsonStructure([
    //         'data',
    //         'meta',
    //     ]);
    //     $this->assertAuthenticated();
    // }

    // public function test_user_can_render_destroy_view_with_invalid_parameter()
    // {
    //     $fqdn = $this->fqdn;

    //     $model = $fqdn::factory()->create();

    //     $user = User::factory()->create();

    //     $url = route(sprintf(
    //         '%1$s.destroy',
    //         $this->packageInfo['model_route']
    //     ), [
    //         $this->packageInfo['model_slug'] => $model->id,
    //     ]);

    //     $response = $this->actingAs($user)->get($url.'?owned_by_id=[duck]');

    //     // $response->dump();
    //     // $response->dumpHeaders();
    //     // $response->dumpSession();
    //     $response->assertStatus(302);

    //     // // The owned by id field must be a valid UUID.
    //     $response->assertSessionHasErrors([
    //         'owned_by_id',
    //     ]);

    //     $this->assertAuthenticated();
    // }
}
