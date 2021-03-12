<?php

namespace App\Traits;

use App\Models\Candidate;
use App\Models\Meta;
use App\Models\Type;
use App\Models\VerifiedUsername;
use App\Models\Vote;
use Carbon\Carbon;

trait HelpTrait
{
    public static function hasCurrentUserVoted(int $type_id): bool
    {
        $user = auth()->user();

        if (count(Vote::query()
            ->where('type_id', $type_id)
            ->where('user_id', $user->id)
            ->get())) {
            return true;
        }

        return false;
    }

    public static function getBannerImage(): string
    {
        return Meta::query()->where('key', 'banner')->first()->longText;
    }

    public static function isVoteRunning(): bool
    {
        return Meta::query()->where('key', 'vote_running')->first()->boolean;
    }

    public static function isVotePaused(): bool
    {
        return (!self::isVoteRunning()) && (!self::hasVoteFinished()) && (!self::isVoteReset());
    }

    public static function isVoteReset(): bool
    {
        return Meta::query()->where('key', 'vote_reset')->first()->boolean;
    }

    public static function hasVoteFinished(): bool
    {
        return Meta::query()->where('key', 'vote_finish')->first()->boolean;
    }

    public static function getCandidateTypeId(int $candidate_id): int
    {
        return Candidate::find($candidate_id)->type_id;
    }

    public static function getTotalVotersOfType(int $type_id): int
    {
        return count(Vote::query()->where('type_id', $type_id)->get());
    }

    public static function getTotalVotersOfCandidate(int $candidate_id): int
    {
        $type_id = self::getCandidateTypeId($candidate_id);

        return count(Vote::query()
            ->where('candidate_id', $candidate_id)
            ->where('type_id', $type_id)
            ->get());
    }

    public static function getResults(): array
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

        return $results;
    }

    public static function getDeadline(): string
    {
        return Meta::query()->where('key', 'deadline')->first()->datetime;
    }

    public static function getDeadlineForInput(): string
    {
        return str_replace(' ', 'T', self::getDeadline());
    }

    public static function removeVerifiedUser(string $username): void
    {
        VerifiedUsername::query()->where('username', $username)->delete();
        return;
    }

    public static function addVerifiedUser(string $username)
    {
        return VerifiedUsername::create([
            'username' => $username,
        ]);
    }

    public static function isCurrentUserVerified(): bool
    {
        $found = VerifiedUsername::query()->where('username', auth()->user()->username)->first();
        if (!$found) {
            return false;
        }
        return true;
    }

    public static function isUserVerified($username)
    {
        if (VerifiedUsername::query()->where('username', $username)->first())
            return true;
        return false;
    }

    public static function temp()
    {
//        $verified_usernames_collection =  VerifiedUsername::query()->get('username');
//
//        foreach ($verified_usernames_collection as $item) {
//            $verified_usernames_arr[] = $item->username;
//        }
//
//        return in_array(, $verified_usernames_arr);
    }
}
