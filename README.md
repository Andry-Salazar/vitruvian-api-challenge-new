# PHP API REST EXAMPLE

PHP example for Vitruvian Challenge.

### Prerequisites

- [PHP](https://www.php.net/downloads.php)
- [MySQL](https://www.mysql.com/downloads/)
- [Composer](http://getcomposer.org/)

## Getting Started

Clone this project
Create MySQL Data base with name `vitruvian` on local or cloud and configure user and password

### Configure the database

Create the database table `todo` and colums:

| Name      | Type |
| ----------- | ----------- |
| id      | int AUTO_INCREMENT PRIMARY KEY       |
| name   | varchar NOT NULL       |
| description  | text NOT NULL       |
| autor   | varchar NOT NULL       |
| is_complete  | boolean NOT NULL       |
| create_at   | datetime NOT NULL DETAUL CURRENT_TIMESTAMP|
| update_at   | datetime NOT NULL DETAUL CURRENT_TIMESTAMP|


Copy `.env.example` in new file with name `.env` and enter your database information.


## Start Development Server

Install the project dependencies:

```bash
composer install
```

Start the PHP server

```bash
php -S localhost:8000 -t api
```

## Work your apis APIs under the following criteria

| API               |    CRUD    |                                Description |
| :---------------- | :--------: | -----------------------------------------: |
| GET /tasks        |  **READ**  |        Get all Task created in `todo` table |
| GET /task/{id}    |  **READ**  |        Get the Task by id from `todo` table |
| POST /task        | **CREATE** | Create a Task and insert into `todo` table |
| PUT /task/{id}    | **UPDATE** |            Update the Task by id in `todo` table |
| DELETE /task/{id} | **DELETE** |            Delete a Task by id from `todo` table |

