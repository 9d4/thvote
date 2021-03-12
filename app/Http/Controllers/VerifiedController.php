<?php

namespace App\Http\Controllers;

use App\Models\VerifiedUsername;
use App\Traits\HelpTrait;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class VerifiedController extends Controller
{
    public function removeVerifiedUser(Request $request)
    {
        $request->validate([
            'verified_username' => 'required',
        ]);

        HelpTrait::removeVerifiedUser($request->verified_username);
        return back();
    }

    public function addVerifiedUser(Request $request)
    {
        $request->validate([
            'verified_username' => 'required',
        ]);

        HelpTrait::addVerifiedUser($request->verified_username);
        return back();
    }
}
