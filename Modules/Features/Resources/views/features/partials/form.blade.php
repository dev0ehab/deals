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
    {{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
    {{ BsForm::textarea('description')->rows('5')->attribute(['class' => 'form-control textarea']) }}
    {{-- {{ BsForm::textarea('brief')->rows('3')->attribute(['class' => 'form-control textarea']) }} --}}
@endBsMultilangualFormTabs



<div class="row">
    <div class="col-12 ">
        <label>{{ __('features::features.attributes.image') }}</label>
        @isset($feature)
            @include('dashboard::layouts.apps.file', [
                'file' => $feature->image,
                'name' => 'image',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endisset
    </div>
</div>
{{--
<div class="row">
    <div class="col-12 ">
        <label>{{ __('features::features.attributes.cover') }}</label>
        @isset($feature)
            @include('dashboard::layouts.apps.file', [
                'file' => $feature->cover,
                'name' => 'cover',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'cover'])
        @endisset
    </div>
</div> --}}
