@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.actions.update')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        {{ BsForm::resource('settings::settings')->put(route('dashboard.settings.update'), ['files' => true]) }}

        @include('settings::settings.partials.form')

        {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class','btn btn-danger mb-2') }}

        {{ BsForm::close() }}

    @endcomponent
@endsection

