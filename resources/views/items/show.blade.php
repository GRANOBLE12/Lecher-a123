@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">
                        <i class="fas fa-cow"></i> Detalles de la Vaca: {{ $item['id_vaca'] ?? 'N/A' }}
                    </h3>
                    <span class="badge bg-{{ $item['estado'] == 'Enferma' ? 'danger' : ($item['estado'] == 'Activa' ? 'success' : 'warning') }}">
                        {{ $item['estado'] ?? 'N/A' }}
                    </span>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <!-- Columna izquierda -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-info-circle"></i> Información Básica</h5>
                            <div class="ps-3">
                                <p><strong><i class="fas fa-paw"></i> Raza:</strong> {{ $item['raza'] ?? 'N/A' }}</p>
                                <p><strong><i class="fas fa-calendar-alt"></i> Fecha Nacimiento:</strong> 
                                    {{ isset($item['fecha_nacimiento']) ? \Carbon\Carbon::parse($item['fecha_nacimiento'])->format('d/m/Y') : 'N/A' }}
                                    ({{ isset($item['fecha_nacimiento']) ? \Carbon\Carbon::parse($item['fecha_nacimiento'])->age . ' años' : '' }})
                                </p>
                                <p><strong><i class="fas fa-weight-hanging"></i> Peso:</strong> 
                                    {{ $item['peso'] ?? 'N/A' }} kg
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Columna derecha -->
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2"><i class="fas fa-clipboard-list"></i> Información Adicional</h5>
                            <div class="ps-3">
                                <p><strong><i class="fas fa-cow"></i> ID Madre:</strong> 
                                    {{ $item['id_madre'] ?? 'No registrada' }}
                                </p>
                                @if($item['estado'] == 'Enferma')
                                    <p class="text-danger"><strong><i class="fas fa-bug"></i> Enfermedad:</strong> 
                                        {{ $item['enfermedad'] ?? 'No especificada' }}
                                    </p>
                                    <p><strong><i class="fas fa-notes-medical"></i> Síntomas:</strong> 
                                        {{ $item['sintomas'] ?? 'No especificados' }}
                                    </p>
                                @endif
                                <p><strong><i class="fas fa-comment"></i> Observaciones:</strong> 
                                    {{ $item['observaciones'] ?? 'Ninguna' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            
            <div class="card-footer bg-light">
    <div class="d-flex justify-content-between">
        <a href="{{ route('items.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        <div>
            <!-- Botón Editar -->
            <a href="{{ route('items.edit', $id) }}" class="btn btn-primary me-2">
                <i class="fas fa-edit"></i> Editar
            </a>
            
            <!-- Nuevo botón Producción -->
            <a href="{{ route('produccion.historial', $id) }}" class="btn btn-info me-2">
                <i class="fas fa-chart-line"></i> Producción
            </a>
            
            <!-- Botón Eliminar -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
    </div>
</div>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas eliminar el registro de la vaca {{ $item['id_vaca'] }}?
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i> Esta acción no se puede deshacer.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('items.destroy', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Confirmar Eliminación
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .card-header {
            border-radius: 0.375rem 0.375rem 0 0 !important;
        }
        strong {
            color: #495057;
            min-width: 120px;
            display: inline-block;
        }
        .badge {
            font-size: 1rem;
            padding: 0.5em 0.75em;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        // Inicializar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    @endpush
@endsection