<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MpesaStk;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function index()
    {
    return view('admin.dashboard', [
        'totalUsers' => User::count(),
        'totalTransactions' => 0,
        'stkPushRequests' => MpesaStk::count(),
        'totalDeposits' => MpesaStk::where('status', 'success')->sum('amount'),
    ]);
}
}
