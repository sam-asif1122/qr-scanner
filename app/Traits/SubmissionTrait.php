<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use App\Models\Document;
use App\Models\Enums\SubmissionStatusEnum;
use Zxing\QrReader;

trait SubmissionTrait
{
    public function processSubmission($imagePath, $content)
    {
        $submission = new Submission();
        $submission->code = fake()->uuid();
        $submission->user_id = Auth::id();
        $submission->content = $content;

        if ($submission->save()) {
            $destinationPath = 'uploads';
            $documentName = strval(date("Y-m-d H:i:s").'_'.$imagePath->getClientOriginalName());
            $imagePath->move($destinationPath, $documentName);

            $document = new Document();
            $document->path = $imagePath;
            $document->user_id = Auth::id();
            $document->submission_id = $submission->id;
            $document->document_name = $documentName;

            if ($document->save()) {
                $submission->status = SubmissionStatusEnum::Processed->value;
                $submission->save();
            } else {
                $submission->status = SubmissionStatusEnum::Error->value;
                $submission->save();
            }
        }

        return $submission;
    }

    public function processUpdateSubmission($submission, $imagePath, $content)
    {
        $submission->content = $content;

        if ($submission->update()) {
            $destinationPath = 'uploads';
            $imagePath->move($destinationPath, $imagePath->getClientOriginalName());

            $submission->document->path = $imagePath;
            $documentName = strval(date("Y-m-d H:i:s").'_'.$imagePath->getClientOriginalName());
            $submission->document->document_name = $documentName;

            if ($submission->document->update()) {
                $submission->status = SubmissionStatusEnum::Processed->value;
                $submission->save();
            } else {
                $submission->status = SubmissionStatusEnum::Error->value;
                $submission->save();
            }
        }

        return $submission;
    }
}
