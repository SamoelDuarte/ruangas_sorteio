@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Dashboard de Sorteios</h1>

    <div class="row">
        @foreach ($dados as $sorteio)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title">{{ $sorteio['nome'] }}</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Data de Início:</strong> {{ $sorteio['data_inicio'] }}</p>
                        <p><strong>Data de Término:</strong> {{ $sorteio['data_termino'] }}</p>
                        <p><strong>Total de Inscritos:</strong> {{ $sorteio['total_clientes'] }}</p>
                        <p><strong>Total de Participantes:</strong> {{ $sorteio['total_participantes'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
