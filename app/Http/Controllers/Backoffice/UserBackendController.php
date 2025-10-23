<?php

namespace App\Http\Controllers\Backoffice;
use App\Models\Role;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserBackendController extends Controller
{
    public function index()
    {
$roles = Role::select('id', 'name')->get();
    return view('back.users.index', compact('roles'));    }

  public function list()
{
    $users = \DB::table('users')
        ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
        ->select(
            'users.id',
            'users.name',
            'users.email',
            'users.phone',
            'users.address',
            'users.city',
            'users.role_id',          
            'roles.name as role_name'  
        )
        ->get();

    return response()->json($users);
}


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'phone', 'address', 'city', 'role_id']));
        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
