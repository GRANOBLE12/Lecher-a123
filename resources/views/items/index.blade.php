@extends('layouts.app')

@section('content')
    <h1>Registro de Vacas</h1>
    <a href="{{ route('items.create') }}" class="btn btn-success mb-3">Nuevo Registro</a>
    
    @if ($items && count($items) > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
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
                    <td>{{ $item['estado'] ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('items.show', $id) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('items.edit', $id) }}" class="btn btn-primary btn-sm">Editar</a>
                        <form action="{{ route('items.destroy', $id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este registro?')">Eliminar</button>
                        </form>
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