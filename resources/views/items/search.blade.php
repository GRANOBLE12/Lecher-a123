@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><i class="fas fa-search"></i> Buscar Vaca</h3>
                </div>
                
                <div class="card-body">
                    <form action="{{ route('items.search') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg" 
                                   name="id_vaca" 
                                   placeholder="Ingrese el ID de la vaca" 
                                   value="{{ $id_vaca ?? old('id_vaca') }}" 
                                   required>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </form>

                    @if($searchPerformed ?? false)
                        @if($notFound ?? false)
                            <div class="alert alert-warning mt-4">
                                <i class="fas fa-exclamation-triangle"></i> No se encontró la vaca con ID: {{ $id_vaca }}
                            </div>
                        @else
                            <div class="mt-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h4 class="mb-0">Resultado de la búsqueda</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>ID Vaca:</strong> {{ $item['id_vaca'] ?? 'N/A' }}</p>
                                                <p><strong>Raza:</strong> {{ $item['raza'] ?? 'N/A' }}</p>
                                                <p><strong>Estado:</strong> 
                                                    <span class="badge bg-{{ $item['estado'] == 'Enferma' ? 'danger' : ($item['estado'] == 'Activa' ? 'success' : 'warning') }}">
                                                        {{ $item['estado'] ?? 'N/A' }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Fecha Nacimiento:</strong> 
                                                    @isset($item['fecha_nacimiento'])
                                                        {{ \Carbon\Carbon::parse($item['fecha_nacimiento'])->format('d/m/Y') }}
                                                    @else
                                                        N/A
                                                    @endisset
                                                </p>
                                                <p><strong>Peso:</strong> {{ $item['peso'] ?? 'N/A' }} kg</p>
                                            </div>
                                        </div>
                                        
                                        @if($item['estado'] == 'Enferma')
                                        <div class="alert alert-danger mt-3">
                                            <p><strong>Enfermedad:</strong> {{ $item['enfermedad'] ?? 'No especificada' }}</p>
                                            <p><strong>Síntomas:</strong> {{ $item['sintomas'] ?? 'No especificados' }}</p>
                                        </div>
                                        @endif
                                        
                                        <div class="mt-3">
                                            <a href="{{ route('items.show', $id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> Ver detalles completos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                
                <div class="card-footer">
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection