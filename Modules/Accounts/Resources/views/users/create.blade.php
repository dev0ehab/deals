@extends('dashboard::layouts.default')

@section('title')
    @lang('accounts::user.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('accounts::user.plural'))
        @slot('breadcrumbs', ['dashboard.users.create'])

        {{ BsForm::resource('accounts::users')->post(route('dashboard.users.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('accounts::user.actions.create'))

            @include('accounts::users.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('accounts::user.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection

