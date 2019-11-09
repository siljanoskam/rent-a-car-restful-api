<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Auth;
use App\Traits\ApiUtils;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ApiUtils;

    protected $authRepository;

    public function __construct()
    {
        $this->authRepository = new Auth();
    }

    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $userRegister =
            $this
                ->authRepository
                ->register($request->all());

        if ($userRegister->hasError()) {
            return $this::errorResponse(
                $userRegister->getApiErrorCode()
            );
        }

        return $this::response($userRegister->getItems());
    }

    /**
     * Login a user
     *
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $userLogin =
            $this
                ->authRepository
                ->login($request->all());

        if ($userLogin->hasError()) {
            return $this::errorResponse(
                $userLogin->getApiErrorCode()
            );
        }

        return $this::response($userLogin->getItems());
    }
}
