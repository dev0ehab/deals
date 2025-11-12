<?php

namespace Modules\Orders\Http\Controllers\Dashboard;

use App\Enums\OrderStatusEnum;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Orders\Entities\Order;
use Modules\Orders\Events\UpdateOrderStatusEvent;
use Modules\Orders\Http\Requests\ChangeStatusRequest;
use Modules\Orders\Repositories\OrderRepository;


class OrderController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var OrderRepository
     */
    private OrderRepository $repository;

    /**
     * OrderController constructor.
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->middleware('permission:read_orders')->only(['index']);
        $this->middleware('permission:create_orders')->only(['create', 'store']);
        $this->middleware('permission:update_orders')->only(['edit', 'update']);
        $this->middleware('permission:delete_orders')->only(['destroy']);
        $this->middleware('permission:show_orders')->only(['show', 'invoice']);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     * @return Factory|View
     */
    public function index()
    {
        $orders = $this->repository->all();
        return view('orders::orders.index', get_defined_vars());
    }

    /**
     * Show the specified resource.
     * @param Order $order
     * @return Factory|View
     */
    public function show(Order $order)
    {
        $order = $this->repository->find($order);
        return view('orders::orders.show', get_defined_vars());
    }

    /**
     * Remove the specified resource from storage.
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $this->repository->delete($order);

        flash(trans('orders::orders.messages.deleted'))->error();

        return redirect()->route('dashboard.orders.index');
    }

    /**
     * change the status
     * @param Order $order
     * @return RedirectResponse
     */
    public function status(ChangeStatusRequest $request,  Order $order)
    {

        $order->update($request->validated());

        flash(trans('orders::orders.messages.status'))->success();

        event(new UpdateOrderStatusEvent($order->refresh()));

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param Order $order
     * @return Factory|View
     */
    public function invoice(Order $order)
    {
        $order = $this->repository->find($order);

        return view('orders::orders.invoice-new', compact('order'));
    }

    /**
     * Show the specified resource.
     * @param Order $order
     * @return Factory|View
     */
    public function printReceipt(Order $order)
    {
        $order = $this->repository->find($order);

        return view('orders::orders.invoice_receipt', compact('order'));
    }
}
