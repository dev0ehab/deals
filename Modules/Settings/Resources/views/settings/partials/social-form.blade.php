@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{ BsForm::text('facebook')
        ->value(Settings::get('facebook'))
        ->attribute('pattern','https://.*')
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->placeholder("https://facebook.com")
        ->note(trans('settings::settings.notes.social_facebook'))
        }}
{{-- {{ BsForm::text('twitter')
        ->value(Settings::get('twitter'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://twitter.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_twitter'))
        }} --}}
{{ BsForm::text('instagram')
        ->value(Settings::get('instagram'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://instagram.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_instagram'))
        }}


{{ BsForm::text('x')
        ->value(Settings::get('x'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://x.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_twitter'))
        }}

{{ BsForm::text('telegram')
        ->value(Settings::get('telegram'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://telegram.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_telegram'))
        }}

{{-- {{ BsForm::text('youtube')
        ->value(Settings::get('youtube'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://youtube.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_youtube'))
        }} --}}
{{-- {{ BsForm::text('linkedin')
        ->value(Settings::get('linkedin'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://linkedin.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_linkedin'))
        }} --}}
{{ BsForm::text('snapchat')
        ->value(Settings::get('snapchat'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://snapchat.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_snapchat'))
        }}

{{-- {{ BsForm::text('tiktok')
        ->value(Settings::get('tiktok'))
        ->attribute('pattern','https://.*')
        ->placeholder("https://tiktok.com")
        ->attribute(['data-parsley-type' => 'url','data-parsley-minlength' => '3'])
        ->note(trans('settings::settings.notes.social_tiktok'))
        }} --}}
