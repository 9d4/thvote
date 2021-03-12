<?php

namespace App\Traits;

use App\Models\Photo;

trait CandidateTrait {
    public static function getCandidatePhoto($candidate_id) {
        return Photo::query()->where('candidate_id', $candidate_id)->first()->img;
    }
}
