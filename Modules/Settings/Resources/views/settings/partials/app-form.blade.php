@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- {{ BsForm::text('android_app_id')->value(Settings::get('android_app_id')) }}
{{ BsForm::text('ios_app_id')->value(Settings::get('ios_app_id')) }} --}}
{{ BsForm::text('android_version')->value(Settings::get('android_version')) }}
{{ BsForm::text('ios_version')->value(Settings::get('ios_version')) }}
{{-- {{ BsForm::number('delivery_fee')->min(1)->value(Settings::get('delivery_fee')) }} --}}
{{-- {{ BsForm::number('radius')->min(1)->value(Settings::get('radius')) }} --}}
{{-- {{ BsForm::checkbox('android_force_update')->value(1)->checked(Settings::get('android_force_update') ?? old('android_force_update')) }}
{{ BsForm::checkbox('ios_force_update')->value(1)->checked(Settings::get('ios_force_update') ?? old('ios_force_update')) }} --}}
