@extends('dashboard::layouts.default')

@section('title')
    @lang('advertisements::advertisements.actions.create')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('advertisements::advertisements.plural'))
        @slot('breadcrumbs', ['dashboard.advertisements.create'])

        {{ BsForm::resource('advertisements::advertisements')->post(route('dashboard.advertisements.store'), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('advertisements::advertisements.actions.create'))

            @include('advertisements::advertisements.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('advertisements::advertisements.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
