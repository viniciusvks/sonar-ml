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
                            <div class="card p-3 shadow">

                                <div class="card-body">
                                    <div class="card-title">
                                        <h2 class="text-success text-center">{{ 'Nova conta' }}</h2>
                                    </div>
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label for="name"
                                                   class="col-md-6 col-form-label text-md-left">{{ 'Nome' }}</label>
                                            <div class="col-md">
                                                <input id="name" type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       name="name" value="{{ old('name') }}" required
                                                       autocomplete="name" autofocus>

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="email"
                                                   class="col-md-6 col-form-label text-md-left">{{ 'Endereço de e-mail' }}</label>

                                            <div class="col-md">
                                                <input id="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('email') }}" required
                                                       autocomplete="email">

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
                                            <label for="role"
                                                   class="col-md-8 col-form-label text-md-left">{{ 'Que tipo de profissional você é?' }}</label>
                                            <div class="col-md">
                                                <select id="role" class="form-control" name="role" required>
                                                    <option value=""></option>
                                                    @foreach($roles as $role => $description)
                                                        <option value={{ $role }}>Sou {{ $description }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md">
                                                <button type="submit"
                                                        class="btn btn-success btn-block font-weight-bold">
                                                    {{ 'CRIAR CONTA' }}
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
