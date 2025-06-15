<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Models\User;
use Illuminate\Http\Request;

class SuperDashController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // Protect this route for authenticated users
    }

    public function index()
    {
        $usersCount = User::count();
        $ordersCount = 150; // Replace with actual Order::count() if you have an Order model
        $revenue = 725000.50; // Replace with real revenue logic

        return view('auth.superdash', compact('usersCount', 'ordersCount', 'revenue'));
    }

    
}
