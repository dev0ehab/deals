@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.tabs.mail')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        <div class="row">
            <div class="form-group col-12">
                <a href="{{ route('dashboard.settings.test-mail') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-envelope"></i>
                    Test Mail
                </a>
            </div>
        </div>


        {{ BsForm::resource('settings::settings')->put(route('dashboard.settings.update'), ['files' => true]) }}
        @component('dashboard::layouts.components.box')

            @slot('title', trans('settings::settings.tabs.mail'))

            @include('settings::settings.partials.mail-form')

            {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class','btn btn-danger mb-2') }}
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

