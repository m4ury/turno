<?php

namespace App\Http\Controllers;

use App\Models\Cama;
use App\Models\Sala;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cama = Cama::with('sala')->select('camas.id', 'numero_cama', 'estado_cama', 'sala_id')->latest()->get();
        $sala = Sala::select('id', 'numero_sala', 'descripcion_sala')->latest()->get();
        return Inertia::render('Camas/Index', [
            'cama' => $cama, 'sala' => $sala
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cama $cama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cama $cama)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cama $cama)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cama $cama)
    {
        //
    }
}
