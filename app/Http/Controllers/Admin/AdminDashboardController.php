<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        /** @var User $admin */
        $admin = auth()->user();

        return view('admin.dashboard', [
            'admin' => $admin,
        ]);
    }
}
