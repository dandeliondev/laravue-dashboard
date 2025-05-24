<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::select('id','name','email','phone')->paginate(10);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'phone'=>'nullable',
            'password'=>'required|min:8',
        ]);
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function update(Request $req, User $user)
    {
        $data = $req->validate([
            'name'=>'required',
            'email'=>"required|email|unique:users,email,{$user->id}",
            'phone'=>'nullable',
        ]);
        $user->update($data);
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
