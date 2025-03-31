@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3><i class="fas fa-weight"></i> Registro de Producción de Leche</h3>
        </div>
        
        <div class="card-body">
            @if(!isset($found))
            <form action="{{ route('produccion.buscar') }}" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-lg" 
                           name="id_vaca" 
                           placeholder="Ingrese el ID de la vaca" 
                           required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar Vaca
                    </button>
                </div>
            </form>
            @endif

            @if(isset($found) && $found)
            <div class="mt-4">
                <h4>Registrar Producción para: {{ $vaca['id_vaca'] }}</h4>
                <form action="{{ route('produccion.agregar', $vacaId) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" name="fecha" 
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="turno">Turno</label>
                            <select class="form-select" name="turno" required>
                                <option value="Mañana">Mañana</option>
                                <option value="Tarde">Tarde</option>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="litros">Litros</label>
                            <input type="number" step="0.1" class="form-control" 
                                   name="litros" required>
                        </div>
                        
                        <div class="col-md-3">
                            <label for="calidad">Calidad</label>
                            <input type="text" class="form-control" name="calidad" required>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Guardar Producción
                        </button>
                        <a href="{{ route('produccion.historial', $vacaId) }}" 
                           class="btn btn-info">
                            <i class="fas fa-history"></i> Ver Historial
                        </a>
                    </div>
                </form>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger mt-3">
                {{ session('error') }}
            </div>
            @endif
            
            @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection