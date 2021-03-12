<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Meta;
use App\Models\Type;
use App\Models\Vote;
use App\Traits\HelpTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function startVote()
    {
        Meta::query()
            ->where(['key' => 'vote_running'])
            ->update(['boolean' => true]);

        Meta::query()
            ->where(['key' => 'vote_reset'])
            ->update(['boolean' => false]);

        return back();
    }

    public function stopVote()
    {
        Meta::query()
            ->where(['key' => 'vote_running'])
            ->update(['boolean' => false]);

        Meta::query()
            ->where(['key' => 'vote_finish'])
            ->update(['boolean' => true]);

        return back();
    }

    public function pauseVote()
    {
        Meta::query()
            ->where(['key' => 'vote_running'])
            ->update(['boolean' => false]);

        return back();
    }

    public function resetVote()
    {
        Meta::query()
            ->where(['key' => 'vote_running'])
            ->update(['boolean' => false]);

        Meta::query()
            ->where(['key' => 'vote_finish'])
            ->update(['boolean' => false]);

        Meta::query()
            ->where(['key' => 'vote_reset'])
            ->update(['boolean' => true]);

        Candidate::query()->whereNotNull('id')->delete();

        return back();
    }

    public function showResult()
    {
        $types = Type::all();
        $results = null;

        foreach ($types as $_type) {
            $candidates_in_this_type = $_type->Candidates()->sortBy('number');
            $total_voter_in_this_type = HelpTrait::getTotalVotersOfType($_type->id);

            foreach ($candidates_in_this_type as $_candidate) {
                $_candidate->voters = HelpTrait::getTotalVotersOfCandidate($_candidate->id);

                if ($total_voter_in_this_type) {
                    $_candidate->percentage = ($_candidate->voters / $total_voter_in_this_type) * 100;
                    $_candidate->percentage = number_format($_candidate->percentage, 1) . '%';
                } else {
                    $_candidate->percentage = '0%';
                }
            }

            $_type->total_voter = $total_voter_in_this_type;
            $_type->candidates = $candidates_in_this_type;
            $results[] = $_type;
        }

        $out = [
            'results' => $results,
        ];
        return view('dash.result', $out);
    }

    public function doVote(Request $request)
    {
        if (!HelpTrait::isVoteRunning()) {
            return back()->with([
                'voting_stopped' => true,
            ]);
        }

        $validator = Validator::make($request->only('candidate_id'), [
            'candidate_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors());
        }

        if (!$candidate = Candidate::find($request->candidate_id)) {
            return back()
                ->with(['candidate_not_found' => true]);
        }

        // No errors and continue
        $user_id = auth()->user()->id;
        $data = $validator->validate();
        $type_id = $candidate->type_id;

        if (Vote::query()
            ->where('type_id', $type_id)
            ->where('user_id', $user_id)
            ->exists()) {
            return back()->with([
                'already_voted' => true,
                'type_string' => Type::find($type_id)->type,
            ]);
        }

        Vote::create([
            'type_id' => $type_id,
            'candidate_id' => $candidate->id,
            'user_id' => $user_id,
        ]);

        return back()->with(['success' => true]);
    }

    /* This will sanitize unverified user */
    public function verifyVote()
    {
        $votes = Vote::all();

        foreach ($votes as $vote) {
            if (!HelpTrait::isUserVerified($vote->voterUsername())) {
                Vote::destroy($vote->id);
            }
        }

        return back()->with(['clear' => true]);
    }
}
