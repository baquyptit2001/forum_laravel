<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest\SigninRequest;
use App\Http\Requests\AccountRequest\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(): string
    {
        return phpinfo();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @throws ValidationException
     */
    public function signUp(SignupRequest $request): string
    {
        $user = new User();
        $validator = $this->validate($request, array('*.email' => 'required|email', '*.username' => 'required', '*.password' => 'required'));
        $user->username = $request['data']['username'];
        $user->email = $request['data']['email'];
        $user->password = Hash::make($request['data']['password']);
        $user->save();
        return __("Đăng ký thành công");
    }

    public function signIn(SigninRequest $request)
    {
        try {

            $credentials = array(
                'username' => $request->data['username'],
                'password' => $request->data['password']
            );

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 500,
                    'message' => 'Tài khoản hoặc mật khẩu không đúng'
                ]);
            }

            $user = User::where('username', $request->data['username'])->first();

            if (!Hash::check($request->data['password'], $user->password, [])) {
                throw new \Exception('Tài khoản hoặc mật khẩu không đúng');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'user' => $user->only(['id', 'username', 'email']),
                'token_type' => 'Bearer',
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Đăng nhập thất bại',
                'error' => $error,
            ]);
        }
    }

    public function logOut(): \Illuminate\Http\JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'status_code' => 200,
                'message' => 'Đăng xuất thành công'
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Đăng xuất thất bại',
                'error' => $error,
            ]);
        }
    }

    public function getInfo(Request $request)
    {
        try {
            $tokens = PersonalAccessToken::findToken($request->bearerToken());
        } catch (\Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Invalid Token',
                'error' => $error,
            ]);
        }

        $user = $tokens->tokenable;
        return response()->json([
            'status_code' => 200,
            'data' => [
                'username' => $user->username,
                'email' => $user->email,
            ]
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
