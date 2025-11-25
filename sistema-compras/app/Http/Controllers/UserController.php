<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_active', 1)->get();
        return view('user', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = DB::table('roles')->orderBy('name')->get();
        $setores = DB::table('setores')->orderBy('nome')->get();
        
        return view('useredit', compact('user', 'roles', 'setores'));
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])
                    ->where('is_active', 1)
                    ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return redirect()
            ->route('login.form')
            ->withErrors(['email' => 'Usuário ou senha inválidos'])
            ->withInput($request->only('email'));
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $roleId = (User::count() == 0) ? 5 : 1;

        $user = User::create([
            'name' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $roleId,
            'is_active' => 1,
        ]);

        return redirect()->route('login.form')->with('success', 'Usuário registrado com sucesso. Faça login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }

    public function deleteUser(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.form');
        }

        $id = $request->input('id');

        if (!is_numeric($id)) {
            return redirect()->route('users.index')->withErrors(['id' => 'ID inválido']);
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->withErrors(['id' => 'Usuário não encontrado']);
        }

        $user->is_active = 0;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuário deletado com sucesso');
    }

    public function updateUser(UpdateUserRequest $request)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {
            $id = intval($data['id']);
            $user = User::findOrFail($id);

            $oldSetorId = $user->setor_id;

            $user->name = $data['nome'];
            $user->email = $data['email'];
            $user->role_id = intval($data['funcao']);
            $user->setor_id = !empty($data['setor_id']) && intval($data['setor_id']) > 0 ? intval($data['setor_id']) : null;
            $user->is_active = ($data['status'] === 'ativo') ? 1 : 0;
            $user->save();

            DB::table('setores')
                ->where('id', $user->setor_id)
                ->update(['user_responsavel_id' => $id]);

            if (!is_null($oldSetorId) && intval($oldSetorId) !== intval($user->setor_id)) {
                DB::table('setores')
                    ->where('id', $oldSetorId)
                    ->update(['user_responsavel_id' => null]);
            }

            return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
        });
    }

    public function getAllUsers()
    {
        return response()->json(User::all());
    }
}
