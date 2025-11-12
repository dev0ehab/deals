<?php

namespace Modules\Addresses\Tests\Feature\Api;

use Modules\Addresses\Entities\Address;
use Modules\Countries\Entities\City;
use Modules\Countries\Entities\Region;
use Tests\TestCase;

class AddressApiTest extends TestCase
{


    /** @test */
    public function it_can_display_list_of_customer_addresses_api()
    {
        $customer = $this->actingAsCustomer();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $response = $this->get(route('addresses.index'));

        $response->assertSuccessful();

        $response->assertSee(e($address->name));
        $response->assertSee(e($address->city->name));
        $response->assertSee(e($address->city->country->name));
    }

    /** @test */
    public function it_can_create_address_api()
    {
        $customer = $this->actingAsCustomer();

        $city = City::factory()->create();

        $region = Region::factory()->create(['city_id' => $city->id]);

        $addressesCount = $customer->addresses()->count();

        $response = $this->post(
            route('addresses.store'),
            [
                'address' => 'Test',
                'description' => 'Test desc',
                'city_id' => $city->id,
                'region_id' => $region->id,
                'lat' => '31.0243506',
                'long' => '31.3655877',
            ]
        );

        $response->assertSuccessful();

        $this->assertEquals($customer->addresses()->count(), $addressesCount + 1);
        $this->assertEquals($customer->addresses->last()->address, 'Test');
    }

    /** @test */
    public function it_can_update_customer_address_api()
    {
        $customer = $this->actingAsCustomer();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $city = City::factory()->create();

        $region = Region::factory()->create(['city_id' => $city->id]);

        $response = $this->post(
            route('addresses.update', [$customer, $address]),
            [
                'address' => 'Test',
                'description' => 'Test desc',
                'city_id' => $city->id,
                'region_id' => $region->id,
                'lat' => '31.0243506',
                'long' => '31.3655877',
            ]
        );

        $response->assertSuccessful();

        $address->refresh();

        $this->assertEquals($address->address, 'Test');
        $this->assertEquals($address->city_id, $city->id);
        $this->assertEquals($address->region_id, $region->id);
    }

    /** @test */
    public function it_can_delete_customer_address_api()
    {
        $customer = $this->actingAsCustomer();

        $address = Address::factory()->create(['user_id' => $customer->id]);

        $addressesCount = $customer->addresses()->count();

        $response = $this->post(route('addresses.destroy', [$customer, $address]));
        $response->assertSuccessful();

        $this->assertEquals($customer->addresses()->count(), $addressesCount - 1);
    }
}
