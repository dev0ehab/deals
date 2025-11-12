<?php

namespace Modules\Addresses\Tests\Feature\Dashboard;

use App\Http\Middleware\VerifyCsrfToken;
use Modules\Accounts\Entities\Customer;
use Modules\Addresses\Entities\Address;
use Modules\Countries\Entities\City;
use Modules\Countries\Entities\Region;
use Tests\TestCase;

class AddressTest extends TestCase
{


    /** @test */
    public function it_can_display_list_of_customer_addresses()
    {
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $response = $this->get(route('dashboard.customers.show', $customer));

        $response->assertSuccessful();

        $response->assertSee(e($address->name));
    }

    /** @test */
    public function it_can_create_addresses()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();

        $city = City::factory()->create();

        $region = Region::factory()->create(['city_id' => $city->id]);

        $addressesCount = $customer->addresses()->count();

        $response = $this->post(
            route('dashboard.customers.addresses.store', $customer),
            [
                'address' => 'Test',
                'description' => 'Test desc',
                'city_id' => $city->id,
                'region_id' => $region->id,
                'lat' => '31.0243506',
                'long' => '31.3655877',
            ]
        );

        $response->assertRedirect();

        $this->assertEquals($customer->addresses()->count(), $addressesCount + 1);
        $this->assertEquals($customer->addresses->last()->address, 'Test');
    }

    /** @test */
    public function it_can_display_address_edit_form()
    {
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $response = $this->get(route('dashboard.customers.addresses.edit', [$customer, $address]));

        $response->assertSuccessful();

        $response->assertSee(trans('addresses::addresses.actions.edit'));
    }

    /** @test */
    public function it_can_update_addresses()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $city = City::factory()->create();

        $region = Region::factory()->create(['city_id' => $city->id]);

        $response = $this->put(
            route('dashboard.customers.addresses.update', [$customer, $address]),
            [
                'address' => 'Test',
                'description' => 'Test desc',
                'city_id' => $city->id,
                'region_id' => $region->id,
                'lat' => '31.0243506',
                'long' => '31.3655877',
            ]
        );

        $response->assertRedirect();

        $address->refresh();

        $this->assertEquals($address->address, 'Test');
        $this->assertEquals($address->city_id, $city->id);
        $this->assertEquals($address->region_id, $region->id);
    }

    /** @test */
    public function it_can_delete_address()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class); // remove if test fails
        $this->actingAsAdmin();

        $customer = Customer::factory()->create();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $addressesCount = $customer->addresses()->count();

        $response = $this->delete(route('dashboard.customers.addresses.destroy', [$customer, $address]));
        $response->assertRedirect();

        $this->assertEquals($customer->addresses()->count(), $addressesCount - 1);
    }
}
