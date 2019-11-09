<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rents\CreateRequest;
use App\Http\Requests\Rents\ListRequest;
use App\Repositories\Rents;
use App\Traits\ApiUtils;
use Illuminate\Http\JsonResponse;

class RentController extends Controller
{
    use ApiUtils;

    protected $rentsRepository;

    public function __construct()
    {
        $this->rentsRepository = new Rents();
    }

    /**
     * Show details about a rent
     *
     * @param ListRequest $request
     *
     * @return JsonResponse
     */
    public function index(ListRequest $request)
    {
        $rentsSearch =
            $this
                ->rentsRepository
                ->all($request->query());

        if ($rentsSearch->hasError()) {
            return $this::errorResponse(
                $rentsSearch->getApiErrorCode()
            );
        }

        return $this::response($rentsSearch->getItems());
    }

    /**
     * Create a new rent
     *
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $rentStore =
            $this
                ->rentsRepository
                ->create($request->all());

        if ($rentStore->hasError()) {
            return $this::errorResponse(
                $rentStore->getApiErrorCode()
            );
        }

        return $this::response($rentStore->getItems());
    }
}
