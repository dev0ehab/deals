@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.tabs.app')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        {{ BsForm::resource('settings::settings')->put(route('dashboard.settings.update'), ['files' => true]) }}
        @component('dashboard::layouts.components.box')

            @slot('title', trans('settings::settings.tabs.app'))

            @include('settings::settings.partials.app-form')

            {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class','btn btn-danger mb-2') }}
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

