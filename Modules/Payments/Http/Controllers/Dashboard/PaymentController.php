<?php

namespace Modules\Payments\Http\Controllers\Dashboard;

use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Payments\Entities\Payment;
use Modules\Payments\Http\Requests\PaymentRequest;
use Modules\Payments\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var PaymentRepository
     */
    private $repository;

    /**
     * PaymentController constructor.
     * @param PaymentRepository $repository
     */
    public function __construct(PaymentRepository $repository)
    {
        $this->middleware('permission:read_payments')->only(['index']);
        $this->middleware('permission:create_payments')->only(['create', 'store']);
        $this->middleware('permission:update_payments')->only(['edit', 'update']);
        $this->middleware('permission:delete_payments')->only(['destroy']);
        $this->middleware('permission:show_payments')->only(['show']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $payments = $this->repository->all();

        return view('payments::payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Factory|View
     */
    public function create()
    {
        return view('payments::payments.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param PaymentRequest $request
     * @return RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
        $payment = $this->repository->create($request->all());

        flash(trans('payments::payments.messages.created'))->success();

        return redirect()->route('dashboard.payments.show', $payment);
    }

    /**
     * Show the specified resource.
     * @param Payment $payment
     * @return Factory|View
     */
    public function show(Payment $payment)
    {
        $payment = $this->repository->find($payment);

        return view('payments::payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Payment $payment
     * @return Factory|View
     */
    public function edit(Payment $payment)
    {
        return view('payments::payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     * @param PaymentRequest $request
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function update(PaymentRequest $request, Payment $payment)
    {
        $payment = $this->repository->update($payment, $request->all());

        flash(trans('payments::payments.messages.updated'))->success();

        return redirect()->route('dashboard.payments.show', $payment);
    }

    /**
     * Remove the specified resource from storage.
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function destroy(Payment $payment)
    {
        $this->repository->delete($payment);

        flash(trans('payments::payments.messages.deleted'))->error();

        return redirect()->route('dashboard.payments.index');
    }
}
