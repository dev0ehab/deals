{{-- database_connection --}}
<div class="form-group {{ $errors->has('database_connection') ? ' has-error ' : '' }}">
    <label for="database_connection">
        {{ trans('installer::installer.environment.wizard.form.db_connection_label') }}
    </label>
    <select name="database_connection" id="database_connection" class="form-control">
        <option
            value="mysql" {{ old('database_connection', env('DB_CONNECTION', 'mysql')) === 'mysql' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.db_connection_label_mysql') }}</option>
        <option
            value="sqlite" {{ old('database_connection', env('DB_CONNECTION')) === 'sqlite' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.db_connection_label_sqlite') }}</option>
        <option
            value="pgsql" {{ old('database_connection', env('DB_CONNECTION')) === 'pgsql' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.db_connection_label_pgsql') }}</option>
        {{--        <option--}}
        {{--            value="sqlsrv" {{ old('database_connection') === 'sqlsrv' ? 'selected' : '' }}>{{ trans('installer::installer.environment.wizard.form.db_connection_label_sqlsrv') }}</option>--}}
    </select>
    @if ($errors->has('database_connection'))
        <span class="error-block">
            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
            {{ $errors->first('database_connection') }}
        </span>
    @endif
</div>
{{-- database_hostname --}}
<div class="form-group {{ $errors->has('database_hostname') ? ' has-error ' : '' }}">
    <label for="database_hostname">
        {{ trans('installer::installer.environment.wizard.form.db_host_label') }}
    </label>
    <input type="text" name="database_hostname" id="database_hostname" class="form-control"
           value="{{ old('database_hostname', env('DB_HOST', '127.0.0.1')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.db_host_placeholder') }}"/>
    @if ($errors->has('database_hostname'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_hostname') }}
                        </span>
    @endif
</div>
{{-- database_port --}}
<div class="form-group {{ $errors->has('database_port') ? ' has-error ' : '' }}">
    <label for="database_port">
        {{ trans('installer::installer.environment.wizard.form.db_port_label') }}
    </label>
    <input type="number" name="database_port" id="database_port"
           value="{{ old('database_port', env('DB_PORT', '3306')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.db_port_placeholder') }}"/>
    @if ($errors->has('database_port'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_port') }}
                        </span>
    @endif
</div>
{{-- database_name --}}
<div class="form-group {{ $errors->has('database_name') ? ' has-error ' : '' }}">
    <label for="database_name">
        {{ trans('installer::installer.environment.wizard.form.db_name_label') }}
    </label>
    <input type="text" name="database_name" id="database_name" class="form-control"
           value="{{ old('database_name', env('DB_DATABASE')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.db_name_placeholder') }}"/>
    @if ($errors->has('database_name'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_name') }}
                        </span>
    @endif
</div>
{{-- database_username --}}
<div class="form-group {{ $errors->has('database_username') ? ' has-error ' : '' }}">
    <label for="database_username">
        {{ trans('installer::installer.environment.wizard.form.db_username_label') }}
    </label>
    <input type="text" name="database_username" id="database_username" class="form-control"
           value="{{ old('database_username', env('DB_USERNAME')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.db_username_placeholder') }}"/>
    @if ($errors->has('database_username'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_username') }}
                        </span>
    @endif
</div>
{{-- database_password --}}
<div class="form-group {{ $errors->has('database_password') ? ' has-error ' : '' }}">
    <label for="database_password">
        {{ trans('installer::installer.environment.wizard.form.db_password_label') }}
    </label>
    <input type="password" name="database_password" id="database_password" class="form-control"
           value="{{ old('database_password', env('DB_PASSWORD')) }}"
           placeholder="{{ trans('installer::installer.environment.wizard.form.db_password_placeholder') }}"/>
    @if ($errors->has('database_password'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('database_password') }}
                        </span>
    @endif
</div>
{{-- botton to application --}}
<div class="buttons">
    <button class="button" onclick="showApplicationSettings();return false">
        {{ trans('installer::installer.environment.wizard.form.buttons.setup_application') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
    </button>
</div>
