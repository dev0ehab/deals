@if(auth()->user()->hasPermission('delete_products'))
    <a href="#feature-{{ $feature->id }}-delete-modal"
       class="btn btn-outline-danger waves-effect waves-light btn-sm"
       data-toggle="modal">
        <i class="fas fa-trash-alt fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="feature-{{ $feature->id }}-delete-modal" tabindex="-1" role="dialog"
         aria-labelledby="modal-title-{{ $feature->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="modal-title-{{ $feature->id }}">@lang('products::products.features.dialogs.delete.title', [], app()->getLocale())</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @lang('products::products.features.dialogs.delete.info', [], app()->getLocale())
                </div>
                <div class="modal-footer">
                    {{ BsForm::delete(route('dashboard.products.features.destroy', [$product, $feature])) }}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        @lang('products::products.features.dialogs.delete.cancel', [], app()->getLocale())
                    </button>
                    <button type="submit" class="btn btn-danger">
                        @lang('products::products.features.dialogs.delete.confirm', [], app()->getLocale())
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
@endif

