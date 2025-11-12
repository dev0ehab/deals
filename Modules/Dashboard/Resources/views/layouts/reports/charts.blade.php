<div class="col-md-6">
    <div class="card">
        <div class="card-body" style="position: relative;">
            <h4 class="card-title mb-4">@lang('dashboard::dashboard.most_searched_vin_numbers')</h4>
            {!! $mostSearchedVinNumbers->container() !!}
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-body" style="position: relative;">
            <h4 class="card-title mb-4">@lang('dashboard::dashboard.most_searched_brands')</h4>
            {!! $mostSearchedBrands->container() !!}
        </div>
    </div>
</div>

@push('js')

    <script src="{{ $mostSearchedVinNumbers->cdn() }}"></script>

    {{ $mostSearchedVinNumbers->script() }}

    {{ $mostSearchedBrands->script() }}
@endpush
