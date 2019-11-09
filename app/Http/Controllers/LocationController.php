<?php

namespace App\Http\Controllers;

use App\Http\Requests\Locations\CreateRequest;
use App\Http\Requests\Locations\DeleteRequest;
use App\Http\Requests\Locations\ListRequest;
use App\Http\Requests\Locations\ShowRequest;
use App\Http\Requests\Locations\UpdateRequest;
use App\Repositories\Locations;
use App\Traits\ApiUtils;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    use ApiUtils;

    protected $locationsRepo;

    public function __construct()
    {
        $this->locationsRepo = new Locations();
    }

    /**
     * Show list of locations
     *
     * @param ListRequest $request
     *
     * @return JsonResponse
     */
    public function index(ListRequest $request)
    {
        $locationsSearch =
            $this
                ->locationsRepo
                ->search($request->query());

        if ($locationsSearch->hasError()) {
            return $this::errorResponse(
                $locationsSearch->getApiErrorCode()
            );
        }

        return $this::response($locationsSearch->getItems());
    }

    /**
     * Create a new location
     *
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateRequest $request)
    {
        $locationStore =
            $this
                ->locationsRepo
                ->create($request->all());

        if ($locationStore->hasError()) {
            return $this::errorResponse(
                $locationStore->getApiErrorCode()
            );
        }

        return $this::response($locationStore->getItems());
    }

    /**
     * Show details about a location
     *
     * @param ShowRequest $request
     *
     * @return JsonResponse
     */
    public function show(ShowRequest $request)
    {
        $locationShow =
            $this
                ->locationsRepo
                ->show($request->route('id'));

        if ($locationShow->hasError()) {
            return $this::errorResponse(
                $locationShow->getApiErrorCode()
            );
        }

        return $this::response($locationShow->getItems());
    }

    /**
     * Update a location
     *
     * @param UpdateRequest $request
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request)
    {
        $locationUpdate =
            $this
                ->locationsRepo
                ->update($request->route('id'), $request->all());

        if ($locationUpdate->hasError()) {
            return $this::errorResponse(
                $locationUpdate->getApiErrorCode()
            );
        }

        return $this::response($locationUpdate->getItems());
    }

    /**
     * Delete a location
     *
     * @param DeleteRequest $request
     *
     * @return JsonResponse
     */
    public function delete(DeleteRequest $request)
    {
        $locationUpdate =
            $this
                ->locationsRepo
                ->delete($request->route('id'));

        if ($locationUpdate->hasError()) {
            return $this::errorResponse(
                $locationUpdate->getApiErrorCode()
            );
        }

        return $this::response($locationUpdate->getItems());
    }
}
