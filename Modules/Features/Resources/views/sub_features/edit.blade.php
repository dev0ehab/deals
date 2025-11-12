@extends('dashboard::layouts.default')

@section('title')
    {{ $feature->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $feature->name)
        @slot('breadcrumbs', ['dashboard.sub_features.edit', $feature])

        {{ BsForm::resource('features::features')->putModel($feature, route('dashboard.features.update', $feature), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('features::features.actions.edit'))

            @include('features::sub_features.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('features::features.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
