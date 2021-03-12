<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    public function addNewCandidate(Request $request)
    {
        $url = $request->fullUrl();
        switch ($url) {
            case route('admin.newLeader'):
                $type_id = 1;
                break;
            case route('admin.newCoLeader'):
                $type_id = 2;
                break;
        }

        $rules = [
            'number' => 'required',
            'name' => 'required',
            'vision' => 'required',
            'mission' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jfif,jpeg,svg|max:3000',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        // No errors and continue
        $data = $validator->validate();

        // Check if number exists
        $exists = count(Candidate::query()
            ->where('type_id', $type_id)
            ->where('number', $data['number'])
            ->get());
        if ($exists) {
            return back()
                ->withInput()
                ->with('numberExists', true);
        }

        $query = Candidate::create([
            'number' => $data['number'],
            'name' => $data['name'],
            'vision' => $data['vision'],
            'mission' => $data['mission'],
            'type_id' => $type_id,
        ]);

        Photo::create([
            'img' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($request->file('photo'))),
            'candidate_id' => $query->id,
        ]);

        return back();
    }

    public function showCandidates(Request $request)
    {
        $url = $request->fullUrl();
        switch ($url) {
            case route('admin.leaders'):
                $type_id = 1;
                $view = 'dash.leaders';
                break;
            case route('admin.coLeaders'):
                $type_id = 2;
                $view = 'dash.coLeaders';
                break;
        }

        $candidates = Candidate::query()
            ->where('type_id', $type_id)
            ->orderBy('number')
            ->get();

        // set photo data uri
        foreach ($candidates as $candidate) {
            $img_raw = Photo::query()->where('candidate_id', $candidate->id)->first()->img;
            $data_uri = $img_raw;

            $candidate->photo = $data_uri;
        }

        $out = [
            'candidates' => $candidates,
        ];

        return view($view, $out);
    }

    public function deleteCandidate(Request $request, $id)
    {
        if (Candidate::find($id))
            Candidate::destroy($id);
        return back();
    }
}
