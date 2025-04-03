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

    public function lista()
    {
        return view('items.lista');
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
        // Reglas base de validación
        $rules = [
            'id_vaca' => 'required|string|max:50',
            'raza' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric|min:0',
            'estado' => 'required|string|in:Activa,Inactiva,Vendida,Enferma',
            'id_madre' => 'nullable|string',
            'observaciones' => 'nullable|string|max:500',

        ];

        // Agregar reglas condicionales
        if ($request->estado === 'Enferma') {
            $rules['enfermedad'] = 'nullable|string|max:500';
            $rules['sintomas'] = 'required|string|max:500';
        }

        // Validación
        $validated = $request->validate($rules);

        // Preparar datos para Firebase
        $data = $request->all();

        // Solo mantener enfermedad y síntomas si el estado es Enferma
        if ($request->estado !== 'Enferma') {
            unset($data['enfermedad']);
            unset($data['sintomas']);
        }

        // Verificar si el id_vaca ya existe
        $items = $this->database->getReference('items')->getValue() ?? [];

        foreach ($items as $existingItem) {
            if (isset($existingItem['id_vaca']) && $existingItem['id_vaca'] === $validated['id_vaca']) {
                return back()
                    ->withInput()
                    ->withErrors(['id_vaca' => 'El ID de vaca ya está registrado']);
            }
        }

        // Crear nuevo registro
        $this->database->getReference('items')->push($data);

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
        // Reglas base de validación
        $rules = [
            'id_vaca' => 'required|string|max:50',
            'raza' => 'required|string|max:100',
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric|min:0',
            'estado' => 'required|string|in:Activa,Inactiva,Vendida,Enferma',
            'id_madre' => 'nullable|string',
            'observaciones' => 'nullable|string|max:500',
        ];

        // Agregar reglas condicionales
        if ($request->estado === 'Enferma') {
            $rules['enfermedad'] = 'nullable|string|max:500';
            $rules['sintomas'] = 'required|string|max:500';
        }

        // Validación
        $validated = $request->validate($rules);

        // Preparar datos para Firebase
        $data = $request->all();

        // Solo mantener enfermedad y síntomas si el estado es Enferma
        if ($request->estado !== 'Enferma') {
            $data['enfermedad'] = null;
            $data['sintomas'] = null;
        }

        // Verificar si el id_vaca ya existe en otros registros
        $items = $this->database->getReference('items')->getValue() ?? [];

        foreach ($items as $itemId => $existingItem) {
            if ($itemId !== $id && isset($existingItem['id_vaca']) && $existingItem['id_vaca'] === $validated['id_vaca']) {
                return back()
                    ->withInput()
                    ->withErrors(['id_vaca' => 'El ID de vaca ya está registrado en otro animal']);
            }
        }

        // Actualizar registro
        $this->database->getReference('items/' . $id)->update($data);

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
    // Método para mostrar formulario de búsqueda
    public function buscar()
    {
        return view('items.search');
    }

    // Método para procesar búsqueda
    public function search(Request $request)
    {
        $idVaca = $request->input('id_vaca');
        $items = $this->database->getReference('items')->getValue() ?? [];

        foreach ($items as $id => $item) {
            if (isset($item['id_vaca']) && $item['id_vaca'] == $idVaca) {
                return view('items.search', [
                    'item' => $item,
                    'id' => $id,
                    'searchPerformed' => true,
                    'notFound' => false
                ]);
            }
        }

        return view('items.search', [
            'searchPerformed' => true,
            'notFound' => true,
            'id_vaca' => $idVaca
        ]);
    }
    // Método para mostrar formulario de producción
    public function produccionForm()
    {
        return view('items.produccion');
    }

    // Método para buscar vaca y mostrar formulario de producción
    public function searchForProduction(Request $request)
    {
        $idVaca = $request->input('id_vaca');
        $items = $this->database->getReference('items')->getValue() ?? [];

        foreach ($items as $id => $item) {
            if (isset($item['id_vaca']) && $item['id_vaca'] == $idVaca) {
                return view('items.produccion', [
                    'vaca' => $item,
                    'vacaId' => $id,
                    'found' => true
                ]);
            }
        }

        return view('items.produccion')->with('error', 'Vaca no encontrada');
    }

    // Método para registrar producción
    public function addProduction(Request $request, $id)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'turno' => 'required|in:Mañana,Tarde',
            'litros' => 'required|numeric|min:0',
            'calidad' => 'nullable|string|max:100'
        ]);

        // Obtener referencia a la vaca
        $vacaRef = $this->database->getReference("items/$id");

        // Obtener producción existente o crear array vacío
        $produccion = $vacaRef->getChild('produccion')->getValue() ?? [];

        // Agregar nuevo registro
        $produccion[] = [
            'fecha' => $validated['fecha'],
            'turno' => $validated['turno'],
            'litros' => $validated['litros'],
            'calidad' => $validated['calidad'] ?? null
        ];

        // Actualizar en Firebase
        $vacaRef->update(['produccion' => $produccion]);

        return redirect()->route('produccion.form')
            ->with('success', 'Producción registrada exitosamente');
    }

    // Método para ver historial de producción
    public function verProduccion($id)
    {
        $vaca = $this->database->getReference("items/$id")->getValue();

        if (!$vaca) {
            return redirect()->route('produccion.form')->with('error', 'Vaca no encontrada');
        }

        $produccion = $vaca['produccion'] ?? [];

        // Ordenar por fecha descendente
        usort($produccion, function ($a, $b) {
            return strtotime($b['fecha']) - strtotime($a['fecha']);
        });

        return view('items.ver-produccion', [
            'vaca' => $vaca,
            'produccion' => $produccion,
            'vacaId' => $id
        ]);
    }
}
