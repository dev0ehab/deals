@if(auth()->user()->hasPermission('update_products'))
    <a href="#edit-feature-modal-{{ $feature->id }}"
       class="btn btn-outline-primary waves-effect waves-light btn-sm"
       data-toggle="modal">
        <i class="fas fa-edit fa fa-fw"></i>
    </a>

    <!-- Modal -->
    <div class="modal fade" id="edit-feature-modal-{{ $feature->id }}" tabindex="-1" role="dialog"
         aria-labelledby="edit-feature-modal-title-{{ $feature->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit-feature-modal-title-{{ $feature->id }}">
                        @lang('products::products.features.edit', [], app()->getLocale())
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ BsForm::putModel($feature, route('dashboard.products.features.update', [$product, $feature]), ['files' => true, 'data-parsley-validate', 'id' => 'edit-feature-form-' . $feature->id, 'class' => 'product-feature-form']) }}
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group">
                        {{ BsForm::select('feature_type')->options([
                            'text' => 'Text',
                            'image' => 'Image',
                            'data' => 'Data from Features Table',
                        ])->value($feature->feature_type)->label(__('products::products.features.feature_type', [], app()->getLocale()) ?: 'Feature Type')->attribute(['id' => 'edit_modal_feature_type_' . $feature->id, 'class' => 'form-control feature-type-select-edit-modal'])->placeholder(__('Select one'))->required() }}
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{ __('products::products.features.text_ar', [], app()->getLocale()) ?: 'Text (Arabic)' }}</label>
                                {{ BsForm::textarea('text_ar')->value($feature->text_ar ?? null)->attribute(['class' => 'form-control', 'rows' => 3]) }}
                            </div>
                            <div class="col-md-6">
                                <label>{{ __('products::products.features.text_en', [], app()->getLocale()) ?: 'Text (English)' }}</label>
                                {{ BsForm::textarea('text_en')->value($feature->text_en ?? null)->attribute(['class' => 'form-control', 'rows' => 3]) }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group feature-id-field-edit-modal" style="display: {{ $feature->feature_type === 'data' ? 'block' : 'none' }};">
                        {{ BsForm::select('feature_id')->options(Modules\Features\Entities\Feature::all()->pluck('name', 'id')->toArray())->value($feature->feature_id ?? null)->label(__('products::products.features.select_feature', [], app()->getLocale()) ?: 'Select Feature')->attribute(['id' => 'edit_modal_feature_id_' . $feature->id, 'class' => 'form-control main-select feature-select-edit-modal'])->placeholder(__('Select one')) }}
                    </div>


                    {{-- <div class="form-group text-value-fields-edit-modal" style="display: {{ $feature->feature_type === 'text' ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-6">
                                <label>{{ __('products::products.features.text_value_ar', [], app()->getLocale()) ?: 'Text Value (Arabic)' }}</label>
                                {{ BsForm::textarea('text_value_ar')->value($feature->text_value_ar ?? $feature->text_ar ?? null)->attribute(['class' => 'form-control', 'rows' => 3]) }}
                            </div>
                            <div class="col-md-6">
                                <label>{{ __('products::products.features.text_value_en', [], app()->getLocale()) ?: 'Text Value (English)' }}</label>
                                {{ BsForm::textarea('text_value_en')->value($feature->text_value_en ?? $feature->text_en ?? null)->attribute(['class' => 'form-control', 'rows' => 3]) }}
                            </div>
                        </div>
                    </div> --}}

                    <div class="form-group data-value-fields-edit-modal" style="display: {{ ($feature->feature_type === 'data' && $feature->feature_id) ? 'block' : 'none' }};">
                        <div class="form-group">
                            <label>{{ __('products::products.features.feature_options', [], app()->getLocale()) ?: 'Feature Options' }}</label>
                            {{ BsForm::select('feature_options[]')->options($feature->featureOptions->pluck('name', 'id')->toArray())->value($feature->featureOptions->pluck('id')->toArray())->attribute(['id' => 'edit_modal_feature_options_' . $feature->id, 'class' => 'form-control feature-options-select-edit-modal', 'multiple' => true]) }}
                        </div>
                    </div>

                    <div class="form-group image-field-edit-modal" style="display: {{ $feature->feature_type === 'image' ? 'block' : 'none' }};">
                        {{-- <label>{{ __('products::products.features.image', [], app()->getLocale()) ?: 'Image' }} <span class="text-danger">*</span></label>
                        @if($feature->image)
                            @include('dashboard::layouts.apps.file', [
                                'file' => $feature->image,
                                'name' => 'image',
                                'mimes' => 'png jpg jpeg svg',
                                'attributes' => $feature->feature_type === 'image' ? 'required' : '',
                            ])
                        @else
                            @include('dashboard::layouts.apps.file', [
                                'name' => 'image',
                                'mimes' => 'png jpg jpeg svg',
                                'attributes' => $feature->feature_type === 'image' ? 'required' : '',
                            ])
                        @endif --}}
                    </div>

                    <div class="form-group">
                        {{ BsForm::checkbox('is_active')->checked($feature->is_active ?? false)->label(__('products::products.attributes.is_active', [], app()->getLocale()) ?: 'Is Active') }}
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
            const featureId = {{ $feature->id }};
            const modalId = '#edit-feature-modal-' + featureId;
            const featureTypeId = '#edit_modal_feature_type_' + featureId;
            const featureSelectId = '#edit_modal_feature_id_' + featureId;
            const optionsSelectId = '#edit_modal_feature_options_' + featureId;

            // Handle feature type change in edit modal
            $(document).on('change', featureTypeId, function() {
                const featureType = $(this).val();
                const featureIdField = $(modalId).find('.feature-id-field-edit-modal');
                const dataFields = $(modalId).find('.data-value-fields-edit-modal');
                const imageField = $(modalId).find('.image-field-edit-modal');
                const imageInput = $(modalId).find('input[type="file"][name="image"]');
                const featureIdSelect = $(featureSelectId);
                const optionsSelect = $(optionsSelectId);

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

            // Handle feature selection change in edit modal to load options
            $(document).on('change', featureSelectId, function() {
                const selectedFeatureId = $(this).val();
                const featureType = $(featureTypeId).val();
                const optionsSelect = $(optionsSelectId);
                const dataFields = $(modalId).find('.data-value-fields-edit-modal');

                if (selectedFeatureId && featureType === 'data') {
                    // Show feature options field
                    dataFields.show();

                    // Load feature options via AJAX
                    $.ajax({
                        url: '{{ route("api.features.options", ":featureId") }}'.replace(':featureId', selectedFeatureId),
                        method: 'GET',
                        success: function(response) {
                            optionsSelect.empty();
                            if (response.options && response.options.length > 0) {
                                $.each(response.options, function(index, option) {
                                    optionsSelect.append(new Option(option.name, option.id));
                                });
                            }
                            // Restore previously selected values
                            const oldValues = @json($feature->featureOptions->pluck('id')->toArray());
                            if (oldValues && oldValues.length > 0) {
                                optionsSelect.val(oldValues).trigger('change');
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

            // Initialize when modal is shown
            $(modalId).on('shown.bs.modal', function() {
                // If feature type is data and feature_id exists, show options and load them
                @if($feature->feature_type === 'data' && $feature->feature_id)
                    $(modalId).find('.data-value-fields-edit-modal').show();
                    $(featureSelectId).trigger('change');
                @endif
            });

            // Reset modal when closed (optional, but good for cleanup)
            $(modalId).on('hidden.bs.modal', function() {
                // Reset can be done here if needed, but we want to preserve data
            });
        });
    </script>
    @endpush
@else
    <button
        type="button"
        disabled
        class="btn btn-outline-primary waves-effect waves-light btn-sm">
        <i class="fas fa-edit fa fa-fw"></i>
        @lang('products::products.actions.edit', [], app()->getLocale())
    </button>
@endif

