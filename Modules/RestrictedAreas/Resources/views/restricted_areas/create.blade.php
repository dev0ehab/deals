@extends('dashboard::layouts.default')

@section('title')
    @lang('restricted_areas::restricted_areas.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('restricted_areas::restricted_areas.plural'))
        @slot('breadcrumbs', ['dashboard.restricted_areas.create'])

        {{ BsForm::resource('restricted_areas::restricted_areas')->post(route('dashboard.restricted_areas.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('restricted_areas::restricted_areas.actions.create'))

            @include('restricted_areas::restricted_areas.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('restricted_areas::restricted_areas.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
