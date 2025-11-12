@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::categories.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('attributes::categories.plural'))
        @slot('breadcrumbs', ['dashboard.categories.index'])

        @include('attributes::categories.partials.filter')

        @include('attributes::categories.data')

        @endcomponent
    @endsection
