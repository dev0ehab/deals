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
                                <h5 class="text-white font-size-20">@lang('Forgot Password')</h5>
                                {{-- <p class="text-white-50 mb-0">@lang('admin.auth.login.info').</p> --}}
                                <a href="{{ route('home') }}" class="logo logo-dark mt-4">
                                    <img src="{{ app_login_logo() }}" alt="" height="100">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="username">@lang('admin.auth.login.email')</label>
                                        <input id="email"
                                               type="email"
                                               class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               name="email"
                                               required
                                               autocomplete="email"
                                               placeholder="@lang('admin.auth.login.email')"
                                               autofocus>
                                        @if($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block " type="submit">
                                            @lang('Send')
                                        </button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="{{ route('login') }}" class="text-muted"><i class="mdi mdi-lock mr-1"></i> {{ __('Back to login') }}</a>
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
