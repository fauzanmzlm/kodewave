<?php

namespace App\Http\Controllers;

use App\TodoList;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_admin = null;
        $total_user = null;

        if (auth()->user()->role == User::ROLE_ADMIN) {
            $total_admin = User::totalAdmin();
            $total_user = User::totalUser();
        }
        
        return view('dashboard.index', compact('total_admin','total_user'));
    }
}
