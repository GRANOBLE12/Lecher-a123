@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3>
                <i class="fas fa-chart-line"></i>
                Historial de Producción: {{ $vaca['id_vaca'] }}
                <a href="{{ route('produccion.form') }}" class="btn btn-light float-end">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </h3>
        </div>

        <div class="card-body">
            @if(count($produccion) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Turno</th>
                            <th>Litros</th>
                            <th>Calidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produccion as $registro)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($registro['fecha'])->format('d/m/Y') }}</td>
                            <td>{{ $registro['turno'] }}</td>
                            <td>{{ $registro['litros'] }} L</td> <!-- Cambiado de 'cantidad' a 'litros' -->
                            <td>{{ $registro['calidad'] ?? '--' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-info">
                No hay registros de producción para esta vaca
            </div>
            @endif
        </div>
    </div>
</div>
@endsection