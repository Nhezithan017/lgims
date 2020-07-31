<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function search(Request $request){
        $query = (new User)->newQuery();

        if($request->q){
            $query->where(function($q) use ($request){
                $q->where('name', '=', $request->q)
                    ->orWhere('username', '=', $request->q);
            });
        }

        return $query->get();
    }
    public function index(){
        $users = User::paginate(5);

        return response()->json($users, 200);
    }
    public function show(User $users, $id){
        $user = $users->findOrFail($id);

        return response()->json($user);
    }
    public function update(User $users, Request $request){
        $this->validate($request, [
            'username' => ['required','string'],
            'name' => ['required', 'string', 'max:255'],
            // 'password' => ['required', 'string', 'min:8'],
        ]);

        $users->update([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Users updated successfully.'], 200);
    }
}
