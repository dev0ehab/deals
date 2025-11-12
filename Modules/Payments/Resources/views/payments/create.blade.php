@extends('dashboard::layouts.default')

@section('title')
    @lang('payments::payments.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('payments::payments.plural'))
        @slot('breadcrumbs', ['dashboard.payments.create'])

        {{ BsForm::resource('payments::payments')->errorBag('payment')->post(route('dashboard.payments.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('payments::payments.actions.create'))

            @include('payments::payments.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('payments::payments.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
