<div class="block">
    <input type="radio" name="appSettingsTabs" id="appSettingsTab1" value="null" checked/>
    <label for="appSettingsTab1">
                                        <span>
                                            {{ trans('installer::installer.environment.wizard.form.app_tabs.broadcasting_title') }}
                                        </span>
    </label>


    <div class="info">
        <div class="form-group {{ $errors->has('broadcast_driver') ? ' has-error ' : '' }}">
            <label
                for="broadcast_driver">{{ trans('installer::installer.environment.wizard.form.app_tabs.broadcasting_label') }}
                <sup>
                    <a href="https://laravel.com/docs/5.4/broadcasting" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="broadcast_driver" id="broadcast_driver" value="log"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.broadcasting_placeholder') }}"/>
            @if ($errors->has('broadcast_driver'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('broadcast_driver') }}
                                                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('cache_driver') ? ' has-error ' : '' }}">
            <label
                for="cache_driver">{{ trans('installer::installer.environment.wizard.form.app_tabs.cache_label') }}
                <sup>
                    <a href="https://laravel.com/docs/5.4/cache" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="cache_driver" id="cache_driver" value="file"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.cache_placeholder') }}"/>
            @if ($errors->has('cache_driver'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('cache_driver') }}
                                                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('session_driver') ? ' has-error ' : '' }}">
            <label
                for="session_driver">{{ trans('installer::installer.environment.wizard.form.app_tabs.session_label') }}
                <sup>
                    <a href="https://laravel.com/docs/5.4/session" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="session_driver" id="session_driver" value="file"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.session_placeholder') }}"/>
            @if ($errors->has('session_driver'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('session_driver') }}
                                                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('queue_connection') ? ' has-error ' : '' }}">
            <label
                for="queue_connection">{{ trans('installer::installer.environment.wizard.form.app_tabs.queue_label') }}
                <sup>
                    <a href="https://laravel.com/docs/5.4/queues" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="queue_connection" id="queue_connection" value="sync"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.queue_placeholder') }}"/>
            @if ($errors->has('queue_connection'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('queue_connection') }}
                                                </span>
            @endif
        </div>
    </div>
</div>
<div class="block">
    <input type="radio" name="appSettingsTabs" id="appSettingsTab2" value="null"/>
    <label for="appSettingsTab2">
                                        <span>
                                            {{ trans('installer::installer.environment.wizard.form.app_tabs.redis_label') }}
                                        </span>
    </label>
    <div class="info">
        <div class="form-group {{ $errors->has('redis_hostname') ? ' has-error ' : '' }}">
            <label for="redis_hostname">
                {{ trans('installer::installer.environment.wizard.form.app_tabs.redis_host') }}
                <sup>
                    <a href="https://laravel.com/docs/5.4/redis" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="redis_hostname" id="redis_hostname" value="127.0.0.1"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.redis_host') }}"/>
            @if ($errors->has('redis_hostname'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('redis_hostname') }}
                                                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('redis_password') ? ' has-error ' : '' }}">
            <label
                for="redis_password">{{ trans('installer::installer.environment.wizard.form.app_tabs.redis_password') }}</label>
            <input type="password" name="redis_password" id="redis_password" value="null"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.redis_password') }}"/>
            @if ($errors->has('redis_password'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('redis_password') }}
                                                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('redis_port') ? ' has-error ' : '' }}">
            <label
                for="redis_port">{{ trans('installer::installer.environment.wizard.form.app_tabs.redis_port') }}</label>
            <input type="number" name="redis_port" id="redis_port" value="6379"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.redis_port') }}"/>
            @if ($errors->has('redis_port'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('redis_port') }}
                                                </span>
            @endif
        </div>
    </div>
</div>
<div class="block">
    <input type="radio" name="appSettingsTabs" id="appSettingsTab3" value="null"/>
    <label for="appSettingsTab3">
                                        <span>
                                            {{ trans('installer::installer.environment.wizard.form.app_tabs.mail_label') }}
                                        </span>
    </label>
    <div class="info">
        <div class="form-group {{ $errors->has('mail_driver') ? ' has-error ' : '' }}">
            <label for="mail_driver">
                {{ trans('installer::installer.environment.wizard.form.app_tabs.mail_driver_label') }}
                <sup>
                    <a href="https://laravel.com/docs/5.4/mail" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="mail_driver" id="mail_driver" value="smtp"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_driver_placeholder') }}"/>
            @if ($errors->has('mail_driver'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('mail_driver') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mail_host') ? ' has-error ' : '' }}">
            <label
                for="mail_host">{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_host_label') }}</label>
            <input type="text" name="mail_host" id="mail_host" value="smtp.mailtrap.io"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_host_placeholder') }}"/>
            @if ($errors->has('mail_host'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('mail_host') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mail_port') ? ' has-error ' : '' }}">
            <label
                for="mail_port">{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_port_label') }}</label>
            <input type="number" name="mail_port" id="mail_port" value="2525"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_port_placeholder') }}"/>
            @if ($errors->has('mail_port'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('mail_port') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mail_username') ? ' has-error ' : '' }}">
            <label
                for="mail_username">{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_username_label') }}</label>
            <input type="text" name="mail_username" id="mail_username" value="null"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_username_placeholder') }}"/>
            @if ($errors->has('mail_username'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('mail_username') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mail_password') ? ' has-error ' : '' }}">
            <label
                for="mail_password">{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_password_label') }}</label>
            <input type="text" name="mail_password" id="mail_password" value="null"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_password_placeholder') }}"/>
            @if ($errors->has('mail_password'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('mail_password') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('mail_encryption') ? ' has-error ' : '' }}">
            <label
                for="mail_encryption">{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_encryption_label') }}</label>
            <input type="text" name="mail_encryption" id="mail_encryption" value="null"
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.mail_encryption_placeholder') }}"/>
            @if ($errors->has('mail_encryption'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('mail_encryption') }}
                                                </span>
            @endif
        </div>
    </div>
</div>
<div class="block margin-bottom-2">
    <input type="radio" name="appSettingsTabs" id="appSettingsTab4" value="null"/>
    <label for="appSettingsTab4">
                                        <span>
                                            {{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_label') }}
                                        </span>
    </label>
    <div class="info">
        <div class="form-group {{ $errors->has('pusher_app_id') ? ' has-error ' : '' }}">
            <label for="pusher_app_id">
                {{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_app_id_label') }}
                <sup>
                    <a href="https://pusher.com/docs/server_api_guide" target="_blank"
                       title="{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}">
                        <i class="fa fa-info-circle fa-fw" aria-hidden="true"></i>
                        <span
                            class="sr-only">{{ trans('installer::installer.environment.wizard.form.app_tabs.more_info') }}</span>
                    </a>
                </sup>
            </label>
            <input type="text" name="pusher_app_id" id="pusher_app_id" value=""
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_app_id_palceholder') }}"/>
            @if ($errors->has('pusher_app_id'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('pusher_app_id') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('pusher_app_key') ? ' has-error ' : '' }}">
            <label
                for="pusher_app_key">{{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_app_key_label') }}</label>
            <input type="text" name="pusher_app_key" id="pusher_app_key" value=""
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_app_key_palceholder') }}"/>
            @if ($errors->has('pusher_app_key'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('pusher_app_key') }}
                                                </span>
            @endif
        </div>
        <div class="form-group {{ $errors->has('pusher_app_secret') ? ' has-error ' : '' }}">
            <label
                for="pusher_app_secret">{{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_app_secret_label') }}</label>
            <input type="password" name="pusher_app_secret" id="pusher_app_secret" value=""
                   placeholder="{{ trans('installer::installer.environment.wizard.form.app_tabs.pusher_app_secret_palceholder') }}"/>
            @if ($errors->has('pusher_app_secret'))
                <span class="error-block">
                                                    <i class="fa fa-fw fa-exclamation-triangle" aria-hidden="true"></i>
                                                    {{ $errors->first('pusher_app_secret') }}
                                                </span>
            @endif
        </div>
    </div>
</div>
