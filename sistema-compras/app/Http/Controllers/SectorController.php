<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::with('responsavel')->get();
        $users = \App\Models\User::all();
        return view('setores', compact('sectors', 'users'));
    }

    public function create()
    {
        return view('sectors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'user_responsavel_id' => 'nullable|exists:users,id',
        ]);
        Sector::create($request->only('nome', 'user_responsavel_id'));
        return redirect()->route('sectors.index');
    }

    public function edit($id)
    {
        $sector = Sector::findOrFail($id);
        $users = \App\Models\User::all();
        return view('sectors.edit', compact('sector', 'users'));
    }

    public function update(Request $request, $id)
    {
        $sector = Sector::findOrFail($id);
        $request->validate([
            'nome' => 'required|string|max:255',
            'user_responsavel_id' => 'nullable|exists:users,id',
        ]);
        $sector->update($request->only('nome', 'user_responsavel_id'));
        return redirect()->route('sectors.index');
    }

    public function destroy($id)
    {
        $sector = Sector::findOrFail($id);
        $sector->delete();
        return redirect()->route('sectors.index');
    }
}
