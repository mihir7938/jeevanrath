<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(){}

    public function create($request, $role_id, $password = '')
    {
        return DB::transaction(function () use ($request, $role_id, $password) {
            $user = new User();
            $user->role_id = $role_id;
            $user->name = $request->name;
            $user->email = $request->email;
            if($password) {
                $user->password = Hash::make($password);
            } else {
                $user->password = Hash::make($request->password);
            }
            $user->phone = $request->phone;
            $user->status = $request->active;
            $user->save();
            return $user;
        });
    }
    public function getUserById($id)
    {
        return User::find($id);
    }
    public function update($user, $data)
    {
        return $user->update($data);
    }
    public function delete($user)
    {
        return $user->delete($user);
    }
    public function getAllUsers($role_id, $per_page = -1)
    {
        if($per_page == -1){
            return User::orderBy('created_at', 'desc')->where('role_id', $role_id)->get();    
        }
        return User::orderBy('created_at', 'desc')->where('role_id', $role_id)->paginate($per_page);
    }
}
