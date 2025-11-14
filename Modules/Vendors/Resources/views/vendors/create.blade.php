@extends('dashboard::layouts.default')

@section('title')
    @lang('vendors::vendorsactions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('vendors::vendorsplural'))
        @slot('breadcrumbs', ['dashboard.vendors.create'])

        {{ BsForm::resource('vendors::vendorss')->post(route('dashboard.vendors.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('vendors::vendorsactions.create'))

            @include('vendors::vendorspartials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('vendors::vendorsactions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

