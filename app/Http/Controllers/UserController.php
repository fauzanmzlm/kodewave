<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::when(request()->name, function($query) {
            return $query->where('name', 'like', '%' . request()->name . '%');
        })->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = User::roles();

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {

            // hash password
            $password = Hash::make($request->password);

            // store user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'role' => $request->role,
            ]);

            DB::commit();

            $notification = [
                'message' => 'User successfully created',
                'alert_type' => 'success'
            ];

            return back()->with($notification);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];

            return back()->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = $user->roles();

        return view('users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = $user->roles();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::beginTransaction();

        try {

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);

            DB::commit();

            $notification = [
                'message' => 'User successfully updated',
                'alert_type' => 'success'
            ];
            
            return back()->with($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return back()->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {

            $user->delete();

            DB::commit();

            $notification = [
                'message' => 'User successfully deleted',
                'alert_type' => 'success'
            ];
            
            return back()->with($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return back()->with($notification);
        }
    }
}
