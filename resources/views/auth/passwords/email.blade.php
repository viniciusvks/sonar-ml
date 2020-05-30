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
                                        <h2 class="text-success text-center">{{ 'Redefinir Senha' }}</h2>
                                    </div>

                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label for="email"
                                                   class="col-md-6 col-form-label text-md-left">{{ 'Endereço de E-Mail' }}</label>

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
                                            <div class="col-md">
                                                <button type="submit"
                                                        class="btn btn-success btn-block font-weight-bold">
                                                    {{ 'Enviar link de redefinição de senha' }}
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
