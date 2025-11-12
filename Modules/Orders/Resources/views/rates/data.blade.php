@component('dashboard::layouts.components.table-box')
    @slot('title', trans('orders::rates.plural'))
    <thead>
        <tr>
            <th>@lang('orders::rates.attributes.id')</th>
            <th>@lang('accounts::user.attributes.name')</th>
            <th>@lang('products::products.singular')</th>
            <th>@lang('orders::rates.attributes.rate')</th>
            <th>@lang('orders::rates.attributes.comment')</th>
            <th>@lang('orders::rates.action')</th>
            <th style="width: 160px">...</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rates as $rate)
            <tr>
                <td>
                        {{ $loop->iteration }}
                </td>

                <td>
                    {{ $rate->order->user->name }}
                </td>

                <td>
                    {{ $rate->product->name }}
                </td>

                <td>
                    {{ $rate->rate }}
                </td>

                <td>
                    {{ $rate->comment }}
                </td>

                <td>

                    @include('dashboard::layouts.apps.activate', [
                        'item' => $rate,
                        'url' => 'rate/active/',
                    ])
                </td>
                {{-- <td style="width: 160px">
                    @include('orders::rates.partials.actions.show')
                    @include('orders::rates.partials.actions.delete')
                 </td> --}}
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('orders::rates.empty')</td>
            </tr>
        @endforelse

        @if ($rates->hasPages())
            @slot('footer')
                {{ $rates->links() }}
            @endslot
        @endif
    </tbody>
@endcomponent
