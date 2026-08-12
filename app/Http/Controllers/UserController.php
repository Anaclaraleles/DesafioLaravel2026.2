<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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
        return view('users.create');
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

        User::query()->create($data);

        return to_route('users')->with('message', 'Alterado com sucesso!');
    }
    
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

            if ($request->hasFile('photo')) {
                $data['photo'] = $request->file('photo')->store('images', 'public');
            }

        $user->update($data);

        return to_route('users')->with('message', 'Alterado com sucesso!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users')->with('message', 'Deletado com sucesso!');
    }
}
