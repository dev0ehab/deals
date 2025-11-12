@include('dashboard::errors')
{{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191','data-parsley-minlength' => '3']) }}
{{ BsForm::email('email')->required()->attribute(['data-parsley-type' => 'email','data-parsley-minlength' => '3']) }}

{{ BsForm::password('password') }}
{{ BsForm::password('password_confirmation') }}



<div class="row">
    <div class="col-12">
        <label>{{ __('accounts::admins.attributes.avatar') }}</label>
        @isset($admin)
            @include('dashboard::layouts.apps.file', [
                'file' => $admin->getAvatar(),
                'name' => 'avatars',
                'mimes' => 'png jpg jpeg',
            ])
        @else
            @include('dashboard::layouts.apps.file', ['name' => 'avatars'])
        @endisset
    </div>
</div>
