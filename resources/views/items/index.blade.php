@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Registro de Vacas</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Registro de Vacas</h1>
    <div>
        <a href="{{ route('items.buscar') }}" class="btn btn-warning me-2">
            <i class="fas fa-search"></i> Buscar Vaca
        </a>
        <a href="{{ route('produccion.form') }}" class="btn btn-info me-2">
            <i class="fas fa-weight"></i> Producción Leche
        </a>
        <a href="{{ route('items.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nuevo Registro
        </a>
    </div>
</div>
    
</div>

@if ($items && count($items) > 0)
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Vaca</th>
                <th>Raza</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $id => $item)
            <tr>
                <td>{{ $item['id_vaca'] ?? 'N/A' }}</td>
                <td>{{ $item['raza'] ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ $item['estado'] == 'Enferma' ? 'danger' : ($item['estado'] == 'Activa' ? 'success' : 'warning') }}">
                        {{ $item['estado'] ?? 'N/A' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('items.show', $id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                        <a href="{{ route('items.edit', $id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('items.destroy', $id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Estás seguro de eliminar este registro?')">
                                <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="alert alert-info">
    No hay registros de vacas disponibles.
</div>
@endif
@endsection