<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest\SigninRequest;
use App\Http\Requests\AccountRequest\SignupRequest;
use App\Http\Resources\UserResource;
use App\Models\Profile;
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

    public function isLogged(Request $request): bool
    {
        $user = auth('sanctum')->user();
        if ($user) {
            return true;
        } else {
            return false;
        }
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
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->display_name = $user->username;
        $profile->avatar = 'img4.jpg';
        $profile->save();
        return __("Đăng ký thành công");
    }

    public function getTimeMember($id)
    {
        $user = User::find($id);
        return $user->created_at->diffForHumans();
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
                'user' => UserResource::make($user),
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
        return response()->json(UserResource::make($user));

    }

    public function updateProfile(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $destinationPath = public_path('/assets/avatar');
            $fileName = $request->user_id . $file->getClientOriginalExtension();;
            $file->move($destinationPath, $fileName);
            Profile::where('user_id', $request->user_id)->update([
                'avatar' => 'assets/avatar/' . $fileName,
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);
        } else {
            Profile::where('user_id', $request->user_id)->update([
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);
        }
        return response()->json(UserResource::make(User::find($request->user_id)));
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
