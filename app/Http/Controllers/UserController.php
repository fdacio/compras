<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\Http\Requests\UserRequest;
use App\TipoUsuario;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.access')->except(['perfil', 'editPassword', 'passwordUpdate']);

    }
    
    public function perfil()
    {
        $user = Auth::user();
        return view('user.show', compact('user'));
    }

    public function editPassword()
    {
        $user = Auth::user();
        return view('user.edit-password', compact('user'));
    }

    public function passwordUpdate(UserRequest $request)
    {
        $newPassword = User::encryptSenha($request->password);
        $user = User::find(Auth::user()->id);
        $user->password = $newPassword;
        $user->update();
        return redirect()->route('edit.password')->with('success', 'Senha alterada com sucesso!');
    }

    public function index()
    {
        $users = User::where('id_tipo', '!=', TipoUsuario::NIVEL_MANUTENCAO)->orderBy('id', 'asc');

        $nome = request()->get('nome');
        if (!empty($nome)) {
            $users =  $users->where('name', 'LIKE', '%' . $nome . '%');
        }
        $users = $users->paginate(10);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        $tipos = TipoUsuario::where('id', '!=', TipoUsuario::NIVEL_MANUTENCAO)->pluck('nome', 'id');
        return view('user.create', compact('tipos'));
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = User::encryptSenha($request->password);
        $user = User::create($data);
        return redirect()->route('user.index');
    }

    public function show(User $user) 
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $tipos = TipoUsuario::where('id', '!=', TipoUsuario::NIVEL_MANUTENCAO)->pluck('nome', 'id');
        return view('user.edit', compact('user', 'tipos'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Deletado com sucesso!');
    }

    public function centrosCustosEdit(User $user)
    {
        $centrosCustosUser = $user->centrosCustos();
        $centrosCustos = CentroCusto::orderBy('nome')->get();
        return view('user.centros-custos.edit', compact('user', 'centrosCustosUser', 'centrosCustos'));
    }

    public function centrosCustosUpdate(Request $request, User $user)
    {
        $user->centrosCustos()->sync($request->centros_custos);
        return redirect()->route('user.centros-custos.edit', $user)->with('success', 'Centros de custos atualizados com sucesso!');
    }

}
