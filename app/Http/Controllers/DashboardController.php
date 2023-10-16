<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use App\Models\Enums\SubmissionStatusEnum;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_submissions = Auth::user()->submissions()->count();
        $processed_submissions = Auth::user()->submissions()->where('status', SubmissionStatusEnum::Processed->value)->count();
        $processing_submissions = Auth::user()->submissions()->where('status', SubmissionStatusEnum::Processing->value)->count();
        $error_submissions = Auth::user()->submissions()->where('status', SubmissionStatusEnum::Error->value)->count();

        return view('dashboard', [
            'total_submissions' => $total_submissions,
            'processed_submissions' => $processed_submissions,
            'processing_submissions' => $processing_submissions,
            'error_submissions' => $error_submissions,
         ]);
    }
}
