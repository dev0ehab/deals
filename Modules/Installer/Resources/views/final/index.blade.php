@extends('installer::layouts.app')

@section('template_title')
    {{ trans('installer::installer.final.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer::installer.final.title') }}
@endsection

@section('container')

    {{--    <h4>Admin Credentials</h4>--}}
    {{--    @php--}}
    {{--        $admin = \Modules\Accounts\Entities\Admin::where('email','!=', 'root@demo.com')->orderBy('id', 'desc')->first();--}}
    {{--        if ($admin) {--}}
    {{--            $admin_email = $admin->email;--}}
    {{--        }--}}
    {{--    @endphp--}}
    {{--    <p>--}}
    {{--        <strong>@lang('accounts::admins.attributes.email'):</strong> <span--}}
    {{--            style="color: #93a1af;">{{ $admin_email }}</span><br/>--}}
    {{--        <strong>@lang('accounts::admins.attributes.password'):</strong> <span style="color: #93a1af;">your chosen password</span>--}}
    {{--    </p>--}}

    {{--    <div class="buttons">--}}
    {{--        <a href="{{ route('login') }}" class="button">@lang('admin.auth.login.title')</a>--}}
    {{--    </div>--}}

    @if ($dbMessage && !empty($dbMessage['dbOutputLog']))
        <p><strong><small>{{ trans('installer::installer.final.migration') }}</small></strong></p>
        <pre><code>{{ $dbMessage['dbOutputLog'] }}</code></pre>
    @endif

    <p><strong><small>{{ trans('installer::installer.final.console') }}</small></strong></p>
    <pre><code>{{ $finalMessages }}</code></pre>

    <p><strong><small>{{ trans('installer::installer.final.log') }}</small></strong></p>
    <pre><code>{{ $finalStatusMessage }}</code></pre>

    <p><strong><small>{{ trans('installer::installer.final.env') }}</small></strong></p>
    <pre><code>{{ $finalEnvFile }}</code></pre>

    <div class="buttons">
        <a href="{{ url('/') }}" class="button">{{ trans('installer::installer.final.exit') }}</a>
    </div>

@endsection


