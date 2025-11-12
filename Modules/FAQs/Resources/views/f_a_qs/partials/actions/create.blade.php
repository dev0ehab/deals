@if(auth()->user()->hasPermission('create_f_a_qs'))
    <a href="{{ route('dashboard.f_a_qs.create') }}"
       class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('f_a_qs::f_a_qs.actions.create')
    </a>
@else
    <button
        type="button"
        disabled
        class="btn btn-primary font-weight-bolder">
        <i class="fas fa fa-fw fa-plus"></i>
        @lang('f_a_qs::f_a_qs.actions.create')
    </button>
@endif
