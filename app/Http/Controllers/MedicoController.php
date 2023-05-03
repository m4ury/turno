<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medico = Medico::select('id', 'nombres_medico', 'rut_medico', 'apellidoP', 'apellidoM')->get();

        return Inertia::render('Medicos/Index', [
            'medico' => $medico
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Medicos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //dd($request->all());
        $request->validate([
            'nombres_medico' => 'required|string|max:255',
            'rut_medico' => 'required|cl_rut',
            'apellidoP' => 'required|string|max:255',

        ]);
        $medico = new Medico($request->all());
        $medico->save();

        return redirect(route('medicos.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Medico $medico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medico $medico)
    {
        return Inertia::render('Medicos/Edit', ['medico' => $medico]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medico $medico)
    {
        $request->validate(['nombres_medico' => 'required|max:90']);
        $medico->update($request->all());
        return redirect('medicos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medico $medico)
    {
        $medico->delete();
        return redirect('medicos');
    }
}
