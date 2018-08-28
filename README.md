# Omar SADEK - Interview questions

## Summary

- [*Installation*](#installation)
- [*Question One Anagrams*](#question-one-anagrams)
- [*Question Two Boggle*](#question-two-boggle)
- [*Question Three Messaging App*](#question-three-messaging-app)

## Installation

Install vendors

```
$ git clone git@github.com:omarysadek/tumblr.git
$ cd tumblr/
$ composer update
```

## Question One: Anagrams

| Task          | Time   |
|---------------|--------|
| Conception    | ~7m    |
| Set up env    | ~10m   |
| Coding        | ~25m   |
| Documentation | ~5m    |
| Total         | ~50m   |

Running tests

```
$ vendor/bin/phpunit --group anagram
```

_Tests cases are written here => Tests\AnagramTest.php_

## Question Two: Boggle

| Task          | Time   |
|---------------|--------|
| Conception    | ~20m   |
| Coding        | ~2h30m |
| UnitTesting   | ~30m   |
| Documentation | ~5m    |
| Total         | ~3h30m |

Running tests

```
$ vendor/bin/phpunit --group boggle
```

Running the game

```
$ php console.php boggle
```
> Please chose the size of the grid? 4
>
> How would like to generate the grid : 1) Manually 2) Randomly 1
>
> Please enter your grid, without space followed by | for each line
>
> here an exemple :
>
> ```
> 4x4 => ARTY|EAON|YSTD|ECIC
> ```
>
> : ARTY|EAON|YSTD|ECIC
>
> a r t y
>
> e a o n
>
> y s t d
>
> e c i c
>
>
> Please enter a word : arty
>
> arty => true
>
> Please enter a word : tony
>
> tony => true
>
> Please enter a word : notice
>
> notice => true
>
> Please enter a word : year
>
> year => true
>
> Please enter a word : stand
>
> stand => false
>
> Please enter a word : party
>
> party => false
>
> Please enter a word : stick
>
> stick => false
>
> Please enter a word : ^C

## Question Three Messaging App

| Task          | Time   |
|---------------|--------|
| Conception    | ~30m   |
| Documentation | ~10m   |
| Total         | ~40m   |

### Services

- V1 : As soon as possible
    - React : Or any good front end framework
    - Symfony 4/Lumen : Since it is not a heavy application, we can use a light mvc framework
    - Postgresql : Or any other relationship database such as MySQL
    - Nginx : One of the faster for php server and easy to implement the load balancing feature

- Issue :
    - Hard to ship in production
    - Run slow especialy if there are a lot of users
    - Regressions

- Some solutions :
    - AWS : Host the app load balancing the backend, duplicate and load balancing database, Redis too.
    - Tests : Unit, functional andintergration tests to make the app more secure
    - Docker and Kubernete : so we can ship it quickly
    - Jenkins : testing purpose CI
    - Node.js : Will be connected to a message queue, so we can get some notification directly from it and avoid using selects on the database
    - Redis : Caching purpose and avoid using as much as possible the database
    - RabbitMQ : For all asynchrone tasks or not real time, also we can use it for this exemple:
        - when sending a message to a user, instead of inserting it directly to the DDB, we can creat an event on RabbitMQ, the listener will broadcast this message to the users and save it in the DDB
    - Microservices : if there are a lot of users

### Entities

### User

| name       | type    | comments |
|------------|---------|----------|
| id         | integer |          |
| first_name | string  |          |
| last_name  | string  |          |
| email      | string  |          |
| username   | string  |          |
| password   | string  |          |
| salt       | string  |          |
| enabled.   | boolean |          |

- Restrictions :
    - id as key

### Message

| name            | type      | comments |
|-----------------|-----------|----------|
| id              | integer   |          |
| user_id         | integer   | ManToOne |
| conversation_id | integer   | ManToOne |
| at              | timestamp |          |
| content         | blob      |          |


- Restrictions :
    - id as key
    - belongs_to exist in user

### Conversation

| name         | type      | comments |
|--------------|-----------|----------|
| id           | integer   |          |
| from_user_id | integer   | ManToOne |
| to_user_id   | integer   | ManToOne |
| at           | timestamp |          |
| deleted      | boolean   |          |


- Restrictions :
    - id as key
    - from + to as unique keys
    - from exist in user
    - to exist in user

## Route

- POST /user _(creat new user)_
- GET /user/{id} _(get user information)_
- PUT /user/{id} _(edit bunch of field for a user)_
- PATCH /user/{id} _(edit one field for a user)_
- POST /auth _(authentication)_
- GET /user/{id}/conversation _(get the list of conversations with the user)_
- GET /user _(get list of users)_
- POST /user/{id}/message _(send a message to a user)_
- GET /user/{id}/conversation/{id} _(get messages for this conversation)_
- DELETE /user/{$id}/conversation/{$id} _(delete one conversation)_
- DELETE /user/{$id}/message/{$id} _(delete one message)_
