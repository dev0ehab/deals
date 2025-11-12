@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.tabs.contacts')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        {{ BsForm::resource('settings::settings')->put(route('dashboard.settings.update'), ['files' => true, 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('settings::settings.tabs.contacts'))

            @include('settings::settings.partials.contacts-form')

            {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class', 'btn btn-danger mb-2') }}
        @endcomponent
        {{ BsForm::close() }}
    @endcomponent
@endsection


