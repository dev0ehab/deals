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
    ])->value($feature->feature_type)->label(__('products::products.features.feature_type', [], app()->getLocale()) ?: 'Feature Type')->attribute(['id' => 'edit_feature_type', 'class' => 'form-control feature-type-select-edit'])->placeholder(__('Select one'))->required() }}
</div>

<div class="form-group feature-id-field-edit" style="display: {{ $feature->feature_type === 'data' ? 'block' : 'none' }};">
    {{ BsForm::select('feature_id')->options(Modules\Features\Entities\Feature::all()->pluck('name', 'id')->toArray())->value($feature->feature_id ?? null)->label(__('products::products.features.select_feature', [], app()->getLocale()) ?: 'Select Feature')->attribute(['id' => 'edit_feature_id', 'class' => 'form-control main-select feature-select-edit'])->placeholder(__('Select one')) }}
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


<div class="form-group data-value-fields-edit" style="display: {{ ($feature->feature_type === 'data' && $feature->feature_id) ? 'block' : 'none' }};">
    <div class="form-group">
        <label>{{ __('products::products.features.feature_options', [], app()->getLocale()) ?: 'Feature Options' }}</label>
        {{ BsForm::select('feature_options[]')->options($feature->featureOptions->pluck('name', 'id')->toArray())->value($feature->featureOptions->pluck('id')->toArray())->label(__('products::products.features.select_options', [], app()->getLocale()) ?: 'Select Options')->attribute(['id' => 'edit_feature_options', 'class' => 'form-control feature-options-select-edit', 'multiple' => true]) }}
    </div>
</div>

<div class="form-group image-field-edit" style="display: {{ $feature->feature_type === 'image' ? 'block' : 'none' }};">
    <label>{{ __('products::products.features.image', [], app()->getLocale()) ?: 'Image' }} <span class="text-danger">*</span></label>
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
    @endif
</div>

<div class="form-group">
    {{ BsForm::checkbox('is_active')->checked($feature->is_active ?? false)->label(__('products::products.attributes.is_active', [], app()->getLocale()) ?: 'Is Active') }}
</div>

@push('js')
<script>
    $(document).ready(function() {
        // Handle feature type change in edit form
        $(document).on('change', '#edit_feature_type', function() {
            const featureType = $(this).val();
            const featureIdField = $('.feature-id-field-edit');
            const dataFields = $('.data-value-fields-edit');
            const imageField = $('.image-field-edit');
            const imageInput = $('input[type="file"][name="image"]');
            const featureIdSelect = $('#edit_feature_id');
            const optionsSelect = $('#edit_feature_options');

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

        // Handle feature selection change in edit form to load options
        $(document).on('change', '#edit_feature_id', function() {
            const featureId = $(this).val();
            const featureType = $('#edit_feature_type').val();
            const optionsSelect = $('#edit_feature_options');
            const dataFields = $('.data-value-fields-edit');

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

        // Initialize if feature type is data and feature_id exists
        @if($feature->feature_type === 'data' && $feature->feature_id)
            $('.data-value-fields-edit').show();
            $('#edit_feature_id').trigger('change');
        @endif
    });
</script>
@endpush

