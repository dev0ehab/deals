@extends('dashboard::layouts.default')

@section('title')
    {{ $option->name }}
@endsection

@section('content')

    @component('dashboard::layouts.components.page')
        @slot('title', $option->name)
        {{-- @slot('breadcrumbs', ['dashboard.options.edit', ['feature' => $option->feature, 'option' => $option]]) --}}

        {{ BsForm::resource('features::features')->putModel($option, route('dashboard.options.update', ['feature' => $option->feature, 'option' => $option]), ['files' => true, 'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('features::options.actions.edit'))

            @include('features::options.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('features::features.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}
    @endcomponent
@endsection
