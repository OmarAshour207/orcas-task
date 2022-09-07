## Orcas Task made by omarashour207@gmail.com

- This task required:
- 1 - consume 2 or more API and validate some of data considering different schemas and save it.
- 2 - endpoint to fetch users and paginate it.
- 3 - endpoint to search using firstnam, lastname, email.

- i have made it using docker with nginx, mysql 5.7, php 7.4 with laravel framework

## how to make it work 
- open power shell in project dir
- run command `docker run --rm -v ${PWD}:/app composer install`
- run command `docker-compose build --no-cache`
- then run command `docker-compose up -d`
- then run command `docker-compose exec app php artisan key:generate`
- then run command `docker-compose exec app php artisan config:cache`
- then run command `docker-compose exec app php artisan migrate`

- it will work insallah in `http://localhost:8100`

# endpoints

## consume api and add data after validating it

### `GET`: /api/v1/users/add 

- json reponse in successing with success message


## fetch users data paginated 10 user per page

### `GET`: /api/v1/users

- GET `api_key`: `k3Hy5qr73QhXrmHLXhpEh6CQ`


## search in users using firstname, lastname, email

### `GET`: /api/v1/users/search

- GET `serch_value`: the word you want search with
