@extends('dashboard::layouts.default')

@section('title')
    {{ $payment->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $payment->name)
        @slot('breadcrumbs', ['dashboard.payments.edit', $payment])

        {{ BsForm::resource('payments::payments')->putModel($payment, route('dashboard.payments.update', $payment), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('payments::payments.actions.edit'))

            @include('payments::payments.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('payments::payments.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
