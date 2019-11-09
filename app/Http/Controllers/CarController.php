<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cars\CreateRequest;
use App\Http\Requests\Cars\DeleteRequest;
use App\Http\Requests\Cars\ListRequest;
use App\Http\Requests\Cars\ShowRequest;
use App\Http\Requests\Cars\UpdateRequest;
use App\Repositories\Cars;
use App\Traits\ApiUtils;
use Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    use ApiUtils;

    protected $carsRepository;

    public function __construct()
    {
        $this->carsRepository = new Cars();
    }

    /**
     * Show details about a car
     *
     * @param ListRequest $request
     *
     * @return JsonResponse
     */
    public function index(ListRequest $request)
    {
        $carsSearch =
            $this
                ->carsRepository
                ->search($request->query());

        if ($carsSearch->hasError()) {
            return $this::errorResponse(
                $carsSearch->getApiErrorCode()
            );
        }

        return $this::response($carsSearch->getItems());
    }

    /**
     * Create a new car
     *
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $carStore =
            $this
                ->carsRepository
                ->create($request->all());

        if ($carStore->hasError()) {
            return $this::errorResponse(
                $carStore->getApiErrorCode()
            );
        }

        return $this::response($carStore->getItems());
    }

    /**
     * Show details about a car
     *
     * @param ShowRequest $request
     *
     * @return JsonResponse
     */
    public function show(ShowRequest $request)
    {
        $carShow =
            $this
                ->carsRepository
                ->show($request->route('id'));

        if ($carShow->hasError()) {
            return $this::errorResponse(
                $carShow->getApiErrorCode()
            );
        }

        return $this::response($carShow->getItems());
    }

    /**
     * Update a car
     *
     * @param UpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $carUpdate =
            $this
                ->carsRepository
                ->update($request->route('id'), $request->all());

        if ($carUpdate->hasError()) {
            return $this::errorResponse(
                $carUpdate->getApiErrorCode()
            );
        }

        return $this::response($carUpdate->getItems());
    }

    /**
     * Delete a car
     *
     * @param DeleteRequest $request
     *
     * @return JsonResponse
     */
    public function delete(DeleteRequest $request)
    {
        $carUpdate =
            $this
                ->carsRepository
                ->delete($request->route('id'));

        if ($carUpdate->hasError()) {
            return $this::errorResponse(
                $carUpdate->getApiErrorCode()
            );
        }

        return $this::response($carUpdate->getItems());
    }
}
