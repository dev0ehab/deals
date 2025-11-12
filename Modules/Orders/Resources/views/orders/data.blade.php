@component('dashboard::layouts.components.table-box')
    @slot('title', trans('orders::orders.plural'))

    @php
        use App\Enums\OrderStatusEnum;
        $statuses = array_slice(OrderStatusEnum::values(), 1, -1);
        $orderClassEnum = OrderStatusEnum::class;

    @endphp


    <nav class="nav nav-pills flex-column flex-sm-row my-5">
        @foreach ($statuses as $status)
            <a class='flex-sm-fill text-sm-center nav-link {{ (request()->status ?? 'pending') == $status ? 'active' : '' }}'
                href="{{ route('dashboard.orders.index', ['status' => $status]) }}">@lang("orders::orders.status.$status")</a>
        @endforeach

    </nav>


    <thead>
        <tr>
            <th>#</th>
            <th>@lang('orders::orders.attributes.id')</th>
            <th>@lang('accounts::user.attributes.name')</th>
            <th>@lang('orders::orders.attributes.delivery_type')</th>
            <th>@lang('orders::orders.attributes.area')</th>

            <th>@lang('orders::orders.attributes.total_products')</th>
            <th>@lang('orders::orders.attributes.total_files')</th>
            <th>@lang('orders::orders.attributes.created_at')</th>
            <th style="width: 160px">...</th>
        </tr>
    </thead>
    <tbody>
        @forelse($orders as $order)
            <tr>
                <td>
                    <a href="{{ route('dashboard.orders.show', $order) }}" class="text-decoration-none text-ellipsis">
                        {{ $loop->iteration }}
                    </a>
                </td>

                <td>
                    {{  '#' . $order->id }}
                </td>

                <td>
                    {{ $order->user->name }}
                </td>


                <td>
                    {{ __('orders::orders.delivery_type.' . $order->delivery_type) }}
                </td>

                <td>
                    {{ $order->address?->areaModel?->name ?? '---' }}
                </td>

                <td>
                    {{ $order->orderProducts->count()  ?? '---' }}
                </td>

                <td>
                    {{ $order->orderFiles->count() ?? '---' }}
                </td>

                <td>
                    {{ date('Y-m-d h:i A', strtotime($order->created_at)) }}
                </td>

                <td style="width: 160px">
                    @include('orders::orders.partials.actions.show')
                    @if ($newStatus = $orderClassEnum::nextStatus($order->status))

                    @php
                        $flag = [
                            [
                                'icon'            => 'fa-check-circle',
                                'color'           => 'success',
                            ],
                            [
                                'icon'            => 'fa-times',
                                'color'           => 'danger',
                            ],
                        ];
                    @endphp


                        @foreach (is_array($newStatus) ? $newStatus : [$newStatus] as $index => $status)

                            @include('orders::orders.partials.actions.change-status', [
                                'status'          => $status,
                                'with_image'      => false,
                                'with_image_name' => 'invoice',
                                'icon'            => $flag[$index]['icon'],
                                'color'           => $flag[$index]['color'],
                            ])
                        @endforeach
                    @endif

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders::orders.empty')</td>
            </tr>
        @endforelse

        @if ($orders->hasPages())
            @slot('footer')
                {{ $orders->links() }}
            @endslot
        @endif
    </tbody>
@endcomponent
