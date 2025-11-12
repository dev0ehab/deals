@extends('dashboard::layouts.default')

@section('title')
    @lang('roles::roles.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('roles::roles.plural'))
        @slot('breadcrumbs', ['dashboard.roles.create'])

        {{ BsForm::resource('roles::roles')->post(route('dashboard.roles.store'), ['files' => true]) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('roles::roles.actions.create'))

            @include('roles::roles.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('roles::roles.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
