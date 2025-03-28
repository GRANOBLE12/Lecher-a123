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
        <input type="text" class="form-control @error('raza') is-invalid @enderror" 
            name="raza" id="raza" value="{{ old('raza') }}" required>
        @error('raza')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
            name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
        @error('fecha_nacimiento')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="peso" class="form-label">Peso (kg) *</label>
        <input type="number" step="0.1" class="form-control @error('peso') is-invalid @enderror" 
            name="peso" id="peso" value="{{ old('peso') }}" required>
        @error('peso')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado *</label>
        <select class="form-select @error('estado') is-invalid @enderror" 
            name="estado" id="estado" required onchange="toggleEnfermedadFields()">
            <option value="Activa" {{ old('estado') == 'Activa' ? 'selected' : '' }}>Activa</option>
            <option value="Inactiva" {{ old('estado') == 'Inactiva' ? 'selected' : '' }}>Inactiva</option>
            <option value="Vendida" {{ old('estado') == 'Vendida' ? 'selected' : '' }}>Vendida</option>
            <option value="Enferma" {{ old('estado') == 'Enferma' ? 'selected' : '' }}>Enferma</option>
        </select>
        @error('estado')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Campos condicionales para estado Enferma -->
    <div id="enfermedadFields" style="display: none;">
        <div class="mb-3">
            <label for="enfermedad" class="form-label">Enfermedad</label>
            <input type="text" class="form-control @error('enfermedad') is-invalid @enderror" 
                name="enfermedad" id="enfermedad" value="{{ old('enfermedad') }}">
            @error('enfermedad')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sintomas" class="form-label">Síntomas *</label>
            <textarea class="form-control @error('sintomas') is-invalid @enderror" 
                name="sintomas" id="sintomas" rows="3">{{ old('sintomas') }}</textarea>
            @error('sintomas')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label for="id_madre" class="form-label">ID Madre (opcional)</label>
        <input type="text" class="form-control @error('id_madre') is-invalid @enderror" 
            name="id_madre" id="id_madre" value="{{ old('id_madre') }}">
        @error('id_madre')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
            name="observaciones" id="observaciones" rows="3">{{ old('observaciones') }}</textarea>
        @error('observaciones')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-success">
        <span class="button-text">Guardar</span>
        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
    </button>
</form>

<script>
    function toggleEnfermedadFields() {
        const estado = document.getElementById('estado').value;
        const enfermedadFields = document.getElementById('enfermedadFields');
        const sintomasInput = document.getElementById('sintomas');

        if (estado === 'Enferma') {
            enfermedadFields.style.display = 'block';
            sintomasInput.setAttribute('required', 'required');
        } else {
            enfermedadFields.style.display = 'none';
            sintomasInput.removeAttribute('required');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar campos si hay error de validación
        if (document.getElementById('estado').value === 'Enferma') {
            document.getElementById('enfermedadFields').style.display = 'block';
        }
        
        toggleEnfermedadFields();
        
        // Evitar doble envío del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.querySelector('.button-text').classList.add('d-none');
            btn.querySelector('.spinner-border').classList.remove('d-none');
        });
    });
</script>

<style>
    .d-none { display: none; }
</style>
@endsection