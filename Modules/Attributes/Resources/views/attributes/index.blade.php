@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::attributes.plural')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('attributes::attributes.plural'))
        @slot('breadcrumbs', ['dashboard.attributes.index'])

        @include('attributes::attributes.partials.filter')

        @include('attributes::attributes.data')

        @endcomponent
    @endsection
