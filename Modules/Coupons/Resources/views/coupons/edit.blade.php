@extends('dashboard::layouts.default')

@section('title')
    {{ $coupon->code }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $coupon->code)
        @slot('breadcrumbs', ['dashboard.coupons.edit', $coupon])

        {{ BsForm::resource('coupons::coupons')->putModel($coupon, route('dashboard.coupons.update', $coupon), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('coupons::coupons.actions.edit'))

            @include('coupons::coupons.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('coupons::coupons.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
