<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\Enrollment;
use App\Services\WalletService;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    /**
     * Show the enrollment form for logged-in users.
     */
    public function create()
    {
        $programmingCount = Enrollment::where('course', 'Programming')->count();
        $graphicsCount = Enrollment::where('course', 'Graphics Design')->count();

        return view('student.enroll', compact('programmingCount', 'graphicsCount'));
    }

    /**
     * Handle the enrollment request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'course' => ['required', 'string', Rule::in(['Graphics Design', 'Programming'])],
        ]);

        if (now()->greaterThanOrEqualTo('2026-02-10')) {
            return back()->withErrors(['deadline' => 'Registration has closed for the 2026 session.']);
        }

        // Check Course Capacity
        $count = Enrollment::where('course', $request->course)->count();
        if ($count >= 30) {
            return back()->withErrors(['capacity' => "The $request->course course has reached its maximum capacity of 30 students."]);
        }

        $user = Auth::user();

        // 1. Check for existing enrollment
        if ($user->enrollment()->exists()) {
            return back()->withErrors(['enrollment' => 'You have already applied for a course.']);
        }

        // 2. Check wallet balance
        if ($user->wallet_balance < 25000) {
            return back()->withErrors(['wallet' => 'Insufficient wallet balance. Please fund your wallet with at least ₦25,000.']);
        }

        try {
            // 3. Debit Wallet
            $reference = 'ENROLL_' . Str::random(10);
            WalletService::debit($user, 25000, 'Application Fee for ' . $request->course, $reference);

            // 4. Create Enrollment
            Enrollment::create([
                'user_id' => $user->id,
                'course' => $request->course,
                'status' => 'pending',
                'transaction_reference' => $reference,
            ]);

            return redirect()->route('student.enroll')->with('status', 'enrollment-submitted');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred during enrollment: ' . $e->getMessage()]);
        }
    }
}
