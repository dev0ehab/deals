@if(auth()->user()->hasPermission('create_users'))
    <a href="{{ route('dashboard.users.create', request()->only('type')) }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('accounts::user.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('accounts::user.actions.create')
    </button>
@endif
