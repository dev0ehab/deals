<?php

namespace Modules\Accounts\Tests\Feature\Dashboard;

use App\Http\Middleware\VerifyCsrfToken;
use Modules\Accounts\Entities\Admin;
use Tests\TestCase;

class AdminTest extends TestCase
{


    /** @test */
    public function it_can_display_list_of_admins()
    {
        $this->actingAsAdmin();

        $admin = Admin::factory()->create();

        $response = $this->get(route('dashboard.admins.index'));

        $response->assertSuccessful();

        $response->assertSee(e($admin->name));
    }

    /** @test */
    public function it_can_display_admin_details()
    {
        $this->actingAsAdmin();

        $admin = Admin::factory()->create();

        $response = $this->get(route('dashboard.admins.show', $admin));

        $response->assertSuccessful();

        $response->assertSee(e($admin->name));
    }

    /** @test */
    public function it_can_display_admin_create_form()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.admins.create'));

        $response->assertSuccessful();

        $response->assertSee(trans('accounts::admins.actions.create'));
    }

    /** @test */
    public function it_can_create_admins()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $adminsCount = Admin::count();

        $response = $this->post(
            route('dashboard.admins.store'),
            [
                'name' => 'Admin',
                'email' => 'admin@demo.com',
                'phone' => '123456789',
                'password' => 'password',
                'password_confirmation' => 'password',
                'role_id' => 1
            ]
        );

        $response->assertRedirect();

        $this->assertEquals(Admin::count(), $adminsCount + 1);
    }

    /** @test */
    public function it_can_display_admin_edit_form()
    {
        $this->actingAsAdmin();

        $admin = Admin::factory()->create();

        $response = $this->get(route('dashboard.admins.edit', $admin));

        $response->assertSuccessful();

        $response->assertSee(trans('accounts::admins.actions.edit'));
    }

    /** @test */
    public function it_can_update_admins()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $admin = Admin::factory()->create();

        $response = $this->put(
            route('dashboard.admins.update', $admin),
            [
                'name' => 'Admin',
                'email' => 'admin@demo.com',
                'phone' => '123456789',
                'password' => 'password',
                'password_confirmation' => 'password',
                'role_id' => 1
            ]
        );

        $response->assertRedirect();

        $admin->refresh();

        $this->assertEquals($admin->name, 'Admin');
    }

    /** @test */
    public function it_can_delete_admin()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $admin = Admin::factory()->create();

        $adminsCount = Admin::count();

        $response = $this->delete(route('dashboard.admins.destroy', $admin));
        $response->assertRedirect();

        $this->assertEquals(Admin::count(), $adminsCount - 1);
    }

//    /** @test */
//    public function it_can_block_admins()
//    {
//        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
//        $this->actingAsAdmin();
//
//        $admin = Admin::factory()->create();
//
//        $admin->block()->save();
//
//        $response = $this->get(route('dashboard.admins.show', $admin));
//
//        $response->assertSuccessful();
//
//        $admin->refresh();
//
//        $response->assertSee(trans('accounts::admins.actions.unblock'));
//    }
//
//    /** @test */
//    public function it_can_unblock_admins()
//    {
//        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
//        $this->actingAsAdmin();
//
//        $admin = Admin::factory()->create();
//
//        $admin->block()->save();
//
//        $response = $this->get(route('dashboard.admins.show', $admin));
//
//        $response->assertSuccessful();
//
//        $admin->refresh();
//
//        $response->assertSee(trans('accounts::admins.actions.unblock'));
//
//        // unblock
//
//        $admin->unblock()->save();
//
//        $response = $this->get(route('dashboard.admins.show', $admin));
//
//        $response->assertSuccessful();
//
//        $admin->refresh();
//
//        $response->assertSee(trans('accounts::admins.actions.block'));
//    }
}
