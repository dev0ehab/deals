@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@bsMultilangualFormTabs
    {{ BsForm::text('name')->value(Settings::locale($locale->code)->get('name'))->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{ BsForm::textarea('description')->rows(3)->attribute('class', 'form-control textarea')->value(Settings::locale($locale->code)->get('description'))->attribute(['data-parsley-minlength' => '3']) }}
    {{-- {{ BsForm::textarea('meta_description')->rows(3)->attribute('class','form-control textarea')->value(Settings::locale($locale->code)->get('meta_description'))->attribute(['data-parsley-minlength' => '3']) }} --}}
    {{-- {{ BsForm::text('keywords')->value(Settings::locale($locale->code)->get('keywords'))->note(trans('settings::settings.notes.keywords')) }} --}}
@endBsMultilangualFormTabs

<div class="row mb-3">
    <div class="col-md-6">
        <label>{{ __('settings::settings.attributes.logo') }}</label>
        @include('dashboard::layouts.apps.file1', [
            'file' => optional(Settings::instance('logo'))->getFirstMediaUrl('logo'),
            'name' => 'logo',
        ])
    </div>
    <div class="col-md-6">
        <label>{{ __('settings::settings.attributes.favicon') }}</label>
        @include('dashboard::layouts.apps.file1', [
            'file' => optional(Settings::instance('favicon'))->getFirstMediaUrl('favicon'),
            'name' => 'favicon',
        ])
    </div>
    <div class="col-md-6">
        <label>{{ __('settings::settings.attributes.loginLogo') }}</label>
        @include('dashboard::layouts.apps.file1', [
            'file' => optional(Settings::instance('loginLogo'))->getFirstMediaUrl('loginLogo'),
            'name' => 'loginLogo',
        ])
    </div>
</div>

{{-- <div class="row mb-3">
    <div class="col-md-6">
        <label>{{ __('settings::settings.attributes.logo') }}</label>
        @include('dashboard::layouts.apps.file1', [
            'file' => optional(Settings::instance('logo'))->getFirstMediaUrl('logo'),
            'name' => 'logo',
        ])
    </div>
    <div class="col-md-6">
        <label>{{ __('settings::settings.attributes.favicon') }}</label>
        @include('dashboard::layouts.apps.file1', [
            'file' => optional(Settings::instance('favicon'))->getFirstMediaUrl('favicon'),
            'name' => 'favicon',
        ])
    </div>
    <div class="col-md-6">
        <label>{{ __('settings::settings.attributes.loginLogo') }}</label>
        @include('dashboard::layouts.apps.file1', [
            'file' => optional(Settings::instance('loginLogo'))->getFirstMediaUrl('loginLogo'),
            'name' => 'loginLogo',
        ])
    </div>
</div> --}}

<div class="card">
   
    <div class="card-body">
        <div class="form-group">
            <label for="address">
                {{ __('Map Address') }}
            </label>
            <input type="text" id="address-input" name="map_address" class="form-control map-input"
                value="{{ Settings::get('map_address') }}">
            <input type="hidden" name="latitude" id="address-latitude" value="{{ Settings::get('latitude') }}" />
            <input type="hidden" name="longitude" id="address-longitude" value="{{ Settings::get('longitude') }}" />
        </div>
        <div id="address-map-container" style="width:100%;height:400px; ">
            <div style="width: 100%; height: 100%" id="address-map"></div>
        </div>
    </div>
</div>



@push('js')
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places,marker&callback=initialize"
        async defer></script>

    <script src="{{ asset('js/map.js') }}"></script>
@endpush

