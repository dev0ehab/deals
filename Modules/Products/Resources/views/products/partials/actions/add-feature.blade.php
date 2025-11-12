<a href="#add-feature-modal-{{ $product->id }}"
    class="btn btn-primary waves-effect waves-light btn-sm"
    data-toggle="modal">
    <i class="fa fa-plus"></i>
    @lang('products::products.features.add', [], app()->getLocale())
</a>

<!-- Modal -->
<div class="modal fade" id="add-feature-modal-{{ $product->id }}" tabindex="-1" role="dialog"
     aria-labelledby="add-feature-modal-title-{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-feature-modal-title-{{ $product->id }}">
                    @lang('products::products.features.add', [], app()->getLocale())
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{ BsForm::post(route('dashboard.products.features.store', $product), ['files' => true, 'data-parsley-validate', 'id' => 'add-feature-form-' . $product->id, 'class' => 'product-feature-form']) }}
            <div class="modal-body">

                <div class="form-group">
                    {{ BsForm::select('feature_type')->options([
                        'text' => 'Text',
                        'image' => 'Image',
                        'data' => 'Data from Features Table',
                    ])->label(__('products::products.features.feature_type', [], app()->getLocale()) ?: 'Feature Type')->attribute(['id' => 'modal_feature_type', 'class' => 'form-control feature-type-select-modal'])->placeholder(__('Select one'))->required() }}
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <label>{{ __('products::products.features.text_ar', [], app()->getLocale()) ?: 'Text (Arabic)' }}</label>
                            {{ BsForm::textarea('text_ar')->attribute(['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                        <div class="col-md-6">
                            <label>{{ __('products::products.features.text_en', [], app()->getLocale()) ?: 'Text (English)' }}</label>
                            {{ BsForm::textarea('text_en')->attribute(['class' => 'form-control', 'rows' => 3]) }}
                        </div>
                    </div>
                </div>

                <div class="form-group feature-id-field-modal" style="display: none;">
                    {{ BsForm::select('feature_id')->options(Modules\Features\Entities\Feature::all()->pluck('name', 'id')->toArray())->label(__('products::products.features.select_feature', [], app()->getLocale()) ?: 'Select Feature')->attribute(['id' => 'modal_feature_id', 'class' => 'form-control main-select feature-select-modal'])->placeholder(__('Select one')) }}
                </div>

                <div class="form-group data-value-fields-modal" style="display: none;">
                    <div class="form-group">
                        <label>{{ __('products::products.features.feature_options', [], app()->getLocale()) ?: 'Feature Options' }}</label>
                        {{ BsForm::select('feature_options[]')->options([])->attribute(['id' => 'modal_feature_options', 'class' => 'form-control feature-options-select-modal', 'multiple' => true]) }}
                    </div>
                </div>

                <div class="form-group image-field-modal" style="display: none;">
                    {{-- <label>{{ __('products::products.features.image', [], app()->getLocale()) ?: 'Image' }} <span class="text-danger">*</span></label>
                    @include('dashboard::layouts.apps.file', [
                        'name' => 'image',
                        'mimes' => 'png jpg jpeg svg',
                        'attributes' => 'required',
                    ]) --}}
                </div>

                <div class="form-group">
                    {{ BsForm::checkbox('is_active')->checked()->label(__('products::products.attributes.is_active', [], app()->getLocale()) ?: 'Is Active') }}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @lang('products::products.dialogs.delete.cancel', [], app()->getLocale())
                </button>
                <button type="submit" class="btn btn-primary">
                    @lang('products::products.features.save', [], app()->getLocale())
                </button>
            </div>
            {{ BsForm::close() }}
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Handle feature type change in modal
        $(document).on('change', '#modal_feature_type', function() {
            const featureType = $(this).val();
            const featureIdField = $('.feature-id-field-modal');
            const dataFields = $('.data-value-fields-modal');
            const imageField = $('.image-field-modal');
            const imageInput = $('#add-feature-modal-{{ $product->id }}').find('input[type="file"][name="image"]');
            const featureIdSelect = $('#modal_feature_id');
            const optionsSelect = $('#modal_feature_options');

            // Hide all fields first
            featureIdField.hide();
            dataFields.hide();
            imageField.hide();
            featureIdSelect.val('').trigger('change');
            optionsSelect.empty().trigger('change');

            // Show relevant fields based on type
            if (featureType === 'image') {
                imageField.show();
                // Add required to image
                imageInput.attr('required', 'required');
            } else if (featureType === 'data') {
                featureIdField.show();
                // Remove required from image
                imageInput.removeAttr('required');
            } else {
                // Remove required from image for text type
                imageInput.removeAttr('required');
            }
        });

        // Handle feature selection change in modal to load options
        $(document).on('change', '#modal_feature_id', function() {
            const featureId = $(this).val();
            const featureType = $('#modal_feature_type').val();
            const optionsSelect = $('#modal_feature_options');
            const dataFields = $('.data-value-fields-modal');

            if (featureId && featureType === 'data') {
                // Show feature options field
                dataFields.show();

                // Load feature options via AJAX
                $.ajax({
                    url: '{{ route("api.features.options", ":featureId") }}'.replace(':featureId', featureId),
                    method: 'GET',
                    success: function(response) {
                        optionsSelect.empty();
                        if (response.options && response.options.length > 0) {
                            $.each(response.options, function(index, option) {
                                optionsSelect.append(new Option(option.name, option.id));
                            });
                        }
                        optionsSelect.select2();
                    },
                    error: function() {
                        optionsSelect.empty();
                    }
                });
            } else {
                dataFields.hide();
                optionsSelect.empty().trigger('change');
            }
        });

        // Reset modal when closed
        $('#add-feature-modal-{{ $product->id }}').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $('.feature-id-field-modal, .data-value-fields-modal, .image-field-modal').hide();
            $('#modal_feature_id').val('').trigger('change');
            $('#modal_feature_options').empty().trigger('change');
        });
    });
</script>
@endpush

