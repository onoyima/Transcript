<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StudentTrans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Staff::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::login($admin);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login_failed' => 'Invalid email or password']);
    }

    public function showDashboard()
    {
        $applications = StudentTrans::all();
        return view('admin.dashboard', compact('applications'));
    }

    public function updateApplicationStatus(Request $request)
    {
        $application = StudentTrans::find($request->application_id);
        $application->application_status = $request->status;
        $application->save();

        return redirect()->route('admin.dashboard');
    }
}
