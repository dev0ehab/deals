@extends('dashboard::layouts.default')

@section('title')
    @lang('features::features.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('features::features.plural'))
        @slot('breadcrumbs', ['dashboard.features.create'])

        {{ BsForm::resource('features::features')->post(route('dashboard.features.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('features::features.actions.create'))

            @include('features::features.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('features::features.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
