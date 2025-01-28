<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        // Log::info('Data users:', ['users' => $users]);
        return response()->json($users);
    }

    public function show($id){
        return response()->json(User::findOrFail($id));
    }

    public function store($request){
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
}
