<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class AuthController extends BaseController
{
    #[OA\Post(
        path: "/api/signup",
        summary: "Register a new user",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John Doe"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "secret123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User registered successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function signup(UserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'status' => true,
            'data' => $user,
        ], 200);

    }

    #[OA\Post(
        path: "/api/login",
        summary: "Authenticate user and get token",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "secret123")
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "User logged in successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User Logged in Successfully"),
                        new OA\Property(property: "token", type: "string", example: "1|abcdef123456..."),
                        new OA\Property(property: "token_type", type: "string", example: "bearer")
                    ]
                )
            ),
            new OA\Response(response: 403, description: "Invalid credentials")
        ]
    )]
    public function login(LoginRequest $request)
    {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'User Logged in Successfully',
                'token' => $authUser->createToken('API Token')->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Emial & Password does not matched',
            ], 403);
        }
    }

    #[OA\Post(
        path: "/api/logout",
        summary: "Logout the authenticated user",
        tags: ["Authentication"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "User logged out successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "User Logged out Successfully"),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'date' => $user,
            'message' => 'User Logged out Successfully',
        ], 200);
    }
}
