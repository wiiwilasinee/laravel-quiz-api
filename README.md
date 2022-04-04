# Laravel Quiz API
_an API written in PHP (Laravel 9 Framework) for creating and managing quizzes._
> Note: Laravel 9 - required PHP version 8.*

## Installation

```bash
# clone repository and cd to project folder
$ cd laravel-quiz-api

# install laravel via composer
$ composer install

# copy .env.example to .env and generate key
$ cp .env.example .env
$ php artisan key:generate
```

Enter database settings.
_This database will create by sail (docker) inside the container_
```sh
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={YOUR_DATABASE_NAME}
DB_USERNAME={YOUR_DATABASE_USERNAME}
DB_PASSWORD={YOUR_DATABASE_PASSWORD}
...
```

## Launching app locally using sail (docker)
> Note: Including MySQL and redis.
```bash
$ ./vendor/bin/sail up
```

However, instead of repeatedly typing vendor/bin/sail to execute Sail commands, you may wish to configure a Bash alias that allows you to execute Sail's commands more easily:
```bash
$ alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

> Note: For more information about laravel sail https://laravel.com/docs/9.x/sail

Migrate database table
```bash
$ sail artisan migrate
```

If you would like to seed default a quiz database (Optional)
```bash
$ sail artisan db:seed -- DefaultQuizSeeder
```

Verify the deployment by navigating to your server address in
your preferred browser.

```sh
127.0.0.1:8000
```

## Available routes

| Route | Method | Description |
| ------ | ------ | ------ |
| /quizzes | GET | Get all quizzes |
| /quizzes/:id | GET | Get quiz |
| /quizzes/:slug/questions | GET | Get quiz with questions and options |
| /quizzes | POST | Create a quiz |
| /quizzes/:id | PUT/PATCH | Update quiz data |
| /quizzes/:id | DELETE | Delete a quiz, all questions and options |
| /questions | POST | Create a question |
| /questions/:id | DELETE | Delete a question and all options |
| /options | POST | Create an option |
| /options/:id | DELETE | Delete an option |
| /options/:id/answer-check | GET | Check answer option is correct |

## Requests

##### Get all quizzes
HTTP request
```sh
GET /quizzes
```
Response
_If successful, this method returns a response body with the following structure:_
```sh
[
    {
        "id": unsigned integer,
        "name": string,
        "slug": string
    },
    ...
]
```

##### Get a quiz
HTTP request
```sh
GET /quizzes/{Quiz ID}
```
Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "id": unsigned integer,
    "name": string,
    "slug": string
}
```

##### Get a quiz with questions and options
HTTP request
```sh
GET /quizzes/{Quiz Slug}/questions
```
Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "slug": string,
    "name": string,
    "questions": [
        {
            "question_id": unsigned integer,
            "content": text,
            "message": string,
            "options": [
                {
                    "option_id": unsigned integer,
                    "content": text
                },
                ...
            ]
        },
        ...
    ]
}
```

##### Create new quiz
HTTP request
```sh
POST /quizzes
```
Request body
> Note: Slug will generate from name when you create aquiz and slug can not change later.

- name  (***_string_**) - _Quiz name_

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Quiz Created",
    "data": {
        "id": unsigned integer,
        "name": string,
        "slug": string
    }
}
```

##### Update quiz data (name)
HTTP request
```sh
PUT /quizzes/{Quiz ID}
```
Request body

- name  (***_string_**) - _Quiz name_

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Quiz Updated",
    "data": {
        "id": unsigned integer,
        "name": string,
        "slug": string
    }
}
```

##### 	Delete a quiz (this will be delete all questions and options in a quiz)
HTTP request
```sh
DELETE /quizzes/{Quiz ID}
```

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Quiz Deleted",
}
```

##### Create new question
HTTP request
```sh
POST /questions
```
Request body

- quiz_id  (***_integer_**) - _Quiz ID_
- content  (***_string_**) - _Question_
- message  (**_string_**) - _Extra information for question_

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Question Created"
}
```

##### 	Delete a question (this will be delete all options in a question)
HTTP request
```sh
DELETE /questions/{Question ID}
```

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Question Deleted",
}
```

##### Create new option
HTTP request
```sh
POST /options
```
Request body

- question_id  (***_integer_**) - _Question ID_
- content  (***_string_**) - _Option_
- is_correct  (**_boolean_**) - _To say this option is a correct option or not_

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Option Created"
}
```

##### 	Delete an option
HTTP request
```sh
DELETE /options/{Option ID}
```

Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "message": "Option Deleted",
}
```

##### Check answer
HTTP request
```sh
GET /options/{Option ID}/answer-check
```
Response
_If successful, this method returns a response body with the following structure:_
```sh
{
    "answer": {
        "option_id": unsigned integer,
        "content": text,
    },
    "correct": {
        "option_id": unsigned integer,
        "content": text,
    },
    "is_correct": boolean
}
```
