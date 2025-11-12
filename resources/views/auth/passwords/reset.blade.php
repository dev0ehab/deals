@extends('dashboard::layouts.default-without-nav')

@section('title') @lang('admin.auth.login.title') @endsection

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('home') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="bg-login text-center" style="background-color: {{ env('DASHBOARD_CHOSEN_COLOR') }};">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">@lang('Reset Password')</h5>
                                {{-- <p class="text-white-50 mb-0">@lang('admin.auth.login.info').</p> --}}
                                <a href="{{ route('home') }}" class="logo logo-dark mt-4">
                                    <img src="{{ app_login_logo() }}" alt="" height="100">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ $email }}">

                                    <div class="form-group">
                                        <label for="password" style="float: right">{{ __('Password') }}</label>

                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password-confirm" style="float: right">{{ __('Confirm Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block " type="submit">
                                            @lang('Save')
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
