@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.tabs.mail-templates')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        {{ BsForm::resource('settings::settings')->put(route('dashboard.settings.update'), ['files' => true]) }}
        @component('dashboard::layouts.components.box')

            @slot('title', trans('settings::settings.tabs.mail-templates'))

            @include('settings::settings.partials.templates-form')

            {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class','btn btn-danger mb-2') }}
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

