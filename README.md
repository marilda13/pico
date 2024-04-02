Springfield residents application
========================

This is an application to manage residents' data and lookup residents' quotes.

Requirements
------------

  * PHP 8.2.0 or higher;

Installation
------------


[Download Composer][6] and use the `composer` binary installed
on your computer to run these commands:

```bash
# Import the code repository locally

# or clone the code repository and install its dependencies
$ git clone https://github.com/symfony/demo.git my_project
$ cd my_project/
$ composer install
```

Usage
-----

[Download Symfony CLI][4] and run this command:

```bash
$ cd my_project/
$ symfony serve
```

Then access the application in your browser at the given URL (<https://localhost:8000> by default).

API Endpoints
-----

Read API Endpoint
-----
{lang}/resident/
Example: http://localhost:8000

Add API Endpoint
-----
{lang}/resident/add
Example: http://127.0.0.1:8000/en/resident/add

Edit API Endpoint
-----
{lang}/resident/edit/{id}
Example: http://127.0.0.1:8000/en/resident/edit/1

View API Endpoint
-----
{lang}/resident/view/{id}
Example: http://127.0.0.1:8000/en/resident/view/1

Delete API Endpoint
-----
{lang}/resident/delete/{id}
Example: http://127.0.0.1:8000/en/resident/delete/1

Delete API Endpoint
-----
{lang}/lookup/{ch}/{count}
Example: http://127.0.0.1:8000/en/resident/lookup/ho/10




