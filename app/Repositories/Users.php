<?php

namespace App\Repositories;

use App\Enums\ApiError;
use App\Enums\ApiErrorCodes;
use App\Response\Partials\IdName;
use App\Response\Users\UserDetails;
use App\Role;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpStatusCode;

class Users extends Repository
{
    public function create(array $requestData)
    {
        try {
            $user = User::create([
                'email' => $requestData['email'],
                'password' => bcrypt($requestData['password']),
                'first_name' => $requestData['firstName'],
                'last_name' => $requestData['lastName'],
                'birth_date' => $requestData['birthDate'],
                'phone_number' => $requestData['phoneNumber'],
                'role_id' => $requestData['role']
            ]);
            // successful insert
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $user->createToken(config('app.name'))->accessToken;
            $this->std200Response->setItem([
                new IdName(
                    $user->id,
                    $this->getUserFullName($user)
                )
            ]);
        } catch (QueryException $exception) {
            dd($exception);
            Log::emergency('Error when inserting a new user into DB',
                [
                    'requestData' => $requestData,
                    'exception' => $exception->getMessage()
                ]
            );
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD500;
            $this->apiErrorCode = ApiError::CREATION_FAILURE;
        }

        return (new Repository())
            ->setItems($this->std200Response)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    public function show()
    {
        try {
            $user = User::find(auth()->user()->id);
            // successful update
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new UserDetails(
                $user->id,
                $user->email,
                $user->first_name,
                $user->last_name,
                $user->birth_date,
                $user->phone_number,
                $this->getUserRoleName($user->role_id)
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when trying to find the user into the DB',
                [
                    'id' => auth()->user()->id,
                    'exception' => $exception->getMessage()
                ]
            );
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD400;
            $this->apiErrorCode = ApiError::NOT_FOUND;
            $this->httpStatusCode = HttpStatusCode::HTTP_NOT_FOUND;
        }

        return (new Repository())
            ->setItems($this->std200Response)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    public function update(array $requestData)
    {
        try {
            $user = User::find(auth()->user()->id);
            $user->email = $requestData['email'];
            $user->password = bcrypt($requestData['password']);
            $user->first_name = $requestData['firstName'];
            $user->last_name = $requestData['lastName'];
            $user->birth_date = $requestData['birthDate'];
            $user->phone_number = $requestData['phoneNumber'];
            $user->save();
            // successful update
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new UserDetails(
                $user->id,
                $user->email,
                $user->first_name,
                $user->last_name,
                $user->birth_date,
                $user->phone_number,
                $this->getUserRoleName($user->role_id)
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when updating the user into DB',
                [
                    'requestData' => $requestData,
                    'exception' => $exception->getMessage()
                ]
            );
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD500;
            $this->apiErrorCode = ApiError::COULD_NOT_UPDATE;
        }

        return (new Repository())
            ->setItems($this->std200Response)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    private function getUserFullName(User $user)
    {
        return $user->first_name . ' ' . $user->last_name;
    }

    private function getUserRoleName($roleId) {
        return Role::find($roleId)->name;
    }
}
