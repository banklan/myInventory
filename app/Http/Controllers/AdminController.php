<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\Admin;
use App\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    public function getAdmins()
    {
        $admin = Admin::orderBy('id', 'asc')->get();

        return response()->json($admin, 200);
    }

    public function getUsers()
    {
        $users = User::orderBy('id', 'asc')->get();

        return response()->json($users, 200);
    }

    public function getAllSupervisors()
    {
        $users = Supervisor::orderBy('id', 'asc')->get();

        return response()->json($users, 200);
    }

    public function getAdminUser($id)
    {
       $admin = Admin::findOrFail($id);

       return response()->json($admin, 200);
    }

    public function getFrontOfficeUser($id)
    {
       $user = User::findOrFail($id);

       return response()->json($user, 200);
    }

    public function getSupervisorUser($id)
    {
       $user = Supervisor::findOrFail($id);

       return response()->json($user, 200);
    }

    public function updateAdminUser(Request $request, $id)
    {
        $this->validate($request, [
            'full_name' => 'required',
            'email' => 'required|email'
        ]);

        $admin = Admin::findOrFail($id);

        $admin->update([
            $admin->full_name = $request->full_name,
            $admin->email = $request->email,
        ]);

        return response()->json($admin, 201);
    }

    public function updateFrontOfficeUser(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            $user->full_name = $request->fullname,
            $user->email = $request->email,
        ]);

        return response()->json($user, 201);
    }
    
    public function updateAdminSupervisor(Request $request, $id)
    {
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required|email'
        ]);

        $supervisor = Supervisor::findOrFail($id);

        $supervisor->update([
            $supervisor->full_name = $request->fullname,
            $supervisor->email = $request->email,
        ]);

        return response()->json($supervisor, 201);
    }

    public function enableAdminUser($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update([
            $admin->status = 1,
        ]);

        return response()->json($admin, 201);
    }

    public function disableAdminUser($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update([
            $admin->status = 0,
        ]);

        return response()->json($admin, 201);
    }

    public function enableUser($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            $user->status = 1,
        ]);

        return response()->json($user, 201);
    }
    
    public function disableUser($id)
    {
        $user = user::findOrFail($id);
        $user->update([
            $user->status = 0,
        ]);

        return response()->json($user, 201);
    }

    public function enableSupervisor($id)
    {
        $user = Supervisor::findOrFail($id);
        $user->update([
            $user->status = 1,
        ]);

        return response()->json($user, 201);
    }

    public function disableSupervisor($id)
    {
        $user = Supervisor::findOrFail($id);
        $user->update([
            $user->status = 0,
        ]);

        return response()->json($user, 201);
    }

    public function resetAdminPswd(Request $request, $id)
    {
        $admin =  Admin::findOrFail($id);
        $admin->update([
            $admin->password = bcrypt($request->newPassword),
        ]);

        return response()->json($admin, 201);
    }

    public function resetUserPswd(Request $request, $id)
    {
        $user =  User::findOrFail($id);
        $user->update([
            $user->password = bcrypt($request->newPassword),
        ]);

        return response()->json($user, 201);
    }

    public function resetSupervisorPswd(Request $request, $id)
    {
        $user =  Supervisor::findOrFail($id);
        $user->update([
            $user->password = bcrypt($request->newPassword),
        ]);

        return response()->json($user, 201);
    }

    public function delAdmin($id)
    {
        $admin =  Admin::findOrFail($id);
        $admin->delete();

        return response()->json([
            'message' => 'deleted',
        ]);
    }

    public function delUser($id)
    {
        $user =  User::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'deleted',
        ]);
    }

    public function delSupervisor($id)
    {
        $user =  Supervisor::findOrFail($id);
        $user->delete();

        return response()->json([
            'message' => 'deleted',
        ]);
    }

    public function createNewUser(Request $request)
    {
        $this->validate($request, [
            'user.fullname' => 'required|max:60',
            'user.email' => 'required|unique:users,email',
            'user.role' => 'required|integer',
            'user.status' => 'required|integer',
            'user.password' => 'required|min:5|max:20'
        ]);

        $user = new User;
        $user->name = $request->user['fullname'];
        $user->email = $request->user['email'];
        $user->password = bcrypt($request->user['password']);
        $user->role_id = $request->user['role'];
        $user->status = $request->user['status'];
        $user->save();

        return response()->json($user, 200);
    }

    public function createNewSupervisor(Request $request)
    {
        $this->validate($request, [
            'user.fullname' => 'required|max:60',
            'user.email' => 'required|unique:users,email',
            'user.role' => 'required|integer',
            'user.status' => 'required|integer',
            'user.password' => 'required|min:5|max:20'
        ]);

        $user = new Supervisor;
        $user->name = $request->user['fullname'];
        $user->email = $request->user['email'];
        $user->password = bcrypt($request->user['password']);
        $user->role_id = $request->user['role'];
        $user->status = $request->user['status'];
        $user->save();

        return response()->json($user, 200);
    }

    public function createNewAdmin(Request $request)
    {
        $this->validate($request, [
            'user.fullname' => 'required|max:60',
            'user.email' => 'required|unique:admins,email',
            'user.role' => 'required|integer',
            'user.status' => 'required|integer',
            'user.password' => 'required|min:5|max:20'
        ]);

        $user = new Admin;
        $user->full_name = $request->user['fullname'];
        $user->email = $request->user['email'];
        $user->password = bcrypt($request->user['password']);
        $user->role_id = $request->user['role'];
        $user->status = $request->user['status'];
        $user->save();

        return response()->json($user, 200);
    }

    public function AdminSearchAdmin(Request $request)
    {
        $search = $request->q;
        $admins = Admin::where('full_name', 'like', "%".$search."%")->orWhere('email', 'like', "%".$search."%")->get();
        
        $sups = Supervisor::where('full_name', 'like', "%".$search."%")->orWhere('email', 'like', "%".$search."%")->get();
        $users = User::where('full_name', 'like', "%".$search."%")->orWhere('email', 'like', "%".$search."%")->get();
        $m = $admins->merge($sups)->merge($users)->all();
        return response()->json($m, 201);
    }

    public function AdminCreateAdmin(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|max:60',
            'email' => 'required|email|unique:admins,email',
            'status' => 'required|integer',
            'password' => 'required|min:5|max:20'
        ]);

        $user = new Admin;
        $user->full_name = $request->fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->user['password']);
        $user->role_id = 7;
        $user->status = $request->status;
        $user->save();

        return response()->json($user, 201);
    }

    public function AdminDelUser(Request $request, $id)
    {
       $role = $request->role;
       if($role === 7){
            $user = Admin::findOrFail($id);
            $user->delete();
       }elseif($role === 2){
            $user = Supervisor::findOrFail($id);
            $user->delete();
       }else{
            $user = User::findOrFail($id);
            $user->delete();
       }
        return response()->json(['message' => 'Admin Deleted']); 
    }

    public function AdminUpdateUser(Request $request, $id)
    {
        $role = $request->role;
        if($role === 7){
            $user = Admin::findOrFail($id);
        }elseif($role === 2){
            $user = Supervisor::findOrFail($id);
        }else{
            $user = User::findOrFail($id);
        }
        
        $this->validate($request, [
            'fullname' => 'required|min:5|max:70',
            'email' => 'required|email'
        ]);
            
        $user->update([
            $user->full_name = $request->fullname,
            $user->email = $request->email
        ]);
            
        return response()->json($user, 202);
    }

    public function AdminCreateSup(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|max:60',
            'email' => 'required|email|unique:supervisors,email',
            'status' => 'required|integer',
            'password' => 'required|min:5|max:20'
        ]);

        $user = new Supervisor;
        $user->full_name = $request->fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->user['password']);
        $user->role_id = 2;
        $user->status = $request->status;
        $user->save();

        return response()->json($user, 201);
    }

    public function AdminCreateUser(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|max:60',
            'email' => 'required|email|unique:users,email',
            'status' => 'required|integer',
            'password' => 'required|min:5|max:20'
        ]);

        $user = new User;
        $user->full_name = $request->fullname;
        $user->email = $request->email;
        $user->password = bcrypt($request->user['password']);
        $user->role_id = 1;
        $user->status = $request->status;
        $user->save();

        return response()->json($user, 201);
    }

    public function getRoles()
    {
        $roles = Role::orderBy('role_id', 'asc')->get();

        return response()->json($roles, 200);
    }

    public function AdminDelRole($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return response()->json(['message' => 'Role deleted'], 200);
    }

    public function AdminCreateRole(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required|max:60',
            'role_id' => 'required|unique:roles,role_id',
        ]);

        $role = new Role;
        $role->role_name = $request->role_name;
        $role->role_id = $request->role_id;
        $role->save();

        return response()->json($role, 201);
    }

    public function AdminUpdateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->validate($request, [
            'role_name' => 'required|max:60',
            'role_id' => 'required|integer'
        ]);
            
        $role->update([
            $role->role_name = $request->role_name,
            $role->role_id = $request->role_id
        ]);
            
        return response()->json($role, 202);
    }

    public function GetSingleRole($id)
    {
        $role = Role::findOrFail($id);

        return response()->json($role, 200);
    }
}

