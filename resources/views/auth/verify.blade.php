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
                            <div class="card p-3 shadow">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-success text-left">{{ 'Verifique seu e-mail' }}</h3>
                                    </div>
                                    @if (session('resent'))
                                        <div class="alert alert-success" role="alert">
                                            {{ 'Um link de verificação foi enviado ao seu endereço de e-mail.' }}
                                        </div>
                                    @endif

                                    {{
                                    'Antes de prosseguir, confirme seu cadastro através do link de verificação enviado ao seu endereço de e-mail.
                                     Se você não recebeu seu e-mail de verificação '
                                    }},
                                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                        @csrf
                                        <button type="submit"
                                                class="btn btn-link p-0 m-0 align-baseline">{{ 'clique aqui para reenviar' }}</button>
                                        .
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
