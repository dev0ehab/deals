@include('dashboard::errors')
@bsMultilangualFormTabs
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3'])->label(__('features::sub_features.attributes.name')) }}
    {{ BsForm::textarea('description')->label(__('features::sub_features.attributes.description'))->rows('5')->attribute(['class' => 'form-control textarea']) }}
@endBsMultilangualFormTabs

<input type="hidden" name="parent_id" value="{{ $feature->id }}">

<div class="row">
    <div class="col-12">
        <label>{{ __('features::sub_features.attributes.image') }}</label>
        @if (request()->routeIs('dashboard.sub_features.edit'))
            @isset($sub_feature)
                @include('dashboard::layouts.apps.file', [
                    'file' => $feature->getImage(),
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
