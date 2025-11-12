@extends('dashboard::layouts.default')

@section('title')
    @lang('coupons::coupons.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('coupons::coupons.plural'))
        @slot('breadcrumbs', ['dashboard.coupons.index'])

        @include('coupons::coupons.partials.filter')

        @include('coupons::coupons.data')

    @endcomponent
@endsection
