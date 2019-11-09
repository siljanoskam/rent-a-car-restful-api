<?php

namespace App\Repositories;

use App\Enums\ApiError;
use App\Enums\ApiErrorCodes;
use App\Rent;
use App\Response\Partials\IdName;
use App\Response\Rents\RentDetails;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Response as HttpStatusCode;

class Rents extends Repository
{
    protected $locationsRepository;
    protected $carsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->locationsRepository = new Locations();
        $this->carsRepository = new Cars();
    }

    public function all(array $queryParameters): RepositoryInterface
    {
        $activeRentsFilter = $queryParameters['active'] ?? '';
        $finishedRentsFilter = $queryParameters['finished'] ?? '';

        try {
            $rents = Rent::where('user_id', '=', auth()->user()->id);

            if ($activeRentsFilter) {
                $rents = Rent::where('ending_date', '>', Date::now());
            }

            if ($finishedRentsFilter) {
                $rents = Rent::where('ending_date', '<', Date::now());
            }

            $this->std200ListResponse->setItems(self::getRentList($rents->get()));
        } catch (QueryException $exception) {
            Log::emergency('Error when getting the list of rents from DB', ['exception' => $exception]);
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
        if (!$this->userHasCarsRented(auth()->user()->id)) {
            try {
                Rent::create([
                    'start_date' => $requestData['startDate'],
                    'end_date' => $requestData['endDate'],
                    'starting_location' => $requestData['startingLocation'],
                    'ending_location' => $requestData['endingLocation'],
                    'car_id' => $requestData['carId'],
                    'user_id' => auth()->user()->id
                ]);
                // successful insert
                $this->std200Response->setStatusCode(HttpStatusCode::HTTP_CREATED);
            } catch (QueryException $exception) {
                Log::emergency('Error when inserting a new rent into DB',
                    [
                        'requestData' => $requestData,
                        'exception' => $exception->getMessage()
                    ]
                );
                $this->error = true;
                $this->errorType = ApiErrorCodes::STD500;
                $this->apiErrorCode = ApiError::CREATION_FAILURE;
            }
        } else {
            $this->error = true;
            $this->errorType = ApiErrorCodes::STD422;
            $this->apiErrorCode = ApiError::CREATION_FAILURE;
        }

        return (new Repository())
            ->setItems($this->stdEmptyResponse)
            ->setError($this->error)
            ->setErrorType($this->errorType)
            ->setApiErrorCode($this->apiErrorCode);
    }

    private function getRentList(Collection $rents)
    {
        $rentDetailsList = [];

        if (!empty($rents)) {
            foreach ($rents as $rent) {
                $rentDetailsList[] = new RentDetails(
                    $rent->id,
                    $rent->start_date,
                    $rent->end_date,
                    new IdName(
                        $rent->starting_location,
                        $this->locationsRepository->getLocationName($rent->starting_location)),
                    new IdName(
                        $rent->ending_location,
                        $this->locationsRepository->getLocationName($rent->ending_location)),
                    new IdName(
                        $rent->car_id,
                        $this->carsRepository->getCarName($rent->car_id))
                );
            }
        }

        return $rentDetailsList;
    }

    // Returns FALSE if the user does not have any cars rented at the moment
    private function userHasCarsRented(int $userId)
    {
        $activeRents = Rent::where('user_id', '=', $userId)
            ->where('end_date', '>=', Carbon::now()->toDateTimeString())
            ->get()
            ->toArray();

        return empty($activeRents) ? false : true;
    }
}
