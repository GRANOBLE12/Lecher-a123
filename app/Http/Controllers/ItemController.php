<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class ItemController extends Controller
{
    protected $database;

    public function __construct()
    {
        // Configuración de Firebase
        $firebase = (new Factory)
            ->withServiceAccount(base_path('storage/app/proyectoleche-91725-firebase-adminsdk-fbsvc-e7276bdee3.json')) // Ruta al archivo JSON de credenciales
            ->withDatabaseUri('https://proyectoleche-91725-default-rtdb.firebaseio.com/'); // Reemplaza con tu URL de Firebase

        $this->database = $firebase->createDatabase(); // Usa createDatabase() en lugar de create()
    }

    /**
     * Mostrar una lista de los ítems.
     */
    public function index()
    {
        $items = $this->database->getReference('items')->getValue() ?? [];
        return view('items.index', compact('items'));
    }

    /**
     * Mostrar el formulario para crear un nuevo ítem.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Almacenar un nuevo ítem en Firebase.
     */
    public function store(Request $request)
    {
        // Validación inicial
        $validated = $request->validate([
            'id_vaca' => 'required|string|max:50',
            'raza' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric|min:0',
            'estado' => 'required|string|in:Activa,Inactiva,Vendida,Enferma',
            'id_madre' => 'nullable|string',
            'observaciones' => 'nullable|string|max:500'
        ]);

        // Verificar si el id_vaca ya existe
        $items = $this->database->getReference('items')->getValue() ?? [];

        foreach ($items as $existingItem) {
            if (isset($existingItem['id_vaca']) && $existingItem['id_vaca'] === $validated['id_vaca']) {
                return back()
                    ->withInput()
                    ->withErrors(['id_vaca' => 'El ID de vaca ya está registrado']);
            }
        }

        // Si no existe, crear el nuevo registro
        $this->database->getReference('items')->push($validated);

        return redirect()->route('items.index')
            ->with('success', 'Registro de vaca creado correctamente.');
    }

    /**
     * Mostrar un ítem específico.
     */
    public function show($id)
    {
        // Obtener el ítem de Firebase
        $item = $this->database->getReference('items/' . $id)->getValue();

        if (!$item) {
            return redirect()->route('items.index')->with('error', 'Ítem no encontrado.');
        }

        return view('items.show', compact('item', 'id'));
    }

    /**
     * Mostrar el formulario para editar un ítem.
     */
    public function edit($id)
    {
        // Obtener el ítem de Firebase
        $item = $this->database->getReference('items/' . $id)->getValue();

        if (!$item) {
            return redirect()->route('items.index')->with('error', 'Ítem no encontrado.');
        }

        return view('items.edit', compact('item', 'id'));
    }

    /**
     * Actualizar un ítem en Firebase.
     */
    public function update(Request $request, $id)
    {
        // Validación inicial
        $validated = $request->validate([
            'id_vaca' => 'required|string|max:50',
            'raza' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric|min:0',
            'estado' => 'required|string|in:Activa,Inactiva,Vendida,Enferma',
            'id_madre' => 'nullable|string',
            'observaciones' => 'nullable|string|max:500'
        ]);

        // Verificar si el id_vaca ya existe en otros registros
        $items = $this->database->getReference('items')->getValue() ?? [];

        foreach ($items as $itemId => $existingItem) {
            if ($itemId !== $id && isset($existingItem['id_vaca']) && $existingItem['id_vaca'] === $validated['id_vaca']) {
                return back()
                    ->withInput()
                    ->withErrors(['id_vaca' => 'El ID de vaca ya está registrado en otro animal']);
            }
        }

        // Si no hay duplicados, actualizar
        $this->database->getReference('items/' . $id)->update($validated);

        return redirect()->route('items.index')
            ->with('success', 'Registro de vaca actualizado correctamente.');
    }

    /**
     * Eliminar un ítem de Firebase.
     */
    public function destroy($id)
    {
        // Eliminar el ítem de Firebase
        $this->database->getReference('items/' . $id)->remove();

        return redirect()->route('items.index')->with('success', 'Ítem eliminado correctamente.');
    }
    public function buscar()
{
    return view('items.buscar'); // Muestra el formulario de búsqueda
}
}
