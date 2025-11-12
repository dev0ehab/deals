@extends('dashboard::layouts.default')

@section('title')
    @lang('accounts::admins.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('accounts::admins.plural'))
        @slot('breadcrumbs', ['dashboard.admins.create'])

        {{ BsForm::resource('accounts::admins')->post(route('dashboard.admins.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('accounts::admins.actions.create'))

            @include('accounts::admins.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('accounts::admins.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

