@extends('dashboard::layouts.default')

@section('title')
    {{ $attribute->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $attribute->name)
        @slot('breadcrumbs', ['dashboard.attributes.edit', $attribute])

        {{ BsForm::resource('attributes::attributes')->putModel($attribute, route('dashboard.attributes.update', $attribute), ['files' => true,'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('attributes::attributes.actions.edit'))

            @include('attributes::attributes.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('attributes::attributes.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
