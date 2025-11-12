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
    {{-- {{ BsForm::textarea('description')->rows('3') }} --}}
@endBsMultilangualFormTabs

{{ BsForm::text('url')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3' ,"data-parsley-type"=>"url"]) }}

<div class="row">
    <div class="col-12">
        <label>{{ __('advertisements::advertisements.attributes.image') }}</label>
        @isset($advertisement)
            @include('dashboard::layouts.apps.file', [
                'file' => $advertisement->getImage(),
                'name' => 'image',
                'mimes' => 'png jpg jpeg',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'image'])
        @endisset
    </div>
</div>


<div class="row">
    @include('dashboard::layouts.apps.switch', [
        'name' => 'active',
        'label' => __('advertisements::advertisements.attributes.active'),
        'item' => $advertisement ?? '',
        'checked' => old('active', $advertisement->active ?? 0),
    ])
</div>
