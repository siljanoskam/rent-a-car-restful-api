<?php

namespace App\Repositories;

use App\Enums\ApiError;
use App\Enums\ApiErrorCodes;
use Illuminate\Http\Response as HttpStatusCode;

class Auth extends Repository
{
    protected $usersRepository;

    public function __construct()
    {
        parent::__construct();
        $this->usersRepository = new Users();
    }

    public function register(array $requestData)
    {
        return $this->usersRepository->create($requestData);
    }

    public function login(array $requestData)
    {
        $credentials = [
            'email' => $requestData['email'],
            'password' => $requestData['password']
        ];

        try {
            auth()->attempt($credentials);
            $token = auth()->user()->createToken(config('app.name'))->accessToken;
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_OK);
            $this->std200Response->setItem([
                'token' => $token
            ]);
        } catch (\Exception $exception) {
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD400;
            $this->apiErrorCode = ApiError::UNAUTHORIZED;
        }

        return (new Repository())
            ->setItems($this->std200Response)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    public function getLoggedInUser()
    {
        $this->std200Response->setItem([
            'user' => auth()->user()
        ]);

        return (new Repository())
            ->setItems($this->std200Response);
    }
}
