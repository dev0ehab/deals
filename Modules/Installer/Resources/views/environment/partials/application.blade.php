<div class="form-group {{ $errors->has('app_locale') ? ' has-error ' : '' }}">
    <label for="app_locale">
        Language
    </label>
    <select name="app_locale" id="app_locale" class="form-control">
        @include('installer::environment.partials.locale_options', ['selected' => old('app_locale', \Config::get('app.locale')), 'no_custom_locales' => true])
    </select>
    @if ($errors->has('app_locale'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_locale') }}
                        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('app_timezone') ? ' has-error ' : '' }}">
    <label for="app_timezone">
        Timezone
    </label>
    <select name="app_timezone"
            class="form-control selectpicker show-tick"
            data-container="body"
            data-live-search="true"
            data-max-options="1"
            data-size="10"
            id="app_timezone">
        @include('installer::environment.partials.timezone_options', ['current_timezone' => old('app_timezone', \Config::get('app.timezone'))])
    </select>
    @if ($errors->has('app_timezone'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_timezone') }}
                        </span>
    @endif
</div>

{{-- uncomment this line if you want to edit broadcast and pusher inot in env --}}
@include('installer::environment.partials.broadcast_pusher')

<div class="buttons">
    <button class="button" onclick="showStyleSettings();return false">
        {{ trans('installer::installer.environment.wizard.form.buttons.setup_style') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
    </button>
</div>
