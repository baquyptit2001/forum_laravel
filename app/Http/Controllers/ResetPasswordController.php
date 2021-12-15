<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Notifications\ResetPasswordRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function sendMail(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = $this->validate($request, [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại',
        ]);

        $user = User::where('email', $request->email)->firstOrFail();
        $passwordReset = PasswordReset::updateOrCreate([
            'email' => $user->email,
        ], [
            'token' => Str::random(60),
        ]);
        if ($passwordReset) {
            $user->notify(new ResetPasswordRequest($passwordReset->token));
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'We have e-mailed your password reset link!'
        ]);
    }

    public function reset(Request $request, $token)
    {
        $validator = $this->validate($request, [
            'password' => 'required|between:6,16|confirmed',
        ], [
            'password.required' => 'Mật khẩu không được để trống',
            'password.between' => 'Mật khẩu phải có độ dài từ 6 đến 16 ký tự',
            'password.confirmed' => 'Mật khẩu không trùng khớp',
        ]);
        try {
            $passwordReset = PasswordReset::where('token', $token)->firstOrFail();
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
                $passwordReset->delete();

                return response()->json([
                    'message' => 'This password reset token is invalid.',
                ], 422);
            }
            $user = User::where('email', $passwordReset->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $passwordReset->delete();

            return response()->json([
                'status_code' => 200,
                'success' => $user->save(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi, vui lòng thử lại sau',
            ], 422);
        }
    }
}
