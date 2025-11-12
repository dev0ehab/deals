@extends('dashboard::layouts.default')

@section('title')
    @lang('products::products.features.edit', [], app()->getLocale())
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('products::products.features.edit', [], app()->getLocale()))
        @slot('breadcrumbs', ['dashboard.products.show', $product])

        {{ BsForm::putModel($feature, route('dashboard.products.features.update', [$product, $feature]), ['files' => true, 'data-parsley-validate', 'class' => 'product-feature-form']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('products::products.features.edit', [], app()->getLocale()))

            @include('products::features.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('products::products.actions.save', [], app()->getLocale())) }}
                <a href="{{ route('dashboard.products.show', $product) }}" class="btn btn-secondary">
                    @lang('products::products.features.dialogs.delete.cancel', [], app()->getLocale())
                </a>
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

