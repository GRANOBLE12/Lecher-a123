@extends('layouts.app')

@section('content')
<h1>Registrar Nueva Vaca</h1>
<form action="{{ route('items.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="id_vaca" class="form-label">ID Vaca *</label>
        <input type="text" class="form-control @error('id_vaca') is-invalid @enderror"
            name="id_vaca" id="id_vaca" value="{{ old('id_vaca') }}" required>
        @error('id_vaca')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="raza" class="form-label">Raza *</label>
        <input type="text" class="form-control" name="raza" id="raza" required>
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required>
    </div>

    <div class="mb-3">
        <label for="peso" class="form-label">Peso (kg) *</label>
        <input type="number" step="0.1" class="form-control" name="peso" id="peso" required>
    </div>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado *</label>
        <select class="form-select" name="estado" id="estado" required>
            <option value="Activa">Activa</option>
            <option value="Inactiva">Inactiva</option>
            <option value="Vendida">Vendida</option>
            <option value="Enferma">Enferma</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="id_madre" class="form-label">ID Madre (opcional)</label>
        <input type="text" class="form-control" name="id_madre" id="id_madre">
    </div>

    <div class="mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea class="form-control" name="observaciones" id="observaciones" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success">Guardar</button>
</form>
@endsection