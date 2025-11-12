<?php

namespace Modules\Addresses\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Accounts\Entities\User;
use Modules\Addresses\Entities\Address;
use Modules\Addresses\Http\Requests\AddressRequest;
use Modules\Addresses\Repositories\AddressRepository;

class AddressController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * The repository instance.
     *
     * @var AddressRepository
     */
    private $repository;

    /**
     * UserController constructor.
     *
     * @param AddressRepository $repository
     */
    public function __construct(AddressRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressRequest $request
     * @return RedirectResponse
     */
    public function store(AddressRequest $request, User $customer)
    {
        $this->repository->create($customer, $request->all());

        flash(trans('addresses::addresses.messages.created'))->success();

        return redirect()->route('dashboard.customers.show', $customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Address $address
     * @return Application|Factory|View
     */
    public function edit(User $customer, Address $address)
    {
        return view('addresses::edit', compact('customer', 'address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddressRequest $request
     * @param Address $address
     * @return RedirectResponse
     */
    public function update(AddressRequest $request, User $customer, Address $address)
    {
        $this->repository->update($address, $request->all());

        flash(trans('addresses::addresses.messages.updated'))->success();

        return redirect()->route('dashboard.customers.show', $customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $customer, Address $address)
    {
        $this->repository->delete($address);

        flash(trans('addresses::addresses.messages.deleted'))->error();

        return redirect()->route('dashboard.customers.show', $customer);
    }
}
