{{-- app_name --}}
<div class="form-group {{ $errors->has('app_name') ? ' has-error ' : '' }}">
    <label for="app_name" class="">
        {{ trans('installer::installer.environment.wizard.form.app_name_label') }}
    </label>
    <input type="text" name="app_name" id="app_name" class="form-control"
           value="{{ old('app_name', \Config::get('app.name')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.app_name_placeholder') }}"/>
    @if ($errors->has('app_name'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_name') }}
                        </span>
    @endif
</div>
{{-- environment --}}
<div class="form-group {{ $errors->has('environment') ? ' has-error ' : '' }}">
    <label for="environment">
        {{ trans('installer::installer.environment.wizard.form.app_environment_label') }}
    </label>
    <select name="environment" id="environment" class="form-control" onchange='checkEnvironment(this.value);'>
        <option
            value="local" {{ old('environment') === 'local' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_environment_label_local') }}</option>
        <option
            value="development" {{ old('environment') === 'development' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_environment_label_developement') }}</option>
        <option
            value="qa" {{ old('environment') === 'qa' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_environment_label_qa') }}</option>
        <option
            value="production" {{ old('environment') === 'production' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_environment_label_production') }}</option>
        <option
            value="other" {{ old('environment') === 'other' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_environment_label_other') }}</option>
    </select>
    <div id="environment_text_input" style="display: none;">
        <input type="text" name="environment_custom" id="environment_custom"
               placeholder="{{ trans('installer::installer.environment.wizard.form.app_environment_placeholder_other') }}"/>
    </div>
    @if ($errors->has('environment'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('environment') }}
                        </span>
    @endif
</div>
{{-- app_debug --}}
<div class="form-group {{ $errors->has('app_debug') ? ' has-error ' : '' }}">
    <label for="app_debug">
        {{ trans('installer::installer.environment.wizard.form.app_debug_label') }}
    </label>
    @php
        $app_debug = false;
        if (old('app_debug') == 'true' || \Config::get('app.debug')) {
            $app_debug = true;
        }
    @endphp
    <label for="app_debug_true">
        <input type="radio" name="app_debug" id="app_debug_true" value="true"
               @if ($app_debug) checked @endif/>
        {{ trans('installer::installer.environment.wizard.form.app_debug_label_true') }}
    </label>
    <label for="app_debug_false">
        <input type="radio" name="app_debug" id="app_debug_false" value="false"
               @if (!$app_debug) checked @endif/>
        {{ trans('installer::installer.environment.wizard.form.app_debug_label_false') }}
    </label>
    @if ($errors->has('app_debug'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_debug') }}
                        </span>
    @endif
</div>
{{-- app_force_https --}}
<div class="form-group {{ $errors->has('app_force_https') ? ' has-error ' : '' }} mb-2">
    <label for="app_force_https">
        {{ trans('installer::installer.environment.wizard.form.app_force_https') }}
    </label>
    @php
        $force_https = false;
        if (old('app_force_https') == 'true' || \Config::get('app.force_https')) {
            $force_https = true;
        }
    @endphp
    <label for="app_force_https_true">
        <input type="radio" name="app_force_https" id="app_force_https_true" value="true"
               @if ($force_https) checked @endif/>
        {{ trans('installer::installer.environment.wizard.form.app_force_https_true') }}
    </label>
    <label for="app_force_https_false">
        <input type="radio" name="app_force_https" id="app_force_https_false" value="false"
               @if ($force_https) checked @endif/>
        {{ trans('installer::installer.environment.wizard.form.app_force_https_false') }}
    </label>
    @if ($errors->has('app_force_https'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_force_https') }}
                        </span>
    @endif
</div>
{{-- app_log_level --}}
<div class="form-group {{ $errors->has('app_log_level') ? ' has-error ' : '' }}">
    <label for="app_log_level">
        {{ trans('installer::installer.environment.wizard.form.app_log_level_label') }}
    </label>
    <select name="app_log_level" class="form-control" id="app_log_level">
        <option
            value="debug" {{ old('app_log_level') === 'debug' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_debug') }}</option>
        <option
            value="info" {{ old('app_log_level') === 'info' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_info') }}</option>
        <option
            value="notice" {{ old('app_log_level') === 'notice' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_notice') }}</option>
        <option
            value="warning" {{ old('app_log_level') === 'warning' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_warning') }}</option>
        <option
            value="error" {{ old('app_log_level') === 'error' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_error') }}</option>
        <option
            value="critical" {{ old('app_log_level') === 'critical' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_critical') }}</option>
        <option
            value="alert" {{ old('app_log_level') === 'alert' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_alert') }}</option>
        <option
            value="emergency" {{ old('app_log_level') === 'emergency' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.app_log_level_label_emergency') }}</option>
    </select>
    @if ($errors->has('app_log_level'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_log_level') }}
                        </span>
    @endif
</div>
{{-- app_domain --}}
<div class="form-group {{ $errors->has('app_domain') ? ' has-error ' : '' }}">
    <label for="app_domain">
        {{ trans('installer::installer.environment.wizard.form.app_domain_label') }}
    </label>
    <input type="text" name="app_domain" id="app_domain" class="form-control"
           value="{{ old('app_domain', \Config::get('app.domain')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.app_domain_placeholder') }}"/>
    @if ($errors->has('app_domain'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('app_domain') }}
                        </span>
    @endif
</div>
{{-- botton to database --}}
<div class="buttons">
    <button class="button" onclick="showDatabaseSettings();return false">
        {{ trans('installer::installer.environment.wizard.form.buttons.setup_database') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
    </button>
</div>
