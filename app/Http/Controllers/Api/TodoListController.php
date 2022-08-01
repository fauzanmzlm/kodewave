<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todoLists = TodoList::latest()->paginate(6);
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Todo list successfully retrieved"
            ],
            "todos" => $todoLists
        ], 200);
    }

    public function total(Request $request)
    {
        $user_id = $request->user_id;
        $todoListsTotal = TodoList::where('user_id', $user_id)->count();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Todo list successfully retrieved"
            ],
            "total" => $todoListsTotal
        ], 200);
    }

    public function totalUncompleted(Request $request)
    {
        $user_id = $request->user_id;
        $status = TodoList::STATUS_UNCOMPLETED;
        $todoListsTotal = TodoList::where('user_id', $user_id)->where('is_complete', $status)->count();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Todo list successfully retrieved"
            ],
            "total" => $todoListsTotal
        ], 200);
    }

    public function totalCompleted(Request $request)
    {
        $user_id = $request->user_id;
        $status = TodoList::STATUS_COMPLETED;
        $todoListsTotal = TodoList::where('user_id', $user_id)->where('is_complete', $status)->count();
        return response()->json([
            "response" => [
                "status"    => 200,
                "message"   => "Todo list successfully retrieved"
            ],
            "total" => $todoListsTotal
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTodoRequest $request)
    {
        $todo = TodoList::create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'is_complete' => 2,
        ]);

        return response()->json([
            'message' => 'Todo successfully added!',
            'todo' => $todo,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (request()->has('user_id') && request()->has('token')) {

            $todoLists = TodoList::where('user_id', request()->user_id)->latest()->get();

            return response()->json([
                "todos" => $todoLists,
                "status"    => 200,
                "message"   => "Todo list successfully retrieved"
            ], 200);
        } else {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user_id and token."
            ], 200);
        }
        
    }

    public function specificShow($id)
    {
        if (request()->has('user_id') && request()->has('token')) {

            $todo = TodoList::find($id);

            return response()->json([
                "todo" => $todo,
                "status"    => 200,
                "message"   => "Todo successfully retrieved"
            ], 200);
        } else {
            return response()->json([
                "status"    => 200,
                "message"   => "Make sure you provide paramter user_id and token."
            ], 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreTodoRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTodoRequest $request, $id)
    {
        $todo = TodoList::find($id);
        $todo->update([
            'body' => $request->body
        ]);

        return response()->json([
            "status"    => 200,
            "message"   => "Todo successfully updated!"
        ], 200);
    }

    public function complete($id)
    {
        $todo = TodoList::find($id);
        $todo->update([
            'is_complete' => TodoList::STATUS_COMPLETED
        ]);

        return response()->json([
            "status"    => 200,
            "message"   => "Well done for completed your todo!"
        ], 200);
    }

    public function uncomplete($id)
    {
        $todo = TodoList::find($id);
        $todo->update([
            'is_complete' => TodoList::STATUS_UNCOMPLETED
        ]);

        return response()->json([
            "status"    => 200,
            "message"   => "Todo status has been updated!"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = TodoList::find($id);
        $todo->delete();

        return response()->json([
            "status"    => 200,
            "message"   => "Todo list successfully deleted"
        ], 200);
    }
}
