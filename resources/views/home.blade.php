@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <form method="post" action="capturar">
                        @csrf
                            {{ __('Digite sua busca:') }}
                            <input type="text" id="busca" name="busca">
                            <button type="submit" class="btn btn-primary">Capturar</button>
                        </form>

                        <a href="{{route('artigos.index')}}">
                            <button type="button" name="btnlistar" class="btn btn-primary">Listar todos os artigos</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
