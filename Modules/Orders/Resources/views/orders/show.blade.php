@extends('dashboard::layouts.default')

@php
    use App\Enums\OrderStatusEnum;
$orderClassEnum = OrderStatusEnum::class;
$lang = app()->getLocale();
@endphp

@section('title')
    @lang('orders::orders.singular') #{{ $order->id }}
@endsection


@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('orders::orders.singular') . ' #' . $order->id)
        @slot('breadcrumbs', ['dashboard.orders.show', $order])

        <div class="row">
            <!-- Order Basic Information -->
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('title', trans('orders::orders.attributes.statuses.status'))
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.id')</th>
                                <td>
                                    <span class="badge badge-primary">#{{ $order->id }}</span>
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.statuses.status')</th>
                                <td>{!! $order->getStatus() !!}</td>
                            </tr>

                            @if($order->name)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.name')</th>
                                <td>{{ $order->name }}</td>
                            </tr>
                            @endif

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.delivery_type')</th>
                                <td>{{ __('orders::orders.delivery_type.' . $order->delivery_type) }}</td>
                            </tr>

                            @if($order->delivery_type == 'delivery')
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.area')</th>
                                <td>{{ $order->address->areaModel?->name }}</td>
                            </tr>
                            @endif

                            @if($order->description)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.description')</th>
                                <td>{{ $order->description }}</td>
                            </tr>
                            @endif

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.created_at')</th>
                                <td>{{ $order->created_at->format('Y-m-d h:i A') }}</td>
                            </tr>

                            @if ($order->isStatus(OrderStatusEnum::CANCELLED->value))
                                <tr>
                                    <th width="200">@lang('orders::orders.attributes.cancel_reason')</th>
                                    <td>
                                        <span class="text-danger">{{ $order->cancel_reason }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th width="200">@lang('orders::orders.attributes.is_refunded')</th>
                                    <td>
                                        @include('dashboard::layouts.apps.flag', [
                                            'bool' => $order->is_refunded,
                                        ])
                                    </td>
                                </tr>
                            @endif




                            <tr>
                                <th width="200"></th>
                                <td>

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
                        </tbody>
                    </table>
                @endcomponent
            </div>

            <!-- Customer Information -->
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('title', trans('accounts::user.singular'))
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('accounts::user.attributes.name')</th>
                                <td>{{ $order->user->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('accounts::user.attributes.email')</th>
                                <td>{{ $order->user->email }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('accounts::user.attributes.phone')</th>
                                <td>{{ $order->user->phone ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>

        <div class="row">
            <!-- Address Information -->

            @if($order->address)

            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('title', trans('addresses::addresses.singular'))
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.address')</th>
                                <td>{{ $order->address->address }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.area')</th>
                                <td>{{ $order->address->area }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.building_number')</th>
                                <td>{{ $order->address->building_number }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.appartement_number')</th>
                                <td>{{ $order->address->appartement_number }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.floor_number')</th>
                                <td>{{ $order->address->floor_number }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.street_name')</th>
                                <td>{{ $order->address->street_name }}</td>
                            </tr>
                            @if($order->address->landmark)
                            <tr>
                                <th width="200">@lang('addresses::addresses.attributes.landmark')</th>
                                <td>{{ $order->address->landmark }}</td>
                            </tr>
                        </tbody>
                    </table>

                    @endif
                    @endcomponent
                </div>
                @endif

            <!-- Payment & Pricing Information -->
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('title', trans('orders::orders.attributes.total'))
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>

                            <tr>
                                <th width="200">@lang('orders::orders.attributes.product_sub_total')</th>
                                <td>{{ number_format($order->orderProducts->sum('total'), 2) }} @lang('currency.symbol')</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.print_sub_total')</th>
                                <td>{{ number_format($order->orderFiles->sum('total'), 2) }} @lang('currency.symbol')</td>
                            </tr>

                            @if($order->discount > 0)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.discount')</th>
                                <td class="text-success">-{{ number_format($order->discount, 2) }} @lang('currency.symbol')</td>
                            </tr>
                            @endif

                            @if($order->bulk_discount > 0)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.bulk_discount')</th>
                                <td class="text-success">-{{ number_format($order->bulk_discount, 2) }} @lang('currency.symbol')</td>
                            </tr>
                            @endif

                            @if($order->tax > 0)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.tax')</th>
                                <td>{{ number_format($order->tax, 2) }} @lang('currency.symbol')</td>
                            </tr>
                            @endif

                            @if($order->delivery_fee > 0)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.delivery_fee')</th>
                                <td>{{ number_format($order->delivery_fee, 2) }} @lang('currency.symbol')</td>
                            </tr>
                            @endif

                            <tr class="table-active">
                                <th width="200"><strong>@lang('orders::orders.attributes.total')</strong></th>
                                <td><strong>{{ number_format($order->total, 2) }} @lang('currency.symbol')</strong></td>
                            </tr>

                            @if($order->payment)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.payment_id')</th>
                                <td>{{ $order->payment->name }}</td>
                            </tr>
                            @endif

                            @if($order->coupon)
                            <tr>
                                <th width="200">@lang('orders::orders.attributes.coupon')</th>
                                <td>
                                    <span class="badge badge-info">{{ $order->coupon->code }}</span>
                                    @if($order->coupon->description)
                                        <br><small class="text-muted">{!! $order->coupon->description !!}</small>
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>

        <!-- Order Files/Items -->
        @if($order->orderFiles && $order->orderFiles->count() > 0)
        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('title', trans('orders::orders.attributes.print_service'))
                    @slot('bodyClass', 'p-0')

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('orders::orders.attributes.products.print.receipt_name')</th>
                                    <th>@lang('orders::orders.attributes.products.print.receipt_quantity')</th>
                                    <th>@lang('orders::orders.attributes.products.print.receipt_real_papers_count_per_copy')</th>
                                    <th>@lang('orders::orders.attributes.products.print.receipt_price')</th>
                                    <th>@lang('orders::orders.attributes.products.print.receipt_total')</th>
                                    <th>@lang('orders::orders.actions.download')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderFiles as $index => $file)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ data_get($file->file, 'name') ?? "file - " . $file->id }}</strong>
                                        @if($file->fileAttributes && $file->fileAttributes->count() > 0)
                                            <br><strong class="text-muted">
                                                @foreach($file->fileAttributes as $attr)
                                                    {{ $attr->attribute->title ?? 'N/A' }}: {{ $attr->option_name ?? 'N/A' }}@if(!$loop->last), <br> @endif
                                                @endforeach
                                            </strong>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $file->copies ?? 1 }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $file->real_paper_count ?? 1 }}</span>
                                    </td>
                                    <td>{{ number_format($file->paper_price ?? 0, 2) }} @lang('currency.symbol')</td>
                                    <td>
                                        <strong>{{ number_format($file->total ?? 0, 2) }} @lang('currency.symbol')</strong>
                                    </td>
                                    {{-- <td>
                                        @if($file->file)
                                            <img src="{{ $file->file['url'] }}"
                                                 alt="File preview"
                                                 class="img-thumbnail"
                                                 style="width: 60px; height: 60px; object-fit: cover;"
                                                 data-toggle="modal"
                                                 data-target="#imageModal{{ $file->id }}">
                                        @else
                                            <span class="text-muted">
                                                <i class="fas fa-file-alt"></i> @lang('orders::orders.empty')
                                            </span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        @if($file->file)
                                            <a href="{{ $file->file['url'] }}"
                                               class="btn btn-sm btn-primary"
                                               download
                                               title="@lang('orders::orders.actions.download')">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endcomponent
            </div>
        </div>

        <!-- Image Preview Modals -->
        @foreach($order->orderFiles as $file)
            @if($file->file)
            <div class="modal fade" id="imageModal{{ $file->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                @lang('orders::orders.attributes.products.print.receipt_name')
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="{{ $file->file['url'] }}"
                                 alt="File preview"
                                 class="img-fluid"
                                 style="max-height: 70vh;">
                        </div>
                        <div class="modal-footer">
                            <a href="{{ $file->file['url'] }}"
                               class="btn btn-primary"
                               download>
                                <i class="fas fa-download"></i> @lang('orders::orders.actions.download')
                            </a>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                @lang('orders::orders.dialogs.cancel')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
        @endif

        @if($order->orderProducts && $order->orderProducts->count() > 0)
        <div class="row">
            <div class="col-md-12">
                @component('dashboard::layouts.components.box')
                    @slot('title', trans('orders::orders.attributes.product_service'))
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('orders::orders.attributes.products.name')</th>
                                <th>@lang('orders::orders.attributes.products.quantity')</th>
                                <th>@lang('orders::orders.attributes.products.price')</th>
                                <th>@lang('orders::orders.attributes.products.total')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ $product->product->image }}" width="100" class="rounded" alt="{{ $product->product->name }}">
                                    {{ $product->product->name }}
                                </td>

                                @if($product->orderProductFeatures && $product->orderProductFeatures->count() > 0)
                                <td>
                                    @foreach($product->orderProductFeatures as $orderProductFeature)
                                    <span class="badge badge-info">{{ $orderProductFeature->productFeature->{"text_{$lang}"} }}</span> {{ $orderProductFeature->option_product }}

                                    @if($orderProductFeature->image)
                                        <img src="{{ $orderProductFeature->image }}" width="100" class="rounded" >
                                    @endif

                                    @if(!$loop->last)
                                        <br>
                                    @endif

                                    @endforeach
                                </td>
                                @endif

                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->total }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endcomponent
            </div>
        </div>
        @endif





    @endcomponent
@endsection
