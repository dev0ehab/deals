@extends('dashboard::layouts.default')

@section('title')
    {{ $product->name }}
@endsection
@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $product->name)
        @slot('breadcrumbs', ['dashboard.products.show', $product])

        <div class="row">
            <div class="col-md-6">
                @component('dashboard::layouts.components.box')
                    @slot('bodyClass', 'p-0')

                    <table class="table table-middle">
                        <tbody>
                            <tr>
                                <th width="200">@lang('products::products.attributes.name')</th>
                                <td>{{ $product->name }}</td>
                            </tr>
                            <tr>
                                <th width="200">@lang('sections::sections.singular')</th>
                                <td>{{ $product->section->name }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.cover')</th>
                                <td>
                                    <img src="{{ $product->cover }}" width="150" class="rounded" alt="{{ $product->name }}">
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.image')</th>
                                <td>
                                    @foreach($product->images as $image)
                                    <img src="{{ $image['url'] }}" width="150" class="rounded" alt="{{ $product->name }}">
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.price')</th>
                                <td>{{ $product->price }}</td>
                            </tr>
                            @if($product->old_price)
                            <tr>
                                <th width="200">@lang('products::products.attributes.old_price')</th>
                                <td>{{ $product->old_price }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th width="200">@lang('products::products.attributes.stock')</th>
                                <td>{{ $product->stock }}</td>
                            </tr>

                            <tr>
                                <th width="200">@lang('products::products.attributes.is_active')</th>
                                <td>
                                    @include('dashboard::layouts.apps.flag', [
                                        'bool' => $product->is_active,
                                        ])
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    @slot('footer')
                        @include('products::products.partials.actions.edit')
                        @include('products::products.partials.actions.delete')
                    @endslot
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
