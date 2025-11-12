@extends('dashboard::layouts.default')

@section('title')
    @lang('f_a_qs::f_a_qs.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('f_a_qs::f_a_qs.plural'))
        @slot('breadcrumbs', ['dashboard.f_a_qs.create'])

        {{ BsForm::resource('f_a_qs::f_a_qs')->post(route('dashboard.f_a_qs.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('f_a_qs::f_a_qs.actions.create'))

            @include('f_a_qs::f_a_qs.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('f_a_qs::f_a_qs.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
