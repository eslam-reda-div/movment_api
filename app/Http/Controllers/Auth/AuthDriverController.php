<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthDriverController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Post(
     *     path="/api/auth/driver/login",
     *     summary="Driver Login",
     *     tags={"Driver Auth"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"phone_number","password"},
     *
     *             @OA\Property(property="phone_number", type="string", example="1234567890"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logged in successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Logged in successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="1|abcdef123456...")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=401, description="Invalid phone number or password"),
     *     @OA\Response(response=422, description="Validation Error"),
     *     @OA\Response(response=500, description="Could not create token")
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|exists:drivers,phone_number',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors()->toArray(), 422);
        }

        if (! auth('driver')->attempt($request->only('phone_number', 'password'))) {
            return $this->sendError('Invalid phone number or password', [], 401);
        }

        $driver = auth('driver')->user();

        try {
            $token = $driver->createToken('auth_token')->plainTextToken;
        } catch (\Exception $e) {
            return $this->sendError('Could not create token', [], 500);
        }

        return $this->sendResponse('Logged in successfully', ['token' => $token]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/driver/logout",
     *     summary="Driver Logout",
     *     tags={"Driver Auth"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logged out successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Logged out successfully"),
     *             @OA\Property(property="data", type="null")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        auth('driver')->user()->tokens()->delete();

        return $this->sendResponse('Logged out successfully', null);
    }
}
