@extends('dashboard::layouts.default')

@section('title')
    @lang('services::services.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('services::services.plural'))
        @slot('breadcrumbs', ['dashboard.services.create'])

        {{ BsForm::resource('services::services')->post(route('dashboard.services.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('services::services.actions.create'))

            @include('services::services.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('services::services.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

