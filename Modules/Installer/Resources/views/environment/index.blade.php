@extends('installer::layouts.app')

@section('template_title')
    {{ trans('installer::installer.environment.menu.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer::installer.environment.menu.title') }}
@endsection

@section('container')

    <p class="text-center">
        {!! trans('installer::installer.environment.menu.desc') !!}
    </p>
    <div class="buttons">
        <a href="{{ route('installer.environmentWizard') }}" class="button button-wizard">
            <i class="fa fa-sliders fa-fw"
               aria-hidden="true"></i> {{ trans('installer::installer.environment.menu.wizard-button') }}
        </a>
        <a href="{{ route('installer.environmentClassic') }}" class="button button-classic">
            <i class="fa fa-code fa-fw"
               aria-hidden="true"></i> {{ trans('installer::installer.environment.menu.classic-button') }}
        </a>
    </div>

@endsection


