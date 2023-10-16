<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmissionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use App\Models\Document;
use App\Models\Enums\SubmissionStatusEnum;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Zxing\QrReader;
use Illuminate\Support\Facades\Gate;
use App\Traits\SubmissionTrait;
use Illuminate\Contracts\Foundation\Application as ApplicationFoundation;


class SubmissionController extends Controller
{
    use SubmissionTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|ApplicationFoundation
    {
        $submissions = Auth::user()->submissions()->paginate(5);
        return view('submission.index', [
           'submissions' => $submissions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Application|Factory|ApplicationFoundation
    {
        return view('submission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubmissionRequest $request): RedirectResponse
    {
        try {
            // Decoding the QR scan file content
            $imagePath = $request->file('path');
            $qrcode = new QrReader($imagePath);
            $content = $qrcode->text();

            $submission = $this->processSubmission($imagePath, $content);

            return redirect('/submission')->with([
                'success' => __("Submission successfully created")
            ]);

        } catch (\Exception $e) {
            // Submission with an error status
            $submission = $this->processSubmission(null, null);
            
            return redirect('/submission')->with([
                'error' => __("Submission caused an error")
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Submission $submission)
    {
        Gate::authorize('view-submission', $submission);

        return view('submission.show', [
          'submission' => $submission,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        Gate::authorize('update-submission', $submission);

        return view('submission.edit', [
            'submission' => $submission,
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Submission $submission)
    {
        Gate::authorize('update-submission', $submission);

        try {
            // Decoding the QR scan file content
            $imagePath = $request->file('path');
            $qrcode = new QrReader($imagePath);
            $content = $qrcode->text();

            $submission = $this->processUpdateSubmission($submission, $imagePath, $content);

            return redirect('/submission')->with([
                'success' => __("Submission successfully updated")
            ]);

        } catch (\Exception $e) {
            // Submission with an error status
            $submission->status = SubmissionStatusEnum::Error->value;
            $submission->save();

            return redirect('/submission')->with([
                'error' => __("Submission caused an error")
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission): RedirectResponse
    {
        Gate::authorize('delete-submission', $submission);
        $submission->delete();
        $submission->document?->delete();

        return Redirect::back()->with([
            'success' => __("Submission successfully deleted")
        ]);
    }
}
