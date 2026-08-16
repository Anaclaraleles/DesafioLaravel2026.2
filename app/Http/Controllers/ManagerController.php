<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateManagerRequest;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->paginate(5);       
        return view('admin.manager', compact('admins'));
    }

    public function create()
    {
        return view('admin.manager');
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

        $userData['role'] = 'admin';

        $user = User::query()->create($userData);
        $user->addresses()->create($addressData);

        return to_route('admins')->with('message', 'Criado com sucesso!');
    }
    
    public function edit(User $admin)
    {
        return view('admin.manager', compact('admin'));
    }

    public function update(UpdateManagerRequest $request, User $admin)
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

        $userData['role'] = 'admin';

        $admin->update($userData);
        $admin->addresses()->first()->update($addressData);

        return to_route('admins')->with('message', 'Alterado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.manager')->with('message', 'Deletado com sucesso!');
    }
}
