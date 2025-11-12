@include('dashboard::errors')
@bsMultilangualFormTabs
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3'])->label(__('features::options.attributes.name')) }}
@endBsMultilangualFormTabs

<input type="hidden" name="parent_id" value="{{ isset($option) ? $option?->feature?->id : $feature?->id  }}">

<div class="row">
    <div class="col-12">
        <label>{{ __('features::options.attributes.image') }}</label>
        @if (request()->routeIs('dashboard.options.edit'))
            @isset($option)
                @include('dashboard::layouts.apps.file', [
                    'file' => $option->getImage(),
                    'name' => 'image',
                ])
            @else
                @include('dashboard::layouts.apps.file', ['name' => 'image'])
            @endisset
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endif
    </div>

</div>
