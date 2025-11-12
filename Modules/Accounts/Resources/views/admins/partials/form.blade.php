@include('dashboard::errors')
{{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191','data-parsley-minlength' => '3']) }}
{{ BsForm::email('email')->required()->attribute(['data-parsley-type' => 'email','data-parsley-minlength' => '3']) }}
{{-- {{ BsForm::text('phone')->required()->attribute(['data-parsley-pattern' => '(05)([0-9]{8})']) }} --}}
{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}

<input type="hidden" name="role_id" value="1">

@if(\Module::collections()->has('Roles'))
    <select2 name="role_id"
            label="@lang('roles::roles.singular')"
            remote-url="{{ route('roles.select') }}"
            @isset($admin)
            value="{{ $admin->roles()->orderBy('id','desc')->first()->id ?? old('role_id') }}"
            @endisset
            :required="true"
    ></select2>
@endif

<label>{{ __('accounts::admins.attributes.avatar') }}</label>
@isset($admin)
    @include('dashboard::layouts.apps.file', [
        'file' => $admin->getAvatar(),
        'name' => 'avatar',
        'mimes' => 'png jpg jpeg svg',
    ])
@else
    @include('dashboard::layouts.apps.file', ['name' => 'avatar'])
@endisset

