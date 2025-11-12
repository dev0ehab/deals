@extends('dashboard::layouts.default')

@section('title')
    @lang('products::products.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('products::products.plural'))
        @slot('breadcrumbs', ['dashboard.products.create'])

        {{ BsForm::resource('products::products')->post(route('dashboard.products.store'), ['files' => true,'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('products::products.actions.create'))

            @include('products::products.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('products::products.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
