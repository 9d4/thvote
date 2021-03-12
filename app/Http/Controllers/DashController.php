<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\VerifiedUsername;
use App\Models\Vote;
use App\Traits\HelpTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\TextUI\Help;

class DashController extends Controller
{
    public function dashboard()
    {
        $running = HelpTrait::isVoteRunning();
        $finish = HelpTrait::hasVoteFinished();
        $paused = HelpTrait::isVotePaused();
        $reset = HelpTrait::isVoteReset();

        $out = [
            'vote_running' => $running,
            'vote_finish' => $finish,
            'vote_paused' => $paused,
            'vote_reset' => $reset,
        ];
        return view('dash.index', $out);
    }

    public function changeBanner(Request $request)
    {
        $validator = Validator::make($request->only('banner_image'), [
            'banner_image' => 'required|image|mimes:jpg,png,jfif,jpeg,svg|max:3000',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator);
        }

        // No errors and continue
        $data = $validator->validate();
        $parsed_image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($data['banner_image']));

        Meta::query()
            ->where('key', 'banner')
            ->update([
                'longText' => $parsed_image,
            ]);

        return back()->with(['image_changed' => true]);
    }

    public function changeDeadline(Request $request)
    {
        $request->validate([
            'deadline' => 'required',
        ]);

        Meta::query()
            ->where('key', 'deadline')
            ->update(['datetime' => $request->deadline]);

        return back()->with(['deadline_changed' => true]);
    }

    public function initMeta()
    {
        DB::table('metas')->insert(['key' => 'vote_running']);
        DB::table('metas')->insert(['key' => 'deadline']);
//        Meta::create(['key' => '', 'value' => '']);
//        Meta::create(['key' => '', 'value' => '']);
//        Meta::create(['key' => '', 'value' => '']);
    }

    public function showVerifiedUsers()
    {
        $verified_usernames = VerifiedUsername::all()->sortBy('username');

        $out = [
            'verified_usernames' => $verified_usernames,
        ];
        return view('dash.verified-users', $out);
    }

    public function debug()
    {

        return HelpTrait::isUserVerified('999999');
    }
}
