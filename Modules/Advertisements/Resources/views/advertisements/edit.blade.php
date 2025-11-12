@extends('dashboard::layouts.default')

@section('title')
    {{ $advertisement->title }}
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', $advertisement->title)
        @slot('breadcrumbs', ['dashboard.advertisements.edit', $advertisement])

        {{ BsForm::resource('advertisements::advertisements')->putModel($advertisement, route('dashboard.advertisements.update', $advertisement), ['files' => true,'data-parsley-validate']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('advertisements::advertisements.actions.edit'))

            @include('advertisements::advertisements.partials.form')

            @slot('footer')
                {{ BsForm::submit()->label(trans('advertisements::advertisements.actions.save')) }}
            @endslot
        @endcomponent
        {{ BsForm::close() }}

    @endcomponent
@endsection
