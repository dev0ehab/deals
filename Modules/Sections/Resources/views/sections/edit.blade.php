@extends('dashboard::layouts.default')

@section('title')
    {{ $section->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $section->name)
        @slot('breadcrumbs', ['dashboard.sections.edit', $section])

        {{ BsForm::resource('sections::sections')->putModel($section, route('dashboard.sections.update', $section), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('sections::sections.actions.edit'))

            @include('sections::sections.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('sections::sections.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
