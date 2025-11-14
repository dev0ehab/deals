@extends('dashboard::layouts.default')

@section('title')
    {{ $vendor->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $vendor->name)
        @slot('breadcrumbs', ['dashboard.vendors.edit', $vendor])

        {{ BsForm::resource('vendors::vendorss')->putModel($vendor, route('dashboard.vendors.update', $vendor), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('vendors::vendorsactions.edit'))

            @include('vendors::vendorspartials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('vendors::vendorsactions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
