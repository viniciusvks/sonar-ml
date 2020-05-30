@extends('layouts.app')

@section('main')
    <div id="app" class="container h-100">
        <div class="row h-75">
            <main class="col-sm-12 my-auto">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="text-center m-3">
                                <img src="{{ asset('img/logo-black.png') }}">
                            </div>
                            <div class="card p-3 has-shadow">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h2 class="text-success text-center">{{ 'Redefinição de senha' }}</h2>
                                    </div>
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group">
                                            <label for="email" class="col-md-6 col-form-label text-md-left">{{ 'Endereço de e-Mail' }}</label>
                                            <div class="col-md">
                                                <input id="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{ $email ?? old('email') }}" required
                                                       autocomplete="email" autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password" class="col-md-6 col-form-label text-md-left">{{ 'Senha' }}</label>
                                            <div class="col-md">
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password" required autocomplete="new-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password-confirm"
                                                   class="col-md-6 col-form-label text-md-left">{{ 'Confirmar Senha' }}</label>
                                            <div class="col-md">
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation" required
                                                       autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md">
                                                <button type="submit"
                                                        class="btn btn-success btn-block font-weight-bold">
                                                    {{ 'Redefinir Senha' }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
