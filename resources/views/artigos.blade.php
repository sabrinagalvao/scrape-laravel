@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">ID Usuário</th>
                                    <th scope="col">Nome do Veículo</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Ano</th>
                                    <th scope="col">Combustível</th>
                                    <th scope="col">Portas</th>
                                    <th scope="col">Quilometragem</th>
                                    <th scope="col">Câmbio</th>
                                    <th scope="col">Cor</th>
                                    <th scope="col">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($artigos as $artigo)
                                    <tr>
                                        <td>{{$artigo->id}}</td>
                                        <td>{{$artigo->user_id}}</td>
                                        <td>{{$artigo->nome_veiculo}}</td>
                                        <td>{{$artigo->link}}</td>
                                        <td>{{$artigo->ano}}</td>
                                        <td>{{$artigo->combustivel}}</td>
                                        <td>{{$artigo->portas}}</td>
                                        <td>{{$artigo->km}}</td>
                                        <td>{{$artigo->cambio}}</td>
                                        <td>{{$artigo->cor}}</td>
                                        <td>
                                            <form action="{{ route('artigos.destroy', $artigo->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
