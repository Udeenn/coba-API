<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;



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

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function destroy($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'user not found'], 404);
        }

        $user->delete();

        return response()->json(['message'=>'user delete successfully'], 200);
    }
}
