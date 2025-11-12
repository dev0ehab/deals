@extends('dashboard::layouts.default')

@section('title')
    {{ $admin->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $admin->name)
        @slot('breadcrumbs', ['dashboard.admins.edit', $admin])

        {{ BsForm::resource('accounts::admins')->putModel($admin, route('dashboard.admins.update', $admin), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('accounts::admins.actions.edit'))

            @include('accounts::admins.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('accounts::admins.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
