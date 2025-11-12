@extends('dashboard::layouts.default')

@section('title')
    @lang('coupons::coupons.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('coupons::coupons.plural'))
        @slot('breadcrumbs', ['dashboard.coupons.create'])

        {{ BsForm::resource('coupons::coupons')->post(route('dashboard.coupons.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('coupons::coupons.actions.create'))

            @include('coupons::coupons.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('coupons::coupons.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
