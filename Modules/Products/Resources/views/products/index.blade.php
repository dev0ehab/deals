@extends('dashboard::layouts.default')

@section('title')
    @lang('products::products.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
    @slot('title', trans('products::products.plural'))
    @slot('breadcrumbs', ['dashboard.products.index'])

    @include('products::products.partials.filter')

    @component('dashboard::layouts.components.table-box')
    @slot('title', trans('products::products.actions.list'))
    @slot('tools')
    @include('products::products.partials.actions.create')
    @endslot

    <thead>
        <tr>
            <th>@lang('products::products.attributes.image')</th>
            <th>@lang('products::products.attributes.name')</th>
            <th width="200">@lang('sections::sections.singular')</th>
            <th width="200">@lang('products::products.attributes.is_active')</th>
            <th style="width: 160px">...</th>
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td class="d-none d-md-table-cell">
                    <img src="{{ $product->cover }}" class="mr-2 rounded" width="64" height="64">
                </td>

                <td class="d-none d-md-table-cell">
                    {{ $product->name }}
                </td>

                <td>
                    {{ $product->section->name }}
                </td>

                <td>
                    @include('dashboard::layouts.apps.activate', [
                        'item' => $product,
                        'url' => 'products/active/',
                    ])
                </td>


                <td style="width: 160px">
                    @include('products::products.partials.actions.show')
                    @include('products::products.partials.actions.edit')
                    @include('products::products.partials.actions.delete')
                </td>

            </tr>
        @empty

        <tr>
                <td colspan="100" class="text-center">@lang('products::products.empty')</td>
        </tr>
     @endforelse
      @if ($products->hasPages())
        @slot('footer')
        {{ $products->links() }}
        @endslot
    @endif
            @endcomponent
            @endcomponent
@endsection
