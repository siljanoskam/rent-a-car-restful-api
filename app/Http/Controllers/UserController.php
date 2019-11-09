<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateRequest;
use App\Repositories\Users;
use App\Traits\ApiUtils;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiUtils;

    protected $usersRepository;

    public function __construct()
    {
        $this->usersRepository = new Users();
    }

    /**
     * Show details about a user
     *
     * @return JsonResponse
     */
    public function show()
    {
        $userShow =
            $this
                ->usersRepository
                ->show();

        if ($userShow->hasError()) {
            return $this::errorResponse(
                $userShow->getApiErrorCode()
            );
        }

        return $this::response($userShow->getItems());
    }

    /**
     * Update a user
     *
     * @param UpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $userUpdate =
            $this
                ->usersRepository
                ->update($request->all());

        if ($userUpdate->hasError()) {
            return $this::errorResponse(
                $userUpdate->getApiErrorCode()
            );
        }

        return $this::response($userUpdate->getItems());
    }
}
