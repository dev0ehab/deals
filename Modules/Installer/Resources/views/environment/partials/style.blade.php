<div class="form-group {{ $errors->has('dashboard_color') ? ' has-error ' : '' }}">
    <label for="dashboard_color">
        Language
    </label>
    <div id="colorpicker-wrapper" class="input-group">
        <input type="text" name="dashboard_color" id="color-picker" class="form-control form-control-color"
               value="{{ old('dashboard_color',"#". env('MIX_DASHBOARD_CHOSEN_COLOR')) }}">
    </div>
    @if ($errors->has('dashboard_color'))
        <span class="error-block">
                            <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ $errors->first('dashboard_color') }}
                        </span>
    @endif
</div>

{{--<div class="buttons">--}}
{{--    <button class="button" onclick="showAdminSettings();return false">--}}
{{--        {{ trans('installer::installer.environment.wizard.form.buttons.setup_admin') }}--}}
{{--        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>--}}
{{--    </button>--}}
{{--</div>--}}

<div class="buttons">
    <button class="button" type="submit">
        {{ trans('installer::installer.environment.wizard.form.buttons.install') }}
        <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
    </button>
</div>
