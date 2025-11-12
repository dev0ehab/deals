<?php

namespace Modules\Accounts\Tests\Feature\Dashboard;

use Modules\Accounts\Entities\Admin;
use Tests\TestCase;

class AdminFilterTest extends TestCase
{


    /** @test */
    public function it_can_filter_admins_by_name()
    {
        $this->actingAsAdmin();

        $admin = Admin::factory()->create(['name' => 'Ahmed']);

        $admin->attachRole('receptionist');

        $second_admin = Admin::factory()->create(['name' => 'Mohamed']);

        $second_admin->attachRole('receptionist');

        $this->get(route('dashboard.admins.index', [
            'name' => 'ahmed',
        ]))
            ->assertSuccessful()
            ->assertSee('Ahmed')
            ->assertDontSee('Mohamed');
    }

    /** @test */
    public function it_can_filter_admins_by_email()
    {
        $this->actingAsAdmin();

        $admin = Admin::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@demo.com',
        ]);

        $admin->attachRole('receptionist');

        $second_admin = Admin::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@demo.com',
        ]);

        $second_admin->attachRole('receptionist');

        $this->get(route('dashboard.admins.index', [
            'email' => 'user1@',
        ]))
            ->assertSuccessful()
            ->assertSee('User 1')
            ->assertDontSee('User 2');
    }

    /** @test */
    public function it_can_filter_admins_by_phone()
    {
        $this->actingAsAdmin();

        $admin = Admin::factory()->create([
            'name' => 'User 1',
            'phone' => '123',
        ]);

        $admin->attachRole('receptionist');

        $second_admin = Admin::factory()->create([
            'name' => 'User 2',
            'email' => '456',
        ]);

        $second_admin->attachRole('receptionist');

        $this->get(route('dashboard.admins.index', [
            'phone' => '123',
        ]))
            ->assertSuccessful()
            ->assertSee('User 1')
            ->assertDontSee('User 2');
    }
}
