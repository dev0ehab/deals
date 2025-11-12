<?php

namespace Modules\Addresses\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounts\Entities\User;
use Modules\Addresses\Entities\Address;

class AddressRepository
{
    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return auth()->user()->addresses()->orderByDesc("is_default")->paginate(request('per_page') ?? 15);
    }

    /**
     * @param User $user
     * @param array $data
     * @return Model
     */
    public function create(User $user, array $data)
    {
        return $user->addresses()->create($data);
    }

    /**
     * @param Address $address
     * @param array $data
     * @return Address
     */
    public function update(Address $address, array $data)
    {
        if (isset($data["is_default"]) && $data["is_default"]) {
            auth()->user()->addresses()->update(
                [
                    "is_default" => 0
                ]
            );
        }

        $address->update($data);

        return $address;
    }

    /**
     * @param Address $address
     * @return mixed
     * @throws Exception
     */
    public function delete(Address $address)
    {
        return $address->delete();
    }
}
