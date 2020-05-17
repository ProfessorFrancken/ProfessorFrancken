|            |            |
| ------------- |:-------------:|
| <a href="https://professorfrancken.nl"><img width="200px" alt="Logo of T.F.V. Professor Francken" src="https://github.com/ProfessorFrancken/ProfessorFrancken/blob/master/public/images/LOGO_KAAL.png"></a> | <h1>T.F.V. 'Professor Francken'</h1> [![Build Status](http://github.scriptcie.nl/api/badges/ProfessorFrancken/ProfessorFrancken/status.svg)](http://github.scriptcie.nl/ProfessorFrancken/ProfessorFrancken) [![Coverage Status](https://coveralls.io/repos/github/ProfessorFrancken/ProfessorFrancken/badge.svg?branch=master)](https://coveralls.io/github/ProfessorFrancken/ProfessorFrancken?branch=master) |

This is the repository containing code for the new website of
[T.F.V. Porfessor Francken](http://professorfrancken.nl/).
We are using the [Laravel v6.0](http://laravel.com/docs/6.0) framework in
combination with [Broadway](http://github.com/qandidate-labs/broadway), an
infrastructure library for creating CQRS and Event Sourced applications.

You can find some high quality introductory videos on
[laravelfromscratch.com](laravelfromscratch.com).
For more info on Broadway, watch
[Willem-Jan Zijderveld speak on CQRS and Event Sourcing](https://www.youtube.com/watch?v=d1PDPsxWGqM).


- [Getting started](#getting-started)
    - [Summary](#summary)
- [Contributing](#contributing)
    - [Generating css (or compiling assets)](#generating-css-or-compiling-assets)
        - [Windows configuration](#windows-configuration)
    - [Testing](#testing)
    - [Code style](#code-style)
    - [Git Usage](#git-usage)
- [An introduction to this application's folder and namespace structure](#an-introduction-to-this-applications-folder-and-namespace-structure)
    - [Domain layer](#domain-layer)
    - [Application layer](#application-layer)
        - [Adding projectors](#adding-projectors)
    - [Infrastructure layer](#infrastructure-layer)

## Getting started

If you want to get started working on our website, first clone the repository
using git. Next copy the `.env.example` file and name the copy `.env`.

The following instructions assume that you've
installed [Docker](https://www.docker.com/products/docker#/linux)
and [docker-compose](https://docs.docker.com/compose/install/).
If you haven't yet, follow the links and install Docker.

Next you will want to download our php and javascript dependencies. Using you
terminal run `docker-compose run composer install` and `docker-compose run yarn`
in the root of the project.
Once you've installed the dependencies run `docker-compose run php php artisan
key:generate` to generate an application key.
Next run `docker-compose run php php artisan migrate:refresh --seed` to setup a
sqlite database and lastly run `docker-compose up nginx` to start the website.

You can now visit the website at [localhost](http://localhost).


### Summary

Run the following commands to setup and start the website.

```sh
git clone git@github.com:ProfessorFrancken/ProfessorFrancken.git Francken && cd Francken

cp .env.example .env

docker-compose run composer install
docker-compose run npm npm install
docker-compose run npm npm run dev
docker-compose run php php artisan key:generate
docker-compose run php php artisan migrate:refresh --seed
docker-compose up nginx
```

## Contributing
Before you push your changes to this repository make sure that the tests are all
green and that there are no issues with code style.

Below you will find a quick summary on how to run the tests and a code style
fixer.

### Generating css (or compiling assets)

We use [scss](http://sass-lang.com/) which compiles to css.

To compile our assets you will first have to install some necessary javascript
dependencies. You can do this using [npm](npmjs.com).
Assuming you've installed npm locally you can run the command,
```
npm install
```
Alternatively if you prefer to use a docker container (that is if you have
installed Docker but don't have npm installed), then you can run
`docker-compose run npm npm install`.


Once you've installed the javascript dependencies you can compile our assets by
running
```
npm run dev
```
in the root of this project (the folder in which a `package.json` file  is
present), or alternatively use `docker-compose run npm npm run dev`.
The compiled files will be placed in the `/public/dist` folder. This folder is
added to our `.gitignore` so you won't see the folder until you run the above
command.

Check the documentation
of [Laravel Mix](https://laravel.com/docs/5.4/mix#introduction) to learn more
about how our assets (css & js) are compiled.

#### Windows configuration

I haven't yet tested whether this works on Windows.. If you're using Docker
(which you should :-)) then the docker commands should work.

### Testing
We use [phpunit](https://phpunit.de/) for most of our tests. To execute the
tests using Docker run,
```
docker-compose run php vendor/bin/phpunit
```

### Code style
We're using the PSR-2 code style guidelines as well as PSR-4 for autoloading classes.
See the [PHP-fig](http://www.php-fig.org/psr/) for more info on the standards.
You can use `fabpot/php-cs-fixer` to verify that your code conforms to the PSR-2
code style guidelines. By running the following command in the root directory
all code style issues be found.
```
vendor/bin/php-cs-fixer fix . --level=psr2 --dry-run --fixers=-psr0
```
By removing the `--dry-run` option any issues found by the program will be fixed
automatically. Add the `--diff` option to show the diff for each file.
N.B. once we've gone open source we will use a continuous integration service
that automatically checks whether your PR conforms to the code style guidelines.

*Note* we omit the `psr0` fixer. This fixer looks at the namespace declarations
however it is not compatible with PSR-4, which is an improvement over PSR-0.

### Git Usage
The master branch is a protected branch, meaning you won't be able to force push changes to the master branch and status checks (i.e. tests should be green) are required before merging to master.
Before sending a pull request with your latest changes you should make sure that your branch is up to date by rebasing your branch onto master.
This makes it easier to review your pull request since there won't be many merge commits and it gives us a nice linear history.

We generally use a [git flow](http://nvie.com/posts/a-successful-git-branching-model/) ish git model.
Since this application hasn't been pushed to production yet we won't be very strict about this, however you should try to be consistent with the naming of branching (i.e. using feature and branches and bug fix branches).

## An introduction to this application's folder and namespace structure
This application is build upon an hexagonal architecture and is inspired by the
talk [Hexagonal architecture - message oriented software design](http://www.slideshare.net/matthiasnoback/hexagonal-architecture-messageoriented-software-design-php-benelux-2016)
by Matthias Noback.

The application is divided by three layers: a Domain layer, Application layer
and an Infrastructure layer.
Each layer is only allowed to be dependent on its own layer, or a layer "below"
it.
Doing so ensures that we can use dependency inversion and makes our application
more testable.

### Domain layer
The domain layer contains all of the business logic. Except for
[Broadway](https://github.com/qandidate-labs/broadway) this layer should not
have any external dependencies and *must* be framework agnostic.

The code in the domain layer should have 100% line and mutation coverage and
should only need unit tests.

The [docs](docs/) folder contains some documentation of important domain concepts.

### Application layer
The application layer gives us an entry point into the domain layer.
Inside the application layer we can find use cases of some our domain concepts.
These use cases can be commands and command handlers, projections, event
handlers and processors.
The code inside this layer *should* be framework agnostic and should not need
acceptance tests, however each class should be unit and integration tested.

#### Adding projectors
We use projectors to generate read models. Currently these projectors are placed
in `App\ReadModels`. Once you've created a projector you should add its Fully
Qualified Classs Name (FQCN) to the `event_sourcing.php` config file.
The application will then automatically call each of the projectors in the
config file when an event is published.

### Infrastructure layer
The infrastructure layer is the only layer that is not framework agnostic and
could as well be called the "framework layer".
This layer contains Laravel's service providers and the console and http
kernels and their commands and controllers.
It may also contain implementations of repositories, notification services etc.

Code inside the infrastructure layer should be tested using acceptance criteria.
Unit and integration tests should be written whenever they are useful.
