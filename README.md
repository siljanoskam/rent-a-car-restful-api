# README

## Get started
1. Clone the repository
2. Create a docker image with the Dockerfile that is pushed to the repository by running the following command:
    
        docker image build <full-path-of-the-dockerfile>
    
3. Run a docker container with the created image by running the following command:

        docker run -dit -p 3000:80 -v "<full-path-of-the-repository>":/var/www/html --name rent-a-car <the-ID-of-the-created-image>
    
    * You can check the ID of the created image by running:
    
            docker images
            
4. Run a `mysql` docker container by running the following command:
        
        docker run --name mysql -e MYSQL_ROOT_PASSWORD=123 -d mysql:5.7

5. Create a docker network by running the following commands 
(we're doing this in order to allow the docker containers to communicate between each other):
        
        docker network create development
        docker network connect development mysql
        docker network connect development rent-a-car
        docker network inspect development (to check if all of the containers are within the newly created network)

    * Note that for the containers to be able to be seen in the network, they have to be up and running

6. Copy `.env.local` file and rename the new one to `.env`
7. Enter correct database name and credentials in the `.env` file (if you left the default it should be user `root` and password `123`)
8. Run `docker exec -it rent-a-car composer install`
9. Run `docker exec -it rent-a-car php artisan migrate --seed`
10. Run `docker exec -it rent-a-car php artisan passport:install` (This is needed because I'm using Laravel Passport as authentication)
11. The API should now be up and running on port 3000 and you should be able to request the routes via Postman or something similar

## Available features

### Auth
* Register **POST (`/api/register`)**
    
    - Test case:
        
            {
            	"email": "magdalenasiljanoska979@gmail.com",
            	"password": "test123",
            	"firstName": "Magdalena",
            	"lastName": "Siljanoska",
            	"birthDate": "1994-06-10",
            	"phoneNumber": "075123456"
            }

* Login **POST (`/api/login`)**
    
    - Test case:
        
            {
            	"email": "magdalenasiljanoska979@gmail.com",
            	"password": "test123"
            }     
### Users                   
* Check user's profile **GET (`/api/users/profile`)**
* Update user's profile **PUT (`/api/users/profile`)**

### Locations
* Get a list of locations **GET (`/api/locations`)**
    
    * Available filters: `name`, `address`

* Create a location **POST (`/api/locations`)**
    
    - Test case:
        
            {
                "email": "avis@example.com",
                "name": "Avis Skopje",
                "address": "Bulever Aleksandar Makedonski",
                "latitude": 55.8211230,
                "longitude": 174.7644980,
                "phoneNumber": "075123456"
            }
* Get details about a location **GET (`/api/locations/{id}`)**
* Update a location **PUT (`/api/locations/{id}`)**
    
    - Test case:
        
            {
                "email": "avisskopje@example.com",
                "name": "Avis Skopje 2",
                "address": "Bulever Kliment Ohridski",
                "latitude": 55.8211230,
                "longitude": 174.7644980,
                "phoneNumber": "075123456"
            }
* Delete a location **DELETE (`/api/locations/{id}`)**

### Cars
* Get a list of locations **GET (`/api/cars`)**

    * Available filters: `available`, `rented`, `location`, `priceRange` (for this filter there should be provided `minPrice` and `maxPrice`), `brand`, `model`, `year`

* Create a location **POST (`/api/cars`)**
    
    - Test case:
        
            {
                "brand": "Lada",
                "model": "Niva",
                "year": 1992,
                "fuelType": "Diesel",
                "price": 100,
                "available": true,
                "locationId": 1
            }
* Get details about a location **GET (`/api/cars/{id}`)**
* Update a location **PUT (`/api/cars/{id}`)**
    
    - Test case:
        
            {
                "brand": "Lada",
                "model": "Samara",
                "year": 1992,
                "fuelType": "Gasoline",
                "price": 50,
                "available": true,
                "locationId": 1
            }
* Delete a location **DELETE (`/api/cars/{id}`)**

### Rents
* Get a list of rents per user **GET (`/api/rents`)**
* Rent a car **POST (`/api/rents`)**
    
    - Test case:
        
            {
                "startDate": "2019-06-25 03:44:50",
            	"endDate": "2019-07-25 03:44:50",
            	"startingLocation": 1,
            	"endingLocation": 1,
            	"carId": 1
            }

### Notes

* In case of testing the routes that are protected by authenticaton, you should first require a token from **POST (`/api/users/login`)**
and the token from the response should be sent as an `Authorization` header in the next requests with value: `Bearer <token-from-response>`

* In case of filtering the lists, all of the filters that should be applied and are available for the corresponding list
should be sent as query parameters to the appropriate route with the exact names that are provided above

* Note that I have tested the API with the `mysql` image `5.7`, saying this to tell you that if you pull some other image there might be errors
(just mentioning this because it had happened to me earlier)
            
## Future improvements
  - Unit and Feature tests implementation
  - Docker compose file, so the installation of the API is simpler and easier
  - Generating swagger for the API endpoints
  - Improve code readability and/or rework code with Laravel Resources
  - Improve docs
