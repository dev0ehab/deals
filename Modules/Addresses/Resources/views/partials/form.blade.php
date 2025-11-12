@include('dashboard::errors')
{{ BsForm::text('address')->required() }}
{{ BsForm::text('description')->required() }}
<select2 name="city_id" label="@lang('countries::cities.singular')" remote-url="{{ route('cities.select') }}"
    value="{{ $address->city_id ?? old('city_id') }}" required="true"></select2>

<select2 name="region_id" label="@lang('countries::regions.singular')" remote-url="{{ route('regions.select') }}"
    value="{{ $address->region_id ?? old('region_id') }}" required="true"></select2>

{{ BsForm::select('type')->options([
    'home' => __('Home'),
    'office' => __('Office'),
])->placeholder(__("Select one")) }}
