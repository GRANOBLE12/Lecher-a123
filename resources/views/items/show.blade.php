@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Detalles de la Vaca: {{ $item['id_vaca'] ?? 'N/A' }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Raza:</strong> {{ $item['raza'] ?? 'N/A' }}</p>
                    <p><strong>Fecha Nacimiento:</strong> {{ isset($item['fecha_nacimiento']) ? \Carbon\Carbon::parse($item['fecha_nacimiento'])->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Peso:</strong> {{ $item['peso'] ?? 'N/A' }} kg</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Estado:</strong> {{ $item['estado'] ?? 'N/A' }}</p>
                    <p><strong>ID Madre:</strong> {{ $item['id_madre'] ?? 'No registrada' }}</p>
                    <p><strong>Observaciones:</strong> {{ $item['observaciones'] ?? 'Ninguna' }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@endsection