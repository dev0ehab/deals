@extends('dashboard::layouts.default')

@section('title')
    @lang('notifications::notifications.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('notifications::notifications.plural'))
        @slot('breadcrumbs', ['dashboard.notifications.create'])

        {{ BsForm::resource('notifications::notifications')->post(route('dashboard.notifications.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('notifications::notifications.actions.create'))

            @include('notifications::notifications.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('notifications::notifications.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
