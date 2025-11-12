@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-body">
    {{ BsForm::textarea('address')->required()->rows(3)->attribute('class', 'form-control textarea')->value(Settings::get('address'))->attribute(['data-parsley-minlength' => '3'])->label(__('settings::settings.attributes.address')) }}

    {{ BsForm::text('about_us_title')->required()->attribute('class', 'form-control')->value(Settings::get('about_us_title'))->label(__('settings::settings.attributes.about_us_title')) }}

    {{ BsForm::text('about_us_sub_title')->required()->attribute('class', 'form-control')->value(Settings::get('about_us_sub_title'))->label(__('settings::settings.attributes.about_us_sub_title')) }}

    {{ BsForm::textarea('about_us_desc')->required()->rows(3)->attribute('class', 'form-control textarea')->value(Settings::get('about_us_desc'))->attribute(['data-parsley-minlength' => '3'])->label(__('settings::settings.attributes.about_us_desc')) }}

    {{ BsForm::textarea('our_vision')->required()->rows(3)->attribute('class', 'form-control textarea')->value(Settings::get('our_vision'))->attribute(['data-parsley-minlength' => '3'])->label(__('settings::settings.attributes.our_vision')) }}

    {{ BsForm::textarea('our_mission')->required()->rows(3)->attribute('class', 'form-control textarea')->value(Settings::get('our_mission'))->attribute(['data-parsley-minlength' => '3'])->label(__('settings::settings.attributes.our_mission')) }}

    {{ BsForm::textarea('our_tasks')->required()->rows(3)->attribute('class', 'form-control textarea')->value(Settings::get('our_tasks'))->attribute(['data-parsley-minlength' => '3'])->label(__('settings::settings.attributes.our_tasks')) }}
</div>
