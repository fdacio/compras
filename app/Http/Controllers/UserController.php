<?php

namespace App\Http\Controllers;

use App\CentroCusto;
use App\Http\Requests\UserRequest;
use App\TipoUsuario;
use App\User;
use App\UserCentroCusto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        try {
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Deletado com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('user.index')->with('danger', 'Não foi possível deletar o usuário: ' . $e->getMessage());
        }
    }

    public function desativar(User $user)
    {
        $user->status = 0;
        $user->update();
        return redirect()->route('user.index')->with('success', 'Desativado com sucesso!');
    }

    public function centrosCustosEdit(User $user)
    {
        $centrosCustosUser = UserCentroCusto::where('id_user', $user->id);
        $centrosCustos = CentroCusto::orderBy('nome')->get();
        return view('user.centros-custos.edit', compact('user', 'centrosCustosUser', 'centrosCustos'));
    }

    public function centrosCustosUpdate(Request $request, User $user)
    {

        try {

            DB::beginTransaction();

            UserCentroCusto::where('id_user', $user->id)->delete();

            if (isset($request->centros_custos)) {
                foreach ($request->centros_custos as $centroCusto) {
                    $dados = ['id_user' => $user->id, 'id_centro_custo' => $centroCusto];
                    UserCentroCusto::create($dados);
                }
            }

            DB::commit();

            return redirect()->route('user.index')->with('success', 'Centros de custos atualizados com sucesso!');
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->route('user.centros-custos.edit', $user->id)->with('danger', 'Não foi possível registrar os centros de custos: ' . $e->getMessage());
        }
    }
}
