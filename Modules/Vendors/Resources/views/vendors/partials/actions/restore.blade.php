@if(auth()->user()->hasPermission('restore_vendors'))
    <a href="#vendor-{{ $vendor->id }}-restore-model" class="btn btn-outline-primary waves-effect waves-light btn-sm"
       data-toggle="modal">
       <i class="fas fa-trash-restore"></i>
    </a>


    <!-- Modal -->
    <div class="modal fade" id="vendor-{{ $vendor->id }}-restore-model" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $vendor->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $vendor->id }}">@lang('vendors::vendors.dialogs.restore.title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('vendors::vendors.dialogs.restore.info')
                </div>
                <div class="modal-footer">
                    {{ BsForm::get(route('dashboard.vendors.restore', $vendor)) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('vendors::vendors.dialogs.restore.cancel')
                    </button>
                    <button type="submit" class="btn btn-success">
                        @lang('vendors::vendors.dialogs.restore.confirm')
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
        class=btn btn-outline-danger waves-effect waves-light btn-sm">
        <i class="fas fa-trash-restore"></i>
    </button>
@endcan
