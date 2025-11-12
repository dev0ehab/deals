@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@bsMultilangualFormTabs
    {{ BsForm::text('title')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{ BsForm::textarea('description')->required()->attribute(['class' => 'form-control textarea', 'data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
@endBsMultilangualFormTabs

<div class="form-group">
    {{ BsForm::select('category_id')->options(\Modules\Attributes\Entities\Category::listsTranslations('name')->active()->ordered()->pluck('name', 'id')->toArray())->required()->placeholder('Select Category')->label(__('attributes::categories.singular')) }}
    {{ BsForm::select('type')->required()->options(trans('attributes::attributes.types'))->required()->attribute(['id' => 'attribute-type']) }}
</div>

<div class="form-group">
    {{ BsForm::select('pricing_type')->options([
        \App\Enums\AttributePricingEnum::PAPER_PRICE->value => \App\Enums\AttributePricingEnum::translatedName(\App\Enums\AttributePricingEnum::PAPER_PRICE->value),
        \App\Enums\AttributePricingEnum::TOTAL_PRICE->value => \App\Enums\AttributePricingEnum::translatedName(\App\Enums\AttributePricingEnum::TOTAL_PRICE->value),
        \App\Enums\AttributePricingEnum::NO_PRICE->value => \App\Enums\AttributePricingEnum::translatedName(\App\Enums\AttributePricingEnum::NO_PRICE->value),
    ])->required()->placeholder('Select Price Type')->attribute(['id' => 'pricing-type']) }}
    {{ BsForm::checkbox('is_active')->value(1)->withDefault()->checked(isset($attribute) ? $attribute->is_active : false) }}
</div>

<div class="options-form" style="display: none;">

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
                                    {{ BsForm::text('name:ar')->value($option->translate('ar')->name)->label(trans('attributes::attributeOptions.attributes.name_ar', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                </div>
                                <div class="col-6">
                                    {{ BsForm::text('name:en')->value($option->translate('en')->name)->label(trans('attributes::attributeOptions.attributes.name_en', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
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

                                <div class="col-6">
                                    <label>{{ __('attributes::attributeOptions.attributes.icon') }}</label>
                                    @include('dashboard::layouts.apps.file', [
                                        'file'       => $option->icon ? $option->icon['url'] : null,
                                        'name'       => 'icon',
                                        'mimes'      => 'png jpg jpeg svg',
                                        'attributes' => "data-show-remove=true data-id=" . ($option->icon ? $option->icon['id'] : 0),
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

                                <input type="checkbox" name="is_default" value="{{ $option->is_default }}" class="is_default" {{ $option->is_default ? 'checked' : '' }} >
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
                                    {{ BsForm::text('name:ar')->label(trans('attributes::attributeOptions.attributes.name_ar', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                </div>
                                <div class="col-6">
                                    {{ BsForm::text('name:en')->label(trans('attributes::attributeOptions.attributes.name_en', [], app()->getLocale()))->attribute(['class' => 'form-control option_class']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>{{ __('attributes::attributeOptions.attributes.image') }}</label>
                                    @include('dashboard::layouts.apps.file', [
                                        'name'       => 'image',
                                        'mimes'      => 'png jpg jpeg svg',
                                        ])
                                </div>
                                <div class="col-6">
                                    <label>{{ __('attributes::attributeOptions.attributes.icon') }}</label>
                                    @include('dashboard::layouts.apps.file', [
                                        'name'       => 'icon',
                                        'mimes'      => 'png jpg jpeg svg',
                                        ])
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-3 d-flex align-items-center justify-content-center" style="gap: 10px">
                        <div>
                            {{ BsForm::number('paper_count_factor')->value(1)->attribute(['min' => '.1', 'step' => '.1']) }}
                        </div>

                        <div class="price-field" style="display: none;">
                            {{ BsForm::number('price')->attribute(['min' => '.1', 'step' => '.1']) }}
                        </div>

                        <label class="switch" style="margin-top: 15px">
                            <input type="checkbox" name="is_default" value="0" class="is_default">
                            <span class="slider round"></span>
                        </label>
                    </div>

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
    });

    // Handle new repeater items
    $("[data-repeater-create]").on('click', function() {
        setTimeout(function() {
            toggleOptionsForm();
            togglePaperCountFactor();

            dropifies = $('.dropify');

            dorps = dropifies.slice(-2);

            // make this for last 2 dropifies

            dorps.each(function(index, dropify) {
                let drEvent = $(dropify).dropify();
                let dropifyInstance = drEvent.data('dropify');
                dropifyInstance.clearElement();
                dropifyInstance.resetPreview();
            });

            console.log($('.dropify') , $('.dropify-wrapper').parent());
            // select last 4 .dropify-wrapper then split them into 2 arrays then replace the last 2 with the first 2
            let dropifyWrappers = $('.dropify-wrapper').slice(-4);

        // Fix: increment i by 2, and actually perform the replacement
        for (let i = 1; i < dropifyWrappers.length; i+=2) {
            let replaced_wrapper = dropifyWrappers[i];
            let wrapper = dropifyWrappers[i - 1];
            // make this with jquery
            $(wrapper).replaceWith($(replaced_wrapper));
        }


            console.log($('.dropify') , $('.dropify-wrapper').parent());
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


    $(document).on('change', '.is_default', function() {
        $('.is_default').not(this).prop('checked', false).val(0);

        // Set the value of the currently checked checkbox to 1, otherwise 0
        if ($(this).is(':checked')) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
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
    </style>
@endpush

