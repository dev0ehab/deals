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
    {{ BsForm::text('name')->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
@endBsMultilangualFormTabs

<div class="row">
    <div class="col-12">
        <label>{{ __('sections::sections.attributes.image') }}</label>
        @isset($section)
            @include('dashboard::layouts.apps.file', [
                'file' => $section->getImage(),
                'name' => 'image',
                'mimes' => 'png jpg jpeg',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endisset
    </div>
</div>
