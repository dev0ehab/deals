@php
    $uuid = uniqid();
    $index = 0;
    $components_count = count($components);
@endphp

<label for=""> {{ $label ??= '' }}</label>
@foreach (languages() as $locale => $values)
    @push("$uuid-$locale")
        <div class="w-100" data-repeat-list='{{ "$uuid-$locale" }}'>
            @if ($models ??= [])
                @foreach ($models as $index => $model)
                    @foreach ($components as $component)
                        @include($component['input'], [
                            'name' => ($name = $component['name']),
                            'label' => $component['label'],
                            'attributes' => $component['attributes'],
                            'model' => $model,
                            'index' => $index,
                        ])
                    @endforeach
                @endforeach
            @else
                @foreach ($components as $component)
                    @include($component['input'], [
                        'name' => $component['name'],
                        'label' => $component['label'],
                        'attributes' => $component['attributes'],
                        'model' => null,
                        'index' => $index,
                    ])
                @endforeach
            @endif
        </div>
    @endpush
@endforeach


<div class="card-body ">

    @include('components.tab-item')

    @include('components.tab-content')

    <button type="button" data-repeat-create='{{ "$uuid" }}' class="btn btn-primary my-2 create">
        <i class="fa fa-plus"></i>
    </button>
</div>


@push('js')
    <script>
        $(function() {
            if (!window.hasRepeatCreateEvent) {
                window.hasRepeatCreateEvent = true; // Prevent multiple bindings

                $(document).ready(function() {

                    components_count = @json($components_count);


                    var locales = Object.keys({!! json_encode(languages()) !!});

                    $('.create').on('click', function(e) {
                        e.preventDefault();


                        var uuid = $(this).attr('data-repeat-create');
                        var index = (($('*[data-row^="' + uuid + '"]').length) / 2) - 1;
                        var repeat = $('*[data-repeat="' + uuid + '"]');


                        for (let i = 0; i < components_count; i++) {

                            for (let j = 0; j < locales.length; j++) {

                                var element = $(repeat[i]);


                                var locale = element.data('locale');
                                var template = element.prop(
                                    'outerHTML'); // Get the element itself + its inner HTML
                                row_index = element.data('row-index');
                                last_row_index = $(repeat[repeat.length - 1]).data('row-index');
                                new_index = last_row_index + 1;

                                var html = template
                                    .replace(new RegExp(`${locales[0]}]`, 'g'),
                                        `${locales[j]}]`) // Replace first locale
                                    .replace(new RegExp(`-${row_index}`, 'g'),
                                        `-${new_index}`) // Replace -index
                                    .replace(new RegExp(`data-row-index="${row_index}"`, 'g'),
                                        `data-row-index="${new_index}"`) // Fix typo in attribute
                                    .replace(new RegExp(`\\[${row_index}\\]`, 'g'),
                                        `[${new_index}]`); // Replace [index]

                                let newElement = $(html)
                                    .hide(); // Create the element and hide it initially


                                $(`*[data-repeat-list="${uuid + '-' + locales[j]}"]`).append(
                                    newElement);
                                newElement.slideDown(); // Animate the appearance

                                if (element.data("type") == 'textarea') {
                                    newElement.find(".note-editor").remove();
                                }

                                newElement.find("input[type='hidden']").val("");
                                newElement.find("input[type='text']").val("");
                                newElement.find(".note-editable").html("");

                            }

                        }

                        $(`.${uuid}-delete-button`).removeClass('d-none');

                        // Summernote
                        $('.textarea').summernote({
                            height: 150,
                            placeholder: 'Start typing your text...',
                            toolbar: [
                                ['style', ['bold', 'italic', 'underline', 'clear']],
                                ['fontsize', ['fontsize']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['insert', ['ltr', 'rtl']],
                                ['insert', ['link', 'picture', 'video', 'hr']],
                                ['view', ['fullscreen', 'codeview']]
                            ]
                        });

                    });


                    $(document).on('click', '[data-delete]', function(e) {

                        e.preventDefault();

                        var row = $(`[data-row="${$(this).data('delete')}"]`);
                        var uuid = row.data('repeat');

                        row.slideUp(function() {
                            row.remove();

                            repeats = $('*[data-repeat="' + uuid + '"]');

                            if ((repeats.length / locales.length) == components_count) {
                                row_index = repeats.first().data('row-index');
                                $(`*[data-row-index="${row_index}"] .${uuid}-delete-button`)
                                    .addClass('d-none');
                            }

                        });

                    });

                });
            }
        })
    </script>
@endpush
