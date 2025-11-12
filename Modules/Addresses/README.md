# Addresses Module
> This module references to [scaffolding](https://github.com/laravel-modules/scaffolding) project.

## Requirement Modules
* [Scaffolding Project](https://github.com/laravel-modules/scaffolding)
* [Country Module](https://github.com/laravel-modules/countries)

## Usage
> Clone the repository as name `Addresses` and copy the module folder into `Modules` in [scaffolding](https://github.com/laravel-modules/scaffolding) project.

```bash
cd /path/to/project

git clone https://github.com/laravel-modules/addresses Modules/Addresses
```
> Do not forget to remove `.git` folder.

```bash
rm -rf Modules/Addresses/.git
```
> Add the module into `modules_statuses.json` file.
```json
{
    "Accounts": true,
    "Dashboard": true,
    "Countries": true,
    "Addresses": true
}
```

> Add the seeders to `CustomerFactory` using `afterCreating`

```php
$factory->afterCreating(Customer::class, function (Customer $customer) {
    factory(\Modules\Addresses\Entities\Address::class)->create([
        'user_id' => $customer->id,
    ]);
});
```

> In `\Modules\Accounts\Entities\Customer` model use `HasManyAddresses` trait.

```php
use Modules\Addresses\Entities\Relations\HasManyAddresses;

class Customer extends User
{
    use HasParent, HasManyAddresses;
    ...
}
```

> In `CustomerController@show` method get the addresses from storage.

```php
/**
 * Display the specified resource.
 *
 * @param \Modules\Accounts\Entities\Customer $customer
 * @return \Illuminate\Http\Response
 */
public function show(Customer $customer)
{
    $customer = $this->repository->find($customer);

    $addresses = $customer->addresses()->with('city')->paginate();

    return view('accounts::customers.show', compact('customer', 'addresses'));
}
```

> In `customers/show.blade.php` view include the addresses file.

```blade
@include('addresses::index')
```

> Now you should update the composer packages.

```bash
composer update
```
> Migrate the tables.

```bash
php artisan migrate:fresh --seed
```