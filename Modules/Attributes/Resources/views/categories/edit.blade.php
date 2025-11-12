@extends('dashboard::layouts.default')

@section('title')
    {{ $category->name }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $category->name)
        @slot('breadcrumbs', ['dashboard.categories.edit', $category])

        {{ BsForm::resource('attributes::categories')->putModel($category, route('dashboard.categories.update', $category), ['files' => true,'data-parsley-validate', 'class' => 'repeater']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('attributes::categories.actions.edit'))

            @include('attributes::categories.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('attributes::categories.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
