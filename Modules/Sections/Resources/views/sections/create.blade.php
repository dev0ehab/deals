@extends('dashboard::layouts.default')

@section('title')
    @lang('sections::sections.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('sections::sections.plural'))
        @slot('breadcrumbs', ['dashboard.sections.create'])

        {{ BsForm::resource('sections::sections')->post(route('dashboard.sections.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('sections::sections.actions.create'))

            @include('sections::sections.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('sections::sections.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
