@extends('dashboard::layouts.default')

@section('title')
    @lang('orders::rates.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('orders::rates.plural'))
        @slot('breadcrumbs', ['dashboard.rates.index'])

        @include('orders::rates.partials.filter')

        @include('orders::rates.data')
@endcomponent
@endsection
