{{-- IF its options is in pricing matrix show pricing matrix --}}
@foreach ($attributes as $attribute)
    @if (!$attribute->isInPriceMatrix())
        <div class="col-md-12">
            <div class="alert alert-warning">
                @lang('attributes::attributes.attributes.pricing_matrix_active')
            </div>
        </div>
        @break
    @endif
@endforeach


@component('dashboard::layouts.components.table-box')
    @slot('title', trans('attributes::attributes.plural'))
    @slot('tools')
        @include('attributes::attributes.partials.actions.create')
    @endslot

    <thead>
        <tr>
            <th>@lang('attributes::attributes.attributes.title')</th>
            <th>@lang('attributes::attributes.attributes.category')</th>
            <th>@lang('attributes::attributes.attributes.type')</th>
            <th>@lang('attributes::attributes.attributes.pricing_type')</th>

            @if (auth()->user()->hasPermission('update_attributes'))
                <th>@lang('attributes::attributes.attributes.is_active')</th>
            @endif

            <th style="width: 160px">...</th>
        </tr>
    </thead>
    <tbody>
        @forelse($attributes as $attribute)
            <tr @if (!$attribute->isInPriceMatrix()) class="bg-warning" @endif>
                <td class="d-none d-md-table-cell">
                    {{ $attribute->title }}
                </td>
                <td>
                    {{ $attribute->category ? $attribute->category->name : 'No Category' }}
                </td>
                <td>
                    {{ __('attributes::attributes.types.' . $attribute->type) }}
                </td>
                <td>
                    {{ \App\Enums\AttributePricingEnum::translatedName($attribute->pricing_type) }}
                </td>

                @if (auth()->user()->hasPermission('update_attributes'))
                    <td>
                        @include('dashboard::layouts.apps.activate', [
                            'item' => $attribute,
                            'url' => 'attributes/active/',
                        ])
                    </td>
                @endif

                <td style="width: 160px">
                    @include('attributes::attributes.partials.actions.show')
                    @include('attributes::attributes.partials.actions.edit')
                    @include('attributes::attributes.partials.actions.delete')
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100" class="text-center">@lang('attributes::attributes.empty')</td>
            </tr>
        @endforelse

        @slot('footer')
            @if ($attributes->hasPages() && !isset($target))
                {{ $attributes->links() }}
            @elseif($attributes->hasPages() && isset($target))
                <div id="paginator">
                    @include('orders::orders.partials.target-paginator', ['models' => $attributes])
                </div>
            @endif
        @endslot
    @endcomponent
