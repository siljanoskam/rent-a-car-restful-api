<?php

namespace App\Repositories;

use App\Car;
use App\Enums\ApiError;
use App\Enums\ApiErrorCodes;
use App\Enums\RoleIds;
use App\Response\Cars\CarDetails;
use App\Response\Partials\IdName;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpStatusCode;

class Cars extends Repository
{
    protected $locationsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->locationsRepository = new Locations();
    }

    public function search(array $filters): RepositoryInterface
    {
        $availableFilter = $filters['available'] ?? null;
        $rentedFilter = $filters['rented'] ?? null;
        $locationFilter = $filters['location'] ?? null;
        $minPriceFilter = $filters['minPrice'] ?? null;
        $maxPriceFilter = $filters['maxPrice'] ?? null;
        $brandFilter = $filters['brand'] ?? null;
        $modelFilter = $filters['model'] ?? null;
        $yearFilter = $filters['year'] ?? null;

        try {
            if (auth()->user()->role->id === RoleIds::BUSINESS_ID) {
                $cars = Car::where('user_id', '=', auth()->user()->id);
            } else {
                $cars = Car::where('id', '>=', 1);
            }

            if ($availableFilter) {
                $cars = Car::where('available', '=', $availableFilter);
            }

            // only the rented cars for the user who's logged in
            if ($rentedFilter) {
                $cars = Car::where('user_id', '=', auth()->user()->id)
                    ->where('rented', '=', $rentedFilter);
            }

            if (!empty($locationFilter)) {
                $cars = Car::where('location', '=', $locationFilter);
            }

            if (!empty($minPriceFilter) && !empty($maxPriceFilter)) {
                $cars = Car::where('price', '>=', $minPriceFilter)
                    ->where('price', '<=', $maxPriceFilter);
            }

            if (!empty($brandFilter)) {
                $cars = Car::where('brand', '=', $brandFilter);
            }

            if (!empty($modelFilter)) {
                $cars = Car::where('model', '=', $modelFilter);
            }

            if (!empty($yearFilter)) {
                $cars = Car::where('year', '=', $yearFilter);
            }

            $this->std200ListResponse->setItems(self::getCarList($cars->get()));
        } catch (QueryException $exception) {
            Log::emergency('Error when getting the list of cars from DB', ['filters' => $filters, 'exception' => $exception->getMessage()]);
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD500;
            $this->apiErrorCode = ApiError::LIST_FAILURE;
        }

        return (new Repository())
            ->setItems($this->std200ListResponse)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    public function create(array $requestData): RepositoryInterface
    {
        try {
            $car = Car::create([
                'brand' => $requestData['brand'],
                'model' => $requestData['model'],
                'year' => $requestData['year'],
                'fuel_type' => $requestData['fuelType'],
                'price' => $requestData['price'],
                'available' => $requestData['available'],
                'location_id' => $requestData['locationId'],
                'user_id' => auth()->user()->id
            ]);
            // successful insert
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new IdName(
                $car->id,
                $car->brand . ' ' . $car->model
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when inserting a new car into DB',
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

    public function show(int $id): RepositoryInterface
    {
        try {
            $car = Car::find($id);
            // successful update
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new CarDetails(
                $car->id,
                $car->brand,
                $car->model,
                $car->year,
                $car->fuel_type,
                $car->price,
                $car->available,
                $this->locationsRepository->getLocationName($car->location_id)
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when trying to find the car into the DB',
                [
                    'id' => $id,
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

    public function update(int $id, array $requestData): RepositoryInterface
    {
        try {
            $car = Car::find($id);
            $car->brand = $requestData['brand'];
            $car->model = $requestData['model'];
            $car->year = $requestData['year'];
            $car->fuel_type = $requestData['fuelType'];
            $car->price = $requestData['price'];
            $car->available = $requestData['available'];
            $car->location_id = $requestData['locationId'];
            $car->save();
            // successful update
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new CarDetails(
                $car->id,
                $car->brand,
                $car->model,
                $car->year,
                $car->fuel_type,
                $car->price,
                $car->available,
                $this->locationsRepository->getLocationName($car->location_id)
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when updating the car into DB',
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

    public function delete(int $id): RepositoryInterface
    {
        try {
            Car::find($id)
                ->delete();
        } catch (\Exception $exception) {
            Log::emergency('Error when deleting a car in DB', ['id' => $id, 'exception' => $exception->getMessage()]);
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD500;
            $this->apiErrorCode = ApiError::COULD_NOT_DELETE;
            $this->httpStatusCode = HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR;
        }

        return (new Repository())
            ->setItems($this->stdEmptyResponse)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    public function getCarName(int $id)
    {
        $car = Car::find($id);

        $brand = $car->brand;
        $model = $car->model;

        return $brand . ' ' . $model;
    }

    private function getCarList(Collection $cars)
    {
        $carDetailsList = [];

        if (!empty($cars)) {
            foreach ($cars as $car) {
                $carDetailsList[] = new CarDetails(
                    $car->id,
                    $car->brand,
                    $car->model,
                    $car->year,
                    $car->fuel_type,
                    $car->price,
                    $car->available,
                    $this->locationsRepository->getLocationName($car->location_id)
                );
            }
        }

        return $carDetailsList;
    }
}
