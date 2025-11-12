@if(auth()->user()->hasPermission('update_addresses'))
    <a href="{{ route('dashboard.customers.addresses.edit', [$customer, $address]) }}"
       class="btn btn-icon btn-light-primary btn-hover-primary btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-icon btn-light-primary btn-hover-primary btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
    </button>
@endcan
