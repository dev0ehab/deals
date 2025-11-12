@if(auth()->user()->hasPermission('delete_f_a_qs'))
    <a href="#country-{{ $f_a_q->id }}-delete-model" class="btn btn-outline-danger waves-effect waves-light btn-sm"
       data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="country-{{ $f_a_q->id }}-delete-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $f_a_q->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $f_a_q->id }}">@lang('f_a_qs::f_a_qs.dialogs.delete.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('f_a_qs::f_a_qs.dialogs.delete.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.f_a_qs.destroy', $f_a_q)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('f_a_qs::f_a_qs.dialogs.delete.cancel')
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('f_a_qs::f_a_qs.dialogs.delete.confirm')
                    </button>
                    {{ BsForm::close() }}
                </div>
            </div>
        </div>
    </div>
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-danger waves-effect waves-light btn-sm">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </button>
@endcan
