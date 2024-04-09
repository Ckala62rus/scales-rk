<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * tutorial => https://remotestack.io/laravel-sanctum-auth-and-crud-rest-api-tutorial/
 */
class AuthTokenController extends BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $auth = Auth::user();
            $success['token'] =  $auth->createToken('LaravelSanctumAuth')->plainTextToken;
            $success['name'] =  $auth->name;

            return $this->response(
                ['auth' => $success],
                'User logged-in!',
                true,
                ResponseAlias::HTTP_OK
            );
        }
        else{
            return $this->response(
                ['auth' => null],
                'Unauthorised',
                false,
                ResponseAlias::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return $this->response(
                [],
                'Validation error',
                true,
                ResponseAlias::HTTP_UNAUTHORIZED
            );
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('LaravelSanctumAuth')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->response(
            ['auth' => $success],
            'User successfully registered!',
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return $this->response(
            [],
            'Logout',
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = Auth::user();

        if ($user){
            return $this->response(
                ['user' => Auth::user()],
                'Current Auth user',
                true,
                ResponseAlias::HTTP_OK
            );
        }

        return $this->response(
            ['user' => null],
            'Current Auth user',
            false,
            ResponseAlias::HTTP_UNAUTHORIZED
        );
    }
}
