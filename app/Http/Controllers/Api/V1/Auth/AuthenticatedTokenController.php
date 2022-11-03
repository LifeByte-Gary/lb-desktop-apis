<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthenticatedTokenController extends Controller
{
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $user = $request->user();

        return response()->json(['token' => $user->createToken('Login')]);
    }

    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
