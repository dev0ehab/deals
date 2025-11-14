@if(auth()->user()->hasPermission('readTrashed_vendors'))
    <a href="{{ route('dashboard.vendors.trashed') }}"
       class="btn btn-danger font-weight-bolder">
        <i class="fas fa-trash-alt"></i>
        @lang('vendors::vendors.actions.trashed')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-danger font-weight-bolder">
        <i class="fas fa-trash-alt"></i>
        @lang('vendors::vendors.actions.trashed')
    </button>
@endif
