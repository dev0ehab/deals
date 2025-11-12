@extends('dashboard::layouts.default')

@section('title')
    @lang('attributes::categories.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('attributes::categories.plural'))
        @slot('breadcrumbs', ['dashboard.categories.create'])

        {{ BsForm::resource('attributes::categories')->post(route('dashboard.categories.store'), ['files' => true,'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('attributes::categories.actions.create'))

            @include('attributes::categories.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('attributes::categories.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
