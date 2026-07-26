<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderByDesc('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|between:4,20',
            'email' => 'required|email|between:7,50|unique:users,email',
            'password' => 'required|confirmed|min:8|max:50',
        ]);

        User::create($data);
        return to_route('admin.users.index')->with('success','Le compte administrateur a été crée avec succès.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit',compact('user'));
    }

    public function update(Request $request,User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validate([
            'name' => 'required|between:4,20',
            'email' => ['required','email','between:7,50', Rule::unique('users','email')->ignore($user) ],
        ]);
        $user->update($data);
        return to_route('admin.users.edit',$user->slug)->with('success','Votre compte a été modifié avec succès.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
    }
}
