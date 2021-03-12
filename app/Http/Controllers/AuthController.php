<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HelpTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Psy\Util\Json;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'username' => 'bail|required|numeric|digits_between:5,11|unique:users',
            'password' => 'bail|required|min:6|confirmed',
            'password_confirmation' => 'required',
        ];
        $messages = [
            'username.min' => 'Minimal :min karakter',
            'username.unique' => 'Username sudah ada',
            'username.digits_between' => 'Rentang username antara :min sampai :max digit',
            'password.min' => 'Minimal :min karakter',
            'password.confirmed' => 'Konfirmasi sandi tidak cocok',
            'username.numeric' => 'Harus angka',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        // No errors and continue
        $credentials = $validator->validate();

        $user = User::create([
            'username' => $credentials['username'],
            'password' => Hash::make($credentials['password']),
            'role' => 'user',
        ]);

        // teacher mode
        if (count(str_split($credentials['username'])) >= 8) {
            HelpTrait::addVerifiedUser($user->username);
        }

        Auth::attempt($credentials);
        return redirect(route('index'));
    }

    public function login(Request $request)
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->errors());
        }

        // No errors and continue
        $credentials = $validator->validate();

        if (!Auth::attempt($credentials)) {
            return back()
                ->withInput()
                ->with('status', 'Data tidak ditemukan. Periksa kembali Username dan Password');
        }

        return redirect(route('index'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }
}
