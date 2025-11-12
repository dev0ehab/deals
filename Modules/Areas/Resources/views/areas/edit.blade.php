@extends('dashboard::layouts.default')

@section('title')
    {{ $area->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $area->name)
        @slot('breadcrumbs', ['dashboard.areas.edit', $area])

        {{ BsForm::resource('areas::areas')->putModel($area, route('dashboard.areas.update', $area), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('areas::areas.actions.edit'))

            @include('areas::areas.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('areas::areas.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
