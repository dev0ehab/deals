@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::attributes.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('attributes::attributes.plural'))
        @slot('breadcrumbs', ['dashboard.attributes.create'])

        {{ BsForm::resource('attributes::attributes')->post(route('dashboard.attributes.store'), ['files' => true,'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('attributes::attributes.actions.create'))

            @include('attributes::attributes.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('attributes::attributes.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
