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
            @slot('title', trans('vendors::vendors.actions.edit'))

            @include('vendors::vendors.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('vendors::vendors.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
