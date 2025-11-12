@include('dashboard::errors')
{{ BsForm::text('name')->required()->attribute(['data-parsley-maxlength' => '191', 'data-parsley-minlength' => '3'])->label(trans('accounts::user.attributes.name')) }}
{{ BsForm::email('email')->required()->attribute(['data-parsley-type' => 'email', 'data-parsley-minlength' => '3'])->label(trans('accounts::user.attributes.email')) }}
{{ BsForm::text('phone')->required()->attribute(['data-parsley-type' => 'number', 'data-parsley-minlength' => '3'])->label(trans('accounts::user.attributes.phone')) }}

