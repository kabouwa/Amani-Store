<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        User::create($data);
        return to_route('admin.users.index')->with('success','Le compte administrateur a été crée avec succès.');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit',compact('user'));
    }

    public function update(UserRequest $request,User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validated();
        $user->update($data);
        return to_route('admin.users.edit',$user->slug)->with('success','Votre compte a été modifié avec succès.');
    }

    public function updatePassword(Request $request,User $user)
    {
        $this->authorize('update', $user);
        $data = $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8|max:50',
        ]);

        if(! Hash::check($data['current_password'], $user->password) ) return back()->with('error', 'Votre mot de passe actuel est incorrect.');

        $user->update($data);

        return to_route('admin.users.edit',$user)->with('success','Votre mot de passe a été modifié avec succès.');
    }

    public function destroy(Request $request,User $user)
    {
        $this->authorize('delete', $user);
        $request->session()->flash('toggle_modal',true);
        $data = $request->validate(['delete_password' => 'required']);

        if(! Hash::check($data['delete_password'], $user->password) ) return back()->with('error', 'Votre mot de passe actuel est incorrect.');

        $user->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('toggle_modal');

        return to_route('admin.login')->with('success', 'Votre compte a été supprimé avec succès.');;
    }
}
