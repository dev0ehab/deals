@extends('dashboard::layouts.default')

@section('title')
    @lang('settings::settings.tabs.about')
@endsection

@section('content')
    @component('dashboard::layouts.components.page')
        @slot('title', trans('settings::settings.actions.update'))
        @slot('breadcrumbs', ['dashboard.settings.update'])

        {{ BsForm::putModel($about, route('dashboard.about-us.update'), ['files' => true, 'class' => 'repeater-award']) }}
        @component('dashboard::layouts.components.box')
            @slot('title', trans('Google Maps Settings'))

            @if ($page == 'map1')
                @include('settings::settings.partials.map1')
            @else
                @include('settings::settings.partials.map2')
            @endif

            {{ BsForm::submit()->label(trans('settings::settings.actions.save'))->attribute('class', 'btn btn-danger mb-2') }}
        @endcomponent
        {{ BsForm::close() }}
    @endcomponent
@endsection

@push('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initialize"
        async defer></script>

    <script src="{{ asset('js/map.js') }}"></script>
@endpush
