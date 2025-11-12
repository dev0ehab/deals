@extends('dashboard::layouts.default')

@section('title')
    @lang('areas::areas.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('areas::areas.plural'))
        @slot('breadcrumbs', ['dashboard.areas.create'])

        {{ BsForm::resource('areas::areas')->post(route('dashboard.areas.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('areas::areas.actions.create'))

            @include('areas::areas.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('areas::areas.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
