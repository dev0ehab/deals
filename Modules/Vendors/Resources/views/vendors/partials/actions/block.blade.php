@if(auth()->user()->hasPermission('block_vendors') && auth()->user()->isNot($vendor))
    @if (!$vendor->blocked_at)
        <a href="#vendor-{{ $vendor->id }}-block-model"
           class="btn btn-outline-dark waves-effect waves-light btn-sm"
           data-toggle="modal">
            <i class="fa fa-ban"></i>
            @lang('vendors::vendors.actions.block')
        </a>


        <!-- Modal -->
        <div class="modal fade" id="vendor-{{ $vendor->id }}-block-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $vendor->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $vendor->id }}">@lang('vendors::vendors.dialogs.block.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('vendors::vendors.dialogs.block.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::patch(route('dashboard.vendors.block', $vendor)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('vendors::vendors.dialogs.block.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('vendors::vendors.dialogs.block.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @else
        <a href="#vendor-{{ $vendor->id }}-unblock-model"
           class="btn btn-outline-dark waves-effect waves-light btn-sm"
           data-toggle="modal">
            <i class="fa fa-check"></i>
            @lang('vendors::vendors.actions.unblock')
        </a>


        <!-- Modal -->
        <div class="modal fade" id="vendor-{{ $vendor->id }}-unblock-model" tabindex="-1" role="dialog"
             aria-labelledby="modal-title-{{ $vendor->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="modal-title-{{ $vendor->id }}">@lang('vendors::vendors.dialogs.unblock.title')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('vendors::vendors.dialogs.unblock.info')
                    </div>
                    <div class="modal-footer">
                        {{ BsForm::patch(route('dashboard.vendors.unblock', $vendor)) }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            @lang('vendors::vendors.dialogs.unblock.cancel')
                        </button>
                        <button type="submit" class="btn btn-danger">
                            @lang('vendors::vendors.dialogs.unblock.confirm')
                        </button>
                        {{ BsForm::close() }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
