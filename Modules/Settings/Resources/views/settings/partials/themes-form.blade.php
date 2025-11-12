@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(is_array(trans('settings::settings.dashboard_templates')) && ! empty(trans('settings::settings.dashboard_templates')))
    {{ BsForm::select('dashboard_template')
            ->options(trans('settings::settings.dashboard_templates'))
            ->value(Settings::get('dashboard_template', config('layouts.dashboard'))) }}
@endif
