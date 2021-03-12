<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Traits\CandidateTrait;
use App\Traits\HelpTrait;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = auth()->user()->role == 'admin';

        if (HelpTrait::hasVoteFinished()) {
            $results = HelpTrait::getResults();
            $out = [
                'results' => $results,
                'user' => $user,
                'admin' => $isAdmin,
            ];
            return view('user.index', $out);
        }

        $leaders = Candidate::query()->where('type_id', 1)->orderBy('number')->get();
        $co_leaders = Candidate::query()->where('type_id', 2)->orderBy('number')->get();
        $leader_voted = HelpTrait::hasCurrentUserVoted(1);
        $co_leader_voted = HelpTrait::hasCurrentUserVoted(2);


        foreach ($leaders as $_item) {
            $_item->photo = CandidateTrait::getCandidatePhoto($_item->id);
            $_item->type_voted = $leader_voted;
        }

        foreach ($co_leaders as $_item) {
            $_item->photo = CandidateTrait::getCandidatePhoto($_item->id);
            $_item->type_voted = $co_leader_voted;
        }

        $out = [
            'leaders' => $leaders,
            'co_leaders' => $co_leaders,
            'leader_voted' => $leader_voted,
            'co_leader_voted' => $co_leader_voted,
            'user' => $user,
            'admin' => $isAdmin,
        ];
        return view('user.index', $out);
    }
}
