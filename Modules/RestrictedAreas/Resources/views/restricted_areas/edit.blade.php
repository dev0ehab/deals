@extends('dashboard::layouts.default')

@section('title')
    {{ $restricted_area->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $restricted_area->name)
        @slot('breadcrumbs', ['dashboard.restricted_areas.edit', $restricted_area])

        {{ BsForm::resource('restricted_areas::restricted_areas')->putModel($restricted_area, route('dashboard.restricted_areas.update', $restricted_area), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('restricted_areas::restricted_areas.actions.edit'))

            @include('restricted_areas::restricted_areas.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('restricted_areas::restricted_areas.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
