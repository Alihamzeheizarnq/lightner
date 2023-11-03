<?php

namespace App\Contracts\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface AuthControllerDoc
{
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Auth"},
     *     summary="Login to get JWT token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"mobile"},
     *             @OA\Property(property="mobile", type="integer", example="09124567898"),
     *         )
     *     ),
     *        @OA\Response(response=200,description="Successful operation"),
     *        @OA\Response(response=400,description="Bad Request"),
     *        @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function login(Request $request): JsonResponse;
    /**
     * @OA\Get(
     *     path="/api/v1/auth/me",
     *     tags={"Auth"},
     *     summary="Get current user details",
     *     security={{ "bearerAuth": {} }},
     *          @OA\Response(response=200,description="Successful operation"),
     *          @OA\Response(response=401,description="Unauthenticated"),
     *          @OA\Response(response=403,description="Forbidden"),
     *          @OA\Response(response=404,description="Resource Not Found")
     *  )
     */
    public function me(): JsonResponse;
    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Auth"},
     *     summary="Logout the current user",
     *     security={{ "bearerAuth": {} }},
     *           @OA\Response(response=200,description="Successful operation"),
     *           @OA\Response(response=400,description="Bad Request"),
     *           @OA\Response(response=401,description="Unauthenticated"),
     *           @OA\Response(response=403,description="Forbidden"),
     *           @OA\Response(response=404,description="Resource Not Found")
     *   )
     */
    public function logout(): JsonResponse;

    /**
     * @OA\Post(
     *     path="/api/v1/auth/refresh",
     *     tags={"Auth"},
     *     summary="Refresh JWT token",
     *     security={{ "bearerAuth": {} }},
     *            @OA\Response(response=200,description="Successful operation"),
     *            @OA\Response(response=400,description="Bad Request"),
     *            @OA\Response(response=401,description="Unauthenticated"),
     *            @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function refresh(): JsonResponse;

    /**
     * @OA\Post(
     *     path="/api/v1/auth/verify",
     *     tags={"Auth"},
     *     summary="Login to get JWT token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"code"},
     *             @OA\Property(property="code", type="ineger", format="text", example="123456"),
     *         )
     *     ),
     *        @OA\Response(response=200,description="Successful operation"),
     *        @OA\Response(response=400,description="Bad Request"),
     *        @OA\Response(response=404,description="Resource Not Found")
     * )
     */
    public function verify(Request $request): JsonResponse;
}
