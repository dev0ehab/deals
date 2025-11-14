@extends('dashboard::layouts.default')

@section('title')
    @lang('vendors::vendors.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('vendors::vendors.plural'))
        @slot('breadcrumbs', ['dashboard.vendors.create'])

        {{ BsForm::resource('vendors::vendorss')->post(route('dashboard.vendors.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('vendors::vendors.actions.create'))

            @include('vendors::vendors.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('vendors::vendors.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

