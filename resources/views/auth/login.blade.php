@extends('layouts.app')

@section('main')
    <div id="app" class="container h-100">
        <div class="row h-75">
            <main class="col-sm-12 my-auto">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="text-center m-3">
                                <img src="{{ asset('img/logo-black.png') }}">
                            </div>
                            <div class="card p-3 has-shadow">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h2 class="text-success text-center">{{ 'Login' }}</h2>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label for="email" class="col-md-6 col-form-label text-md-left">{{ 'Endereço de e-mail' }}</label>

                                            <div class="col-md">
                                                <input id="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('email') }}" required
                                                       autocomplete="email" autofocus>

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="password"
                                                   class="col-md-6 col-form-label text-md-left">{{ 'Senha' }}</label>

                                            <div class="col-md">
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password" required autocomplete="current-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ 'Manter logado' }}
                                                    </label>
                                                </div>

                                            </div>
                                            <div class="col-md-6 text-right">
                                                @if (Route::has('password.request'))
                                                    <a class="btn btn-link text-orange"
                                                       href="{{ route('password.request') }}">
                                                        {{ 'Esqueci minha senha' }}
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-block font-weight-bold">
                                                {{ 'ENTRAR' }}
                                            </button>
                                        </div>

                                        <div class="form-group">
                                            Não tem um cadastro?
                                            <a href="register" class="text-orange"
                                               title="Não tem um cadastro? Crie o seu">
                                                Crie o seu
                                            </a>
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
