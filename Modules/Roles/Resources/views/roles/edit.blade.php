@extends('dashboard::layouts.default')

@section('title')
    {{ $role->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $role->name)
        @slot('breadcrumbs', ['dashboard.roles.edit', $role])

        {{ BsForm::resource('roles::roles')->putModel($role, route('dashboard.roles.update', $role), ['files' => true]) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('roles::roles.actions.edit'))

            @include('roles::roles.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('roles::roles.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
