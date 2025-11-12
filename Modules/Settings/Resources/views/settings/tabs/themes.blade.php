@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.tabs.themes')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        {{ BsForm::resource('settings::settings')->put(route('dashboard.settings.update'), ['files' => true]) }}
        @component('dashboard::layouts.components.box')

            @slot('title', trans('settings::settings.tabs.themes'))

            @include('settings::settings.partials.themes-form')

            {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class','btn btn-danger mb-2') }}
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

