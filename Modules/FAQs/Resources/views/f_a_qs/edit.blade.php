@extends('dashboard::layouts.default')

@section('title')
    {{ $f_a_q->id }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $f_a_q->id)
        @slot('breadcrumbs', ['dashboard.f_a_qs.edit', $f_a_q])

        {{ BsForm::resource('f_a_qs::f_a_qs')->putModel($f_a_q, route('dashboard.f_a_qs.update', $f_a_q), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('f_a_qs::f_a_qs.actions.edit'))

            @include('f_a_qs::f_a_qs.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('f_a_qs::f_a_qs.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
