@extends('dashboard::layouts.default')

@section('title')
    {{ $order->user->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $order->user->name)
        @slot('breadcrumbs', ['dashboard.orders.show', $order])

        @php
            $kt_logo_image = 'Logo-Horizontal@1x.png';
            \Date::setLocale(app()->getLocale());
            $date = \Date::createFromDate($order->created_at)->format('l j F Y');
        @endphp

        <!-- begin: Invoice action-->
        <div class="row py-6 px-6 py-md-6 px-md-0">
            <div class="col-md-9">
                <div class="">
                    <a href="{{ route('dashboard.orders.printReceipt',$order) }}"
                       target="_blank"
                       class="btn btn-success font-weight-bold print-receipt-btn">
                        @lang('orders::orders.invoice_details.print-receipt')
                    </a>
                    <button type="button" class="btn btn-primary font-weight-bold print-btn">
                        @lang('orders::orders.invoice_details.print')
                    </button>
                </div>
            </div>
        </div>
        <!-- end: Invoice action-->
        <div id="print-area">
            <div class="card card-custom overflow-hidden">
                <div class="card-body p-0">
                    <!-- begin: Invoice-->
                    <!-- begin: Invoice header-->
                    <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                <h1 class="display-4 font-weight-boldest mb-10">@lang('orders::orders.invoice_details.title',['order_id' => $order->id]) </h1>
                                <div class="d-flex flex-column align-items-md-end px-0">
                                    <!--begin::Logo-->
                                    <a href="#" class="mb-5">
                                        <img width="200"
                                             src="{{ \Modules\Settings\Entities\Setting::first() ? \Modules\Settings\Entities\Setting::first()->getFirstMediaUrl('logo') : asset('backend/images/logos/'.$kt_logo_image) }}"
                                             alt="">
                                    </a>
                                    <!--end::Logo-->
                                    <span class="d-flex flex-column align-items-md-end opacity-70">
                                    <span>{{  \Modules\Settings\Entities\Setting::get('name:' . app()->getLocale()) ?? config('app.name') }}</span>
                                    <span
                                        style="direction: ltr">{{  \Modules\Settings\Entities\Setting::get('phone',null) }}</span>
                                    <span>{{  \Modules\Settings\Entities\Setting::get('email',null) }}</span>
                                </span>
                                </div>
                            </div>
                            <div class="border-bottom w-100"></div>
                            <div class="d-flex justify-content-between pt-6">
                                <div class="d-flex flex-column flex-root">
                                <span
                                    class="font-weight-bolder mb-2">@lang('orders::orders.invoice_details.date')</span>
                                    <span class="opacity-70">{{ $date }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                <span
                                    class="font-weight-bolder mb-2">@lang('orders::orders.invoice_details.order_number')</span>
                                    <span class="opacity-70">{{ $order->id }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                <span
                                    class="font-weight-bolder mb-2">@lang('orders::orders.invoice_details.order_payment_type')</span>
                                    <span class="opacity-70">{{ optional($order->payment)->name }}</span>
                                </div>
                                <div class="d-flex flex-column flex-root">
                                <span
                                    class="font-weight-bolder mb-2">@lang('orders::orders.invoice_details.order_address')</span>
                                    <span class="opacity-70">
                                    {{ optional($order->user)->name }}
                                    <br>{{ optional($order->user)->phone }}
                                    <br>{{ optional($order->address)->address }}, {{ optional(optional($order->address)->region)->name }}, {{ optional(optional($order->address)->city)->name }}, {{ optional(optional(optional($order->address)->city)->country)->name }}
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice header-->
                    <!-- begin: Invoice body-->
                    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="pl-0 font-weight-bold text-uppercase">@lang('orders::orders.attributes.products.name')</th>
                                        <th class="text-right font-weight-bold text-uppercase">@lang('orders::orders.attributes.products.quantity')</th>
                                        <th class="text-right font-weight-bold text-uppercase">@lang('orders::orders.attributes.products.price')</th>
                                        <th class="text-right pr-0 font-weight-bold text-uppercase">@lang('orders::orders.attributes.products.total')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->products as $product)
                                        <tr class="font-weight-boldest">
                                            <td class="pl-0 pt-7">{{ $product->product->name }}</td>
                                            <td class="text-right pt-7">{{ $product->quantity }}</td>
                                            <td class="text-right pt-7">{{ $product->price . ' ₺' }}</td>
                                            <td class="text-danger pr-0 pt-7 text-right">{{ $product->quantity * $product->price . ' ₺' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice body-->
                @if(count($order->taxes) > 0)
                    <!-- begin: taxes body-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="pl-0 font-weight-bold text-uppercase">@lang('taxes::taxes.attributes.name')</th>
                                            <th class="text-right font-weight-bold text-uppercase">@lang('taxes::taxes.attributes.percentage')</th>
                                            <th class="text-right font-weight-bold text-uppercase">@lang('taxes::taxes.attributes.total')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->taxes as $tax)
                                            <tr class="font-weight-boldest">
                                                <td class="pl-0 pt-7">{{ $tax->tax->name }}</td>
                                                <td class="text-right pt-7">{{ $tax->tax->percentage . ' %' }}</td>
                                                <td class="text-danger pr-0 pt-7 text-right">{{ $tax->total . ' ₺' }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: taxes body-->
                @endif
                <!-- begin: Invoice footer-->
                    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="font-weight-bold text-uppercase">@lang('orders::orders.attributes.basic')</th>
                                        <th class="font-weight-bold text-uppercase">@lang('orders::orders.attributes.shipping_cost')</th>
                                        <th class="font-weight-bold text-uppercase">@lang('orders::orders.attributes.tax_cost')</th>
                                        <th class="font-weight-bold text-uppercase">@lang('orders::orders.attributes.discount')</th>
                                        <th class="font-weight-bold text-uppercase">@lang('orders::orders.attributes.total')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="font-weight-bolder">
                                        <td>{{ $order->basic . ' ₺' }}</td>
                                        <td>{{ $order->shipping_cost . ' ₺' }}</td>
                                        <td>{{ $order->tax_cost . ' ₺' }}</td>
                                        <td>{{ $order->discount . ' ₺' }}</td>
                                        <td class="text-danger font-size-h3 font-weight-boldest">{{ $order->total . ' ₺' }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end: Invoice footer-->
                    <!-- end: Invoice-->
                </div>
            </div>
        </div>
    @endcomponent
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"></script>
    <script type="text/javascript">
        $(document).on('click', '.print-btn', function (e) {
            e.preventDefault();
            $('#print-area').printThis();
        })
    </script>
@endsection
