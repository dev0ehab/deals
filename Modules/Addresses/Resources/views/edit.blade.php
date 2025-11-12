@extends('dashboard::layouts.default')

@section('title')
    {{ $address->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $address->name)
        @slot('breadcrumbs', ['dashboard.customers.addresses.edit', $customer, $address])

        {{ BsForm::resource('addresses::addresses')
            ->putModel($address, route('dashboard.customers.addresses.update', [$customer, $address]),['data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('addresses::addresses.actions.edit'))

            @include('addresses::partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('addresses::addresses.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
