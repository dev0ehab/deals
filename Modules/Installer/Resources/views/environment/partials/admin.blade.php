<div class="form-group {{ $errors->has('admin_name') ? ' has-error ' : '' }}">
    <label for="admin_name">
        {{ trans('installer::installer.environment.wizard.form.admin_name') }}
    </label>
    <input type="text"
           name="admin_name"
           id="admin_name"
           placeholder="{{ trans('installer::installer.environment.wizard.form.admin_name') }}"
           value="{{ old('admin_name') }}"/>
    @if ($errors->has('admin_name'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('admin_name') }}
                        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('admin_email') ? ' has-error ' : '' }}">
    <label for="admin_email">
        {{ trans('installer::installer.environment.wizard.form.admin_email') }}
    </label>
    <input type="text"
           name="admin_email"
           id="admin_email"
           placeholder="{{ trans('installer::installer.environment.wizard.form.admin_email') }}"
           value="{{ old('admin_email') }}"/>
    @if ($errors->has('admin_email'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('admin_email') }}
                        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('admin_phone') ? ' has-error ' : '' }}">
    <label for="admin_phone">
        {{ trans('installer::installer.environment.wizard.form.admin_phone') }}
    </label>
    <input type="text"
           name="admin_phone"
           id="admin_phone"
           placeholder="{{ trans('installer::installer.environment.wizard.form.admin_phone') }}"
           value="{{ old('admin_phone') }}"/>
    @if ($errors->has('admin_phone'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('admin_phone') }}
                        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('admin_password') ? ' has-error ' : '' }}">
    <label for="admin_password">
        {{ trans('installer::installer.environment.wizard.form.admin_password') }}
    </label>
    <input type="password"
           name="admin_password"
           id="admin_password"
           placeholder="{{ trans('installer::installer.environment.wizard.form.admin_password') }}"
           value="{{ old('admin_password') }}"/>
    @if ($errors->has('admin_password'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('admin_password') }}
                        </span>
    @endif
</div>

<div class="buttons">
    <button class="button" type="submit">
        {{ trans('installer::installer.environment.wizard.form.buttons.install') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
    </button>
</div>
