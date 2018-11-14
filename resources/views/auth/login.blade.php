@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="cell flex-align-self-center">
                <div class="card w-50">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-content p-2">
                        <form method="POST" action="{{ route('login') }}" class="custom-validation">
                            @csrf

                            <div class="row mb-3">
                                <div class="cell-md-12">
                                    <label for="username">{{ __('Username') }}</label>
                                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="cell-md-12">
                                    <label for="password">{{ __('Password') }}</label>
                                    <input id="password" type="password" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="cell-md-6">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                    data-role="checkbox"
                                           data-caption="{{ __('Remember Me') }}"
                                           data-style="2">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="cell-md-12">
                                    <button type="submit" class="button btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    <a class="button" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
