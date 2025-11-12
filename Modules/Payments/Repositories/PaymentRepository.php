<?php

namespace Modules\Payments\Repositories;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Modules\Contracts\CrudRepository;
use Modules\Payments\Entities\Payment;
use Modules\Payments\Http\Filters\PaymentFilter;

class PaymentRepository implements CrudRepository
{
    /**
     * @var PaymentFilter
     */
    private PaymentFilter $filter;

    /**
     * PaymentRepository constructor.
     * @param PaymentFilter $filter
     */
    public function __construct(PaymentFilter $filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return Payment::filter($this->filter)->paginate(request('perPage'));
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        $payment = Payment::create($data);

        if ($data['media']) {
            $payment->addMediaFromRequest('media')->toMediaCollection('images');
        }

        return $payment;
    }

    /**
     * @param mixed $model
     * @return Model|void
     */
    public function find($model)
    {
        if ($model instanceof Payment) {
            return $model;
        }

        return Payment::findOrFail($model);
    }

    /**
     * @param mixed $model
     * @param array $data
     * @return Model|void
     */
    public function update($model, array $data)
    {
        $payment = $this->find($model);

        $payment->update($data);

        if (isset($data['media'])) {
            $payment->clearMediaCollection('images');
            $payment->addMediaFromRequest('media')->toMediaCollection('images');
        }

        return $payment;
    }

    /**
     * @param mixed $model
     * @throws Exception
     */
    public function delete($model)
    {
        $this->find($model)->delete();
    }

    /**
     * @return mixed
     */
    public function active()
    {
        return Payment::active()->filter($this->filter)->get();
    }
}
