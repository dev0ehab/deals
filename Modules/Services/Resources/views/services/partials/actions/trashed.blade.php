@if(auth()->user()->hasPermission('readTrashed_services'))
    <a href="{{ route('dashboard.services.trashed') }}"
       class="btn btn-danger font-weight-bolder">
        <i class="fas fa-trash-alt"></i>
        @lang('services::services.actions.trashed')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-danger font-weight-bolder">
        <i class="fas fa-trash-alt"></i>
        @lang('services::services.actions.trashed')
    </button>
@endif
