<?php

namespace App\Repositories;

use App\Car;
use App\Enums\ApiError;
use App\Enums\ApiErrorCodes;
use App\Enums\RoleIds;
use App\Location;
use App\Response\Locations\LocationDetails;
use App\Response\Partials\IdName;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpStatusCode;

class Locations extends Repository
{
    public function search(array $filters): RepositoryInterface
    {
        $nameFilter = $filters['name'] ?? '';
        $addressFilter = $filters['address'] ?? '';

        try {
            if (auth()->user()->role->id === RoleIds::BUSINESS_ID) {
                $locations = Location::where('user_id', '=', auth()->user()->id);
            } else {
                $locations = Location::where('id', '>=', 1);
            }

            if (!empty($nameFilter)) {
                $locations = Location::where('name', 'like', '%' . $nameFilter . '%');
            }

            if (!empty($addressFilter)) {
                $locations = Location::where('address', 'like', '%' . $addressFilter . '%');
            }

            $this->std200ListResponse->setItems(self::getLocationList($locations->get()));
        } catch (QueryException $exception) {
            Log::emergency('Error when getting the list of locations from DB', ['filters' => $filters], $exception);
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
            $location = Location::create([
                'email' => $requestData['email'],
                'name' => $requestData['name'],
                'address' => $requestData['address'],
                'latitude' => $requestData['latitude'],
                'longitude' => $requestData['longitude'],
                'phone_number' => $requestData['phoneNumber'],
                'user_id' => auth()->user()->id
            ]);
            // successful insert
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new IdName(
                $location->id,
                $location->name
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when inserting a new location into DB',
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
            $location = Location::find($id);
            // successful update
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new LocationDetails(
                $location->id,
                $location->email,
                $location->name,
                $location->address,
                $location->latitude,
                $location->longitude,
                $location->phone_number,
                self::getLocationTotalCarsNumber($location->id),
                self::getLocationAvailableCarsNumber($location->id),
                self::getRentedAvailableCarsNumber($location->id)
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when trying to find the location into the DB',
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
            $location = Location::find($id);
            $location->email = $requestData['email'];
            $location->name = $requestData['name'];
            $location->address = $requestData['address'];
            $location->latitude = $requestData['latitude'];
            $location->longitude = $requestData['longitude'];
            $location->phone_number = $requestData['phoneNumber'];
            $location->save();
            // successful update
            $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            $this->std200Response->setItem(new LocationDetails(
                $location->id,
                $location->email,
                $location->name,
                $location->address,
                $location->latitude,
                $location->longitude,
                $location->phone_number,
                self::getLocationTotalCarsNumber($location->id),
                self::getLocationAvailableCarsNumber($location->id),
                self::getRentedAvailableCarsNumber($location->id)
            ));
        } catch (QueryException $exception) {
            Log::emergency('Error when updating the location into DB',
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
            Location::find($id)
                ->delete();
        } catch (\Exception $exception) {
            Log::emergency('Error when deleting a location in DB', ['id' => $id, 'exception' => $exception->getMessage()]);
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

    public function getLocationName(int $id)
    {
        $name = Location::find($id)->name;

        return $name;
    }

    private function getLocationList(Collection $locations)
    {
        $locationDetailsList = [];

        if (!empty($locations)) {
            foreach ($locations as $location) {
                $locationDetailsList[] = new LocationDetails(
                    $location->id,
                    $location->email,
                    $location->name,
                    $location->address,
                    $location->latitude,
                    $location->longitude,
                    $location->phone_number,
                    self::getLocationTotalCarsNumber($location->id),
                    self::getLocationAvailableCarsNumber($location->id),
                    self::getRentedAvailableCarsNumber($location->id)
                );
            }
        }

        return $locationDetailsList;
    }

    private function getLocationTotalCarsNumber(int $id)
    {
        $location = Location::find($id);
        $allCars = $location->cars;

        return count($allCars);
    }

    private function getLocationAvailableCarsNumber(int $id)
    {
        $availableCars = Car::where('location_id', '=', $id)
            ->where('available', '=', true)
            ->get();

        return count($availableCars);
    }

    private function getRentedAvailableCarsNumber(int $id)
    {
        $rentedCars = Car::where('location_id', '=', $id)
            ->where('available', '=', false)
            ->get();

        return count($rentedCars);
    }
}
