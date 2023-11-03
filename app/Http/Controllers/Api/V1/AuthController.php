<?php

namespace App\Http\Controllers\Api\V1;

use App\Contracts\Api\V1\AuthControllerDoc;
use App\Http\Controllers\Controller;
use App\Http\Resources\OptResource;
use App\Models\Opt;
use App\Models\User;
use App\Rules\CheckPhoneNumber;
use App\Services\Sms\Sms;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class AuthController extends Controller implements AuthControllerDoc
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'verify']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'mobile' => ['required', new CheckPhoneNumber()],
        ]);

        $user = User::firstOrCreate($data);

        $otp = $user->generateOpt();

        $status = Sms::send($user, 146184, $otp->code);

        return apiResponse()
            ->data([
                'status' => $status
            ])
            ->send();
    }


    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return apiResponse()
            ->data(auth()->user())
            ->send();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return apiResponse()
            ->message(__('auth.messages.successfully_logout'))
            ->send();
    }

    /**
     * Refresh a token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->respondWithToken(auth()->refresh());
    }

    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'code' => ['required', 'exists:opts'],
        ]);

        $dateTime = now()->subMinutes(3)->toDateTimeString();

        $opt = Opt::where('code', $request->code)
            ->where('expired_at', '>=', $dateTime)
            ->first();

        if ( ! $opt) {
            throw new BadRequestException('کد ارسال شده معتبر نمی باشد.');
        }

        return $this->respondWithToken(auth()->login($opt->user));
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return apiResponse()
            ->data(
                [
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]
            )->send();
    }
}
