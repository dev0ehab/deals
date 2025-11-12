@if(auth()->user()->hasPermission('update_addresses'))
    <a href="https://maps.google.com/?q={{ $address->lat }},{{ $address->long }}"
       target="_blank" class="btn btn-icon btn-light-success btn-hover-success btn-sm">
        <i class="fas fa-location-arrow fa fa-fw"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-icon btn-light-success btn-hover-success btn-sm">
        <i class="fas fa-location-arrow fa fa-fw"></i>
    </button>
@endcan
