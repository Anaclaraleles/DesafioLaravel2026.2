<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $isAdmin = auth()->user()->role === 'admin';

        $users = $isAdmin
            ? User::where('role', 'user')->paginate(5)
            : User::where('id', auth()->id())->paginate(5);
        
        return view('users', compact('users'));
    }

    public function create()
    {
        return view('users');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $addressData = collect($data)->only([
            'cep', 'street', 'number', 'neighborhood', 'city', 'state', 'complement',
        ])->toArray();

        $userData = collect($data)->except([
            'cep', 'street', 'number', 'neighborhood', 'city', 'state', 'complement',
        ])->toArray();

        $userData['role'] = 'user';

        $user = User::query()->create($userData);
        $user->addresses()->create($addressData);

        return to_route('usuarios')->with('message', 'Criado com sucesso!');
    }
    
    public function edit(User $user)
    {
        return view('users', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('images', 'public');
        }

        $addressData = collect($data)->only([
            'cep', 'street', 'number', 'neighborhood', 'city', 'state', 'complement',
        ])->toArray();

        $userData = collect($data)->except([
            'cep', 'street', 'number', 'neighborhood', 'city', 'state', 'complement',
        ])->toArray();

        $userData['role'] = 'user';

        $user->update($userData);
        $user->addresses()->first()->update($addressData);

        return to_route('usuarios')->with('message', 'Alterado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->products()->exists()) {
            return back()->with('error', 'Não é possível excluir este usuário pois ele possui produtos cadastrados.');
        }

        $user->delete();

        return to_route('usuarios')->with('message', 'Deletado com sucesso!');
    }
}
