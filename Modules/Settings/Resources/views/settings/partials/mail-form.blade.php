@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{ BsForm::select('mail_driver')
                ->options([
                    'smtp' => 'smtp',
                    'sendmail' => 'sendmail',
                    'mailgun' => 'mailgun',
                    'ses' => 'ses',
                    'postmark' => 'postmark',
                    'log' => 'log',
                    'array' => 'array',
                ])
                ->value(Settings::get('mail_driver', env('MAIL_DRIVER'))) }}
{{ BsForm::text('mail_host')->value(Settings::get('mail_host', env('MAIL_HOST'))) }}
{{ BsForm::text('mail_port')->value(Settings::get('mail_port', env('MAIL_PORT'))) }}
{{ BsForm::text('mail_username')->value(Settings::get('mail_username', env('MAIL_USERNAME'))) }}
{{ BsForm::text('mail_password')->value(Settings::get('mail_password', env('MAIL_PASSWORD'))) }}
{{-- {{ BsForm::text('mail_encryption')->value(Settings::get('mail_encryption', 'tls')) }} --}}
{{ BsForm::select('mail_encryption')
                ->options([
                    'tls' => 'tls',
                    'ssl' => 'ssl'
                ])
                ->value(Settings::get('mail_encryption', env('MAIL_ENCRYPTION'))) }}
{{ BsForm::text('mail_from_address')->value(Settings::get('mail_from_address', env('MAIL_FROM_ADDRESS'))) }}
{{ BsForm::text('mail_from_name')->value(Settings::get('mail_from_name', env('MAIL_FROM_NAME'))) }}


