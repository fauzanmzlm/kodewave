<?php

namespace App\Http\Controllers;

use App\TodoList;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_admin = User::totalAdmin();
        $total_user = User::totalUser();

        // get all current logged-in user todo lists
        $todo_lists = TodoList::where('user_id', 935)->paginate(10);

        return view('dashboard.index', compact('total_admin','total_user','todo_lists'));
    }

}
