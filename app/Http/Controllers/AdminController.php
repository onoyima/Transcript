<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\StudentTrans;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        // Logic for staff login
        $staff = Staff::where('username', $request->username)
                    ->where('password', $request->password)
                    ->first();

        if ($staff) {
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid login credentials.');
    }

    public function dashboard()
    {
        $applications = StudentTrans::all();
        return view('admin.dashboard', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $application = StudentTrans::find($id);
        $application->payment_status = $request->payment_status;
        $application->application_status = $request->application_status;
        $application->save();

        return redirect()->route('admin.dashboard');
    }
}
