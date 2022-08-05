<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Requests\UpdateUserRequest;
use App\TodoList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TodoController extends Controller
{
    /**
     * Display user all todos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();

        try {
            
            $user = User::findOrFail(auth()->user()->id);

            $todoLists = TodoList::where('user_id', $user->id)->latest()->get();

            DB::commit();

            $notification = [
                'message' => 'Todos successfully retrieved',
                'alert_type' => 'success',
                "todos" => $todoLists,
            ];

            return response()->json($notification);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];

            return response()->json($notification);
        }
    }

    /**
     * Get total todo.
     *
     * @return \Illuminate\Http\Response
     */
    public function total()
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail(auth()->user()->id);

            $todoListsTotal = TodoList::where('user_id', $user->id)->count();

            DB::commit();

            $notification = [
                'message' => 'Total todos successfully retrieved',
                'alert_type' => 'success',
                "total" => $todoListsTotal
            ];

            return response()->json($notification);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];

            return response()->json($notification);
        }
    }

    /**
     * Get total uncomplete todo.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalUncompleted()
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail(auth()->user()->id);
            $status = TodoList::STATUS_UNCOMPLETED;
            $todoListsTotal = TodoList::where('user_id', $user->id)->where('is_complete', $status)->count();

            DB::commit();

            $notification = [
                'message' => 'Total uncompleted todos successfully retrieved',
                'alert_type' => 'success',
                'total' => $todoListsTotal
            ];

            return response()->json($notification);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];

            return response()->json($notification);
        }
    }

    /**
     * Get total complete todo.
     *
     * @return \Illuminate\Http\Response
     */
    public function totalCompleted()
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail(auth()->user()->id);
            $status = TodoList::STATUS_COMPLETED;
            $todoListsTotal = TodoList::where('user_id', $user->id)->where('is_complete', $status)->count();

            DB::commit();

            $notification = [
                'message' => 'Total completed todos successfully retrieved',
                'alert_type' => 'success',
                'total' => $todoListsTotal
            ];

            return response()->json($notification);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];

            return response()->json($notification);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail(auth()->user()->id);

            $todo = TodoList::create([
                'user_id' => $user->id,
                'body' => $request->body,
            ]);

            DB::commit();

            $notification = [
                'message' => 'Todo successfully created',
                'alert_type' => 'success',
                'todo' => $todo,
            ];

            return response()->json($notification);

        } catch (\Exception $e) {

            DB::rollBack();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];

            return response()->json($notification);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            DB::commit();

            $notification = [
                'message' => 'Todo status successfully updated',
                'alert_type' => 'success',
                'todo' => $todo,
            ];
            
            return response()->json($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Update todo status to complete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function complete($id)
    {
        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            $todo->update([
                'is_complete' => TodoList::STATUS_COMPLETED
            ]);

            DB::commit();

            $notification = [
                'message' => 'Todo status successfully updated',
                'alert_type' => 'success'
            ];
            
            return response()->json($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Update todo status to uncomplete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function uncomplete($id)
    {
        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            $todo->update([
                'is_complete' => TodoList::STATUS_UNCOMPLETED
            ]);

            DB::commit();

            $notification = [
                'message' => 'Todo status successfully updated',
                'alert_type' => 'success'
            ];
            
            return response()->json($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTodoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTodoRequest $request, $id)
    {
        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            $todo->update([
                'body' => $request->body,
            ]);

            DB::commit();

            $notification = [
                'message' => 'Todo successfully updated',
                'alert_type' => 'success'
            ];
            
            return response()->json($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);
            $todo->delete();

            DB::commit();

            $notification = [
                'message' => 'Todo successfully deleted',
                'alert_type' => 'success'
            ];
            
            return response()->json($notification);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
                'alert_type' => 'error'
            ];
            
            return response()->json($notification);
        }
    }
}
