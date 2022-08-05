<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\TodoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $user_id = $request->user_id;
            $todoLists = TodoList::where('user_id', $user_id)->latest()->get();
            
            DB::commit();

            $notification = [
                "response" => [
                    "status"    => 200,
                    "message"   => "Todo list successfully retrieved"
                ],
                "todos" => $todoLists
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Get total todo.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function total(Request $request)
    {
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $user_id = $request->user_id;
            $todoListsTotal = TodoList::where('user_id', $user_id)->count();

            DB::commit();

            $notification = [
                "response" => [
                    "status"    => 200,
                    "message"   => "Total todo successfully retrieved"
                ],
                "total" => $todoListsTotal
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Get total uncomplete todo.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function totalUncompleted(Request $request)
    {
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $user_id = $request->user_id;
            $status = TodoList::STATUS_UNCOMPLETED;
            $todoListsTotal = TodoList::where('user_id', $user_id)->where('is_complete', $status)->count();

            DB::commit();

            $notification = [
                "response" => [
                    "status"    => 200,
                    "message"   => "Total uncompleted todo successfully retrieved"
                ],
                "total" => $todoListsTotal
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Get total complete todo.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function totalCompleted(Request $request)
    {
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $user_id = $request->user_id;
            $status = TodoList::STATUS_COMPLETED;
            $todoListsTotal = TodoList::where('user_id', $user_id)->where('is_complete', $status)->count();

            DB::commit();

            $notification = [
                "response" => [
                    "status"    => 200,
                    "message"   => "Total completed todo successfully retrieved"
                ],
                "total" => $todoListsTotal
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
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
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $todo = TodoList::create([
                'body' => $request->body,
                'user_id' => $request->user_id,
            ]);

            DB::commit();

            $notification = [
                'status' => 200,
                'message' => 'Todo successfully added',
                'todo' => $todo,
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
            ];
            
            return response()->json($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        try {

            $todo = TodoList::findOrFail($id);

            return response()->json([
                "status"    => 200,
                "message"   => "Todo successfully retrieved",
                "todo" => $todo,
            ], 200);
        
        } catch(\Exception $e) {

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
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
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        try {

            $todo = TodoList::findOrFail($id);

            return response()->json([
                "status"    => 200,
                "message"   => "Todo successfully retrieved",
                "todo" => $todo,
            ], 200);
        
        } catch(\Exception $e) {

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
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
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            $todo->update([
                'body' => $request->body,
            ]);

            DB::commit();

            $notification = [
                'status' => 200,
                'message' => 'Todo successfully updated',
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
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
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            $todo->update([
                'is_complete' => TodoList::STATUS_COMPLETED
            ]);

            DB::commit();

            $notification = [
                'status' => 200,
                'message' => 'Todo status successfully updated',
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
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
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);

            $todo->update([
                'is_complete' => TodoList::STATUS_UNCOMPLETED
            ]);

            DB::commit();

            $notification = [
                'status' => 200,
                'message' => 'Todo status successfully updated',
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
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
        if (!request()->has('user_id') || !request()->has('token')) {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user id and token."
            ], 200);
        }

        DB::beginTransaction();

        try {

            $todo = TodoList::findOrFail($id);
            $todo->delete();

            DB::commit();

            $notification = [
                'status' => 200,
                'message' => 'Todo successfully deleted',
            ];
            
            return response()->json($notification, 200);

        } catch(\Exception $e) {

            DB::rollback();

            $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());

            $notification = [
                'message' => $message,
            ];
            
            return response()->json($notification);
        }
    }
}
