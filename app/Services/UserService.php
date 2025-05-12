<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(){}

    public function create($request, $role_id, $password = '', $category_id = 0)
    {
        return DB::transaction(function () use ($request, $role_id, $password, $category_id) {
            $user = new User();
            $user->role_id = $role_id;
            $user->name = $request->name;
            $user->email = $request->email;
            if($password) {
                $user->password = Hash::make($password);
            } else {
                $user->password = Hash::make($request->password);
            }
            if(isset($request->phone)) {
                $user->phone = $request->phone;
            } else {
                $user->phone = $request->mobile_number;
            }
            $user->status = $request->active;
            $user->category_id = $category_id;
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
