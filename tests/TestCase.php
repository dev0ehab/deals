<?php

namespace Tests;

use Database\Seeders\LaratrustSeeder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Accounts\Entities\Admin;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * Set the currently logged in admin for the application.
     *
     * @param null $driver
     * @return Admin
     */
    public function actingAsAdmin($driver = null)
    {
        $this->seed(LaratrustSeeder::class);

        $admin = Admin::factory()->create();

        $admin->attachRole('super_admin');

        $this->be($admin, $driver);

        return $admin;
    }

//    /**
//     * Set the currently logged in admin for the application.
//     *
//     * @param null $driver
//     * @return Customer
//     */
//    public function actingAsCustomer($driver = null): Customer
//    {
//        $this->seed(LaratrustSeeder::class);
//
//        $customer = Customer::factory()->create();
//
//        $this->be($customer, $driver);
//
//        return $customer;
//    }

    /**
     * Determine wither the model use soft deleting trait.
     *
     * @param $model
     * @return bool
     */
    public function useSoftDeletes($model)
    {
        return in_array(
            SoftDeletes::class,
            array_keys((new \ReflectionClass($model))->getTraits())
        );
    }

}
