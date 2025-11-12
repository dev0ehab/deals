@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    use Modules\Sections\Entities\Section;
@endphp
<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading1">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    # {{ __('products::products.sections.main_info') }}
                </button>
            </h2>
        </div>

        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionExample">

            <div class="card-body">
                @bsMultilangualFormTabs
                {{ BsForm::text('name')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3'])->required() }}
                {{ BsForm::textarea('description')->attribute(['class' => 'textarea'])->required() }}
                @endBsMultilangualFormTabs

                {{ BsForm::select('section_id')->options(Section::listsTranslations('name')->pluck('name', 'id'))->placeholder(__('products::products.sections.select_one'))->label(__('sections::sections.singular'))->required() }}


                {{ BsForm::number('price')->min(0.1)->step('0.1')->required() }}
                {{ BsForm::number('old_price')->min(0.1)->step('0.1') }}
                {{ BsForm::number('stock')->min(0)->required() }}

            </div>
        </div>
    </div>
</div>

<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading3">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                    # {{ __('products::products.sections.cover_and_images') }}
                </button>
            </h2>
        </div>

        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionExample">
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <label>{{ __('products::products.attributes.cover') }}</label>
                        @isset($product)
                            @include('dashboard::layouts.apps.file', [
                                'file' => $product->cover,
                                'name' => 'cover',
                                'mimes' => 'png jpg jpeg',
                            ])
                        @else
                            @include('dashboard::layouts.apps.file', ['name' => 'cover'])
                        @endisset
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label>{{ __('products::products.attributes.images') }}</label>
                        @if (isset($product))
                            @include('dashboard::layouts.apps.multi', [
                                'name' => 'images[]',
                                'images' => $product->images,
                            ])
                        @else
                            @include('dashboard::layouts.apps.multi', ['name' => 'images[]'])
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{--
<div class="accordion" id="accordionExample">

    <div class="card">
        <div class="card-header" id="heading4">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                        data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                    # {{ __('products::products.sections.features') }}
                </button>
            </h2>
        </div>

        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
            <div class="card-body">
                <div class="product-features-form">


                    <div class="options-form" >

                        <label>@lang('attributes::attributeOptions.plural')</label>

                        <div data-repeater-list="options">
                            @if (isset($attribute) && $attribute->options()->count() > 0)
                                @foreach ($attribute->options as $option)
                                    <div data-repeater-item>
                                        <div class="row m-0">
                                            <div class="col-8">
                                                <div class="row">

                                                    <input type="hidden" name="options[{{ $option->id }}][id]" value="{{ $option->id }}">

                                                    <div class="col-6">
                                                        {{ BsForm::text('name_ar')->value($option->translate('ar')->name)->label(trans('attributes::attributeOptions.attributes.name_ar', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                                    </div>
                                                    <div class="col-6">
                                                        {{ BsForm::text('name_en')->value($option->translate('en')->name)->label(trans('attributes::attributeOptions.attributes.name_en', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">

                                                        <label>{{ __('attributes::attributeOptions.attributes.image') }}</label>
                                                        @include('dashboard::layouts.apps.file', [
                                                            'file'       => $option->image ? $option->image['url'] : null,
                                                            'name'       => 'image',
                                                            'mimes'      => 'png jpg jpeg svg',
                                                            'attributes' => "data-show-remove=true data-id=" . ($option->image ? $option->image['id'] : 0),
                                                            ])

                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-3 d-flex align-items-center justify-content-center" style="gap: 10px">

                                                <div>
                                                    {{ BsForm::number('paper_count_factor')->value($option->paper_count_factor ?? 1)->attribute(['min' => '.1', 'step' => '.1']) }}
                                                </div>

                                                <div class="price-field" style="display: none;">
                                                    {{ BsForm::number('price')->value($option->price)->attribute(['min' => '.1', 'step' => '.1']) }}
                                                </div>

                                                <label class="switch" style="margin-top: 15px">

                                                    <input type="checkbox" name="options[{{ $option->id }}][is_default]" value="1" class="is_default" data-parsley-excluded="true" {{ $option->is_default ? 'checked' : '' }} >
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>


                                            <div class="col-1" style="align-self: center">
                                                <button type="button" data-repeater-delete class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div data-repeater-item>
                                    <div class="row my-2">
                                        <div class="col-8">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-6">
                                                        {{ BsForm::text('name_ar')->label(trans('attributes::attributeOptions.attributes.name_ar', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                                    </div>
                                                    <div class="col-6">
                                                        {{ BsForm::text('name_en')->label(trans('attributes::attributeOptions.attributes.name_en', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                    {{ BsForm::select('feature_type')->options([
                                                        'text' => 'Text',
                                                        'image' => 'Image',
                                                        'data' => 'Data from Features Table',
                                                    ])->label(__('products::products.features.feature_type'))->attribute(['class' => 'form-control feature-type-select-repeater']) }}
                                                    </div>
                                                </div>

                                                <div class="row text-value-fields" style="display: none;">
                                                    <div class="col-6">
                                                        <label>{{ __('products::products.features.text_value_ar') }}</label>
                                                        <textarea name="text_value_ar" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col-6">
                                                        <label>{{ __('products::products.features.text_value_en') }}</label>
                                                        <textarea name="text_value_en" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                                <div class="row data-value-fields" style="display: none;">
                                                    <div class="col-4">
                                                        {{ BsForm::select('feature_id')->options(Modules\Features\Entities\Feature::all()->pluck('name', 'id'))->label(__('products::products.features.select_feature'))->attribute(['id' => 'feature_id', 'data_step' => '1', 'class' => 'form-control main-select feature_div'])->placeholder(__('Select one')) }}
                                                    </div>

                                                    @include('dashboard::layouts.components.ajax', [
                                                        'step'            => '2',
                                                        'action'          => 'feature',
                                                        'selector'        => 'feature_options',
                                                        'required'        => true,
                                                        'multiple'        => true,
                                                        'class'           => 'd-none',
                                                        'options'         => [],
                                                        'chosenOptionIds' => [],
                                                        'routeUrl'        => 'api/select/feature-options-by-feature-id',
                                                    ])

                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <label>{{ __('attributes::attributeOptions.attributes.image') }}</label>
                                                        @include('dashboard::layouts.apps.file', [
                                                            'name'       => 'image',
                                                            'mimes'      => 'png jpg jpeg svg',
                                                            ])
                                                    </div>
                                                </div>


                                            </div>

                                            <label class="switch" style="margin-top: 15px">
                                                <input type="checkbox" name="options[][is_default]" value="1" class="is_default" data-parsley-excluded="true">
                                                <span class="slider round"></span>
                                            </label>

                                        <div class="col-1">
                                            <button type="button" data-repeater-delete class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" data-repeater-create class="btn btn-primary my-2">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>





@push('js')
<script>
    function setRequired(fields, required) {
        fields.forEach(field => {
            if (required) {
                field.setAttribute('required', 'required');
            } else {
                field.removeAttribute('required');
            }
        });
    }

    // Function to toggle options form visibility
    function toggleOptionsForm() {
        const typeSelect = document.getElementById('attribute-type');
        const optionsForm = document.querySelector('.options-form');
        const optionNameFields = document.querySelectorAll('.option_class');
        // const optionImageFields = document.querySelectorAll('input[name*="[image]"]');

        if (typeSelect.value === 'select') {
            optionsForm.style.display = 'block';
            setRequired(optionNameFields, true);
            // setRequired(optionImageFields, true);
        } else if (typeSelect.value === 'text') {
            optionsForm.style.display = 'none';
            setRequired(optionNameFields, false);
            // setRequired(optionImageFields, false);
        } else {
            optionsForm.style.display = 'none';
            setRequired(optionNameFields, false);
            // setRequired(optionImageFields, false);
        }
    }

    // Function to toggle paper count factor and price field visibility
    function togglePaperCountFactor() {
        var $pricingTypeSelect = $('#pricing-type');
        var $paperCountFactors = $('.paper-count-factor');
        var $priceField = $('.price-field');

        if ($pricingTypeSelect.length && $pricingTypeSelect.val() === 'paper_price') {
            $paperCountFactors.show();
            $priceField.hide();
        } else if ($pricingTypeSelect.length && $pricingTypeSelect.val() === 'total_price') {
            $paperCountFactors.hide();
            $priceField.show();
        } else {
            $paperCountFactors.hide();
            $priceField.hide();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('attribute-type');
        const pricingTypeSelect = document.getElementById('pricing-type');

        if (typeSelect) {
            typeSelect.addEventListener('change', toggleOptionsForm);
            toggleOptionsForm(); // Initial check
        }

        if (pricingTypeSelect) {
            pricingTypeSelect.addEventListener('change', togglePaperCountFactor);
            togglePaperCountFactor(); // Initial check
        }

        // Initialize feature type handlers for repeater items
        initializeFeatureTypeHandlersInRepeater();
    });

    // Handle feature type change in repeater items
    function handleFeatureTypeChangeInRepeater(selectElement) {
        const repeaterItem = selectElement.closest('[data-repeater-item]');
        const featureType = selectElement.val();
        const textFields = repeaterItem.find('.text-value-fields');
        const dataFields = repeaterItem.find('.data-value-fields');

        // Hide all conditional fields first
        textFields.hide();
        dataFields.hide();

        // Show relevant fields based on type
        if (featureType === 'text') {
            textFields.show();
        } else if (featureType === 'data') {
            dataFields.show();
        }
    }

    // Initialize feature type handlers for repeater items
    function initializeFeatureTypeHandlersInRepeater() {
        // Use delegated event handler for dynamically added items
        $(document).off('change', '.feature-type-select-repeater').on('change', '.feature-type-select-repeater', function() {
            handleFeatureTypeChangeInRepeater($(this));
        });

        // Initialize existing items
        $('.feature-type-select-repeater').each(function() {
            handleFeatureTypeChangeInRepeater($(this));
        });
    }

    // Handle new repeater items
    $("[data-repeater-create]").on('click', function() {
        setTimeout(function() {


            let object = $('.dropify').last().dropify();
            $('.dropify-wrapper').last().parent().replaceWith($('.dropify-wrapper').last());
            let drEvent = object.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();

            // Initialize feature type handlers for new items
            initializeFeatureTypeHandlersInRepeater();
        }, 100);
    });


    $('.dropify').on('dropify.beforeClear', function(event, element){
        // make ajax request to delethe image
        let url = "{{ route('uploader.media.destroy', ['media' => ':media']) }}";
        url = url.replace(':media', element.settings.id);
        $.ajax({
            url: url,
            type: 'DELETE',
            data: {
                id: element.settings.id
            },
            success: function(response) {
            }
        });
    });

    // Handle is_default checkbox behavior
    $(document).on('change', '.is_default', function() {
        const repeaterItem = $(this).closest('[data-repeater-item]');

        // Uncheck other checkboxes in the same repeater item
        repeaterItem.find('.is_default').not(this).prop('checked', false);

        // Update value based on checked state
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    });

    // Product Features Form Repeater - Custom Implementation
    $(document).ready(function() {
        // Handle add feature button
        $(document).on('click', '[data-product-feature-create]', function() {
            addProductFeature();
        });

        // Handle delete feature button
        $(document).on('click', '[data-product-feature-delete]', function() {
            $(this).closest('[data-product-feature-item]').remove();
        });

        // Handle add feature option button
        $(document).on('click', '.add-feature-option', function() {
            addFeatureOption($(this).closest('.feature-options-data'));
        });

        // Handle remove feature option button
        $(document).on('click', '.remove-feature-option', function() {
            $(this).closest('.feature-option-item').remove();
        });

        // Initialize handlers for existing items
        $('.product-feature-item').each(function() {
            initializeFeatureTypeHandlers($(this));
        });
    });

    function addProductFeature() {
        // Clone the existing template item
        const existingItem = $('[data-product-features-list] [data-product-feature-item]').first();
        if (existingItem.length) {
            const newItem = existingItem.clone();

            // Clear all input values
            newItem.find('input[type="text"], input[type="file"], textarea, select').val('');
            newItem.find('input[type="checkbox"]').prop('checked', false);

            // Update name attributes to use array notation
            newItem.find('input, select, textarea').each(function() {
                const name = $(this).attr('name');
                if (name) {
                    $(this).attr('name', name.replace(/\[[0-9]*\]/, '[]'));
                }
            });

            // Reset feature type to 'text' and show text fields
            newItem.find('.feature-type-select').val('text');
            newItem.find('.text-fields').show();
            newItem.find('.data-fields').hide();

            // Populate feature select dropdown
            populateFeatureSelect(newItem.find('.feature-select'));

            // Append to the list
            $('[data-product-features-list]').append(newItem);

            // Initialize handlers for the new item
            initializeFeatureTypeHandlers(newItem);
        } else {
            // If no existing items, create a basic one
            const template = `
                <div data-product-feature-item class="product-feature-item">
                    <div class="row mb-3 p-3 border rounded">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name (Arabic)</label>
                                    <input type="text" name="product_features[][name:ar]" class="form-control feature-name-ar">
                                </div>
                                <div class="col-md-6">
                                    <label>Name (English)</label>
                                    <input type="text" name="product_features[][name:en]" class="form-control feature-name-en">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Feature Type</label>
                                    <select name="product_features[][feature_type]" class="form-control feature-type-select">
                                        <option value="text">Text</option>
                                        <option value="image">Image</option>
                                        <option value="data">Data from Features Table</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Image</label>
                                    <input type="file" name="product_features[][image]" class="form-control feature-image-upload" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3 text-fields">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Text Value (Arabic)</label>
                                    <textarea name="product_features[][text_value_ar]" class="form-control text-value-ar" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label>Text Value (English)</label>
                                    <textarea name="product_features[][text_value_en]" class="form-control text-value-en" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3 data-fields" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Select Feature</label>
                                    <select name="product_features[][feature_id]" class="form-control feature-select">
                                        <option value="">Select Feature</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Select Options</label>
                                    <select name="product_features[][feature_options][][option_ids][]" class="form-control feature-options-select" multiple data-parsley-excluded="true">
                                    </select>
                                </div>
                            </div>

                            <!-- Feature Options Data -->
                            <div class="feature-options-data mt-3">
                                <label>{{ __('products::products.features.feature_options_data') }}</label>
                                <div class="feature-options-list">
                                    <!-- Options will be added dynamically -->
                                </div>
                                <button type="button" class="btn btn-sm btn-primary add-feature-option mt-2">
                                    <i class="fa fa-plus"></i> {{ __('products::products.features.add_option_data') }}
                                </button>
                            </div>
                        </div>

                        <div class="col-12 mt-3 text-right">
                            <button type="button" data-product-feature-delete class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            `;

            $('[data-product-features-list]').append(template);

            // Initialize handlers for the new item
            const newItem = $('[data-product-features-list] [data-product-feature-item]').last();
            initializeFeatureTypeHandlers(newItem);
        }
    }

    // Function to populate feature select dropdown
    function populateFeatureSelect(selectElement) {
        if (selectElement.length) {
            // Get features from the existing select in the form
            const existingSelect = $('.feature-select').first();
            if (existingSelect.length) {
                const options = existingSelect.html();
                selectElement.html(options);
            }
        }
    }

    // Function to add feature option data
    function addFeatureOption(container) {
        const index = container.find('.feature-option-item').length;
        const featureId = container.closest('.product-feature-item').find('.feature-select').val();

        const template = `
            <div class="feature-option-item border p-3 mb-2 rounded">
                <div class="row">
                    <div class="col-md-6">
                        <label>Name (Arabic)</label>
                        <input type="text" name="feature_options[${index}][name_ar]" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Name (English)</label>
                        <input type="text" name="feature_options[${index}][name_en]" class="form-control">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Text Value (Arabic)</label>
                        <textarea name="feature_options[${index}][text_value_ar]" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Text Value (English)</label>
                        <textarea name="feature_options[${index}][text_value_en]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <label>Image</label>
                        <input type="file" name="feature_options[${index}][image]" class="form-control feature-option-image-upload" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <input type="hidden" name="feature_options[${index}][feature_id]" value="${featureId}">
                        <input type="hidden" name="feature_options[${index}][option_ids][]" value="">
                        <button type="button" class="btn btn-sm btn-danger remove-feature-option mt-4">
                            <i class="fa fa-trash"></i> Remove Option
                        </button>
                    </div>
                </div>
            </div>
        `;

        container.find('.feature-options-list').append(template);
    }

    // Initialize feature type handlers for existing items
    function initializeFeatureTypeHandlers(container) {
        container.find('.feature-type-select').off('change').on('change', function() {
            handleFeatureTypeChange($(this));
        });

        container.find('.feature-select').off('change').on('change', function() {
            handleFeatureChange($(this));
        });
    }

    // Handle feature type change
    function handleFeatureTypeChange(selectElement) {
        const featureItem = selectElement.closest('.product-feature-item');
        const featureType = selectElement.val();
        const textFields = featureItem.find('.text-fields');
        const dataFields = featureItem.find('.data-fields');
        const imageField = featureItem.find('.feature-image-upload');

        // Hide all conditional fields first
        textFields.hide();
        dataFields.hide();

        // Show relevant fields based on type
        if (featureType === 'text') {
            textFields.show();
            imageField.removeAttr('required');
        } else if (featureType === 'image') {
            imageField.attr('required', 'required');
        } else if (featureType === 'data') {
            dataFields.show();
            imageField.removeAttr('required');
        }
    }

    // Handle feature selection change
    function handleFeatureChange(selectElement) {
        const featureId = selectElement.val();
        const optionsSelect = selectElement.closest('.product-feature-item').find('.feature-options-select');
        const featureOptionsData = selectElement.closest('.product-feature-item').find('.feature-options-data');

        if (featureId) {
            // Load feature options via AJAX
            $.ajax({
                url: '{{ route("api.features.options", ":featureId") }}'.replace(':featureId', featureId),
                method: 'GET',
                success: function(response) {
                    optionsSelect.empty();
                    console.log(response);
                    if (response.options && response.options.length > 0) {
                        $.each(response.options, function(index, option) {
                            optionsSelect.append(new Option(option.name, option.id));
                        });
                    }

                    optionsSelect.select2();

                    // Update feature_id in all existing feature option items
                    featureOptionsData.find('input[name*="[feature_id]"]').val(featureId);
                },
                error: function() {
                    optionsSelect.empty();
                }
            });
        } else {
            optionsSelect.empty();
        }
    }

    // Initialize handlers for existing items
    $(document).ready(function() {
        $('.product-feature-item').each(function() {
            initializeFeatureTypeHandlers($(this));
        });
    });

</script>
@endpush


@push('css')
    <style>
        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 17px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 13px;
            width: 13px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #45cb85;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #45cb85;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(13px);
            -ms-transform: translateX(13px);
            transform: translateX(13px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 17px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        /* Product Features Form Styles */
        .product-features-form {
            margin-top: 20px;
        }

        .product-feature-item {
            margin-bottom: 20px;
        }

        .product-feature-item .border {
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem;
        }

        .feature-type-select,
        .feature-select,
        .feature-options-select {
            width: 100%;
        }

        .feature-options-select {
            min-height: 100px;
        }

        .text-fields,
        .data-fields {
            transition: all 0.3s ease;
        }

        .feature-image-upload {
            margin-top: 5px;
        }

        /* Feature Options Data Styles */
        .feature-options-data {
            border: 1px solid #e9ecef;
            border-radius: 0.375rem;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .feature-option-item {
            background-color: white;
            border: 1px solid #dee2e6 !important;
        }

        .feature-option-item .border {
            border: 1px solid #dee2e6 !important;
        }

        .add-feature-option {
            margin-top: 10px;
        }

        .remove-feature-option {
            margin-top: 20px;
        }
    </style>
@endpush --}}
