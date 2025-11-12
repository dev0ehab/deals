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
@endBsMultilangualFormTabs


{{-- {{ BsForm::checkbox('is_active')->value(1)->withDefault()->checked(isset($category) ? $category->is_active : false) }} --}}

<div class="row">
    <div class="col-12">
        <label>{{ __('attributes::categories.attributes.icon') }}</label>
        @isset($category)
            @include('dashboard::layouts.apps.file', [
                'file' => $category->icon,
                'name' => 'icon',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'icon'])
        @endisset
    </div>
</div>
