@include('dashboard::errors')
{{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
{{ BsForm::text('username')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3']) }}
{{ BsForm::text('phone')->required()->attribute(['data-parsley-minlength' => '3']) }}

<div class="row">
    <div class="col-6">
        {{ BsForm::password('password') }}
    </div>
    <div class="col-6">
        {{ BsForm::password('password_confirmation') }}
    </div>
</div>


{{ BsForm::select('company_id')->options($companies)->label(__('companies::companies.singular'))->placeholder(__('Select one'))->attribute(["class" => "form-control selectpicker" , 'data-live-search' => 'true',]) }}



<label>{{ __('vendors::vendorsattributes.avatar') }}</label>
@isset($vendor)
    @include('dashboard::layouts.apps.file', [
        'file' => $vendor->getAvatar(),
        'name' => 'avatar',
        'mimes' => 'png jpg jpeg',
    ])
@else
    @include('dashboard::layouts.apps.file', ['name' => 'avatar'])
@endisset
