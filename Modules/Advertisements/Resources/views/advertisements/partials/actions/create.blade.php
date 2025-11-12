@if(auth()->user()->hasPermission('create_advertisements'))
    <a href="{{ route('dashboard.advertisements.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('advertisements::advertisements.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('advertisements::advertisements.actions.create')
    </button>
@endif
