<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Traits\HasExceptionHandling;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HasExceptionHandling;

    public function register(UserRegistrationRequest $request)
    {
        DB::beginTransaction();
        try {
            $credentials = $request->validated();
            $credentials['password'] = Hash::make($credentials['password']);


            $user = User::create($credentials);
            $token = $user->createToken('access_token')->plainTextToken;

            DB::commit();
            return response()->json([
                'message' => 'user created successfully',
                'success' => true,
                'user' => $user,
                'token' => $token,
            ], 201);
        } catch (Exception $e) {

            DB::rollBack();
            return $this->handleExceptions($e);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if (
            !$user
            || !Hash::check($request->password, $user->password)
        ) {

            return response()->json([
                'message' => 'invalid credentials',
                'error' => 'unauthenticated',
            ], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout()
    {
        $user = Auth::user();

        $user->tokens()->delete();

        return response()->json(null, 204);
    }
}