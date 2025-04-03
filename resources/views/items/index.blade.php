@extends('layouts.app')

@section('content')



<link rel="stylesheet" href="{{ asset('css/index.css') }}">

<body>

    <div class="barra">

        <div class="menu-container">

            <button class="menu-btn">
                <span>☰</span> Menú
            </button>

            <div class="menu-dropdown">
                <a href="{{ route('produccion.form') }}" class="menu-item">Producción de Leche</a>
                <a href="{{ route('items.create') }}" class="menu-item">Nuevo Registro</a>
                <a href="{{ route('items.buscar') }}" class="menu-item">Buscar Vaca</a>
                
            </div>
        </div>

        <h1 id="titulo_1">
            <a href="{{ url('/') }}" class="titulo-link">AgroIA LacteaPro</a>
        </h1>


    </div>


    <div class="contenedor">
        <div class="cuadro">
            <img src="{{ asset('Images/fondo.jpg') }}" alt="Imagen de fondo">
        </div>

        <div class="cuadro-texto">
            <h2>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Laborum ipsa excepturi quam.</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime beatae et nostrum officia laboriosam architecto pariatur consectetur voluptate eius maiores molestiae...</p>
        </div>
    </div>


    <button id="modoOscuroBtn" class="modo-oscuro-btn">
        🌙
    </button>


    <div class="user-icon">
        <img src="{{ asset('Images/user.png') }}" alt="Usuario">
    </div>


    <div class="faq-container">
        <button class="faq-btn" id="faqSearchBtn">🔍</button>

        <div id="faqSearchBox" class="faq-search-box d-none">
            <input type="text" id="faqInput" class="form-control" placeholder="Buscar preguntas frecuentes...">
            <div id="faqResults" class="faq-results"></div>
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const menuBtn = document.querySelector(".menu-btn");
            const menuDropdown = document.querySelector(".menu-dropdown");

            menuBtn.addEventListener("click", function(event) {
                event.stopPropagation();
                menuDropdown.classList.toggle("active");
            });

            document.addEventListener("click", function(event) {
                if (!menuDropdown.contains(event.target) && !menuBtn.contains(event.target)) {
                    menuDropdown.classList.remove("active");
                }
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const botonModoOscuro = document.getElementById("modoOscuroBtn");
            const body = document.body;

            if (!botonModoOscuro) {
                console.error(" ERROR: No se encontró el botón de modo oscuro.");
                return;
            }

            console.log(" Script de modo oscuro cargado correctamente.");

            if (localStorage.getItem("modoOscuro") === "true") {
                activarModoOscuro();
            }

            botonModoOscuro.addEventListener("click", function() {
                console.log(" Botón de modo oscuro clickeado.");
                if (body.classList.contains("dark-mode")) {
                    desactivarModoOscuro();
                } else {
                    activarModoOscuro();
                }
            });

            function activarModoOscuro() {
                body.classList.add("dark-mode");
                botonModoOscuro.textContent = "☀️";
                localStorage.setItem("modoOscuro", "true");
            }

            function desactivarModoOscuro() {
                body.classList.remove("dark-mode");
                botonModoOscuro.textContent = "🌙";
                localStorage.setItem("modoOscuro", "false");
            }
        });


        
    </script>
</body>

@endsection 

