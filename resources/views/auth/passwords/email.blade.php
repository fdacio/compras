@extends('auth.base')
@section('content-form')
    <legend>Recuperar Senha</legend>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form class="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">E-Mail</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                    @if ($errors->has('email'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <small class="text-warning font-weight-bold">Informe seu email registrado no sisetma, para receber um
                    link de recuperação de senha.</small>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <a class="link" href="{{ route('login') }}">
                    Login
                </a>
            </div>
        </div>
    </form>
@endsection
