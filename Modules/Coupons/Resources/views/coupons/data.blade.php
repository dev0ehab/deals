@component('dashboard::layouts.components.table-box')
    @slot('title', trans('coupons::coupons.plural'))
    @slot('tools')

        @include('coupons::coupons.partials.actions.create')
    @endslot

    <thead>
        <tr>
            <th>@lang('coupons::coupons.attributes.code')</th>
            <th>@lang('coupons::coupons.attributes.description')</th>
            <th>@lang('coupons::coupons.attributes.discount_type')</th>
            <th>@lang('coupons::coupons.attributes.percentage_discount')</th>
            <th>@lang('coupons::coupons.attributes.max_usage')</th>
            <th>@lang('coupons::coupons.attributes.max_usage_per_user')</th>
            <th>@lang('coupons::coupons.attributes.first_order_count')</th>

            @if(auth()->user()->hasPermission('update_coupons'))
            <th>@lang('Active')</th>
            @endif

            <th>@lang('coupons::coupons.attributes.start_at')</th>
            <th>@lang('coupons::coupons.attributes.expire_at')</th>
            <th style="width: 160px">...</th>
        </tr>
    </thead>
    <tbody>
        @forelse($coupons as $coupon)
            <tr>
                <td>
                    <a href="{{ route('dashboard.coupons.show', $coupon) }}" class="text-decoration-none text-ellipsis">
                        {{ $coupon->code }}
                    </a>
                </td>
                <td>
                    <span class="text-ellipsis" style="max-width: 200px; display: inline-block;">
                        {!! $coupon->description ? Str::limit($coupon->description, 50) : '-' !!}
                    </span>
                </td>
                <td>
                    <span class="badge badge-info">
                        {{ __('coupons::coupons.options.discount_type.' . $coupon->discount_type) }}
                    </span>
                </td>
                <td>
                    @if(($coupon->coupon_type ?? 'percent') === 'percent')
                        {{ $coupon->percentage_discount }}%
                    @else
                        Fixed: {{ $coupon->max_discount }}
                    @endif
                </td>
                <td>
                    {{ $coupon->max_usage }}
                </td>
                <td>
                    {{ $coupon->max_usage_per_user }}
                </td>
                <td>
                    {{ $coupon->first_order_count ?? 'Unlimited' }}
                </td>

                @if(auth()->user()->hasPermission('update_coupons'))
                <td>
                        @include('dashboard::layouts.apps.activate', [
                            'item' => $coupon,
                            'url' => 'coupons/active/',
                        ])
                    </td>
                @endif
                <td>
                    {{ $coupon->start_at->toDateString() }}
                </td>
                <td>
                    {{ $coupon->expire_at->toDateString() }}
                </td>

                <td style="width: 160px">
                    @include('coupons::coupons.partials.actions.show')
                    @include('coupons::coupons.partials.actions.edit')
                    @include('coupons::coupons.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('coupons::coupons.empty')</td>
            </tr>
        @endforelse

        @slot('footer')
            @if ($coupons->hasPages() && !isset($target))
                {{ $coupons->links() }}
            @elseif($coupons->hasPages() && isset($target))
                <div id="paginator">
                    @include('orders::orders.partials.target-paginator', ['models' => $coupons])
                </div>
            @endif
        @endslot
    @endcomponent
