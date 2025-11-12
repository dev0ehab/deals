@extends('dashboard::layouts.default')

@section('title')
    @lang('orders::orders.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('orders::orders.plural'))
        @slot('breadcrumbs', ['dashboard.orders.index'])

        @include('orders::orders.partials.filter')

        @include('orders::orders.data')
@endcomponent
@endsection
