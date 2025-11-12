@if(auth()->user()->hasPermission('readTrashed_users'))
    <a href="{{ route('dashboard.users.trashed') }}"
       class="btn btn-danger font-weight-bolder">
        <i class="fas fa-trash-alt"></i>
        @lang('accounts::user.actions.trashed')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-danger font-weight-bolder">
        <i class="fas fa-trash-alt"></i>
        @lang('accounts::user.actions.trashed')
    </button>
@endif
