<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lcobucci\JWT\Parser;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:api')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard();
    }

     /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        // $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new Response('', 204)
                    : redirect()->intended($this->redirectPath());
    }
    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $personalAccessToken = $user->createToken('Grant Client');

        return new Response([
            'token'=>$personalAccessToken->accessToken,
            'token_type'=>'Bearer'
        ],JsonResponse::HTTP_ACCEPTED);
    }
    public function logout(Request $request)
    {
        $value = $request->bearerToken();
            $tokenId = (new Parser())->parse($value)->getClaim('jti');
            
            $customer = auth('api')->user();
            $token = $customer->tokens->find($tokenId);
            
            $token->revoke();

            return new Response('', JsonResponse::HTTP_NO_CONTENT);
    }

}
