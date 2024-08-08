<?php

namespace App\Facades;

use App\Models\Assignment;
use App\Models\Data;
use App\Models\Reviewer;
use App\Models\Values;

class ModelFacade
{
    public function getAssignmentsWithUsersAndReviewers($reviewerId, $paginate = 5)
    {
        return Assignment::with('getUsers', 'getReviewers')
            ->where('reviewer', $reviewerId)
            ->orderBy('id', 'DESC')
            ->paginate($paginate);
    }

    public function getAllValues()
    {
        return Values::get();
    }

    public function getReviewerAssignments($id, $finished)
    {
        return Reviewer::with('getAssignment', 'getData')
            ->where('id_assignments', $id)
            ->where('finish', $finished)
            ->get();
    }

    public function getAssignmentDetails($id)
    {
        return Assignment::with('getUsers', 'getReviewer')
            ->where('id', $id)
            ->first();
    }

    public function updateDataAndReviewer($dataId, $reviewerId, $dataUpdates, $reviewerUpdates)
    {
        Data::where('id', $dataId)->update($dataUpdates);
        Reviewer::where('id', $reviewerId)->update($reviewerUpdates);
    }
}
